<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Member;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        $member = Member::find($request->member_id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found.'
            ]);
        }

        $currentMembership = $member->memberships()->latest()->first();

        // No membership found
        if (!$currentMembership) {

            return response()->json([
                'success' => false,
                'message' => 'No active membership found.'
            ]);

        }

        // Membership expired
        if (
        $currentMembership->end_date &&
        \Carbon\Carbon::parse($currentMembership->end_date)->isPast()
        ) {

            return response()->json([
                'success' => false,
                'expired' => true,

                'member' => $member->full_name,
                'phone' => $member->phone,

                'trainer' => optional($member->trainer)->name ?? 'No Trainer',

                'membership' => optional($currentMembership)->plan_name ?? 'No Membership',

                'expires' => \Carbon\Carbon::parse($currentMembership->end_date)
                                ->format('F d, Y'),

                'message' => 'Membership Expired'
            ]);
        }        

        // Latest attendance today
        $attendance = Attendance::where('member_id', $member->id)
            ->whereDate('attendance_date', today())
            ->latest()
            ->first();

        // FIRST TIME TODAY
        if (!$attendance) {

            Attendance::create([
                'member_id' => $member->id,
                'attendance_date' => today(),
                'method' => 'QR',
                'time_in' => now()->format('H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'status' => 'in',

                'member' => $member->full_name,

                'phone' => $member->phone,

                'trainer' => optional($member->trainer)->name ?? 'No Trainer',

                'membership' => optional($currentMembership)->plan_name ?? 'No Membership',

                'expires' => optional($currentMembership)->end_date
                    ? \Carbon\Carbon::parse($currentMembership->end_date)->format('F d, Y')
                    : 'N/A',

                'message' => 'Time In recorded successfully.',

                'time' => now()->format('h:i:s A')
            ]);
        }

        // MEMBER IS CURRENTLY INSIDE
        if ($attendance->time_out == null) {

            $attendance->update([
                'time_out' => now()->format('H:i:s')
            ]);

        return response()->json([
            'success' => true,
            'status' => 'out',

            'member' => $member->full_name,

            'phone' => $member->phone,

            'trainer' => optional($member->trainer)->name ?? 'No Trainer',

            'membership' => optional($currentMembership)->plan_name ?? 'No Membership',

            'expires' => optional($currentMembership)->end_date
                ? \Carbon\Carbon::parse($currentMembership->end_date)->format('F d, Y')
                : 'N/A',

            'message' => 'Time Out recorded successfully.',

            'time' => now()->format('h:i:s A')
        ]);

        }

        // LAST SESSION IS FINISHED
        // CREATE A NEW VISIT

        Attendance::create([
            'member_id' => $member->id,
            'attendance_date' => today(),
            'method' => 'QR',
            'time_in' => now()->format('H:i:s')
        ]);

        return response()->json([
            'success' => true,
            'status' => 'in',

            'member' => $member->full_name,

            'phone' => $member->phone,

            'trainer' => optional($member->trainer)->name ?? 'No Trainer',

            'membership' => optional($currentMembership)->plan_name ?? 'No Membership',

            'expires' => optional($currentMembership)->end_date
                ? \Carbon\Carbon::parse($currentMembership->end_date)->format('F d, Y')
                : 'N/A',

            'message' => 'New Time In recorded.',

            'time' => now()->format('h:i:s A')
        ]); 
    }
        public function index(Request $request)
        {
            $query = Attendance::with('member');

            if ($request->search) {

                $query->whereHas('member', function($q) use ($request){

                    $q->where('full_name','LIKE','%'.$request->search.'%');

                });

            }

            $attendances = $query
                ->latest()
                ->paginate(20)
                ->withQueryString();

            $todayScans = Attendance::whereDate('attendance_date', today())->count();

            $insideNow = Attendance::whereDate('attendance_date', today())
                            ->whereNull('time_out')
                            ->count();

            $timeOuts = Attendance::whereDate('attendance_date', today())
                            ->whereNotNull('time_out')
                            ->count();

            return view('attendance.index', compact(
                'attendances',
                'todayScans',
                'insideNow',
                'timeOuts'
            ));
        }

        public function searchMembers(Request $request)
        {
            $search = $request->search;

            $members = Member::where('full_name', 'LIKE', "%{$search}%")
                ->select('id', 'full_name')
                ->orderBy('full_name')
                ->limit(10)
                ->get();

            return response()->json($members);
        }
    
        public function manualAttendance(Request $request)
        {
            $request->validate([
                'member_id' => 'required|exists:members,id',
                'attendance_type' => 'required|in:in,out',
            ]);

            $member = Member::findOrFail($request->member_id);

            $attendance = Attendance::where('member_id', $member->id)
                ->whereDate('attendance_date', today())
                ->latest()
                ->first();

            if ($request->attendance_type == 'in') {

                Attendance::create([
                    'member_id' => $member->id,
                    'attendance_date' => today(),
                    'method' => 'Manual',
                    'time_in' => now()->format('H:i:s')
                ]);

                return redirect()
                    ->route('attendance.index')
                    ->with('success', 'Manual Time In recorded successfully.');

            }

            if (!$attendance || $attendance->time_out) {

                return redirect()
                    ->route('attendance.index')
                    ->with('error', 'No active Time In found for this member.');

            }

            $attendance->update([
                'time_out' => now()->format('H:i:s')
            ]);

            return redirect()
                ->route('attendance.index')
                ->with('success', 'Manual Time Out recorded successfully.');
        }
}
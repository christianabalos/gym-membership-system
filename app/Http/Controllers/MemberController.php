<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::with(['user', 'memberships.trainer'])
            ->when($search, function ($query, $search) {
                $query->where('full_name', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('email', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->get();

        return view('members.index', compact('members', 'search'));
    }

    public function create()
    {
        $trainers = Trainer::orderBy('name')->get();

        foreach ($trainers as $trainer) {
            $trainer->booked_times = Membership::where('trainer_id', $trainer->id)
                ->whereIn('status', ['pending', 'active', 'approved'])
                ->whereNotNull('schedule_time')
                ->pluck('schedule_time')
                ->toArray();
        }

        return view('members.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'trainer_id' => 'nullable|exists:trainers,id',
            'schedule_time' => 'nullable|string|max:100',
            'plan_name' => 'nullable|in:Monthly,Quarterly,Annual',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'payment_method' => 'nullable|in:Cash,Online,cash,online',
        ]);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'trainer_id' => $request->trainer_id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
        ]);

        if ($request->filled('plan_name')) {
            $basePrices = [
                'Monthly' => 500,
                'Quarterly' => 1800,
                'Annual' => 5500,
            ];

            $price = $basePrices[$request->plan_name] ?? 0;

            if ($request->filled('trainer_id')) {
                $price += 300;
            }

            $paymentMethod = strtolower($request->payment_method ?? 'cash');

            $membershipStatus = $paymentMethod === 'online' ? 'active' : 'pending';
            $paymentStatus = $paymentMethod === 'online' ? 'paid' : 'pending';

            $membership = Membership::create([
                'member_id' => $member->id,
                'trainer_id' => $request->trainer_id,
                'plan_name' => $request->plan_name,
                'price' => $price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'schedule_time' => $request->schedule_time,
                'status' => $membershipStatus,
            ]);

            Payment::create([
                'member_id' => $member->id,
                'membership_id' => $membership->id,
                'amount' => $price,
                'method' => $paymentMethod,
                'status' => $paymentStatus,
                'payment_date' => now()->toDateString(),
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]);
        }

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Member added successfully.',
                'data' => $member->load('user'),
            ], 201);
        }

        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function show(Member $member)
    {
        $member->load(['user', 'memberships.trainer']);

        if (request()->is('api/*')) {
            return response()->json($member);
        }

        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
        ]);

        $member->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
        ]);

        if ($member->user) {
            $member->user->update([
                'name' => $request->full_name,
            ]);
        }

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Member updated successfully.',
                'data' => $member->load('user'),
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        if ($member->user) {
            $member->user->delete();
        }

        $member->delete();

        if (request()->is('api/*')) {
            return response()->json([
                'message' => 'Member deleted successfully.',
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    public function export($format)
    {
        $members = Member::with('user', 'memberships.trainer')->get();
        $timestamp = date('Ymd_His');

        if ($format === 'json') {
            return response()->json($members, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        $filename = "members_export_{$timestamp}";
        $headers = [
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Full Name', 'Email', 'Trainer', 'Phone', 'Gender', 'Registration Date'];

        if ($format === 'xlsx') {
            $headers["Content-Type"] = "application/vnd.ms-excel";
            $headers["Content-Disposition"] = "attachment; filename=\"{$filename}.xls\"";
            $delimiter = "\t";
        } else {
            $headers["Content-Type"] = "text/csv";
            $headers["Content-Disposition"] = "attachment; filename=\"{$filename}.csv\"";
            $delimiter = ",";
        }

        $callback = function() use ($members, $columns, $delimiter) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, $delimiter);

            foreach ($members as $member) {
                $latestMembership = $member->memberships->sortByDesc('created_at')->first();
                $trainerName = $latestMembership && $latestMembership->trainer ? $latestMembership->trainer->name : 'No Trainer';
                $email = $member->user->email ?? $member->email ?? 'N/A';

                fputcsv($file, [
                    $member->id,
                    $member->full_name,
                    $email,
                    $trainerName,
                    $member->phone ?? 'N/A',
                    $member->gender ?? 'N/A',
                    $member->created_at ? $member->created_at->format('Y-m-d') : 'N/A',
                ], $delimiter);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file'
        ]);
    
        $file = $request->file('csv_file');
        
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['csv', 'txt'])) {
            return redirect()->back()->with('error', 'Maling format! Tanging .csv o .txt na file lamang ang pinapayagan.');
        }

        $path = $file->getRealPath();
        $importedCount = 0;

        if (($handle = fopen($path, 'r')) !== FALSE) {
            
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            fgetcsv($handle, 1000, ",");

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (empty($row) || !isset($row[0]) || trim($row[0]) === '') {
                    continue;
                }

                $fullName = trim($row[0]);
                $email = isset($row[1]) && trim($row[1]) !== '' ? trim($row[1]) : null;
                $phone = isset($row[2]) && trim($row[2]) !== '' ? trim($row[2]) : 'N/A';
                $gender = isset($row[3]) && trim($row[3]) !== '' ? trim($row[3]) : 'N/A';

                $userId = null;
                if ($email) {
                    $user = User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => $fullName,
                            'password' => Hash::make('password123'),
                            'role' => 'member'
                        ]
                    );
                    $userId = $user->id;
                }

                Member::create([
                    'user_id' => $userId,
                    'full_name' => $fullName,
                    'phone' => $phone,
                    'gender' => $gender,
                ]);

                $importedCount++;
            }
            fclose($handle);
        }

        if ($importedCount > 0) {
            return redirect()->route('members.index')->with('success', "Successfully imported {$importedCount} members!");
        }

        return redirect()->route('members.index')->with('error', 'Walang miyembro na na-import. Pakisuri ang iyong file.');
    }
}
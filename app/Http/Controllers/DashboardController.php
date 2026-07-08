<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Workout;
use App\Models\MemberRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $totalTrainers = Trainer::count();
        $activeMemberships = Membership::where('status', 'active')->count();
        $totalPayments = Payment::sum('amount');
        $totalWorkouts = Workout::count();

        $recentPayments = Payment::with(['member', 'membership'])
            ->latest()
            ->take(5)
            ->get();

        $today = Carbon::today();

        $expiringMemberships = Membership::with(['member', 'trainer'])
            ->whereDate('end_date', '>=', $today)
            ->whereDate('end_date', '<=', $today->copy()->addDays(7))
            ->orderBy('end_date')
            ->get();

        $pendingRequests = MemberRequest::where('status', 'pending')->count();

        return view('dashboard', compact(
            'totalMembers',
            'totalTrainers',
            'activeMemberships',
            'totalPayments',
            'totalWorkouts',
            'recentPayments',
            'expiringMemberships',
            'pendingRequests'
        ));
    }
}
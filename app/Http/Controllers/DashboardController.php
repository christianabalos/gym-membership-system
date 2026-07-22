<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Workout;
use App\Models\MemberRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();

        $totalTrainers = Trainer::count();

        $activeMemberships = Membership::whereIn('status', ['active', 'approved'])
            ->count();

        $totalPayments = Payment::whereIn('status', ['paid', 'approved'])
            ->sum('amount');

        $totalWorkouts = Workout::whereHas('membership', function ($query) {
            $query->whereIn('status', ['active', 'approved']);
        })->count();

        $pendingRequests = MemberRequest::where('status', 'pending')
            ->latest()
            ->get();

        $pendingRequestsCount = $pendingRequests->count();

        $recentPayments = Payment::with(['member', 'membership'])
            ->latest()
            ->take(5)
            ->get();

        $expiringMemberships = Membership::with('member')
            ->whereIn('status', ['active', 'approved'])
            ->whereDate('end_date', '>=', now())
            ->whereDate('end_date', '<=', now()->addDays(7))
            ->get();

        return view('dashboard', compact(
            'totalMembers',
            'totalTrainers',
            'activeMemberships',
            'totalPayments',
            'totalWorkouts',
            'pendingRequests',
            'pendingRequestsCount',
            'recentPayments',
            'expiringMemberships'
        ));
    }
}
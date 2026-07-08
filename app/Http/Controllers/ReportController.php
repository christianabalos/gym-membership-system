<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Workout;
use App\Models\Trainer;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function members()
    {
        $members = Member::with('user')
            ->latest()
            ->get();

        return view('reports.members', compact('members'));
    }

    public function memberships()
    {
        $memberships = Membership::with(['member', 'trainer'])
            ->latest()
            ->get();

        return view('reports.memberships', compact('memberships'));
    }

    public function payments()
{
    $payments = Payment::with(['member', 'membership'])
        ->latest()
        ->get();

    $totalPayments = $payments->sum('amount');
    $paidPayments = $payments->where('status', 'paid')->sum('amount');
    $pendingPayments = $payments->where('status', 'pending')->sum('amount');
    $failedPayments = $payments->where('status', 'failed')->sum('amount');

    return view('reports.payments', compact(
        'payments',
        'totalPayments',
        'paidPayments',
        'pendingPayments',
        'failedPayments'
    ));
}

public function workouts()
{
    $workouts = Workout::with(['member', 'trainer'])
        ->orderBy('workout_date')
        ->get();

    return view('reports.workouts', compact('workouts'));
}
public function trainers()
{
    $trainers = Trainer::with(['memberships.member'])
        ->latest()
        ->get();

    return view('reports.trainers', compact('trainers'));
}

   public function membershipAnalytics()
{
    $today = now()->startOfDay();

    $memberships = \App\Models\Membership::all();

    $totalMemberships = $memberships->count();

    $activeMemberships = $memberships->filter(function ($membership) use ($today) {
        $status = strtolower($membership->status ?? '');

        if (!in_array($status, ['active', 'approved'])) {
            return false;
        }

        if (!$membership->end_date) {
            return false;
        }

        return \Carbon\Carbon::parse($membership->end_date)->startOfDay()->gte($today);
    })->count();

    $expiredMemberships = $memberships->filter(function ($membership) use ($today) {
        $status = strtolower($membership->status ?? '');

        if ($status === 'expired') {
            return true;
        }

        if (!$membership->end_date) {
            return false;
        }

        return \Carbon\Carbon::parse($membership->end_date)->startOfDay()->lt($today);
    })->count();

    $cancelledMemberships = $memberships->filter(function ($membership) {
        $status = strtolower($membership->status ?? '');

        return in_array($status, ['cancelled', 'canceled']);
    })->count();

    $totalRevenue = $memberships->filter(function ($membership) {
        $status = strtolower($membership->status ?? '');

        return !in_array($status, ['cancelled', 'canceled']);
    })->sum('price');

    $monthlyMemberships = $memberships->filter(function ($membership) {
        $status = strtolower($membership->status ?? '');

        return $membership->plan_name === 'Monthly'
            && !in_array($status, ['cancelled', 'canceled']);
    });

    $quarterlyMemberships = $memberships->filter(function ($membership) {
        $status = strtolower($membership->status ?? '');

        return $membership->plan_name === 'Quarterly'
            && !in_array($status, ['cancelled', 'canceled']);
    });

    $annualMemberships = $memberships->filter(function ($membership) {
        $status = strtolower($membership->status ?? '');

        return $membership->plan_name === 'Annual'
            && !in_array($status, ['cancelled', 'canceled']);
    });

    $monthlyCount = $monthlyMemberships->count();
    $quarterlyCount = $quarterlyMemberships->count();
    $annualCount = $annualMemberships->count();

    $monthlyRevenue = $monthlyMemberships->sum('price');
    $quarterlyRevenue = $quarterlyMemberships->sum('price');
    $annualRevenue = $annualMemberships->sum('price');

    return view('reports.membership-analytics', compact(
        'totalMemberships',
        'activeMemberships',
        'expiredMemberships',
        'cancelledMemberships',
        'totalRevenue',
        'monthlyCount',
        'quarterlyCount',
        'annualCount',
        'monthlyRevenue',
        'quarterlyRevenue',
        'annualRevenue'
    ));
}
}
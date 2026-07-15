<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Workout;
use App\Models\Trainer;
use Carbon\Carbon;

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

        $paidPayments = $payments
            ->whereIn('status', ['paid', 'approved'])
            ->sum('amount');

        $pendingPayments = $payments
            ->where('status', 'pending')
            ->sum('amount');

        $cancelledPayments = $payments
            ->whereIn('status', ['cancelled', 'canceled'])
            ->sum('amount');

        return view('reports.payments', compact(
            'payments',
            'totalPayments',
            'paidPayments',
            'pendingPayments',
            'cancelledPayments'
        ));
    }

    public function workouts()
    {
        $workouts = Workout::with(['member', 'trainer', 'membership'])
            ->where(function ($query) {
                $query->whereDoesntHave('membership')
                    ->orWhereHas('membership', function ($membershipQuery) {
                        $membershipQuery->whereIn('status', ['active', 'approved']);
                    });
            })
            ->orderBy('workout_date')
            ->get();

        return view('reports.workouts', compact('workouts'));
    }

    public function trainers()
    {
        $trainers = Trainer::with([
            'memberships' => function ($query) {
                $query->whereIn('status', ['active', 'approved']);
            },
            'memberships.member'
        ])
            ->latest()
            ->get();

        return view('reports.trainers', compact('trainers'));
    }

    public function analytics()
    {
        $today = Carbon::today();

        $memberships = Membership::with(['member', 'trainer'])->get();

        $totalMemberships = $memberships->count();

        $approvedMembershipsCollection = $memberships->filter(function ($membership) {
            return in_array(strtolower($membership->status ?? ''), ['active', 'approved']);
        });

        $approvedMemberships = $approvedMembershipsCollection->count();

        $pendingMemberships = $memberships->filter(function ($membership) {
            return strtolower($membership->status ?? '') === 'pending';
        })->count();

        $cancelledMemberships = $memberships->filter(function ($membership) {
            return in_array(strtolower($membership->status ?? ''), ['cancelled', 'canceled']);
        })->count();

        $expiredMemberships = $approvedMembershipsCollection->filter(function ($membership) use ($today) {
            if (!$membership->end_date) {
                return false;
            }

            return Carbon::parse($membership->end_date)->startOfDay()->lte($today);
        })->count();

        $activeMemberships = $approvedMembershipsCollection->filter(function ($membership) use ($today) {
            if (!$membership->end_date) {
                return false;
            }

            return Carbon::parse($membership->end_date)->startOfDay()->gt($today);
        })->count();

        $validMemberships = $memberships->filter(function ($membership) {
            return !in_array(strtolower($membership->status ?? ''), ['cancelled', 'canceled']);
        });

        $monthlyMemberships = $validMemberships->filter(function ($membership) {
            return strtolower($membership->plan_name ?? '') === 'monthly';
        });

        $quarterlyMemberships = $validMemberships->filter(function ($membership) {
            return strtolower($membership->plan_name ?? '') === 'quarterly';
        });

        $annualMemberships = $validMemberships->filter(function ($membership) {
            return strtolower($membership->plan_name ?? '') === 'annual';
        });

        $monthlyCount = $monthlyMemberships->count();
        $quarterlyCount = $quarterlyMemberships->count();
        $annualCount = $annualMemberships->count();

        $monthlyRevenue = Payment::whereHas('membership', function ($query) {
                $query->where('plan_name', 'Monthly');
            })
            ->whereIn('status', ['paid', 'approved'])
            ->sum('amount');

        $quarterlyRevenue = Payment::whereHas('membership', function ($query) {
                $query->where('plan_name', 'Quarterly');
            })
            ->whereIn('status', ['paid', 'approved'])
            ->sum('amount');

        $annualRevenue = Payment::whereHas('membership', function ($query) {
                $query->where('plan_name', 'Annual');
            })
            ->whereIn('status', ['paid', 'approved'])
            ->sum('amount');

        $totalRevenue = Payment::whereIn('status', ['paid', 'approved'])
            ->sum('amount');

        $planAnalytics = [
            [
                'plan' => 'Monthly',
                'total_members' => $monthlyCount,
                'total_revenue' => $monthlyRevenue,
            ],
            [
                'plan' => 'Quarterly',
                'total_members' => $quarterlyCount,
                'total_revenue' => $quarterlyRevenue,
            ],
            [
                'plan' => 'Annual',
                'total_members' => $annualCount,
                'total_revenue' => $annualRevenue,
            ],
        ];

        return view('reports.analytics', compact(
            'totalMemberships',
            'approvedMemberships',
            'pendingMemberships',
            'activeMemberships',
            'expiredMemberships',
            'cancelledMemberships',
            'totalRevenue',
            'monthlyCount',
            'quarterlyCount',
            'annualCount',
            'monthlyRevenue',
            'quarterlyRevenue',
            'annualRevenue',
            'planAnalytics'
        ));
    }
}
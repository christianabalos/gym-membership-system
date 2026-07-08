<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\BmiController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MemberRequestController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('trainers', TrainerController::class);
    Route::resource('members', MemberController::class);
    Route::resource('memberships', MembershipController::class);
    Route::resource('payments', PaymentController::class);

    Route::get('/workouts/generate/create', [WorkoutController::class, 'generateCreate'])
        ->name('workouts.generate.create');

    Route::post('/workouts/generate', [WorkoutController::class, 'generateStore'])
        ->name('workouts.generate.store');

    Route::post('/workouts/generate-next-week', [WorkoutController::class, 'generateNextWeek'])
        ->name('workouts.generateNextWeek');

    Route::delete('/workouts/member/{member}/delete-all', [WorkoutController::class, 'deleteByMember'])
        ->name('workouts.deleteByMember');

    Route::resource('workouts', WorkoutController::class);

    Route::get('/bmi', [BmiController::class, 'index'])->name('bmi.index');
    Route::post('/bmi', [BmiController::class, 'calculate'])->name('bmi.calculate');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/members', [ReportController::class, 'members'])->name('reports.members');
    Route::get('/reports/memberships', [ReportController::class, 'memberships'])->name('reports.memberships');
    Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
    Route::get('/reports/workouts', [ReportController::class, 'workouts'])->name('reports.workouts');
    Route::get('/reports/trainers', [ReportController::class, 'trainers'])->name('reports.trainers');
    Route::get('/reports/membership-analytics', [ReportController::class, 'membershipAnalytics'])->name('reports.membershipAnalytics');

    Route::get('/admin/requests', [MemberRequestController::class, 'adminIndex'])
        ->name('admin.requests.index');

    Route::put('/admin/requests/{id}', [MemberRequestController::class, 'updateStatus'])
        ->name('admin.requests.update');

    Route::delete('/admin/requests/{memberRequest}', [MemberRequestController::class, 'destroy'])
        ->name('admin.requests.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])
        ->name('member.dashboard');

    Route::get('/member/register-membership', [MemberDashboardController::class, 'registerMembership'])
        ->name('member.registerMembership');

    Route::post('/member/register-membership', [MemberDashboardController::class, 'storeMembership'])
        ->name('member.storeMembership');

    Route::get('/member/schedules', [MemberDashboardController::class, 'schedules'])
        ->name('member.schedules');

    Route::get('/member/payments', [MemberDashboardController::class, 'payments'])
        ->name('member.payments');

    Route::get('/member/bmi', [BmiController::class, 'index'])
        ->name('member.bmi');

    Route::post('/member/bmi', [BmiController::class, 'calculate'])
        ->name('member.bmi.calculate');

    Route::get('/member/requests', [MemberRequestController::class, 'memberIndex'])
        ->name('member.requests');

    Route::get('/member/requests/create', [MemberRequestController::class, 'create'])
        ->name('member.requests.create');

    Route::post('/member/requests', [MemberRequestController::class, 'store'])
        ->name('member.requests.store');

    Route::get('/paymongo/success', function () {
        $paymentId = request('payment_id');

        if ($paymentId) {
            $payment = \App\Models\Payment::with('membership')->find($paymentId);

            if ($payment) {
                $payment->update([
                    'status' => 'paid',
                ]);

                if ($payment->membership) {
                    $payment->membership->update([
                        'status' => 'active',
                    ]);
                }
            }
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Online payment successful. Your membership is now active.');
    })->name('paymongo.success');

    Route::get('/paymongo/cancel', function () {
        $paymentId = request('payment_id');

        if ($paymentId) {
            $payment = \App\Models\Payment::with('membership')->find($paymentId);

            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                ]);

                if ($payment->membership) {
                    $payment->membership->update([
                        'status' => 'pending',
                    ]);
                }
            }
        }

        return redirect()->route('member.dashboard')
            ->withErrors(['payment' => 'Online payment was cancelled or failed.']);
    })->name('paymongo.cancel');
});
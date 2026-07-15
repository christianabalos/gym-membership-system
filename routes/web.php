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
use App\Http\Controllers\MemberImportController;

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

    Route::get('/members/export/{format}', [MemberController::class, 'export'])->name('members.export');
    Route::post('/members/import', [MemberImportController::class, 'import'])->name('members.import');

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
    Route::get('/reports/analytics', [ReportController::class, 'analytics'])->name('reports.analytics');

    Route::get('/admin/member-requests', [MemberRequestController::class, 'adminIndex'])
        ->name('admin.member-requests.index');

    Route::patch('/admin/member-requests/{id}/status', [MemberRequestController::class, 'updateStatus'])
        ->name('admin.member-requests.updateStatus');

    Route::delete('/admin/member-requests/{memberRequest}', [MemberRequestController::class, 'destroy'])
        ->name('admin.member-requests.destroy');
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

    Route::get('/paymongo/success', [MemberDashboardController::class, 'paymongoSuccess'])
        ->name('paymongo.success');

    Route::get('/paymongo/cancel', [MemberDashboardController::class, 'paymongoCancel'])
        ->name('paymongo.cancel');
});
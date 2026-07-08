<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkoutController;

Route::name('api.')->group(function () {
    Route::apiResource('members', MemberController::class);
    Route::apiResource('trainers', TrainerController::class);
    Route::apiResource('memberships', MembershipController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('workouts', WorkoutController::class);
});
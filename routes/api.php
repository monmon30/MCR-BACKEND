<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentPatientController;
use App\Http\Controllers\AppointmentPatientDoneController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthPatientAppointmentConsultationsController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientAuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('user', [AuthController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        'patients' => PatientController::class,
        'patients.consultations' => ConsultationController::class,
        'appointments' => AppointmentController::class,
    ]);
    Route::post('/patients/{patient}/appointments/{appointment}/done', [AppointmentPatientDoneController::class, 'mark_done']);
});

Route::prefix('patients')->group(function () {
    Route::post('auth/login', [PatientAuthController::class, 'login']);
    Route::get('auth/user', [PatientAuthController::class, 'index']);
});
Route::apiResource('patients.appointments', AppointmentPatientController::class)->only(['store', 'index']);
Route::get('/appointments/{appointment}/patients/{patient}', AuthPatientAppointmentConsultationsController::class);

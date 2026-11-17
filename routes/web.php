<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PolyclinicController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/patients', [PatientController::class, 'index'])
    ->name('patients.index');

Route::get('/patients/create', [PatientController::class, 'create'])
    ->name('patients.create');

Route::post('/patients', [PatientController::class, 'store'])
    ->name('patients.store');

Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])
    ->name('patients.edit');

Route::put('/patients/{patient}', [PatientController::class, 'update'])
    ->name('patients.update');

Route::patch('/patients/{patient}/deactivate', [PatientController::class, 'deactivate'])
    ->name('patients.deactivate');

Route::get('/registrations', [RegistrationController::class, 'index'])
    ->name('registrations.index');

Route::get('/registrations/create', [RegistrationController::class, 'create'])
    ->name('registrations.create');

Route::post('/registrations', [RegistrationController::class, 'store'])
    ->name('registrations.store');

Route::patch('/registrations/{registration}/status', [
    RegistrationController::class,
    'updateStatus',
])->name('registrations.updateStatus');

Route::get('/examinations', [ExaminationController::class, 'index'])
    ->name('examinations.index');

Route::get('/examinations/{registration}/create', [ExaminationController::class, 'create'])
    ->name('examinations.create');

Route::post('/examinations/{registration}', [ExaminationController::class, 'store'])
    ->name('examinations.store');

Route::get('/doctors', [DoctorController::class, 'index'])
    ->name('doctors.index');

Route::get('/doctors/create', [DoctorController::class, 'create'])
    ->name('doctors.create');

Route::post('/doctors', [DoctorController::class, 'store'])
    ->name('doctors.store');

Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])
    ->name('doctors.edit');

Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])
    ->name('doctors.update');

Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])
    ->name('doctors.destroy');

Route::get('/polyclinics', [PolyclinicController::class, 'index'])
    ->name('polyclinics.index');

Route::get('/polyclinics/create', [PolyclinicController::class, 'create'])
    ->name('polyclinics.create');

Route::post('/polyclinics', [PolyclinicController::class, 'store'])
    ->name('polyclinics.store');

Route::get('/polyclinics/{polyclinic}/edit', [PolyclinicController::class, 'edit'])
    ->name('polyclinics.edit');

Route::put('/polyclinics/{polyclinic}', [PolyclinicController::class, 'update'])
    ->name('polyclinics.update');

Route::delete('/polyclinics/{polyclinic}', [PolyclinicController::class, 'destroy'])
    ->name('polyclinics.destroy');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\AdminController;
use App\Models\Consultation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// CLIENT DASHBOARD (Only logged-in users)
Route::get('/dashboard', function () {
    $myConsultations = Consultation::where('user_id', Auth::id())->latest()->get();
    return view('dashboard', ['myConsultations' => $myConsultations]);
})->middleware(['auth', 'verified'])->name('dashboard');

// REGULAR CLIENT ROUTES
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Law Firm Consultation Routes (Clients can create and delete their own)
    Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');
    Route::delete('/consultation/{id}', [ConsultationController::class, 'destroy'])->name('consultation.destroy');
});

// ADMIN/LAWYER ROUTES (Protected by the 'admin' bouncer)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/consultation/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.consultation.update');
});

require __DIR__.'/auth.php';
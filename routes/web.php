<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Auth;

// Redirect to login if not authenticated, otherwise show welcome view
Route::get('/', function () {
    if (Auth::check()) {
        return view('welcome');
    }
    return redirect()->route('login');
})->name('home');

// Authentication routes
Auth::routes();

// Group routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Application Routes
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');

    // Bill Routes
    Route::get('/applications/{application}/bills/create', [BillController::class, 'create'])->name('bills.create');
    Route::post('/applications/{application}/bills', [BillController::class, 'store'])->name('bills.store');
    Route::get('/applications/{application}/bills/{bill}', [BillController::class, 'show'])->name('bills.show');

    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('/bills/create', [BillController::class, 'showApplications'])->name('bills.create');
    Route::get('bills/{application}/download/{bill}', [BillController::class, 'downloadPdf'])->name('bills.downloadPdf');

    Route::get('/sales', [SalesController::class, 'showSales'])->name('sales');

    // Inventory resource controller
    Route::resource('inventory', InventoryController::class);

    // Dashboard route
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});

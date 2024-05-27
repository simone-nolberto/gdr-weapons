<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\CharacterController;
use App\Http\Controllers\Admin\WeaponController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('guests.welcome');
});

Route::get('/weapons', function () {
    $weapons = \App\Models\Weapon::all();
    return view('guests.weapons', compact('weapons'));
});

Route::get('/characters', function () {
    $characters = \App\Models\Character::all();
    return view('guests.characters', compact('characters'));
});

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // admin.dashboard
        Route::resource('weapons', WeaponController::class);
        Route::resource('characters', CharacterController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

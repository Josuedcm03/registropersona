<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CitizenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportCitizenController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

//     // Ciudades
//   Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
//     Route::get('/cities/create', [CityController::class, 'create'])->name('cities.create');
//     Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
//     Route::get('/cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
//     Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
//     Route::delete('/cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

//     // Ciudadanos
//     Route::get('/citizens', [CitizenController::class, 'index'])->name('citizens.index');
//     Route::get('/citizens/create', [CitizenController::class, 'create'])->name('citizens.create');
//     Route::post('/citizens', [CitizenController::class, 'store'])->name('citizens.store');
//     Route::get('/citizens/{citizen}/edit', [CitizenController::class, 'edit'])->name('citizens.edit');
//     Route::put('/citizens/{citizen}', [CitizenController::class, 'update'])->name('citizens.update');
//     Route::delete('/citizens/{citizen}', [CityController::class, 'destroy'])->name('citizens.destroy');

});

Route::middleware('auth')->group(function () {
    Route::resource('cities', CityController::class);
    Route::resource('citizens', CitizenController::class);
    Route::post('/report', [ReportCitizenController::class, 'send_report'])->name('report');
    Route::post('/citizens/import', [CitizenController::class, 'import'])->name('citizens.import');
    Route::post('/cities/import', [CityController::class, 'import'])->name('cities.import');


});


require __DIR__.'/auth.php';

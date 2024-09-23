<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateRole;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HasilPemeriksaanController;
use App\Http\Controllers\TandaVitalController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\LogController;


Route::get('login', 	[CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('register', [CustomAuthController::class, 'registration'])->name('register');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('/', [HomeController::class, 'index'])->name('dashboard')->middleware(['auth']);

Route::middleware(['auth'])->group(function() {
	// Admin Role
	Route::resource('dokter', DokterController::class)->middleware(ValidateRole::class.':admin');
	Route::resource('apoteker', ApotekerController::class)->middleware(ValidateRole::class.':admin');
	Route::resource('log', LogController::class)->middleware(ValidateRole::class.':admin');

	// Dokter Role
	Route::resource('hasil-pemeriksaan', HasilPemeriksaanController::class)->except(['destroy'])->middleware(ValidateRole::class.':dokter');
	Route::get('hasil-pemeriksaan/delete/{id}', [HasilPemeriksaanController::class, 'destroy'])->name('hasil-pemeriksaan.delete')->middleware(ValidateRole::class.':dokter');

	Route::resource('pasien', PasienController::class)->except(['destroy'])->middleware(ValidateRole::class.':dokter');

	Route::resource('tanda-vital', TandaVitalController::class)->except(['destroy'])->middleware(ValidateRole::class.':dokter');
	Route::get('tanda-vital/delete/{id}', [TandaVitalController::class, 'destroy'])->name('tanda-vital.delete')->middleware(ValidateRole::class.':dokter');

	// Apoteker Role
	Route::resource('resep', ResepController::class)->except(['destroy'])->middleware(ValidateRole::class.':apoteker');
	Route::get('resep/getprice/{id}', [ResepController::class, 'getmedicinePrice'])->name('resep.price')->middleware(ValidateRole::class.':apoteker');
	Route::get('resep/resi/{id}', [ResepController::class, 'cetakResi'])->name('resep.resi')->middleware(ValidateRole::class.':apoteker');
});


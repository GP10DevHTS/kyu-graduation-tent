<?php

use App\Livewire\Graduands\ListAllGraduands;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return redirect()->route('graduands.list');
    // })->name('dashboard');
    Route::redirect('/dashboard', 'graduands')->name('dashboard');

    Route::get('/graduands', ListAllGraduands::class)->name('graduands.list');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\CandidateAdminController;

Route::get('/', [VotingController::class, 'index'])
    ->name('voting.index');

Route::post('/votar', [VotingController::class, 'store'])
    ->name('voting.store');

    Route::get('/apuracao', [
    VotingController::class,
    'results'
])->name('voting.results');

Route::get('/admin/imagens', [
    CandidateAdminController::class,
    'index'
])->name('admin.images');

Route::post('/admin/imagens', [
    CandidateAdminController::class,
    'store'
])->name('admin.images.store');

Route::post('/admin/imagens/{candidate}', [
    CandidateAdminController::class,
    'updateImage'
])->name('admin.images.update');

Route::delete('/admin/imagens/{candidate}', [
    CandidateAdminController::class,
    'destroy'
])->name('admin.images.destroy');
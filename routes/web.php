<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');

Route::get('questions/create', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');

Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit')->middleware('auth');
Route::put('questions/{question}', [QuestionController::class, 'update'])
    ->name('questions.update')
    ->middleware('auth', 'can:update,question');

Route::get('questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])
    ->name('questions.destroy')
    ->middleware('auth', 'can:delete,question');

Route::post('/answers/{question}', [AnswerController::class, 'store'])->name('answers.store')->middleware('auth');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    // Route::get('settings/two-factor', TwoFactor::class)
    //     ->middleware(
    //         when(
    //             Features::canManageTwoFactorAuthentication()
    //                 && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
    //             ['password.confirm'],
    //             [],
    //         ),
    //     )
    //     ->name('two-factor.show');
});

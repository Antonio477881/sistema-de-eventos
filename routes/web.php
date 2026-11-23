<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // 👤 Rotas de Perfil do Usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📅 Gerenciamento de Eventos
    Route::resource('events', EventController::class);

    // 🎟️ Inscrições e Meus Eventos
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
    Route::delete('/events/{event}/cancel', [RegistrationController::class, 'destroy'])->name('events.cancel');
    Route::get('/my-events', [RegistrationController::class, 'myEvents'])->name('events.my');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\FightController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FightController::class, 'index']);

Route::post('/start-game', [FightController::class, 'startGame'])
    ->name('start.game');

Route::post('/fight-turn', [FightController::class, 'fightTurn'])
    ->name('fight.turn');

Route::get('/reset-game', [FightController::class, 'resetGame'])
    ->name('reset.game');

Route::get('/history', [FightController::class, 'history'])
    ->name('history');

Route::get('/history/{id}', [FightController::class, 'showFight'])
    ->name('fight.details');

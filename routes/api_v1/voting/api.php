<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voting\VotingController;

Route::group(['prefix' => 'voting'], function () {
    Route::post('vote', [VotingController::class, 'vote']);
});

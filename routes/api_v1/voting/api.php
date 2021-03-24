<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voting\VotingController;

Route::get('student_information', [VotingController::class, 'getStudentInformation']);
Route::post('vote', [VotingController::class, 'vote']);
Route::get('list_participants', [VotingController::class, 'getListsParticipants']);
Route::get('verify_user', [VotingController::class, 'verifyUser']);
Route::get('verify_transactional_code', [VotingController::class, 'verifyTransactionalCode']);

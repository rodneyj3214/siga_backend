<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Authentication\UserController;
use App\Http\Controllers\Authentication\RoleController;
use App\Http\Controllers\Authentication\PermissionController;
use App\Http\Controllers\Authentication\UserTestController;
use App\Http\Controllers\Authentication\RouteController;
use App\Http\Controllers\Authentication\ShortcutController;
use App\Http\Controllers\Authentication\SystemController;
use Illuminate\Support\Facades\Route;

Route::apiResource('usertest', UserTestController::class);

// Without Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
    Route::post('user-unlock', [AuthController::class, 'unlockUser'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
    Route::post('unlock', [AuthController::class, 'unlock'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
    Route::get('attempts/{username}', [AuthController::class, 'attempts'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
    Route::put('change-password', [AuthController::class, 'changePassword'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
    Route::get('reset-attempts/{username}', [AuthController::class, 'resetAttempts'])->withoutMiddleware(['check-institution', 'check-role', 'check-permissions']);
});

Route::group(['prefix' => 'users'], function () {
    Route::get('{username}', [UserController::class, 'show'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);;
});
// Without Authentication

Route::group(['prefix' => 'auth'], function () {
    Route::get('transactional_code/{username}', [AuthController::class, 'transactionalCode']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('logout_all', [AuthController::class, 'logoutAll']);
});

Route::apiResource('permissions', PermissionController::class);
Route::apiResource('routes', RouteController::class);
Route::apiResource('shortcuts', ShortcutController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('systems', SystemController::class)->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);

Route::group(['prefix' => 'users'], function () {
    Route::post('filters', [UserController::class, 'index']);
    Route::post('roles', [UserController::class, 'getRoles'])->withoutMiddleware(['check-permissions']);
    Route::post('permissions', [UserController::class, 'getPermissions']);
    Route::post('avatars', [UserController::class, 'uploadAvatar']);
    Route::get('export/', [UserController::class, 'export']);
});

Route::group(['prefix' => 'roles'], function () {
    Route::post('users', [RoleController::class, 'getUsers']);
    Route::post('permissions', [RoleController::class, 'getPermissions']);
    Route::post('assign_role', [RoleController::class, 'assignRole']);
    Route::post('remove_role', [RoleController::class, 'removeRole']);
});


Route::get('test', function () {
    return \App\Models\Authentication\Route::with('image')->get();
//    return response()->json(\App\Models\Authentication\User::withoutGlobalScope('isActive')->get());
})->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);

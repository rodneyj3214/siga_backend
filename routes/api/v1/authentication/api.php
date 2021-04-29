<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Authentication\UserController;
use App\Http\Controllers\Authentication\RoleController;
use App\Http\Controllers\Authentication\PermissionController;
use App\Http\Controllers\Authentication\RouteController;
use App\Http\Controllers\Authentication\ShortcutController;
use App\Http\Controllers\Authentication\SystemController;

//$middlewares = ['auth:api', 'check-institution', 'check-role', 'check-status', 'check-attempts', 'check-permissions'];
$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->prefix('/')
    ->group(function () {
        Route::apiResources([
            'users' => UserController::class,
            'permissions' => PermissionController::class,
            'routes' => RouteController::class,
            'shortcuts' => ShortcutController::class,
            'roles' => RoleController::class,
            'systems' => SystemController::class,
        ]);
        // Roles
        Route::prefix('roles')->group(function () {
            Route::post('users', [RoleController::class, 'getUsers']);
            Route::post('permissions', [RoleController::class, 'getPermissions']);
            Route::post('assign-role', [RoleController::class, 'assignRole']);
            Route::post('remove-role', [RoleController::class, 'removeRole']);
        });

        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('roles', [AuthController::class, 'getRoles'])->withoutMiddleware(['check-permissions']);
            Route::get('permissions', [AuthController::class, 'getPermissions']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('unlock', [AuthController::class, 'unlock']);
            Route::put('change-password', [AuthController::class, 'changePassword']);
            Route::post('transactional-code', [AuthController::class, 'generateTransactionalCode']);
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('logout-all', [AuthController::class, 'logoutAll']);
            Route::post('permissions', [AuthController::class, 'getPermissions']);
            Route::get('reset-attempts', [AuthController::class, 'resetAttempts']);
        });

        // User
        Route::prefix('user')->group(function () {
            Route::get('{username}', [UserController::class, 'show']);
            Route::post('filters', [UserController::class, 'index']);
            Route::post('avatars', [UserController::class, 'uploadAvatar']);
            Route::get('export', [UserController::class, 'export']);
        });
    });

// Without Middleware
Route::prefix('/')
    ->group(function () {
        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
            Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
            Route::post('user-unlock', [AuthController::class, 'unlockUser']);
        });
    });

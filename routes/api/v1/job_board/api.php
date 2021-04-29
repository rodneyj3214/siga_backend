<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobBoard\CompanyController;
use App\Http\Controllers\JobBoard\ProfessionalController;
use App\Http\Controllers\JobBoard\OfferController;
use App\Http\Controllers\JobBoard\CategoryController;
use App\Http\Controllers\JobBoard\SkillController;
use App\Http\Controllers\JobBoard\AcademicFormationController;
use App\Http\Controllers\JobBoard\CourseController;
use App\Http\Controllers\JobBoard\LanguageController;
use App\Http\Controllers\JobBoard\ExperienceController;
use App\Http\Controllers\JobBoard\ReferenceController;
use Illuminate\Support\Facades\Storage;

//$middlewares = ['auth:api', 'check-institution', 'check-role', 'check-status', 'check-attempts', 'check-permissions'];
$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->group(function () {
        // index show store update destroy (crud)
        Route::apiResources([
            'catalogues' => SkillController::class,
            'categories' => CategoryController::class,
            'offers' => OfferController::class,
            'skills' => SkillController::class,
            'academic-formations' => AcademicFormationController::class,
            'courses' => CourseController::class,
            'languages' => LanguageController::class,
            'experiences' => ExperienceController::class,
            'references' => ReferenceController::class,
            'companies' => CompanyController::class,
            'professionals' => ProfessionalController::class,
        ]);

        Route::prefix('skill')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', [SkillController::class, 'test']);

            Route::post('image', [SkillController::class, 'uploadImages']);
            Route::post('image/{image}', [SkillController::class, 'updateImage']);
            Route::delete('image/{image}', [SkillController::class, 'deleteImage']);
            Route::get('image', [SkillController::class, 'indexImage']);
            Route::get('image/{image}', [SkillController::class, 'showImage']);

            Route::post('file', [SkillController::class, 'uploadFiles']);
            Route::post('file/{image}', [SkillController::class, 'updateFile']);
            Route::delete('file/{image}', [SkillController::class, 'deleteFile']);
            Route::get('file', [SkillController::class, 'indexFile']);
            Route::get('file/{file}', [SkillController::class, 'showFile']);
        });

        Route::prefix('company')->group( function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';

            })->withoutMiddleware(['auth:api']);
            Route::get('{id}', [CompanyController::class, 'show']);
            Route::put('{id}', [CompanyController::class, 'update']);
            Route::post('register', [CompanyController::class, 'register']);
        });

        Route::prefix('professional')->group(function () {
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('offer')->group(function () {
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('academic_formation')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('course')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('language')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('experience')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('reference')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });
    });

// Without Middleware
Route::prefix('/')
    ->group(function () {
        // ruta para hcer pruebas
        Route::prefix('test')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });
    });


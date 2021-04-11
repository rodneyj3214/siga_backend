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

Route::apiResources([
    'catalogues' => SkillController::class,
    'categories' => CategoryController::class,
    'offers' => OfferController::class,
    'skills' => SkillController::class,
    'academic_formations' => AcademicFormationController::class,
    'courses' => CourseController::class,
    'languages' => LanguageController::class,
    'experiences' => ExperienceController::class,
    'references' => ReferenceController::class,
]);

Route::group(['prefix' => 'company'], function () {
    Route::get('test', [CompanyController::class, 'test']);
});

Route::group(['prefix' => 'professional'], function () {
    Route::get('test', [ProfessionalController::class, 'test']);
});

Route::group(['prefix' => 'offer'], function () {
    Route::get('test', [OfferController::class, 'test']);
});

Route::group(['prefix' => 'skill'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return \App\Models\JobBoard\Skill::find(1);
    })->withoutMiddleware(['auth:api']);

    Route::post('image', [SkillController::class, 'uploadImage']);
    Route::post('image/{image}', [SkillController::class, 'updateImage']);
    Route::delete('image/{image}', [SkillController::class, 'deleteImage']);

    Route::post('file', [SkillController::class, 'uploadFile']);
    Route::post('file/{image}', [SkillController::class, 'updateFile']);
    Route::delete('file/{image}', [SkillController::class, 'deleteFile']);
    Route::get('file', [SkillController::class, 'indexFile']);
    Route::get('file/{file}', [SkillController::class, 'showFile']);
});

Route::group(['prefix' => 'academic_formation'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
});
Route::group(['prefix' => 'course'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
});
Route::group(['prefix' => 'language'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
});

Route::group(['prefix' => 'experience'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
});

Route::group(['prefix' => 'reference'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
});

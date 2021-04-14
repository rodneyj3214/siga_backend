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
    'academic-formations' => AcademicFormationController::class,
    'courses' => CourseController::class,
    'languages' => LanguageController::class,
    'experiences' => ExperienceController::class,
    'references' => ReferenceController::class,
]);

<<<<<<< HEAD
<<<<<<< HEAD
Route::group(['prefix' => 'abilities'], function () {
    Route::get('/test', [AbilityController::class, 'test'])->where('id', '');
=======
Route::group(['prefix' => 'company'], function () {
    Route::get('test', [CompanyController::class, 'test']);
>>>>>>> a85f1ae8c267017175ae37b9bf652a8b479a91a3
=======
Route::group(['prefix' => 'skill'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return \App\Models\JobBoard\Skill::find(1);
    })->withoutMiddleware(['auth:api']);

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

Route::group(['prefix' => 'company'], function () {
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
>>>>>>> ce96b501a2d51c1243d6d9877d7cfcafa3fa6eda
});

Route::group(['prefix' => 'professional'], function () {
    Route::get('test', [ProfessionalController::class, 'test']);
});

Route::group(['prefix' => 'offer'], function () {
<<<<<<< HEAD
    Route::get('test', [OfferController::class, 'test']);
});

<<<<<<< HEAD
Route::group(['prefix' => 'professionals'], function () {
    Route::get('register', [ProfessionalController::class, 'test'])->where('id', '');
=======
Route::group(['prefix' => 'skill'], function () {
    Route::get('test', [SkillController::class, 'test'])->withoutMiddleware(['auth:api']);
>>>>>>> a85f1ae8c267017175ae37b9bf652a8b479a91a3
=======
    // ruta para hcer pruebas
    Route::get('test', function () {
        return 'test';
    })->withoutMiddleware(['auth:api']);
>>>>>>> ce96b501a2d51c1243d6d9877d7cfcafa3fa6eda
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
<<<<<<< HEAD
/*
 * FinGrupo4
 */
=======
>>>>>>> a85f1ae8c267017175ae37b9bf652a8b479a91a3

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
    Route::get('test', [SkillController::class, 'test']);
});

Route::group(['prefix' => 'academic_formation'], function () {
    Route::get('test', [AcademicFormationController::class, 'test']);
});
Route::group(['prefix' => 'course'], function () {
    Route::get('test', [CourseController::class, 'test']);
});
Route::group(['prefix' => 'language'], function () {
    Route::get('test', [LanguageController::class, 'test']);
});

Route::group(['prefix' => 'experience'], function () {
    Route::get('test', [ExperienceController::class, 'test']);
});

Route::group(['prefix' => 'reference'], function () {
    Route::get('test', [ReferenceController::class, 'test']);
});

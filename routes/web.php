<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/',[App\Http\Controllers\IndexController::class, 'index']);
Route::get('/index',[App\Http\Controllers\IndexController::class, 'index']);

Route::get('/privacy',[App\Http\Controllers\PrivacyController::class, 'index']);

Route::get('/inquiry/create',[App\Http\Controllers\InquiryController::class, 'create']);
Route::put('/inquiry/create',[App\Http\Controllers\InquiryController::class, 'send']);
Route::get('/inquiry/confirm',[App\Http\Controllers\InquiryController::class, 'confirm']);
Route::post('/inquiry/confirm',[App\Http\Controllers\InquiryController::class, 'insert']);
Route::get('/inquiry/complete',[App\Http\Controllers\InquiryController::class, 'complete']);
Route::get('/about',[App\Http\Controllers\AboutController::class, 'index']);
Route::get('/faq',[App\Http\Controllers\FaqController::class, 'index']);
Route::get('/select',[App\Http\Controllers\SelectController::class, 'select']);

Route::get('/instructor/step1',[App\Http\Controllers\InstructorController::class, 'step1']);
Route::post('/instructor/step1',[App\Http\Controllers\InstructorController::class, 'step1Send']);
Route::get('/instructor/step2',[App\Http\Controllers\InstructorController::class, 'step2']);
Route::post('/instructor/step2',[App\Http\Controllers\InstructorController::class, 'step2Send']);
Route::get('/instructor/step3',[App\Http\Controllers\InstructorController::class, 'step3']);
Route::post('/instructor/step3',[App\Http\Controllers\InstructorController::class, 'step3Send']);
Route::get('/instructor/confirm',[App\Http\Controllers\InstructorController::class, 'confirm']);
Route::post('/instructor/confirm',[App\Http\Controllers\InstructorController::class, 'insert']);
Route::get('/instructor/complete',[App\Http\Controllers\InstructorController::class, 'complete']);

Route::get('/school/create',[App\Http\Controllers\SchoolController::class, 'create']);
Route::post('/school/create',[App\Http\Controllers\SchoolController::class, 'send']);
Route::get('/school/confirm',[App\Http\Controllers\SchoolController::class, 'confirm']);
Route::post('/school/confirm',[App\Http\Controllers\SchoolController::class, 'insert']);
Route::get('/school/complete',[App\Http\Controllers\SchoolController::class, 'complete']);

Route::get('/instructor/index',[App\Http\Controllers\InstructorController::class, 'index']);
Route::get('/instructor/edit1',[App\Http\Controllers\InstructorController::class, 'edit1']);
Route::get('/instructor/edit2',[App\Http\Controllers\InstructorController::class, 'edit2']);
Route::get('/instructor/edit3',[App\Http\Controllers\InstructorController::class, 'edit3']);
Route::patch('/instructor/edit3',[App\Http\Controllers\InstructorController::class, 'update']);

Route::get('/school/index',[App\Http\Controllers\SchoolController::class, 'index']);
Route::get('/school/edit',[App\Http\Controllers\SchoolController::class, 'edit']);
Route::patch('/school/edit',[App\Http\Controllers\SchoolController::class, 'update']);

Route::get('/message/index',[App\Http\Controllers\MessageController::class, 'message']);
Route::post('/message/index',[App\Http\Controllers\SchoolController::class, 'insert']);
Route::patch('/message/index',[App\Http\Controllers\SchoolController::class, 'update']);
Route::delete('/message/index',[App\Http\Controllers\SchoolController::class, 'destroy']);

Route::get('/recruit/create',[App\Http\Controllers\RecruitController::class, 'create']);
Route::post('/recruit/create',[App\Http\Controllers\RecruitController::class, 'insert']);
Route::get('/recruit/show',[App\Http\Controllers\RecruitController::class, 'detail']);
Route::get('/recruit/edit',[App\Http\Controllers\RecruitController::class, 'edit']);
Route::patch('/recruit/edit',[App\Http\Controllers\RecruitController::class, 'update']);

Route::get('/public/sc-detail',[App\Http\Controllers\PublicController::class, 'scDetail']);
Route::get('/public/ir-detail',[App\Http\Controllers\PublicController::class, 'irDetail']);
Route::get('/public/re-detail',[App\Http\Controllers\PublicController::class, 'reDetail']);
Route::get('/public/ir-search',[App\Http\Controllers\PublicController::class, 'irSearch']);
Route::get('/public/re-search',[App\Http\Controllers\PublicController::class, 'reSearch']);

Route::get('/expire/confirm',[App\Http\Controllers\PublicController::class, 'confirm']);
Route::delete('/expire/confirm',[App\Http\Controllers\PublicController::class, 'destroy']);
Route::get('/expire/complete',[App\Http\Controllers\PublicController::class, 'complete']);

Route::prefix('/admin')->group(function () {

    Route::get('/dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);

    Route::get('/instructor/index',[App\Http\Controllers\Admin\InstructorController::class, 'index']);
    Route::get('/instructor/create',[App\Http\Controllers\Admin\InstructorController::class, 'create']);
    Route::post('/instructor/create',[App\Http\Controllers\Admin\InstructorController::class, 'insert']);
    Route::get('/instructor/show',[App\Http\Controllers\Admin\InstructorController::class, 'detail']);
    Route::delete('/instructor/show',[App\Http\Controllers\Admin\InstructorController::class, 'destroy']);
    Route::get('/instructor/edit',[App\Http\Controllers\Admin\InstructorController::class, 'edit']);
    Route::patch('/instructor/edit',[App\Http\Controllers\Admin\InstructorController::class, 'update']);

    Route::get('/school/index',[App\Http\Controllers\Admin\SchoolController::class, 'index']);
    Route::get('/school/create',[App\Http\Controllers\Admin\SchoolController::class, 'create']);
    Route::post('/school/create',[App\Http\Controllers\Admin\SchoolController::class, 'insert']);
    Route::get('/school/show',[App\Http\Controllers\Admin\SchoolController::class, 'detail']);
    Route::delete('/school/show',[App\Http\Controllers\Admin\SchoolController::class, 'destroy']);
    Route::get('/school/edit',[App\Http\Controllers\Admin\SchoolController::class, 'edit']);
    Route::patch('/school/edit',[App\Http\Controllers\Admin\SchoolController::class, 'update']);

    Route::get('/recruit/index',[App\Http\Controllers\Admin\RecruitController::class, 'index']);
    Route::get('/recruit/create',[App\Http\Controllers\Admin\RecruitController::class, 'create']);
    Route::post('/recruit/create',[App\Http\Controllers\Admin\RecruitController::class, 'insert']);
    Route::get('/recruit/show',[App\Http\Controllers\Admin\RecruitController::class, 'detail']);
    Route::delete('/recruit/show',[App\Http\Controllers\Admin\RecruitController::class, 'destroy']);
    Route::get('/recruit/edit',[App\Http\Controllers\Admin\RecruitController::class, 'edit']);
    Route::patch('/recruit/edit',[App\Http\Controllers\Admin\RecruitController::class, 'update']);

    Route::get('/application/index',[App\Http\Controllers\Admin\ApplicationController::class, 'index']);
    Route::delete('/application/index',[App\Http\Controllers\Admin\ApplicationController::class, 'destroy']);

    Route::get('/keep-recruit/index',[App\Http\Controllers\Admin\KeepRecruitController::class, 'index']);
    Route::delete('/keep-recruit/index',[App\Http\Controllers\Admin\KeepRecruitController::class, 'destroy']);

    Route::get('/keep-instructor/index',[App\Http\Controllers\Admin\KeepInstructorController::class, 'index']);
    Route::delete('/keep-instructor/index',[App\Http\Controllers\Admin\KeepInstructorController::class, 'destroy']);

    Route::get('/notice/index',[App\Http\Controllers\Admin\NoticeController::class, 'index']);
    Route::get('/notice/create',[App\Http\Controllers\Admin\NoticeController::class, 'create']);
    Route::post('/notice/create',[App\Http\Controllers\Admin\NoticeController::class, 'insert']);
    Route::get('/notice/show',[App\Http\Controllers\Admin\NoticeController::class, 'detail']);
    Route::delete('/notice/show',[App\Http\Controllers\Admin\NoticeController::class, 'destroy']);
    Route::get('/notice/edit',[App\Http\Controllers\Admin\NoticeController::class, 'edit']);
    Route::patch('/notice/edit',[App\Http\Controllers\Admin\NoticeController::class, 'update']);

    Route::get('/message/index',[App\Http\Controllers\Admin\MessageController::class, 'index']);
    Route::get('/message/show',[App\Http\Controllers\Admin\MessageController::class, 'detail']);
    Route::delete('/message/show',[App\Http\Controllers\Admin\MessageController::class, 'destroy']);

    Route::get('/inquiry/index',[App\Http\Controllers\Admin\InquiryController::class, 'index']);
    Route::get('/inquiry/show',[App\Http\Controllers\Admin\InquiryController::class, 'detail']);
    Route::delete('/inquiry/show',[App\Http\Controllers\Admin\InquiryController::class, 'destroy']);

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

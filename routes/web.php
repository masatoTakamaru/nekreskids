<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSessionExistence;

$dir = 'App\Http\Controllers';
Route::get('/', [$dir . '\IndexController', 'index']);
Route::get('/privacy', [$dir . '\PrivacyController', 'index']);
Route::get('/inquiry', [$dir . '\InquiryController', 'index']);
Route::get('/about', [$dir . '\AboutController', 'index']);
Route::get('/faq', [$dir . '\FaqController', 'index']);
Route::get('/select', [$dir . '\SelectController', 'index']);

Route::prefix('instructor/')->group(function () {
    $dir = 'App\Http\Controllers\Instructor';
    Route::get('step1', [$dir . '\Step1Controller', 'index']);
    Route::post('step1', [$dir . '\Step1Controller', 'post']);
    Route::get('step2', [$dir . '\Step2Controller', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::post('step2', [$dir . '\Step2Controller', 'post']);
    Route::get('step3', [$dir . '\Step3Controller', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::post('step3', [$dir . '\Step3Controller', 'post']);
    Route::get('confirm', [$dir . '\ConfirmController', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::post('confirm', [$dir . '\ConfirmController', 'post']);
    Route::get('complete', [$dir . '\CompleteController', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::get('draft-complete', [$dir . '\DraftCompleteController', 'index'])
        ->middleware(CheckSessionExistence::class);
});

Route::prefix('school/')->group(function () {
    $dir = 'App\Http\Controllers\School';
    Route::get('create', [$dir . '\CreateController', 'index']);
    Route::post('create', [$dir . '\CreateController', 'post']);
    Route::get('confirm', [$dir . '\ConfirmController', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::post('confirm', [$dir . '\ConfirmController', 'post']);
    Route::get('complete', [$dir . '\CompleteController', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::get('draft-complete', [$dir . '\DraftCompleteController', 'index'])
        ->middleware(CheckSessionExistence::class);
});

Route::prefix('inquiry/')->group(function () {
    $dir = 'App\Http\Controllers\Inquiry';
    Route::get('create', [$dir . '\CreateController', 'index']);
    Route::post('create', [$dir . '\CreateController', 'post']);
    Route::get('confirm', [$dir . '\ConfirmController', 'index'])
        ->middleware(CheckSessionExistence::class);
    Route::post('confirm', [$dir . '\ConfirmController', 'post']);
    Route::get('complete', [$dir . '\CompleteController', 'index'])
        ->middleware(CheckSessionExistence::class);
});

Route::prefix('user/')
    ->middleware(['auth'])
    ->group(function () {
        Route::prefix('instructor/')->group(function () {
            $dir = 'App\Http\Controllers\User\Instructor';
            Route::get('index', [$dir . '\IndexController', 'index']);
        });
    });

Route::prefix('public/')->group(function () {
    $dir = 'App\Http\Controllers\Public';
    Route::get('school', [$dir . '\SchoolController', 'index']);
    Route::get('school-detail', [$dir . '\SchoolShowController', 'index']);
    Route::get('recruit', [$dir . '\RecruitController', 'index']);
    Route::get('recruit-detail', [$dir . '\RecruitShowController', 'index']);
});

Route::prefix('admin')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::prefix('/application')->group(function () {
            $dir = 'App\Http\Controllers\Admin\Application';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/create', [$dir . '\CreateController', 'create']);
            Route::post('/create', [$dir . '\CreateController', 'store']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
            Route::get('/edit', [$dir . '\EditController', 'edit']);
            Route::patch('/edit', [$dir . '\EditController', 'update']);
        });

        Route::prefix('/instructor')->group(function () {
            $dir = 'App\Http\Controllers\Admin\Instructor';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/create', [$dir . '\CreateController', 'create']);
            Route::post('/create', [$dir . '\CreateController', 'store']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
            Route::get('/edit', [$dir . '\EditController', 'edit']);
            Route::patch('/edit', [$dir . '\EditController', 'update']);
        });

        Route::prefix('/school')->group(function () {
            $dir = 'App\Http\Controllers\Admin\School';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/create', [$dir . '\CreateController', 'create']);
            Route::post('/create', [$dir . '\CreateController', 'store']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
            Route::get('/edit', [$dir . '\EditController', 'edit']);
            Route::patch('/edit', [$dir . '\EditController', 'update']);
        });

        Route::prefix('/recruit')->group(function () {
            $dir = 'App\Http\Controllers\Admin\Recruit';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/schoolIndex', [$dir . '\SchoolIndexController', 'index']);
            Route::get('/create', [$dir . '\CreateController', 'create']);
            Route::post('/create', [$dir . '\CreateController', 'store']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
            Route::get('/edit', [$dir . '\EditController', 'edit']);
            Route::patch('/edit', [$dir . '\EditController', 'update']);
        });

        Route::prefix('/inquiry')->group(function () {
            $dir = 'App\Http\Controllers\Admin\Inquiry';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/create', [$dir . '\CreateController', 'create']);
            Route::post('/create', [$dir . '\CreateController', 'store']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
            Route::get('/edit', [$dir . '\EditController', 'edit']);
            Route::patch('/edit', [$dir . '\EditController', 'update']);
        });

        Route::prefix('/notice')->group(function () {
            $dir = 'App\Http\Controllers\Admin\Notice';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/create', [$dir . '\CreateController', 'create']);
            Route::post('/create', [$dir . '\CreateController', 'store']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
            Route::get('/edit', [$dir . '\EditController', 'edit']);
            Route::patch('/edit', [$dir . '\EditController', 'update']);
        });

        Route::prefix('/message')->group(function () {
            $dir = 'App\Http\Controllers\Admin\Message';
            Route::get('/index', [$dir . '\IndexController', 'index']);
            Route::get('/show', [$dir . '\ShowController', 'show']);
            Route::delete('/show', [$dir . '\ShowController', 'destroy']);
        });

        Route::prefix('/keepInstructor')->group(function () {
            $dir = 'App\Http\Controllers\Admin\KeepInstructor';
            Route::get('/index', [$dir . '\IndexController', 'index']);
        });

        Route::prefix('/keepRecruit')->group(function () {
            $dir = 'App\Http\Controllers\Admin\KeepRecruit';
            Route::get('/index', [$dir . '\IndexController', 'index']);
        });

        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

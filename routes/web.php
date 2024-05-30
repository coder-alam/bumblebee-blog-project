<?php

use App\Http\Controllers\Backend\Admin\Category\CategoryController;
use App\Http\Controllers\Backend\Admin\Permission\PermissionController;
use App\Http\Controllers\Backend\Admin\Role\RoleController;
use App\Http\Controllers\Backend\Admin\Tag\TagController;
use App\Http\Controllers\Backend\Admin\User\UseProfilerController;
use App\Http\Controllers\Backend\Admin\User\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    Inertia::setRootView('admin');
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth', 'role:admin', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/delete/{user_id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/users/profile', [UseProfilerController::class, 'index'])->name('user.profile.index');
    Route::post('/users/update/{id}', [UseProfilerController::class, 'update'])->name('user.profile.update');
    Route::post('/profile/photo', [UseProfilerController::class, 'profile_photo'])->name('user.profile.photo');

    // Category Routes List
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/delete/{category_id}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
    Route::post('/category/update/{category_id}', [CategoryController::class, 'category_update'])->name('category.update');

    // Tag Routes List
    Route::get('/tag', [TagController::class, 'index'])->name('tag.index');
    Route::get('/tag/create', [TagController::class, 'create'])->name('tag.create');
    Route::post('/tag/store', [TagController::class, 'store'])->name('tag.store');

//    Roles And Permission
    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

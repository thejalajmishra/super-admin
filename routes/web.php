<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/mark-as-read', [UserController::class, 'markAsRead'])->name('mark-as-read');
Route::get('/search', [UserController::class, 'search'])->name('search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::group(['middleware' => ['role_or_permission:superadmin|users lists']], function () {
        Route::get('users/lists', [UserController::class, 'index'])->name('users.lists');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|users create']], function () {
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|users update']], function () {
        Route::get('users/{id}/edit/', [UserController::class, 'edit'])->name('users.edit');
        Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|users delete']], function () {
        Route::get('users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|users permissions']], function () {
        Route::get('users/{id}/permissions/', [UserController::class, 'permissions'])->name('users.permissions');
        Route::post('users/update-permissions/{id}', [UserController::class, 'update_permissions'])->name('users.update-permissions');
    // });
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::group(['middleware' => ['role_or_permission:superadmin|roles lists']], function () {
        Route::get('roles/lists', [RoleController::class, 'index'])->name('roles.lists');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|roles create']], function () {
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|roles update']], function () {
        Route::get('roles/{id}/edit/', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|roles delete']], function () {
        Route::get('roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|roles permissions']], function () {
        Route::get('roles/{id}/permissions/', [RoleController::class, 'permissions'])->name('roles.permissions');
        Route::post('roles/update-permissions/{id}', [RoleController::class, 'update_permissions'])->name('roles.update-permissions');
    // });
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::group(['middleware' => ['role_or_permission:superadmin|permissions lists']], function () {
        Route::get('permissions/lists', [PermissionController::class, 'index'])->name('permissions.lists');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|permissions create']], function () {
        Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|permissions update']], function () {
        Route::get('permissions/{id}/edit/', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::post('permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    // });
    // Route::group(['middleware' => ['role_or_permission:superadmin|permissions delete']], function () {
        Route::get('permissions/{id}/delete', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    // });
});

require __DIR__.'/auth.php';

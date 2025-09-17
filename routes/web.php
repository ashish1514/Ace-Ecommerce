<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Users\{UserIndex, UserCreate, UserEdit, UserShow};
use App\Livewire\Products\{ProductIndex, ProductCreate, ProductEdit, ProductShow};
use App\Livewire\Roles\{RolesIndex, RolesCreate, RolesEdit, RolesShow};
use App\Http\Controllers\SwitchUserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard',[SwitchUserController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('users', UserIndex::class)->name('users.index');
Route::get('users/create', UserCreate::class)->name('users.create');
Route::get('users/{id}/edit', UserEdit::class)->name('users.edit');
Route::get('users/{id}', UserShow::class)->name('users.show');

Route::get('products', ProductIndex::class)->name('products.index')->middleware("permission:Product Show|Product Add|Product Edit|Product Delete");
Route::get('products/create', ProductCreate::class)->name('products.create')->middleware("permission:Product Add");
Route::get('products/{id}/edit', ProductEdit::class)->name('products.edit')->middleware("permission:Product Edit");
Route::get('products/{id}', ProductShow::class)->name('products.show')->middleware("permission:Product Show");

Route::get('roles', RolesIndex::class)->name('roles.index')->middleware("permission:Role Show|Role Add|Role Edit|Role Delete");
Route::get('roles/create', RolesCreate::class)->name('roles.create')->middleware("permission:Role Add");
Route::get('roles/{id}/edit', RolesEdit::class)->name('roles.edit')->middleware("permission:Role Edit");
Route::get('roles/{id}', RolesShow::class)->name('roles.show')->middleware("permission:Role Show");

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/switch-user/{user}', [SwitchUserController::class, 'switchTo'])->name('admin.switchUser');
    Route::get('/admin/switch-back', [SwitchUserController::class, 'switchBack'])->name('admin.switch.back');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

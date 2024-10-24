<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', action: [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(BookController::class)->group(function(){

    Route::get('/book/all','index')->name('book.all');
    Route::get('/book/view/{id}','show')->name('book.view');
    Route::get('/book/edit/{id}','edit')->name('book.edit');
    Route::post('/book/update/{id}','update')->name('book.update');
    Route::get('/book/delete/{id}','destroy')->name('book.delete');

});
// todo: Use Policies on Route
// ->can('update,delete');
// ->middleware('can:update,delete,view');

// todo: Use Policies on Route

// Route::post('/book/update/{id}',[BookController::class,'update'])->name('book.update')->can('update','delete'); // todo: if i want attach multiple policies

// Route::post('/book/update/{id}',[BookController::class,'update'])->name('book.update')->middleware('can:update,delete'); // todo: if i want attach multiple policies


Route::controller(AdminController::class)->group(function(){

    Route::get('/admin/logout','logout')->name('admin.logout');

});


require __DIR__.'/auth.php';

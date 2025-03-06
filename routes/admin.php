<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookItemController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\IssuedBookController;



Route::get('/admin', function () {
    return view('admin.home');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth', 'auth.session', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('register', [AuthController::class, 'register'])->name('register-users');
    Route::put('password-user/{user}', [AuthController::class, 'changePassUser'])->name('resetPasswordUser');
});

Route::middleware(['auth', 'auth.session', 'permission'])->group(function () {
    Route::resource('author', AuthorController::class)->names([
        'index'=>'admin.author.index',
        'create'=>'admin.author.create',
        'store'=>'admin.author.store',
        'edit'=>'admin.author.edit',
        'update'=>'admin.author.update',
        'destroy'=>'admin.author.destroy',
    ]);
    Route::resource('genre', GenreController::class)->names([
        'index'=>'admin.genre.index',
        'create'=>'admin.genre.create',
        'store'=>'admin.genre.store',
        'edit'=>'admin.genre.edit',
        'update'=>'admin.genre.update',
        'destroy'=>'admin.genre.destroy',
    ]);
    Route::resource('publisher', PublisherController::class)->names([
        'index'=>'admin.publisher.index',
        'create'=>'admin.publisher.create',
        'store'=>'admin.publisher.store',
        'edit'=>'admin.publisher.edit',
        'update'=>'admin.publisher.update',
        'destroy'=>'admin.publisher.destroy',
    ]);
    Route::resource('tag', TagController::class)->names([
        'index'=>'admin.tag.index',
        'store'=>'admin.tag.store',
        'update'=>'admin.tag.update',
        'destroy'=>'admin.tag.destroy',
    ]);
    Route::resource('book', BookController::class)->names([
        'index'=>'admin.book.index',
        'create'=>'admin.book.create',
        'store'=>'admin.book.store',
        'edit'=>'admin.book.edit',
        'update'=>'admin.book.update',
        'show'=>'admin.book.show',
        'destroy'=>'admin.book.destroy',
    ]);
    Route::resource('book_item', BookItemController::class)->names([

        'store'=>'admin.book_item.store',
        'update'=>'admin.book_item.update',
        'destroy'=>'admin.book_item.destroy',
    ]);
    Route::resource('customer', CustomerController::class)->names([
        'index'=>'admin.customer.index',
        'create'=>'admin.customer.create',
       'store'=>'admin.customer.store',
        'edit'=>'admin.customer.edit',
        'update'=>'admin.customer.update',
        'destroy'=>'admin.customer.destroy',
        'show'=>'admin.customer.show'
    ]);
    Route::resource('issued_book', IssuedBookController::class)->names([
        'index'=>'admin.issued_book.index',
        'create'=>'admin.issued_book.create',
       'store'=>'admin.issued_book.store',
        'edit'=>'admin.issued_book.edit',
        'update'=>'admin.issued_book.update',
        'destroy'=>'admin.issued_book.destroy',
    ]);
    Route::put('issued_book/return/{issued_book}', [IssuedBookController::class, 'returned_book'])->name('admin.issued_book.returned_book');

});

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'create']);
    Route::post('login', [AuthController::class, 'store'])->name('login');
});

Route::middleware('auth', 'auth.session')->prefix('admin')->group(function () {
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('profile', [AuthController::class, 'editProfile'])->name('edit-profile');
    Route::put('profile/{user}', [AuthController::class, 'updateProfile'])->name('update-profile');
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('change-password');

    Route::group(['prefix' => 'files'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::get('/file-manager', function() {
        return view('admin.category-dash.file-manager.index');
    })->name('file-manager-index');
    Route::get('/file-manager-show', [App\Http\Controllers\Admin\FileManagerController::class, 'index'])->name('file-manager-dashboard');
});

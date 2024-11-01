<?php
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AdminAlbumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [AlbumController::class, 'showRecentAlbum'])->name('welcome');

Route::get('/test-log', function () {
    \Log::info('Test log message');
    return 'Log message created!';
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(\App\Http\Middleware\admin::class)->group(function () {
        Route::get('/admin/albums', [AdminAlbumController::class, 'index'])->name('admin.albums');
        Route::post('/admin/albums/{album}/toggle', [AdminAlbumController::class, 'toggleStatus'])->name('admin.albums.toggle');
        Route::delete('/admin/albums/{album}', [AdminAlbumController::class, 'destroy'])->name('albums.admin.destroy');
    });


});



Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');

Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create')->middleware('auth');
Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');

Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');
Route::post('/albums/{album}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comment.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('albums/{id}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
Route::put('albums/{id}', [AlbumController::class, 'update'])->name('albums.update');
Route::delete('albums/{id}', [AlbumController::class, 'destroy'])->name('albums.user.destroy');

Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
Route::post('/profile/image/upload', [ProfileController::class, 'updateProfileImage'])->name('profile.image.upload');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');




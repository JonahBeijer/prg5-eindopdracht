<?php
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/about-us', function() {
    $company = 'Hogeschool Rotterdam';
    return view('about-us', [
        'company' => $company
    ]);
})->name('about-us');


Route::get('products/{id}', function(int$id) {
    // We geven het id door aan een view
    return view('show-product', ['id' => $id]);
})->name('show-product');


Route::get('/contact', function() {
    return 'This page is our contact information';
})->name('contact');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');


Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');




Route::get('albums/{id}/edit', [AlbumController::class, 'edit'])->name('albums.edit');


Route::put('albums/{id}', [AlbumController::class, 'update'])->name('albums.update');

Route::patch('albums/{id}', [AlbumController::class, 'update'])->name('albums.update');

Route::delete('albums/{id}', [AlbumController::class, 'destroy'])->name('albums.destroy');




//"Controller Method (een controller met een speciefieke methode aan te roepen)
//Route::get('/about-us', [PageController::class, 'aboutUs']);
//
//invoke controller (Een controller met een __invoke-methode kan worden gebruikt zonder expliciete methodeaanduiding.)
//Hier is de PageController een enkelvoudige actiecontroller met een __invoke-methode.)
//
//Route::get('/about-us', PageController::class);
//
//namedroutes (routes een naam geven)
//Route::get('/about-us', [PageController::class, 'aboutUs'])->name('about');
//
//Middleware ( voor authenticatie)
//Route::get('/about-us', [PageController::class, 'aboutUs'])->middleware('auth');
//
//
//via view routee (zonder controller)
//Route::view('/about-us', 'about');"

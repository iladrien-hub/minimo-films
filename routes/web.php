<?php

use App\Models\SearchFilm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\PageController::class, 'welcome'])->name('welcome');

Route::get('/home', [App\Http\Controllers\PageController::class, 'home'])->name('home');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin route
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

// Adding a new film
Route::get('/new-film', [App\Http\Controllers\FilmController::class, 'create_index'])->name('new-film');

// Posting a new film
Route::post('/new-film', [App\Http\Controllers\FilmController::class, 'add_film'])->name('post-new-film');

// Removing film
Route::get("/remove-film/{id}", [App\Http\Controllers\FilmController::class, 'remove_film'])->name('remove-film');

// Adding a new category
Route::get('/new-genre', [App\Http\Controllers\GenreController::class, 'create_index'])->name('new-genre');

// Adding a new person
Route::get('/new-person', [App\Http\Controllers\PersonController::class, 'create_index'])->name('new-person');

// Posting a new genre
Route::post('/new-genre', [App\Http\Controllers\GenreController::class, 'add_genre'])->name('post-new-genre');

// Posting a new person
Route::post('/new-person', [App\Http\Controllers\PersonController::class, 'add_person'])->name('post-new-person');

// Updating page for a genre
Route::get("/update-genre/{id}", [App\Http\Controllers\GenreController::class, 'update_index'])->name('update-genre');

// Updating page for a person
Route::get("/update-person/{id}", [App\Http\Controllers\PersonController::class, 'update_index'])->name('update-person');

// Posting changes for a genre
Route::post('/update-genre', [App\Http\Controllers\GenreController::class, 'update_genre'])->name('post-update-genre');

// Posting changes for a person
Route::post('/update-person', [App\Http\Controllers\PersonController::class, 'update_person'])->name('post-update-person');

// Updating a film
Route::get("/update-film/{id}", [App\Http\Controllers\FilmController::class, 'update_index'])->name('update-film');

// Posting changes for a film
Route::post('/update-film', [App\Http\Controllers\FilmController::class, 'update_film'])->name('post-update-film');

// Removing genre
Route::get("/remove-genre/{id}", [App\Http\Controllers\GenreController::class, 'remove_genre'])->name('remove-genre');

// Removing person
Route::get("/remove-person/{id}", [App\Http\Controllers\PersonController::class, 'remove_person'])->name('remove-person');

// Purchasing
Route::get("/purchase/{id}", [App\Http\Controllers\FilmController::class, 'purchase'])->name('purchase');

//// Searching films
//Route::get("/search/{genre?}", [App\Http\Controllers\PageController::class, 'search'])->name('search-film');

// Searching
Route::get('/search', [App\Http\Controllers\PageController::class, 'search'])->name('search');

// Paging route
Route::get("/{id}", [App\Http\Controllers\PageController::class, 'index'])->name('page');



<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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


Route::get('', function () {
    return redirect('home');
});

//Rutas para la autenticación (Generadas con artisan y laravel/ui)
Auth::routes();

// Ruta para la home page
Route::get('/home', [HomeController::class, 'index'])->name('home');


/* Rutas para los libros */
Route::prefix('book')->middleware('auth')->group(function () {
    //Mostrar formulario del libro (Creación)
    Route::get('create', [BookController::class, 'create'])->name("book.form");
    //Mostrar todos los libros
    Route::get('', [BookController::class, 'index'])->name("book.index");
    //Guardar un libro nuevo
    Route::post('', [BookController::class, 'store'])->name("book.store");
    //Actualizar un libro
    Route::put('', [BookController::class, 'update'])->name("book.update");
    //Mostrar formulario del libro (Edición)
    Route::get('{id}', [BookController::class, 'edit'])->name("book.edit");
    //Eliminar un libro
    Route::delete('{id}', [BookController::class, 'destroy'])->name("book.delete");
});


/* Rutas para los clientes */
Route::prefix('client')->middleware('auth')->group(function () {
    // Mostrar formulario del cliente (Creación)
    Route::get('create', [ClientController::class, 'create'])->name("client.form");
    // Mostrar todos los clientes
    Route::get('', [ClientController::class, 'index'])->name("client.index");
    // Guardar un cliente nuevo
    Route::post('', [ClientController::class, 'store'])->name("client.store");
    //Actualizar un cliente
    Route::put('', [ClientController::class, 'update'])->name("client.update");
    //Mostrar formulario de edición de un cliente
    Route::get('{id}', [ClientController::class, 'edit'])->name("client.edit");
    //Eliminar un cliente
    Route::delete('{id}', [ClientController::class, 'destroy'])->name("client.delete");
});


/* Rutas para los prestamos */

Route::prefix('borrows')->middleware('auth')->group(function () {
    //Registrar prestamo de libros
    Route::post('', [BorrowController::class, 'store'])->name("borrow.store");
    //Libros que se pueden prestar
    Route::get('books', [BookController::class, 'borrowableBooks'])->name("borrow.books");
    //Formulario para registrar prestamos
    Route::get('{clientId}', [BorrowController::class, 'create'])->name("borrow.form");
});

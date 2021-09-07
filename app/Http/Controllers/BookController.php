<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookCreate;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Muestra la lista del libro.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = Book::all();


        return view("books.index", [
            "books" => $books
        ]);
    }

    /**
     * Muestra el formulario de creación del libro.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("books.form");
    }

    /**
     * Guarda un nuevo libro
     *
     * @param  \Illuminate\Http\BookCreate  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreate $request)
    {
        $book = new Book();
        $book->fill($request->all());
        $book->save();
        return redirect(route("book.index"));
    }

    /**
     * Muestra el formulario de edición del libro
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($bookId)
    {
        //
        $book = Book::find($bookId);
        return view("books.form", compact("book"));
    }

    /**
     * Actualiza el libro
     *
     * @param  \Illuminate\Http\BookCreate  $request
     * @return \Illuminate\Http\Response
     */
    public function update(BookCreate $request)
    {
        //
        $book = Book::find($request->id);
        $book->fill($request->all());
        $book->save();
        return redirect(route("book.index"));
    }

    /**
     * Elimina el libro.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($bookId)
    {

        $book = Book::find($bookId);
        if ($book->is_borrowed) {
            var_dump("hola");
            return redirect(route("book.index"))->withErrors(["borrowed_book" => "El libro se encuentra prestado"]);
        }
        $book->delete();
        return redirect(route("book.index"));
    }

    /**
     * Retorna los libros disponibles para ser prestados
     *
     *
     * */

    public function borrowableBooks()
    {
        $books = collect(Book::all());
        $books = $books->map(function ($book) {
            $book->last_borrow = $book->borrows->last();
            return $book;
        });
        return $books;
    }
}

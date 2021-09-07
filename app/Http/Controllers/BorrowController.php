<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRegisterRequest;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    //

    function create($clientId)
    {
        /* Devolvemos la vista del formulario de prestamo con los libros (activos) y con el estado de si están prestados y el cliente al que le vamos a prestar los libros */
        $books = Book::all();
        $client = Client::find($clientId);
        return view("books.borrows.form", compact("books", "clientId", "client"));
    }


    function store(BorrowRegisterRequest $request)
    {

        //Creamos un arreglo de errores por si devuelven un libro que no hayan prestado ellos
        $errors = ["refundedBooks" => [], "borrowedBooks" => []];

        //Tomamos los ids de los libros que van a pedir prestados
        $books = $request->input('books');
        //Tomamos los ids de los libros que se van a devolver
        $refundedBooks = $request->input('refundedBooks');
        //El id del cliente al que vamos a prestar los libros
        $client = $request->input('client');

        //Buscamos en base de datos cada uno de los libros para poder actualizar su estado de prestados
        $borrowedBooks = Book::find($books);
        //Por cada libro vamos a registrar un prestamo y actualizaremos el estado del libro a prestado
        foreach ($borrowedBooks as $book) {
            if ($book->is_borrowed) {
                $errors['borrowedBooks'][] = ["message" => "El libro $book->title de $book->author ya se encuentra prestado "];
                continue;
            }
            //Fecha actual
            $currentDate = date("d-m-Y");
            //Sumamos 2 semanas para asignar una fecha de entrega automatica
            $date = date("d-m-Y", strtotime($currentDate . "+ 2 week"));
            //Creamos el prestamo
            $borrow = new Borrow();
            //Asignamos el cliente
            $borrow->client_id = $client;
            //Asignamos el usuario que presta el libro
            $borrow->user_id = Auth::id();
            //Asignamos el libro que estamos prestando
            $borrow->book_id = $book->id;
            //Asignamos la fecha de devolución
            $borrow->devolution_due = $date;
            //Guardamos el prestamo
            $borrow->save();
            //Cambiamos el estado del libro a prestado
            $book->is_borrowed = true;
            //Guardamos el libro
            $book->save();
        }
        //Buscamos los libros que nos devuelven
        $refundedBooks = Book::find($refundedBooks);
        //Buscamos al cliente para obtener info de él
        $client = Client::find($client);
        //Por cada libro devuelto operamos y actualizamos el libro para que esté cómo no prestado
        foreach ($refundedBooks as $refundedBook) {
            $borrow = $refundedBook->borrows->last();
            $refundedBook->is_borrowed = false;
            $refundedBook->save();
        }

        return $errors;
    }
}

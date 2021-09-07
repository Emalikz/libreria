@extends('layouts.app')

@push('css')

@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Libros</div>
                <div class="table-responsive card-body">
                    <table class="table">
                        <thead class="bg-dark text-white">
                            <tr>
                                <td>Título</td>
                                <td>Autor</td>
                                <td>Número de páginas</td>
                                <td>Código ISBN</td>
                                <td>Opciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($books) && count($books) > 0)
                                @foreach ($books as $book)
                                    <tr>
                                        <td>{{$book->title}}</td>
                                        <td>{{$book->author}}</td>
                                        <td>{{$book->number_pages}}</td>
                                        <td>{{$book->isbn_code}}</td>
                                        <td class="btn-group">
                                            <a href="{{route('book.edit', ['id'=>$book->id])}}" class="btn btn-info">🖊</a>
                                            <form method="POST" action="{{route('book.delete',["id"=>$book->id])}}">
                                                @csrf
                                                @method('delete')
                                                <button  class="btn btn-danger" type="submit">🗑</button>
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No hayamos ningún registro</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @error('borrowed_book')
                <div class="alert alert-danger mt-4 alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> No puedes borrar un libro que se encuentra prestado.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            @enderror
        </div>
    </div>
</div>
@endsection

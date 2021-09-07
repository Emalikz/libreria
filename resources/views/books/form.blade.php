@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">Registrar Libro</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('book.store') }}">
                        @method(isset($book->id) ? 'PUT' : 'POST')
                        @csrf
                        @isset($book->id)
                            <input type="number" name="id" hidden value="{{$book->id}}">
                        @endisset
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Título</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ isset($book) ? $book->title : old('title') }}"  autocomplete="title" autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Autor</label>

                            <div class="col-md-6">
                                <input id="author" type="author" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ isset($book) ? $book->author : old('author') }}" autocomplete="author">

                                @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Número de páginas</label>

                            <div class="col-md-6">
                                <input id="number_pages" value="{{ isset($book) ? $book->number_pages : old('number_pages') }}" type="number" min="0" class="form-control @error('number_pages') is-invalid @enderror" name="number_pages" autocomplete="number_pages">

                                @error('number_pages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isbn_code" class="col-md-4 col-form-label text-md-right">Código ISBN</label>

                            <div class="col-md-6">
                                <input @isset($book->id) disabled @endisset id="isbn_code" value="{{isset($book)?$book->isbn_code:old('isbn_code')}}" type="text" class="form-control @error('isbn_code') is-invalid @enderror" name="isbn_code" autocomplete="isbn_code">
                                @error('isbn_code')
                                    <span class="invalid-feedback" >
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-12 mb-0">
                            <div class="offset-md-12">
                                <button type="submit" class="btn btn-block btn-success">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

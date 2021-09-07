@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">Registrar Cliente</div>

                <div class="card-body">
                    <form method="POST" class="row" action="{{ route('client.store') }}">
                        @method(isset($client->id) ? 'PUT' : 'POST')
                        @csrf
                        @isset($client->id)
                            <input type="number" name="id" hidden value="{{$client->id}}">
                        @endisset
                        {{-- Primer Nombre --}}
                        <div class="form-group col-md-6">
                            <label for="name" class="col-md-12 col-form-label text-md-left">Primer Nombre <span class="text-danger">*</span>:</label>

                            <div class="col-md-12">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ isset($client) ? $client->first_name : old('first_name') }}" autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Segundo Nombre --}}

                        <div class="form-group col-md-6">
                            <label for="second_name" class="col-md-12 col-form-label text-md-left">Segundo Nombre:</label>

                            <div class="col-md-12">
                                <input id="second_name" type="second_name" class="form-control @error('second_name') is-invalid @enderror" name="second_name" value="{{ isset($client) ? $client->second_name : old('second_name') }}" autocomplete="second_name">

                                @error('second_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Primer Apellido --}}

                        <div class="form-group col-md-6">
                            <label for="first_lastname" class="col-md-12 col-form-label text-md-left">Primer Apellido <span class="text-danger">*</span>:</label>

                            <div class="col-md-12">
                                <input id="first_lastname" type="first_lastname" class="form-control @error('first_lastname') is-invalid @enderror" name="first_lastname" value="{{ isset($client) ? $client->first_lastname : old('first_lastname') }}" autocomplete="first_lastname">

                                @error('first_lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Segundo Apellido --}}
                        <div class="form-group col-md-6">
                            <label for="second_lastname" class="col-md-12 col-form-label text-md-left">Segundo Apellido <span class="text-danger">*</span>:</label>

                            <div class="col-md-12">
                                <input id="second_lastname" type="second_lastname" class="form-control @error('second_lastname') is-invalid @enderror" name="second_lastname" value="{{ isset($client) ? $client->second_lastname : old('second_lastname') }}" autocomplete="second_lastname">

                                @error('second_lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Tipo de documento --}}
                        <div class="form-group col-md-6">
                            <label for="document_id" class="col-md-12 col-form-label text-md-left">Tipo de documento <span class="text-danger">*</span>:</label>

                            <div class="col-md-12">

                                <select name="document_id" id="document_id" class="form-control @error('document_id') is-invalid @enderror" name="document_id" value="{{ isset($client) ? $client->document_id : old('document_id') }}" autocomplete="document_id">
                                    <option value=""></option>
                                    @foreach ($documentTypes as $documentType )
                                        <option @if(isset($client->id) && $documentType->id == $client->document_id) selected @endif @if ($documentType->id == old('document_id')) selected @endif value="{{ $documentType->id }}">{{$documentType->name}}</option>
                                    @endforeach
                                </select>

                                @error('document_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Número de dócumento --}}
                        <div class="form-group col-md-6">
                            <label for="birth_date" class="col-md-12 col-form-label text-md-left">Número de dócumento <span class="text-danger">*</span>:</label>

                            <div class="col-md-12">
                                <input @isset($client->id) disabled @endisset id="identification_number" type="number" class="form-control @error('identification_number') is-invalid @enderror" name="identification_number" value="{{ isset($client) ? $client->identification_number : old('identification_number') }}" autocomplete="identification_number">

                                @error('identification_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Fecha de nacimiento --}}
                        <div class="form-group col-md-6">
                            <label for="birth_date" class="col-md-12 col-form-label text-md-left">Fecha de nacimiento <span class="text-danger">*</span>:</label>

                            <div class="col-md-12">
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ isset($client) ? $client->birth_date : old('birth_date') }}" autocomplete="birth_date">

                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Dirección de residencia --}}
                        <div class="form-group col-md-6">
                            <label for="address" class="col-md-12 col-form-label text-md-left">Dirección:</label>

                            <div class="col-md-12">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ isset($client) ? $client->address : old('address') }}" autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Dirección de residencia --}}
                        <div class="form-group col-md-6">
                            <label for="telephone_number" class="col-md-12 col-form-label text-md-left">Número de teléfono:</label>

                            <div class="col-md-12">
                                <input id="telephone_number" type="tel" class="form-control @error('telephone_number') is-invalid @enderror" name="telephone_number" value="{{ isset($client) ? $client->telephone_number : old('telephone_number') }}" autocomplete="telephone_number">

                                @error('telephone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-0">
                            <div class="col-md-12">
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

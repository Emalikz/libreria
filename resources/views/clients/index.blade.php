@extends('layouts.app')

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
                                <td>Nombre</td>
                                <td>Tipo documento</td>
                                <td>Número de documento</td>
                                <td>Fecha de nacimiento</td>
                                <td>Dirección de residencia</td>
                                <td>Teléfono</td>
                                <td>Opciones</td>
                            </tr>
                        </thead>
                        <tbody id="clients">
                            @if (!empty($clients) && count($clients) > 0)
                                @foreach ($clients as $client)
                                    <tr data-client-id="{{$client->id}}">
                                        <td>{{$client->first_name}} {{$client->second_name}} {{$client->first_lastname}}  {{$client->second_lastname}}</td>
                                        <td>{{$client->documentType->name}}</td>
                                        <td>{{$client->identification_number}}</td>
                                        <td>{{$client->birth_date}}</td>
                                        <td>{{$client->address}}</td>
                                        <td>{{$client->telephone_number}}</td>
                                        <td>
                                            <form class="btn-group" method="POST" action="{{route('client.delete',["id"=>$client->id])}}">
                                                <a href="{{route('client.edit', ['id'=>$client->id])}}" class="btn btn-primary">🖊</a>
                                                <a href="{{route('borrow.form',['clientId'=>$client->id])}}"  class="btn btn-info" type="button" title="Prestar libros">📚</a>
                                                @csrf
                                                @method('delete')
                                                <button  class="btn btn-danger" type="submit">🗑</button>
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No hayamos ningún registro</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@once
    @push('script')
        <script type="text/javascript">
            console.log("hola")
        </script>
    @endpush

@endonce

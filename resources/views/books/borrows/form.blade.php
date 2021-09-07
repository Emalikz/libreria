@extends('layouts.app')

@section('content')
    <borrow-form :client="{{json_encode($client)}}"></borrow-form>
@endsection

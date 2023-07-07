@extends('adminlte::page')
@section('title', 'Perfil')

@section('content_header')
    {{-- <h1>USUARIO NO AUTORIZADO</h1> --}}
@stop

@section('content')
<div class="row">
    <div class="col-sm-4 col-md-4 col-xl-2"></div>
    <div class="col-sm-8 col-md-8 col-xl-8 p-5 m-3"> <img src="{{ url('/').'/img/admin/no_autorizado.jpg'}}"  width="400px" height="400px" class="rounded mx-auto d-block"></div>
    <div class="col-sm-4 col-md-4 col-xl-6"></div>

</div>
@stop
{{--
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
    <script> console.log('Hi!'); </script>
@stop

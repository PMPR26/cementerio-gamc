@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Cementerio</h1>
@stop

@section('content')
<div class="col-sm-12 col-md-5 col-xl-5 card card-outline  m-auto">
       <div class="card">
            <div class="header m-auto">
<h1>Registro de cuartel</h1>
            </div>
   
            <div class="card-body m-auto">
                <form action="/foo/bar" method="POST" class="form-group">
                    @method('POST')
                        <div class="form-row">
                            <div class="col-sm-12 col-md-12 col-xl-12 form-group">
                                <label for="title" class="form-label">Código</label>
                                <input id="codigo" type="text" class="form-control".@error('codigo') is-invalid @enderror"> 
                                    @error('codigo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="col-sm-12 col-md-12 col-xl-12 form-group">
                                <label for="title" class="form-label">Nombre</label>
                                <input id="nombre" type="text" class="form-control".@error('nombre') is-invalid @enderror"> 
                                    @error('nombre')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="col-sm-12 col-md-12 col-xl-12 form-group">
                                <label for="title" class="form-label">Estado</label>
                                <input id="estado" type="text" class="form-control".@error('estado') is-invalid @enderror"> 
                                    @error('estado')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="col-sm-12 col-md-12 col-xl-12 form-group">
                               
                                <input id="enviar" type="submit" class="btn btn-success btn-lg"> 
                                   
                            </div>

                        </div>
                </form>
            </div>  
        </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
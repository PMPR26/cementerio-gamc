@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de cuarteles</h1>
@stop

@section('content')
<div class="card card-outline">
    <div class="card-body">


        <div class="row">
            <div class="col-md-10 form-inline" style="display:inline; text-align:right;">

                <form class="form-inline float-left">
                    <a href="{{ route('cuartel.create') }}" class="btn btn-md bg-amarillo border-0 text-white">
                        <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Bloque</a>
                </form>
            </div>
        </div>
        <?php //print_r($solicitudes); ?>
        
        <div class="col-sm-12">
            <table id="example" class="table table-bordered  table-hover dataTable dt-responsive nowrap" role="grid"
            aria-describedby="example">
            <thead class="bg-table-header">
               
                    <tr role="row">
                        <th scope="col">#</th>                           
                        <th scope="col">Código</th>
                        <th scope="col">Cuartel</th>
                        <th scope="col">Bloque</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>   
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php($count = 1)
                    @foreach ($bloque as $bloque)
                               
                        <tr>
                            <td scope="row">{{ $count++ }}</td>
                           
                            <td>{{ $bloque->codigo }}</td>   
                            <td>{{ $bloque->cuartel_cod }}</td>                           
                            <td>{{ $bloque->nombre }}</td>
                            <td>{{ $bloque->estado }}</td>                           
                            <td>
                                <a href="#"> editar </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
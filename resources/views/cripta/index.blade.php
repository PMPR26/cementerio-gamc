@extends('adminlte::page')
@section('title', 'Criptas')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>Gestion de Criptas</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
    <button id="new-cripta" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-1x"></i> Nueva Cripta</button>
        </div>
       </div>

       <table id="cripta-data" class="table table-striped table-bordered responsive" role="grid"
    aria-describedby="example">
    <thead class="bg-table-header">
       
            <tr role="row">
                <th scope="col">#</th>                           
                <th scope="col">Código</th>
                <th scope="col">Cuartel</th>
                <th scope="col">Bloque</th>   
                <th scope="col">Cripta</th>
                <th scope="col">Nombre</th>
                <th scope="col">Estado</th>
                <th scope="col">Operaciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
            @foreach ($cripta as $cripta)
                       
                <tr>
                    <td scope="row">{{ $count++ }}</td>
                   
                    <td>{{ $cripta->codigo }}</td>                           
                    <td>{{ $cripta->cuartel_name }}</td>
                    <td>{{ $cripta->bloque_name }}</td>
                    <td>{{ $cripta->cripta_name }}</td>
                    <td>{{ $cripta->estado }}</td>

                    <td>
                        <button type="button" class="btn btn-info" value="{{ $cripta->id }}" id="btn-editar" title="Editar cuartel"><i class="fas fa-edit"></i></button>
                        @if($cripta->estado =='ACTIVO')
                        <button type="button" class="btn btn-warning" value="{{ $cripta->id }}" id="btn-desactivar"><i class="fas fa-thumbs-down"></i></button>
                        @else
                        <button type="button" class="btn btn-success" value="{{ $cripta->id }}" id="btn-desactivar"><i class="fas fa-thumbs-up"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop

@section('css')
<style>
    .modal {
    padding: 2% !important;
    }
    .modal .modal-dialog {
    width: 100%;
    max-width: none;
    
    margin: 0;
    }
    .modal .modal-content {
    height: 95%;
    border: 0;
    border-radius: 0;
    }
    .modal .modal-body {
    overflow-y: auto;
    }
</style>
@stop

@section('js')
    <script>

    </script>
    @stop
@extends('adminlte::page')
@section('title', 'Bloque')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)


@section('content_header')
    <h1>Listado de servicios</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <a href="{{ route('load.form') }}" id="new-servicio" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Servicio</a>
    </div>
 </div>
  
        <div class="col-sm-12">
            <table id="servicio-data" class="table table-striped table-bordered responsive" role="grid"
            aria-describedby="example">
            <thead class="bg-table-header">
               
                    <tr role="row">
                        <th scope="col">#</th>                           
                        <th scope="col">Responable</th>  
                        <th scope="col">Difunto</th>
                        <th scope="col">Nicho</th>
                        <th scope="col">Tipo Servicio</th>
                        <th scope="col">Servicios</th>
                        <th scope="col">Monto</th>

                        <th scope="col">FUR</th>
                        <th scope="col">Gestion Pagada</th>
                        <th scope="col">Estado Pago</th>                        
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php($count = 1)
                    @foreach ($servicio as $serv)
                               
                        <tr>
                            <td scope="row">{{ $count++ }}</td>
                           
                            <td>{{ $serv->responsable }}</td> 
                            <td>{{ $serv->difunto }}</td> 
                            <td>{{ $serv->bloque }}</td>
                            <td>{{ $serv->tipo_serv }}</td>
                            <td>{{ $serv->serv }}</td>
                            <td>{{ $serv->monto }}</td>
                            <td>{{ $serv->fur }}</td>
                            <td>{{ $serv->gestion_pagada }}</td>
                            <td>{{ $serv->estado_pago }}</td>     
                            <td>{{ $serv->estado }}</td>  
                            <td>
                                <button type="button" class="btn btn-info" value="{{ $serv->id }}" id="btn-print" title="Editar imprimir"><i class="fas fa-print"></i></button>
                                                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        

        {{-- @include('servicios.modalRegister')  --}}

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

@section('js')
    <script> 
    $(document).ready(function () {
        // $('#new-servicio').on('click', function(){
        //     //$('#modal-register-servicio').modal('show');
        //     document.location.href="{{ route('load.form') }}"";
        // });

        var datatable = $('#servicio-data').DataTable({
        "paging": true,
        "searching": true,
        "language": {

            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ninguna ubicación registrada aún",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": 'Buscar Datos Por CI:',
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": 'Primero',
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
    });




  
    });


    </script>
@stop
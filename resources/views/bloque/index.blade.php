@extends('adminlte::page')
@section('title', 'Bloque')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Select2', true)
@section('content_header')
    <h1>Listado de bloques</h1>
@stop

@section('content')
<div class="card card-outline">
    <div class="card-body">


        <div>
            <button id="new-bloque" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Bloque</button>
        </div>
        <?php //print_r($solicitudes); ?>
        
        <div class="col-sm-12">
            <table id="bloque-data" class="table table-striped table-bordered responsive" role="grid"
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

@include('bloque.modalRegister') 
    
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
        $('#new-bloque').on('click', function(){

            $('#modal-register-bloque').modal('show');
        });

        var datatable = $('#bloque-data').DataTable({
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


            $(document).ready(function() {
                 $('#js-data-example-ajax').select2();
            });
    </script>
@stop
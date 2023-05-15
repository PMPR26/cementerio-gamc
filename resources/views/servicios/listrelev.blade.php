@extends('adminlte::page')
@section('title', 'Relevamiento')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)


@section('content_header')
    <h1>RELEVAMIENTO DE INFORMACION</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <a href="{{ route('load.formrel') }}" id="new-servicio" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Registro</a>
    </div>
 </div>
  
        <div class="col-sm-12">
            <table id="servicio-data" class="table table-striped table-bordered responsive" role="grid"
            aria-describedby="example">
            <thead class="bg-table-header">
               
                    <tr role="row">
                        <th scope="col">#</th>  
                        <th scope="col">CÓDIGO NICHO</th> 
                        <th scope="col">NRO NICHO</th> 
                        <th scope="col">FILA</th> 
                        <th scope="col">BLOQUE</th> 
                        <th scope="col">CUARTEL</th> 
                        <th scope="col">RESPONSABLE</th>  
                        <th scope="col">DIFUNTO</th>   
                        <th scope="col">TIEMPO</th>   
                        <th scope="col">RENOVACION</th>  
                        <th scope="col">MONTO</th>   
                        <th scope="col">GESTION RENOV</th>                          
                    </tr>
                </thead>

                <tbody>
                    @php($count = 1)
                    @foreach ($servicio as $serv)
                               
                        <tr>
                            <td scope="row">{{ $count++ }}</td>
                            <td>{{ $serv->codigo_nicho??'' }}</td>   
                            <td>{{ $serv->nro_nicho??'' }}</td>                            
                            <td>{{ $serv->fila??'' }}</td>    
                            <td>{{ $serv->bloque??'' }}</td>                            
                            <td>{{ $serv->cuartel??'' }}</td>   
                            <td>{{ $serv->nombre_resp??'' }} {{ $serv->primerap_resp??'' }}{{ $serv->segap_resp??'' }}</td>                          
                            <td>{{ $serv->nombre_dif??'' }} {{ $serv->primerap_dif??'' }}{{ $serv->segap_dif??'' }}</td>                           
                            <td>{{ $serv->tiempo??'' }} </td> 
                            <th>{{ $serv->nro_renovacion??'' }}</th>  
                            <th>{{ $serv->monto_renov??'' }}</th>   
                            <th>{{ $serv->gestion_renov ??'' }}</th>                            
                            
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
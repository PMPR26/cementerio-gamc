@extends('adminlte::page')
@section('title', 'Cuartel')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>Cementerio</h1>
@stop

@section('content')

  
<div class="card">
    <div class="card-body">
     <button id="new-cuartel" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Cuartel</button>
         </div>
        </div>

    <table id="cuartel-data" class="table table-striped table-bordered responsive" role="grid"
    aria-describedby="example">
    <thead class="bg-table-header">
       
            <tr role="row">
                <th scope="col">#</th>                           
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Estado</th>   
                <th scope="col">Opciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
            @foreach ($cuartel as $cuartel)
                       
                <tr>
                    <td scope="row">{{ $count++ }}</td>
                   
                    <td>{{ $cuartel->codigo }}</td>                           
                    <td>{{ $cuartel->nombre }}</td>
                    <td>{{ $cuartel->estado }}</td>
                   
                    <td>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('cuartel.modalRegister', [
        'id_button' => 'btn_guardar_cuartel',
        'title_buton' => 'Guardar Cuartel',
        'title_modal' => 'Nuevo Cuartel'
        ]) 
    

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
    
    $(document).ready(function () {

        $('#btn_guardar_cuartel').on('click', function(){
            return  $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('new.cuartel') }}",
                        async: false,
                        data: JSON.stringify({
                            'codigo': $('#cod').val(),
                            'name':  $('#name').val()
                        }),
                        success: function(data_response) {
                            swal.fire({
                            title: "Guardado!",
                            text: "!Registro realizado con éxito!",
                            type: "success",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                            });
                            setTimeout(function() { 
                                location.reload();
                            }, 2000);
                            //toastr["success"]("Registro realizado con éxito!");
                        },
                        error: function (error) {
                            
                            if(error.status == 422){
                                Object.keys(error.responseJSON.errors).forEach(function(k){
                                toastr["error"](error.responseJSON.errors[k]);
                                //console.log(k + ' - ' + error.responseJSON.errors[k]);
                                });
                            }else if(error.status == 419){
                                location.reload();
                            }

                        }
                    })
        });



        $('#new-cuartel').on('click', function(){

            $('#modal-register-cuartel').modal('show');
        });

        var datatable = $('#cuartel-data').DataTable({
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
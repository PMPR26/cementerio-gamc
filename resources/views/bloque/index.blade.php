@extends('adminlte::page')
@section('title', 'Bloque')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
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
       
        <div class="col-sm-12">
            <table id="bloque-data" class="table table-striped table-bordered responsive" role="grid"
            aria-describedby="example">
            <thead class="bg-table-header">
               
                    <tr role="row">
                        <th scope="col">#</th>                           
                        <th scope="col">Código</th>    
                        <th scope="col">Nombre</th>
                        <th scope="col">Cuartel</th>
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
                            <td>{{ $bloque->nombre }}</td>
                            <td>{{ $bloque->cuartel_cod }}</td> 
                            <td>{{ $bloque->estado }}</td>  
                            <td>
                                <a href="#" id="edit"> <i class='fas fa-pencil-alt' style='font-size:28px;color:red'></i> </a>
                                                              
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
        $('#btn_guardar_bloque').on('click', function(){
            return  $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('new.bloque') }}",
                        async: false,
                        data: JSON.stringify({
                            'codigo': $('#code').val(),
                            'name':  $('#name').val(),
                            'cuartel':  $('#cuartel').val(),
                            'estado':  $('#status').val(),

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

         $('#btn_editar_bloque').on('click', function(){
            return  $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('new.bloque') }}",
                        async: false,
                        data: JSON.stringify({
                            'codigo': $('#code').val(),
                            'name':  $('#name').val(),
                            'cuartel':  $('#cuartel').val(),
                            'estado':  $('#status').val(),

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
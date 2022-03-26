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
                        <button type="button" class="btn btn-info" value="{{ $cuartel->id }}" id="btn-editar" title="Editar cuartel"><i class="fas fa-edit"></i></button>
                        @if($cuartel->estado =='ACTIVO')
                        <button type="button" class="btn btn-warning" value="{{ $cuartel->id }}" id="btn-desactivar"><i class="fas fa-thumbs-down"></i></button>
                        @else
                        <button type="button" class="btn btn-success" value="{{ $cuartel->id }}" id="btn-desactivar"><i class="fas fa-thumbs-up"></i></button>
                        @endif
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
    

    <!-- Modal -->
<div class="modal fade  animated bounceIn" id="edit-cuartel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nombre Cuartel:</label>
                    <input id="nombre-cuartel" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Codigo Cuartel:</label>
                    <input id="codigo-cuartel" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Estado Cuartel:</label>
                    <select  id="estado" class="form-control">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                      </select>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="edit-cuartel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btn-editar-va">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>

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


        //editar cuartel
        $('#btn-editar-va').on('click', function(){
            $.ajax({
                        type: 'PUT',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('cuartel.update') }}",
                        async: false,
                        data: JSON.stringify({
                            'name':  $('#nombre-cuartel').val(),
                            'status': $('#estado').val(),
                            'id': $('#btn-editar-va').val()
                        }),
                        success: function(data_response) {
                            swal.fire({
                            title: "Guardado!",
                            text: "!Registro actualizado con éxito!",
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




        $(document).on('click', '#btn-desactivar', function(){
            $.ajax({
                        type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/cuartel/disable-cuartel/' + $(this).val(),
                        async: false,
                        success: function(data_response) {
                            swal.fire({
                            title: data_response.response,
                            text: "",
                            type: "success",
                            timer: 1000,
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


        $(document).on('click', '#btn-editar', function(){
      
            $('#btn-editar-va').val($(this).val());
     
            $.ajax({
                        type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/cuartel/get-cuartel/' + $(this).val(),
                        async: false,
                        success: function(data_response) {
                           
                            $('#edit-cuartel').modal('show');
                            $('#nombre-cuartel').val(data_response.response.nombre);
                            $('#codigo-cuartel').val(data_response.response.codigo);
                            $('#estado option[value="'+data_response.response.estado+'"]').attr("selected", "selected");
                        }
                    })
        });







        $('#btn_guardar_cuartel').on('click', function(){
            $.ajax({
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
            "sSearch": 'Buscar Cuartel:',
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
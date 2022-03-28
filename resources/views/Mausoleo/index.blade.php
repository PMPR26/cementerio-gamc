@extends('adminlte::page')
@section('title', 'Criptas')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)


@section('content_header')
    <h1>Gestion de Mausoleos</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

    <div class="row">
        <div class="col-sm-6">
        <button id="new-mausoleo" type="button" class="btn btn-info col-sm-12" > <i class="fas fa-plus-circle text-white fa-2x"></i> Nuevo Mausoleo</button>
        </div>
    </div>

   
        </div>
       </div>

       <table id="mausoleo-data" class="table table-striped table-bordered responsive" role="grid"
    aria-describedby="example">
    <thead class="bg-table-header">
       
            <tr role="row">
                <th scope="col">#</th>                           
                <th scope="col">Código</th>
                <th scope="col">Cuartel</th>  
                <th scope="col">Mausoleo</th>
                <th scope="col">Superficie m2</th>
                <th scope="col">Estado</th>
                <th scope="col">Operaciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
            @foreach ($mausoleo as $mausoleo)
                       
                <tr>
                    <td scope="row">{{ $count++ }}</td>
                   
                    <td>{{ $mausoleo->codigo }}</td>                           
                    <td>{{ $mausoleo->cuartel_name }}</td>
                    <td>{{ $mausoleo->mausoleo_name }}</td>
                    <td>{{ $mausoleo->superficie }}</td>
                    <td>{{ $mausoleo->estado }}</td>

                    <td>
                        <button type="button" class="btn btn-info edit" value="{{ $mausoleo->id }}" id="btn-editar" title="Editar Mausoleo"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

  
      <!-- Modal crear -->
<div class="modal fade  animated bounceIn" id="modal-mausoleo" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registrar Nuevo Mausoleo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
        <div class="row">
        <div class="col-sm-12">
                    <label>Cuartel</label>
                    <select  class="form-control select-cuartel" style="width: 100%">
                    <option selected disabled>Seleccione un cuartel</option>
                    @foreach ($cuartel as $value)
                    <option value="{{ $value->id }}">{{ $value->nombre }}</option>
                    @endforeach
                    </select>
        </div>
       
        </div>

        <div class="row">
            <div class="col-sm-2">
                    <label>Codigo:</label>
                    <input id="cod-mausoleo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>
            <div class="col-sm-4">
                    <label>Nombre:</label>
                    <input id="mausoleo-name" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>
            <div class="col-sm-3">
                    <label>Superficie m2:</label>
                    <input id="superficie" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>
            <div class="col-sm-3">
                    <label>Estado:</label>
                    <select  id="estado" class="form-control">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
            </div>
        </div>

       <hr>
       <div class="col-sm-12" style="text-align: center">
            <button type="button" id="btn-mausoleo" class="btn btn-success btn-editar">Guardar</button>
           
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div> 
            
        </div>
        <div class="modal-footer">
            
          <!-- <button type="button" id="edit-cuartel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btn-editar-va">Guardar Cambios</button> -->
        </div>
      </div>
    </div>
  </div>


  
     <!-- Modal editar -->
<div class="modal fade  animated bounceIn" id="modal-mausoleo-editar" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Nuevo Mausoleo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
        <div class="row">
        <div class="col-sm-12">
                    <label>Cuartel</label>
                    <select  class="form-control select-cuartel-edit" style="width: 100%">
                    <option selected disabled>Seleccione un cuartel</option>
                    @foreach ($cuartel as $val)
                    <option value="{{ $val->id }}">{{ $val->nombre }}</option>
                    @endforeach
                    </select>
        </div>
       
        </div>

        <div class="row">
            <div class="col-sm-2">
                    <label>Codigo:</label>
                    <input id="cod-mausoleo-edit" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>
            <div class="col-sm-4">
                    <label>Nombre:</label>
                    <input id="mausoleo-name-edit" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>
            <div class="col-sm-3">
                    <label>Superficie m2:</label>
                    <input id="superficie-edit" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>
            <div class="col-sm-3">
                    <label>Estado:</label>
                    <select  id="estado-edit" class="form-control">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                    </select>
            </div>
        </div>
        <input type="hidden" id="id_mausoleo">
       <hr>
       <div class="col-sm-12" style="text-align: center">
           <button type="button"  id="btn-mausoleo-editar" class="btn btn-success btn-editar">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div> 
            
        </div>
        <div class="modal-footer">
            
          <!-- <button type="button" id="edit-cuartel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btn-editar-va">Guardar Cambios</button> -->
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
        $(document).ready(function(){


            $(document).on('click','#btn-editar', function(){
            $('btn-mausoleo-editar').val($(this).val());

                
                $.ajax({
                        type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/mausoleo/get-mausoleo/' + $(this).val(),
                        async: false,
                        success: function(data_response) {
                            console.log(data_response);
                            $('#modal-mausoleo-editar').modal('show');
                            // $('#btn-mausoleo-editar').show(300);
                            // $('#btn-mausoleo').hide(300);
                            $(".select-cuartel-edit").val(data_response.response.cuartel_id).trigger('change');
                            $('#cod-mausoleo-edit').val(data_response.response.codigo);
                            $('#mausoleo-name-edit').val(data_response.response.nombre);
                            $('#superficie-edit').val(data_response.response.superficie);
                            $('#estado-edit').val(data_response.response.estado);
                            $('#id_mausoleo').val(data_response.response.id);
                        }
                    });

            });



            $('#new-mausoleo').on('click', function(){

                $(".select-cuartel").val('').trigger('change');
                $('#cod-mausoleo').val('');
                $('#mausoleo-name').val('');
                $('#superficie').val('');

                $('#modal-mausoleo').modal('show');
             //   $('#btn-mausoleo-editar').hide(300);
                $('#btn-mausoleo').show(300);
            });


            $(".select-cuartel").select2({
                width: 'resolve', // need to override the changed default
                dropdownParent: $('#modal-mausoleo')
            });


            $('#btn-mausoleo').on('click', function(){

                $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('mausoleo.save') }}",
                        async: false,
                        data: JSON.stringify({
                            'id_cuartel':  $('.select-cuartel').val(),
                            'codigo': $('#cod-mausoleo').val(),
                            'name': $('#mausoleo-name').val(),
                            'superficie': $('#superficie').val(),
                            'status': $('#estado').val()
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
                            }else if(error.status == 400){
                                swal.fire({
                            title: "Duplicado!",
                            text: "!Transacción rechazada!",
                            type: "error",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                            });
                            setTimeout(function() { 
                                location.reload();
                            }, 2000);
                            }

                        }
                    })
            });

            $(document).on('click','#btn-mausoleo-editar', function(){

                $.ajax({
                        type: 'PUT',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('mausoleo.update') }}",
                        async: false,
                        data: JSON.stringify({
                            'id_cuartel':  $('.select-cuartel-edit').val(),
                            'codigo': $('#cod-mausoleo-edit').val(),
                            'name': $('#mausoleo-name-edit').val(),
                            'superficie': $('#superficie-edit').val(),
                            'status': $('#estado-edit').val(),
                            'id': $('#id_mausoleo').val()
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
                            }else if(error.status == 400){
                                swal.fire({
                            title: "Duplicado!",
                            text: "!Transacción rechazada!",
                            type: "error",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                            });
                            setTimeout(function() { 
                                location.reload();
                            }, 2000);
                            }

                        }
                    })
                });



            $('#mausoleo-data').DataTable({
            "paging": true,
            "searching": true,
            "language": {

            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun registro registrado aún",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": 'Buscar mausoleo:',
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
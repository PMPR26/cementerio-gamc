@extends('adminlte::page')
@section('title', 'Bloque')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)


@section('content_header')
    <h1>Listado de bloques</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
        <div class="col-sm-6">
        <button id="new-bloque" type="button" class="btn btn-info col-sm-12" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Bloque</button>
        </div>
        </div>
    </div>
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
                                <button type="button" class="btn btn-info" value="{{ $bloque->id }}" id="btn-editar" title="Editar cuartel"><i class="fas fa-edit"></i></button>
                                                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        

        @include('bloque.modalRegister') 


    <!-- Modal -->
<div class="modal fade  animated bounceIn" id="edit-cuartel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Bloque</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-sm-12 col-md-5 col-xl-5 card m-auto">
                <div class="card-body">
            
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                                <div class="col-sm-12 col-md-12 col-xl-12 form-group">

                                    <label>Cuartel</label>
                                   
                                    <select style="width: 100%"  id="cuartel_edit" >                                      
                                        @foreach($cuartel as $c)
                                        <option value={{ $c->id}}> {{ $c->codigo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label>Codigo:</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="code_edit" autocomplete="off">

                            </div>
                        </div>
                       
                    </div>
            


                    <div class="row" >
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="name_edit" autocomplete="off">
                            </div> 
                        </div>                       
                    </div>

                    <div class="row" >
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <div class="form-group">
                                <label>Estado:</label>
                                <select name="status" id="status_edit" class="form-control">
            
                                    <option value="ACTIVO"> ACTIVO</option>
                                    <option value="INACTIVO"> INACTIVO</option>

                                </select>
                               
                            </div> 
                        </div>                       
                    </div>
                    <input type="hidden" id="id_bloque">
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
                        url: "{{ route('bloque.update') }}",
                        async: false,
                        data: JSON.stringify({
                            'name':  $('#name_edit').val(),
                            'codigo':  $('#code_edit').val(),
                            'cuartel':  $('#cuartel_edit').val(),
                            'estado': $('#status_edit').val(),
                            'id': $('#id_bloque').val()
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

        $(document).on('click', '#btn-editar', function(){
      
            $('#btn-editar-va').val($(this).val());
     
            $.ajax({
                        type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/bloque/get-bloque/' + $(this).val(),
                        async: false,
                        success: function(data_response) {
                           
                            $('#edit-cuartel').modal('show');
                            $('#name_edit').val(data_response.response.nombre);
                            $('#code_edit').val(data_response.response.codigo);                           
                            $('#cuartel_edit').val(data_response.response.cuartel_id).trigger('change');
                            $('#id_bloque').val(data_response.response.id);                           
                           
                            $('#estado option[value="'+data_response.response.estado+'"]').attr("selected", "selected");
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
            "sEmptyTable": "Ningun registro",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": 'Buscar:',
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

    
    //select2 cuartel
    $("#cuartel").select2({
                        width: 'resolve', // need to override the changed default
                        dropdownParent: $('#modal-register-bloque')
                    });

  //select2 cuartel
  $("#cuartel_edit").select2({
                        width: 'resolve', // need to override the changed default
                        dropdownParent: $('#edit-cuartel')
                    });

       
    });


    </script>
@stop
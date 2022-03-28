@extends('adminlte::page')
@section('title', 'Cuartel')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>Listado de Difuntos</h1>
@stop

@section('content')

  
         <div class="card">
     <div class="card-body">
     <button id="new-difunto" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Difunto</button>
         </div>
        </div>

    <table id="difunto-data" class="table table-striped table-bordered responsive" role="grid"
    aria-describedby="example">
    <thead class="bg-table-header">
       
            <tr role="row">
                <th scope="col">#</th>                           
                <th scope="col">Cedula de identidad</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha de defunción</th>  
                <th scope="col">Causa</th>
                <th scope="col">Tipo</th>       
                <th scope="col">Opciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
            @foreach ($difunto as $difunto)
                       
                <tr>
                    <td scope="row">{{ $count++ }}</td>
                   
                    <td>{{ $difunto->ci }}</td>                           
                    <td>{{ $difunto->nombre }}</td>
                    <td>{{ $difunto->fecha_defuncion }}</td>
                    <td>{{ $difunto->causa }}</td>
                    <td>{{ $difunto->tipo }}</td>
                   
                    <td>
                        <button type="button" class="btn btn-info" value="{{ $difunto->id }}" id="btn-editar" title="Editar difunto"><i class="fas fa-edit"></i></button>
                        @if($responsable->estado =='ACTIVO')
                        <button type="button" class="btn btn-warning" value="{{ $difunto->id }}" id="btn-desactivar"><i class="fas fa-thumbs-down"></i></button>
                        @else
                        <button type="button" class="btn btn-success" value="{{ $difunto->id }}" id="btn-desactivar"><i class="fas fa-thumbs-up"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('difunto.modalRegister', [
        'id_button' => 'btn_guardar_difunto',
        'title_buton' => 'Guardar Difunto',
        'title_modal' => 'Nuevo Difunto'
        ]) 
    

    <!-- Modal -->
<div class="modal fade  animated bounceIn" id="edit-difunto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            {{-- <div class="col-sm-4">
                <div class="form-group">
                    <label>Nombre Responsable :</label>
                    <input id="nombre-ree" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Cedula de identidad:</label>
                    <input id="codigo-responsable" disabled>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Estado responsable:</label>
                    <select  id="estado" class="form-control">
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="INACTIVO">INACTIVO</option>
                      </select>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cedula de Identidad:</label>
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="ci-difunto" autocomplete="off">
                        </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nombre :</label>
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombre-difunto" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Primer apellido :</label>
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="primer_apellido-difunto" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Segundo apellido :</label>
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="segundo_apellido-difunto" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fecha de nacimiento :</label>
                        <input type="date"  class="form-control" placeholder="fecha de nacimiento" id="fecha_nacimiento-difunto" max="2006-12-31" >
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Fecha de defunción :</label>
                        <input type="date"  class="form-control" placeholder="fecha de defuncion" id="fecha_defuncion-difunto" max="2006-12-31" >
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Certificado de defunción :</label>
                        <input  type="number" class="form-control" id="certificado_defuncion-difunto" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Causa :</label>
                        <input type="number" class="form-control" id="causa-difunto" autocomplete="off">
                    </div>
                </div>

                {{-- <div class="col-sm-6">
                 
                    <div class="form-group">
                        <label>Estado civil:</label>
                        <select name="status" id="estado_civil-responsable" class="form-control">
    
                            <option value="SOLTERO"> Soltero/a</option>
                            <option value="CASADO"> Casado/a</option>
                            <option value="DIVORCIADO"> Divociado/a</option>
                            <option value="VIUDO"> Viudo/a</option>

                        </select>
                       
                    </div> 
                </div> --}}

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tipo :</label>
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="tipo-responsable" autocomplete="off">
                    </div>
                </div>

                {{-- <div class="col-sm-6">
                    <div class="form-group">
                        <label>Domicilio :</label>
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="domicilio-responsable" autocomplete="off">
                    </div>
                </div> --}}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="edit-difunto" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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


        //editar difunto
        $('#btn-editar-va').on('click', function(){
            $.ajax({
                        type: 'PUT',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('difunto.update') }}",
                        async: false,
                        data: JSON.stringify({
                            'ci':  $('#ci-difunto').val(),
                            'nombres':  $('#nombre-difunto').val(),
                            'primer_apellido':  $('#primer_apellido-difunto').val(),
                            'segundo_apellido':  $('#segundo_apellido-difunto').val(),
                            'fecha_nacimiento':  $('#fecha_nacimiento-difunto').val(),
                            'fecha_defuncion':  $('#fecha_defuncion-difunto').val(),
                            'certificado_defuncion':  $('#certificado_defuncion-difunto').val(),
                            'causa':  $('#causa-difunto').val(),
                            'tipo': $('#tipo-difunto').val(),
                            // 'domicilio': $('#domicilio-responsable').val(),
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
                        url: '/difunto/disable-difunto/' + $(this).val(),
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
                        url: '/difunto/get-difunto/' + $(this).val(),
                        async: false,
                        success: function(data_response) {
                           
                            $('#edit-difunto').modal('show');
                            $('#nombre-difunto').val(data_response.response.nombres);
                            $('#ci-difunto').val(data_response.response.ci);
                            $('#primer_apellido-difunto').val(data_response.response.primer_apellido);
                            $('#segundo_apellido-difunto').val(data_response.response.segundo_apellido);
                            $('#fecha_nacimiento-difunto').val(data_response.response.fecha_nacimiento);
                            $('#fecha_defuncion-difunto').val(data_response.response.fecha_defuncion);
                            $('#certificado_defuncion-difunto').val(data_response.response.certificado_defuncion);
                            $('#causa-difunto').val(data_response.response.causa);
                            $('#tipo-difunto').val(data_response.response.tipo);
                           //$('#domicilio-responsable').val(data_response.response.domicilio);

                            $('#estado option[value="'+data_response.response.estado+'"]').attr("selected", "selected");
                        }
                    })
        });







        $('#btn_guardar_difunto').on('click', function(){
            $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('new.difunto') }}",
                        async: false,
                        data: JSON.stringify({
                            'ci':  $('#ci').val(),
                            'nombres':  $('#nombre').val(),
                            'primer_apellido':  $('#primer_apellido').val(),
                            'segundo_apellido':  $('#segundo_apellido').val(),
                            'fecha_nacimiento':  $('#fecha_nacimiento').val(),
                            'fecha_defuncion':  $('#fecha_defuncion').val(),
                            'certificado_defuncion':  $('#fecha_defuncion').val(),
                            'causa':  $('#causa').val(),
                            'tipo': $('#tipo').val(),
                            // 'domicilio': $('#domicilio').val(),
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



        $('#new-difunto').on('click', function(){

            $('#modal-register-difunto').modal('show');
        });

        var datatable = $('#difunto-data').DataTable({
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
            "sSearch": 'Buscar difunto:',
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
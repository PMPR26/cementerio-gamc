@extends('adminlte::page')
@section('title', 'Cuartel')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)
@section('plugins.dropzone', true)


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
                        <button type="button" class="btn btn-info" value="{{ $difunto->id }}" id="btn-editar-difunto" title="Editar datos difunto"><i class="fas fa-edit"></i></button>
                        @if($difunto->estado =='ACTIVO')
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
        'title_modal' => 'Registro de Difunto'
        ]) 
    


    {{-- //editar datos difunto --}}
    <!-- Modal complementacion de entrega de producto -->
<div class="modal fade fullscreen-modal animated bounceIn" id="modal-update-difunto" data-backdrop="static">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align: center">Editar Datos Difunto</h3>
            <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" >&times;</span>
            </button>
        </div>
        <div class="modal-body">

  <h1>hola mundo</h1>
    </div>
</div>
</div>




@stop

@section('css')
<style>
    .dropzone .dz-preview .dz-error-message {
    top: 150px!important;
}
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

        $("#cert-defuncion").dropzone({
        dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
        dictRemoveFile: 'Remover Archivo',
        dictCancelUpload: 'Cancelar carga',
        dictResponseError: 'Server responded with  code.',
        dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
        url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
        paramName: "documens_files[]",
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
        parallelUploads: 1,
        maxFiles: 1,
        init: function() {
        this.on("complete", function(file) {
            if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                this.removeFile(file);
                toastr["error"]('No se puede subir el archivo '+ file.name);
                return false;
            }
        });

        this.on("removedfile", function(file) {
            $.ajax({
                        type: 'DELETE',
                        headers: {
                            'Content-Type':'application/json'
                        },
                        url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                        async: false,
                        data: JSON.stringify({
                            'url':  JSON.parse(file.xhr.response).response[0].url_file
                        }),
                        success: function(data_response) {
                        }
                    })

        });

        this.on("maxfilesexceeded", function(file){
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se puede subir mas archivos!');
        });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'certificados de difuncion');
                   
                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#url-certification').val(response.response[0].url_file);
            // $(file._removeLink).attr('href', response.response[0].url_file);
            // $(file._removeLink).attr('id', 'btn-remove-file'); 
        },
        error: function (file, response) {
         
            if(response == 'You can not upload any more files.'){
                toastr["error"]('No se puede subir mas archivos');
                this.removeFile(file);
            }
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
        }
    });




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
                            'genero': $('#genero-difunto').val(),
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


        $(document).on('click', '#btn-editar-difunto', function(){
      
            $('#modal-update-difunto').modal('show');
            // $('#btn-editar-va').val($(this).val());
     
            // $.ajax({
            //             type: 'GET',
            //             headers: {
            //                 'Content-Type':'application/json',
            //                 'X-CSRF-TOKEN':'{{ csrf_token() }}',
            //             },
            //             url: '/difunto/get-difunto/' + $(this).val(),
            //             async: false,
            //             success: function(data_response) {
            //                console.log(data_response);
            //                 $('#exampleModal').modal('show');
            //                 $('#nombre-difunto').val(data_response.response.nombres);
            //                 $('#ci-difunto').val(data_response.response.ci);
            //                 $('#primer_apellido-difunto').val(data_response.response.primer_apellido);
            //                 $('#segundo_apellido-difunto').val(data_response.response.segundo_apellido);
            //                 $('#fecha_nacimiento-difunto').val(data_response.response.fecha_nacimiento);
            //                 $('#fecha_defuncion-difunto').val(data_response.response.fecha_defuncion);
            //                 $('#certificado_defuncion-difunto').val(data_response.response.certificado_defuncion);
            //                 $('#causa-difunto').val(data_response.response.causa);
            //                 $('#tipo-difunto').val(data_response.response.tipo);
            //                $('#genero-difunto').val(data_response.response.genero);

            //                 $('#estado option[value="'+data_response.response.estado+'"]').attr("selected", "selected");
            //             }
            //         })
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
                            'genero': $('#genero').val(),
                            'certificado_file': $('#url-certification').val() //aqui
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
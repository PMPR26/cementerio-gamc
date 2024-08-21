@extends('adminlte::page')
@section('title', 'Make template notification')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)

@section('content_header')

<!-- include summernote css/js-->

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js" defer></script>

@stop


@section('content')
<div class="container card">
    <form action="" method="post">
        @csrf
    <div class="row  p-4">
        <div class="col-12">
          <h1>CREACION DE PlANTILLA DE NOTIFICACIONES</h1>
        </div>

        <div class="col-12">
            <label for="titulo">Nombre de la Notificación</label>
            <input class="form-control" type="text" name="titulo" id="titulo">
        </div>

        <div class="col-12 p-4">
            <label for="contenido">Contenido de la notificación</label>
            <textarea class="form-control summernote" name="contenido" id="contenido"></textarea>
        </div>

    </div>
    <div class="row p-4">
        <div class="col-3"></div>

        <div class="col-6">
            <button class="btn btn-primary btn-lg btn-block" id="btn_guardar_tipo_notificacion">Guardar Plantilla</button>
        </div>

        <div class="col-3"></div>
    </div>
</form>
</div>
@endsection

@section('js')


<script type="text/javascript">



jQuery(document).ready(function() {

       // $('.summernote').summernote('editor.insertText', 'hello world');

         $('.summernote').summernote({
           height: 500,
           toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
          });

          /**** guardar tipo de notificacion **/


        $(document).on('click','#btn_guardar_tipo_notificacion', function(e){
            e.preventDefault();

            $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('save.tipo.notificacion') }}",
                        async: false,
                        data: JSON.stringify({
                            'nombre_notificacion': $('#titulo').val(),
                            'contenido':  $('#contenido').val()
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
                                window.location.href = "{{ route('notification-tipo') }}";
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




   });



 </script>

@endsection()

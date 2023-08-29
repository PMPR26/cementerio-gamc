@extends('adminlte::page')
@section('title', 'Registrar notificacion')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)

@section('content_header')

<!-- include summernote css/js-->

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js" defer></script>

@stop


@section('content')
<div class="container card">
    <form action="" method="post">
        @csrf
    <div class="row  p-4">
        <div class="col-12">
          <h2>GENERAR NOTIFICACIONES</h2>
        </div>
    </div>
    <div class="row  p-4">
        <div class="col-12"> <h5>DATOS UBICACION</h5></div>

            <div class="col-6">
                <label for="tipo_ubicacion" > Tipo Ubicacion</label>
               <select  class="form-control" name="tipo_ubicacion" id="tipo_ubicacion">
                <option value="NICHO">Nicho</option>
                <option value="CRIPTA">Cripta</option>
                <option value="MAUSOLEO">Mausoleo</option>
               </select>
            </div>

            <div class="col-12">
                <label for="codigo"  > Código Ubicacion</label>
            </div>
                <div class="col-6 input-group input-group-lg P-4">

                    <input style="text-transform:uppercase;"
                        onkeyup="javascript:this.value=this.value.toUpperCase();" type="search"
                        class="form-control clear" id="search" autocomplete="off">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-default" id="buscar">
                            <i class="fa fa-search"></i>
                        </button>

                        <input type="hidden" name="codigo_search" id="codigo_search">
                        <input type="hidden" name="nro" id="nro">

                    </div>
                </div>

                <div class="card col-12 P-4" id="info">
                    <h5>INFORMACION UBICACION</h5>

                </div>
    </div>

<div id="seccion-notificacion" style="display: none">

</div>
        <div class="col-12">
            <label for="titulo">Tipo Notificación</label>
            <select name="tipo_notificacion" id="tipo_notificacion" class="form-control">
                <option value="">Seleccionar</option>
                   @foreach($tipos as $tipos)
                    <option value="{{ $tipos->id }}"

                    >{{ $tipos->nombre_notificacion }}</option>
                   @endforeach
            </select>

        </div>

        <div class="col-12 p-4">
            <label for="contenido">Contenido de la notificación</label>
            <textarea class="form-control summernote" name="contenido" id="summernote" ></textarea>
        </div>

        <div class="col-12 p-4">
            <label for="contenido">Observacion</label>
            <textarea class="form-control " name="observacion" id="observacion" ></textarea>
        </div>

    </div>
    <div class="row p-4">
        <div class="col-3"></div>

        <div class="col-6">
            <button class="btn btn-primary btn-lg btn-block" id="btn_guardar_notificacion">Guardar</button>
        </div>

        <div class="col-3"></div>
    </div>
</form>
</div>
@endsection

@section('js')


<script type="text/javascript">



    $(document).ready(function() {
        //buscar datos de la ubicacion
        $(document).on('click', '#buscar', function(e){
            e.preventDefault();
            $.ajax({
            type: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}',
            },
            url: "{{ route('buscar.ubicacion') }}",
            async: false,
            data: JSON.stringify({
                'codigo': $('#search').val(),
                'tipo_ubicacion':$('#tipo_ubicacion').val(),
            }),
            success: function(data_response) {
                if($('#tipo_ubicacion').val()=='NICHO'){
                    var info='<br><b><h6> INFORMACION UBICACION</h6></b>'+
                             '<p><b>Tipo de registro</b>: <span> '+$('#tipo_ubicacion').val()+'</span> <span><b></b>: '+ data_response.familia+' </span>'+
                             '<b>Superficie</b>: '+ data_response.superficie+'</p>';
                    $('#info').html(info);
                    $('#codigo_search').val(data_response.id);
                    //revisar para nicho
                }
                else if($('#tipo_ubicacion').val()=='CRIPTA' ||  $('#tipo_ubicacion').val()=='MAUSOLEO'){
                    var info='<br><b><h6> INFORMACION UBICACION</h6></b>'+
                             '<p><b>Tipo de registro</b>: <span> '+$('#tipo_ubicacion').val()+'</span> <span><b>Familia</b>: '+ data_response.familia+' </span>'+
                             '<b>Superficie</b>: '+ data_response.superficie+'</p>';
                    $('#info').html(info);
                    $('#codigo_search').val(data_response.id);

                 }


            }

        })
    })

      $(document).on('change', '#tipo_notificacion', function(e){
      //  alert($('#tipo_notificacion').val());
        e.preventDefault();
        //verificar nro de notificacion si es menor a 3 mostrar contenido de la plantilla
        //remover opcion y mostrarmensaje para seleccion de otra notificacion
         $.ajax({
            type: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}',
            },
            ///url: "{{ route('get.tipo.notificacion') }}",
            url: "{{ route('count.nro.notificacion') }}",

            async: false,
            data: JSON.stringify({
                //'id': $('#tipo_notificacion').val(),
                'tipo_notificacion':$('#tipo_notificacion').val(),
                'codigo': $('#search').val()

            }),
            success: function(data_response) {
                console.log(data_response['result']);
                $('#summernote').summernote('reset');
                if(data_response['nro']<=3){
                    $('#summernote').summernote('editor.pasteHTML',data_response['result']);
                    $('#nro').val(data_response['nro']);
                    $("#seccion-notificacion").show();
                }
                else{
                    swal.fire({
                            title: "El tipo de notificacion excedio el numero permitido por favor elegir otro tipo de notificación!",
                            type: "warning",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        return false;
                }

            }

        });

      });


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


        $(document).on('click','#btn_guardar_notificacion', function(e){
            e.preventDefault();

            $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('save.notificacion') }}",
                        async: false,
                        data: JSON.stringify({
                            'nombre_notificacion': $('#titulo').val(),
                            'contenido':  $('#contenido').val(),
                            'ubicacion':$('#search').val(),
                            'codigo_id': $('#codigo_search').val(),
                            'txt_id': $('#tipo_notificacion').val(),

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




   });



 </script>

@endsection()

@extends('adminlte::page')
@section('title', 'Criptas')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)
@section('plugins.dropzone', true)


{{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> --}}
<link rel="stylesheet" href="{{ asset('libreries/font-awesome/font-awesome.min.css') }}">

@section('content_header')
    <h1>Gestion de Criptas y Mausoleos</h1>
@stop


    <style>
        .obligatorio{
            color: red;
            font-weight: 900;
        }
        .labelservice{
            color: rgb(21, 24, 23);
            font-weight: 900;
        }
       .childservice{
            color: rgb(46, 147, 144);
            font-weight: 900;
        }

    </style>

@section('content')

<div class="card">
    <div class="card-body">

    <div class="row">
        <div class="col-sm-6">
        <button id="new-cripta" type="button" class="btn btn-info col-sm-12" > <i class="fas fa-plus-circle text-white fa-2x"></i> Nueva Cripta</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3>Busqueda avanzada</h3>
        </div>
    </div>
    <form action="{{ route('cripta.index') }}">
            <div class="row">
                <div class="col-sm-3">
                    <label>Cuartel</label>
                    <select  class="form-control select_cuartel_search" name="select_cuartel_search"  id="select_cuartel_search" style="width: 100%" >
                    <option selected disabled>Seleccione un cuartel</option>
                            @foreach ($cuartel as $val)
                            <option value="{{ $val->id }}">{{ $val->codigo }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label>Bloque</label>
                    <select  class="form-control bloque_search" name="bloque_search"  id="bloque_search" style="width: 100%" >
                    </select>
                </div>
                <div class="col-2">
                    <label>Sitio</label>
                    <input type="text"  class="form-control sitio_search" name="sitio_search"  id="sitio_search" style="width: 100%" />
                </div>
                <div class="col-2 pt-2">
                    <br>
                    <input type="submit"  class="btn btn-success" name="advanced_search" style="width: 100%" value="Buscar" />
                </div>
                <div class="col-2 pt-2">
                    <br>
                    <input type="submit"  class="btn btn-info" name="todos" style="width: 100%"  value="Cargar todos"/>
                </div>
            </div>
    </form>
        </div>
       </div>

       <table id="cripta-data"  class="table table-striped table-bordered responsive" role="grid" aria-describedby="example">
    <thead  class="bg-table-header">
            <tr role="row">
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Código</th>
                <th scope="col">Cuartel</th>
                <th scope="col">Bloque</th>
                <th scope="col">Sitio</th>
                <th scope="col">Familia</th>
                <th scope="col">Adjudicatario</th>
                <th scope="col">Documentos Recibidos</th>
                <th scope="col">Superficie</th>
                <th scope="col">Enterratorio Ocupados</th>
                <th scope="col">Total Enterratorio</th>
                <th scope="col">Osarios Ocupados</th>
                <th scope="col">Total Osarios</th>
                <th scope="col">Cenisario</th>
                <th scope="col">Ultima Gestion Pagada</th>
                <th scope="col">Notable</th>
                <th scope="col">Difuntos</th>
                <th scope="col">Estado</th>
                <th scope="col">Operaciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
           {{--  <pre>
            @php(print_r($cripta ))
            </pre> --}}
            @foreach ($cripta as $cripta)

                <tr>
                    <td scope="row">{{ $count++ }}</td>
                    <td>{{ $cripta->tipo_registro }}</td>
                    <td>{{ $cripta->codigo }}</td>
                    <td>{{ $cripta->cuartel_codigo }}</td>
                    <td>{{ $cripta->bloque_nombre ?? '' }}</td>
                    <td>{{ $cripta->sitio }}</td>
                    <td>{{ $cripta->familia ?? '' }}</td>
                    @if($cripta->estado_rel_resp=='ACTIVO')

                    <td>{{ $cripta->nombre }}</td>
                    <td>
                        <?php
                            if($cripta->documentos_recibidos !=null || !empty($cripta->documentos_recibidos)){
                                $v=json_decode($cripta->documentos_recibidos, true);
                                echo "<psan>resolucion nro. " .$v['resolucion']. " , Bienes: ".$v['bienes_m'].", Planos aprobados ".$v['planos_aprobados'].", ci del adjudicatario ".$v['ci'] ?? ''. "  </span><br>";
                                    if(isset($v['foto_resolucion'])){if($v['foto_resolucion']!=null ){echo "<span>|<a href='" .$v['foto_resolucion']. "'> Resolución </a>|</span>"; }}
                                    if(isset($v['foto_titulo'])){if($v['foto_titulo']!=null ){echo "<span>|<a href='" .$v['foto_titulo']. "'> Titulo de propiedad </a>|</span>"; }}
                                    if(isset($v['foto_prop_ci'])){if($v['foto_prop_ci']!=null ){echo "<span>|<a href='" .$v['foto_prop_ci']. "'> ci adjudicatario </a>|</span>"; }}
                                    if(isset($v['foto_planos'])){if($v['foto_planos']!=null ){echo "<span>|<a href='" .$v['foto_planos']. "'> Planos aprobados </a>|</span>"; }}
                            }
                    ?>
                    </td>
                    @else
                    <td>SIN ASIGANCION</td>
                    <td>
                       SIN RECEPCION
                    </td>
                    @endif
                    <td>{{ $cripta->superficie }}</td>
                    <td>{{ $cripta->enterratorios_ocupados }}</td>
                    <td>{{ $cripta->total_enterratorios }}</td>
                    <td>{{ $cripta->osarios }}</td>
                    <td>{{ $cripta->total_osarios }}</td>
                    <td>{{ $cripta->cenisarios }}</td>
                    <td>{{ $cripta->ultimo_pago }}</td>
                    <td>{{ $cripta->notable }}</td>

                    <td><?php
                            if($cripta->difuntos !=null || !empty($cripta->difuntos)){
                                foreach (json_decode($cripta->difuntos) as $key => $value) {
                                    echo "<psan> " .$value->ci. " ".$value->nombres. " ".$value->primer_apellido ?? ''. "  </span>";
                                }
                            }
                    ?></td>


                    <td>{{ $cripta->estado }}</td>

                    <td>
                        <button type="button" class="btn btn-info" value="{{ $cripta->id }}" id="btn-editar" title="Editar cuartel"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-warning" value="{{ $cripta->id }}" id="btn_add_difunto" title="Adicionar Difunto"><i class="fa fa-user-plus"></i></button>
                        <button type="button" class="btn btn-danger" value="{{ $cripta->id }}" id="btn_up_pay_info" title="Actualizar información de  pagos servicios"><i class="fa fa-refresh"></i></button>


                        @if (auth()->check())
                           @php( $user = auth()->user())
                            @php($rolUsuario = $user->role)
                        @endif
                            @if($rolUsuario != "APOYO")

                            <button type="button" class="btn btn-success" value="{{ $cripta->id }}" id="btn_pay_cm" title="Pagar servicios"><i class="fa fa-money"></i></button>
                            @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



    @include('cripta/crear_cripta_mausoleo')
   @include('cripta/modal_difunto_cripta')
   @include('cripta/modal_actualizacion_pagos')


   @include('cripta/modal_pago_servicios')




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





/*****************************************************************************************/
/***seleccion tipo de sitio-inicio de cargado de modal registro de cripta mausoleo******/
/****************************************************************************************/


  var letra="";
  $(document).on('change', '#tipo_reg', function(){
        $('#tipo_reg option').each(function() {
            if(this.selected)
            {
                var val=$('#tipo_reg option:selected').val();
                    if(val==0){
                        Swal.fire(
                            'Seleccione Cripta o Mausoleo!',
                            'Debe especificar el tipo de registro que desea realizar .',
                            'error'
                            )

                            $('#section_data').hide();
                    }else if(val=="CRIPTA"){
                         $('#letra').val("C");
                         $('#section_data').show();
                         $('#box_tipo_cripta').show();
                         $('#box_tipo_cripta').prop('disabled', false);
                    }
                    else if(val=="MAUSOLEO"){
                        $('#letra').val("M");
                        $('#section_data').show();
                        $('#box_tipo_cripta').hide();
                        $('#box_tipo_cripta').prop('disabled', true);
                    }


            }
        });

  });

/***************************************************************************************/
/******************************* modal actualizacion de pagos **************************/
/**************************************************************************************/
        $(document).on('click', '#btn_up_pay_info', function(){
                    $('#modal_up_pay_info').modal('show');
                    $('#id_cripta_mausoleo_modal_pay_info').val($(this).val());
                    // buscar si hay difuntos ingresados
                    $.ajax({
                        type: 'GET',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url: '/cripta/get-cripta/' + $(this).val(),
                                success: function(data)
                                {
                                    console.log(data);
                                    if(data.status!=null )
                                    {
                                        $('#cod_cm_info').html(data.response.cripta.codigo);
                                        var segundo_apellido=data.response.responsable.segundo_apellido ? data.response.responsable.segundo_apellido : '';
                                        $('#resp_cm_info').html(data.response.responsable.nombres+" "+data.response.responsable.primer_apellido+" "+segundo_apellido);
                                        $('#respdifunto_id_cm_info').html(data.response.responsable.id);

                                    }//end if
                                }
                    });

                    $.ajax({
                        type: 'GET',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url: '/mantenimiento/get-mantenimiento/' + $(this).val(),
                                success: function(mant)
                                {
                                    console.log(mant);
                                    if(mant.status==true )
                                    {
                                        $('#upci').val(mant.resp.ci);
                                        $('#upnombre').val(mant.resp.nombrepago);
                                        $('#upprimer_apellido').val(mant.resp.paternopago);
                                        $('#upsegundo_apellido').val(mant.resp.maternopago);
                                        $('#upgestiones').val(mant.resp.gestion);
                                        $('#upultima_gestion').val(mant.resp.ultimo_pago);
                                        $('#upcantidad_gestion').val(mant.resp.cantidad_gestiones);
                                        $('#upfur').val(mant.resp.fur);
                                        $('#upmonto').val(mant.resp.monto);
                                        $('#upglosa').val(mant.resp.glosa);
                                        $('#upobservacion').val(mant.resp.observacion);

                                        if(mant.resp.pago_por =="Titular responsable"){
                                            $('#responsable_pago').prop("checked", true);
                                        }else if(mant.resp.pago_por =="Tercera persona"){
                                            $('#tercera_persona').prop("checked", true);
                                        }



                                        if(mant.resp.fecha_pago!=null){
                                            d=mant.resp.fecha_pago;
                                            var d=(mant.resp.fecha_pago).split(' ');
                                            $('#upfecha_pago').val(d[0]);
                                        }


                                    }//end if
                                }
                    });
        });

        //btn_modal_up_pay_info
        // send update pagos
        $(document).on('click', '#btn_modal_up_pay_info', function(e){
            e.preventDefault();

            if ($("input[type=radio][name=persona_pago]:checked").is(':checked')) {

                     persona_pago=$('input:radio[name=persona_pago]:checked').val();
                    //  alert(persona_pago);
                }
                else {
                    swal.fire({
                        title: "Precaución!",
                        text: "!Debe definir si el pago se hizo por tercera persona o por el adjudicatario!",
                        type: "error",
                        // timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                    return false;
                }
                        $.ajax({
                                            type: 'POST',
                                            headers: {
                                                'Content-Type':'application/json',
                                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                            },
                                            url: '{{ route("save.uppay.info") }}',
                                            async: false,
                                            data: JSON.stringify({
                                                'cripta_mausoleo_id': $('#id_cripta_mausoleo_modal_pay_info').val(),
                                                'respdifunto_id': $('#respdifunto_id_cm_info').val(),
                                                'nombrepago': $('#upnombre').val(),
                                                'paternopago' :  $('#upprimer_apellido').val(),
                                                'maternopago' :  $('#upsegundo_apellido').val(),
                                                'ci' :  $('#upci').val(),
                                                'ultima_gestion': $('#upultima_gestion').val(),
                                                'fur' :  $('#upfur').val(),
                                                'monto' :  $('#upmonto').val(),
                                                'precio_sinot':  $('#upmonto').val(),
                                                'pago_por':persona_pago,
                                                'glosa' :  $('#upglosa').val(),
                                                'observacion' :  $('#upobservacion').val(),
                                                'tipo_ubicacion' : "cripta-mausoleo",
                                                'codigo_ubicacion' :  $('#cod_cm_info').html(),
                                                'cantidad_gestiones' :  $('#upcantidad_gestion').val(),
                                                'gestiones' :  $('#upgestiones').val(),
                                                'fecha_pago' :  $('#upfecha_pago').val(),
                                                'id_ubicacion': $('#id_cripta_mausoleo_modal_pay_info').val(),
                                                'codigo_ubicacion':$('#cod_cm_info').html()

                                            }),
                                            success: function(data) {
                                                console.log()
                                                if(data.status==true){
                                                    swal.fire({
                                                             icon:"success",
                                                            title: "Registro actualizado!",
                                                            text: "!La informacion de pago fue actualizada exitosamente!",
                                                            type: "success",
                                                            showCancelButton: false,
                                                            showConfirmButton: true
                                                        });
                                                        location.reload();

                                                }else{
                                                     swal.fire({
                                                             icon:"error",
                                                            title: "Algo salió mal!",
                                                            text: "!Ocurrió un error, por favor  verifique si registró toda información solicitada!",
                                                            type: "error",
                                                            showCancelButton: false,
                                                            showConfirmButton: true
                                                        });
                                                        return false;
                                                }

                                            }
                                });
        })




/*************************************************************************/
/************************ edicion cripta mausoleo **********************/
/***********************************************************************/
        $(document).ready(function(){
            $(document).on('click','#btn-cripta-editar', function(){

                   var validar= validar_campos();

                   if(validar==false){
                        Swal.fire(
                            'Alerta!',
                            'Debe seleccionar una opcion en el campo notable!.',
                            'error'
                        ) ;

                   }else{


                    if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="0";}
                    else{var bloq=$('#bloque :selected').val();}

                // documentos recibido
                    if ($("#resolucion").is(":checked")) { var resolucion=$('#nro_resolucion').val(); } else { var resolucion="FALTA";}
                    if ($("#ci").is(":checked")) { var ci=$('#nro_ci').val();} else { var ci="FALTA";}
                    if ($("#bienes_m").is(":checked")) { var bienes_m="BIENES M";} else { var bienes_m="FALTA";}
                    if ($("#planos_aprobados").is(":checked")) { var planos_aprobados="PLANOS A";} else { var planos_aprobados="FALTA";}
                    if ($("#obs_resolucion").is(":checked")) { var obs_resolucion=$('#txt_resolucion').val(); } else { var obs_resolucion="FALTA";}
                    if($('#notable :selected').text()=="SELECCIONAR"){ var field_notable=null;}else{ var field_notable= $('#notable :selected').val(); }

                    //edicion de documentos

                    if($('#url_foto_resol').val()!=''){
                        var resolucion_doc=$('#url_foto_resol').val();
                    }
                    else{
                        var resolucion_doc=$('#url_foto_resol_edit').val();
                    }

                    if($('#url_foto_title').val()!=''){
                        var foto_title_doc=$('#url_foto_title').val();
                    }
                    else{
                        var foto_title_doc=$('#url_foto_title_edit').val();
                    }


                    if($('#url_foto_prop').val()!=''){
                        var foto_prop_doc=$('#url_foto_prop').val();
                    }
                    else{
                        var foto_prop_doc=$('#url_foto_prop_edit').val();
                    }

                    if($('#url_foto_planos_ap').val()!=''){
                        var foto_planos_ap_doc=$('#url_foto_planos_ap').val();
                    }
                    else{
                        var foto_planos_ap_doc=$('#url_foto_planos_ap_edit').val();
                    }


                $.ajax({
                        type: 'PUT',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                        },
                        url: '{{ route("cripta.update") }}',
                        async: false,
                        data: JSON.stringify({
                            'cripta_mausoleo_id': $('#cripta_mausoleo_id').val(),
                            'id_cripta':  $('#btn-cripta-editar').val(),
                            'id_cuartel':  $('.select-cuartel').val(),
                            'codigo': $('#cod-cripta').val(),
                            'codigo_ant': $('#cod_cripta_ant').val(),
                            'bloque':bloq,
                            'sitio':$('#cod-sitio').val(),
                            'familia':$('#familia').val(),
                            'tipo_reg':$('#tipo_reg').val(),
                            'nombres_resp': $('#cripta-name').val(),
                            'paterno_resp' :  $('#paterno').val(),
                            'materno_resp' :  $('#materno').val(),
                            'ci_resp' :  $('#dni').val(),
                            'domicilio' :  $('#domicilio').val(),
                            'genero_resp' :  $('#genero').val(),
                            'celular' :  $('#telefono').val(),
                            'superficie': $('#superficie').val(),
                            'nro_cripta' :  $('#nro-cripta').val(),
                            'enterratorios_ocupados' :  $('#enterratorios_ocupados').val(),
                            'total_enterratorios' :  $('#total_enterratorios').val(),
                            'osarios' :  $('#osarios').val(),
                            'total_osarios':$('#total_osarios').val(),
                            'cenisarios' :  $('#cenisarios').val(),
                            'observaciones' :  $('#observaciones').val(),
                            'estado_construccion' :  $('#construido').val(),
                            'tipo_cripta':$('#tipo_cripta option:selected').val(),
                            'adjudicacion':$('#adjudicacion').val(),
                            'notable':field_notable,
                            'altura': $('#altura').val(),
                            'foto' :  $('#url-foto').val(),
                            'foto_edit' :  $('#url-foto-edit').val(),
                            'estado': $('#estado').val() ,
                            'documentos_recibidos':  {
                                                       'resolucion': resolucion,
                                                       'ci': ci,
                                                       'bienes_m': bienes_m,
                                                       'planos_aprobados': planos_aprobados,
                                                       'obs_resolucion':obs_resolucion,
                                                       'foto_resolucion':resolucion_doc,
                                                       'foto_titulo':foto_title_doc,
                                                       'foto_prop_ci':foto_prop_doc,
                                                       'foto_planos':foto_planos_ap_doc,
                                                    }


                        }),
                        success: function(data_response) {
                            console.log(data_response);
                            if(data_response.status){
                                        swal.fire({
                                        title: "Guardado!",
                                        text: "!Registro actualizado con éxito!",
                                        type: "success",
                                        timer: 2000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                        });
                            }else{
                                    swal.fire({
                                    title: "Precaucion!",
                                    text: "!El sitio ya esta ocupado!",
                                    type: "warning",
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                    });
                                }
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function (error) {

                            if(error.status == 422){
                                Object.keys(error.responseJSON.errors).forEach(function(k){
                                toastr["error"](error.responseJSON.errors[k]);

                                });
                            }else if(error.status == 419){
                                location.reload();
                            }

                        }
                    });
                    $('#estado').show();
                }
            });



            $(document).on('click', '#btn-editar', function(){

                $('#foto_actual').empty();
                $('#foto_actual').hide();
                $('.clear').val('');
                $(".select-cuartel").val('').trigger('change');
                $('#cod-cripta').val('');
                $('#cod_cripta_ant').val('');
                $('#cripta-name').val('');
                $('#bloque').val('');
                $('#cod-sitio').val('');
                $('#superficie').val('');
                $('#construido').val(''),
                $('#enterratorios_ocupados').val(0),
                $('#total_enterratorios').val(0),

                $('#osarios').val(0),
                $('#total_osarios').val(0),

                $('#cenisarios').val(0),

                $('#observaciones').val(''),
                $('#url-foto').val(''),
                $('#domicilio').val(''),
                $('#genero').val(''),
                $('#telefono').val(''),

                //reset documentos recibidos
                $('#foto_resol').html('');
                $('#foto_title').html('');
                $('#foto_prop').html('');
                $('#foto_planos_ap').html('');



                $('#familia').val('');
                $('#tipo_cripta').val('');
                $('#resolucion').prop('checked', false);

                $('#ci').prop('checked', false);
                $('#nro_ci').val(''),
                $('#nro_resolucion').val(''),
                $('#notable').val(''),
                $('#altura').val(''),

                $('#dni').val(''),
                $('#adjudicacion').val(''),
                $('#nro_resolucion').hide();
                $('#nro_ci').hide();
                $('#txt_resolucion').hide();
                $('#obs_resolucion').prop('checked', false);

                $('#planos_aprobados').prop('checked', false);
                $('#bienes_m').prop('checked', false);



                $('#cmform').find("input[type=text], input[type=checkbox], textarea,  tel").val("");
                $('#cmform').find("input[type=number]").val("0");
                $('#cmform').find("select[name=notable]").val("");
                  $(this).find('form').trigger('reset');
                // $('#modal-cripta').reset();
                $('#section_data').show();
                $('#estado').show();
                var cripta_mausoleo_id = $(this).val();
                $.ajax({
                        type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/cripta/get-cripta/' + $(this).val(),
                        async: false,
                        success: function(data_query) {
                            console.log("*************************************");
                            console.log(data_query['response']['cripta']);
                            console.log("/*************************************/");

                            console.log(data_query['response']['responsable']);
                            var data_response=data_query['response']['cripta'];
                            var data_resp=data_query['response']['responsable'];
                            if(data_response.enterratorios_ocupados== null){ var enterratorios_ocupados=0;} else{ var enterratorios_ocupados= data_response.enterratorios_ocupados;}
                            if(data_response.total_enterratorios== null){ var total_enterratorios=0;} else{ var total_enterratorios= data_response.total_enterratorios;}
                            if(data_response.osarios== null){ var osarios=0;} else{ var osarios= data_response.osarios;}
                            if(data_response.total_osarios== null){ var total_osarios=0;} else{ var total_osarios= data_response.total_osarios;}
                            if(data_response.cenisarios== null){ var cenisarios=0;} else{ var cenisarios= data_response.cenisarios;}

                            $('#modal-cripta').modal('show');
                            $('#btn-cripta-editar').show(300);
                            $('#btn-cripta').hide(300);
                            $('#cripta_mausoleo_id').val(cripta_mausoleo_id);
                            $(".select-cuartel").val(data_response.cuartel_id).trigger('change');
                            $('#cod-cripta').val(data_response.codigo);
                            $('#cod_cripta_ant').val(data_response.codigo_antiguo);
                            $('#cod-sitio').val(data_response.sitio);
                            $('#bloque').val(data_response.bloque_id);
                            $('#tipo_reg').val(data_response.tipo_registro);
                            $('#superficie').val(data_response.superficie);
                            $('#estado').val(data_response.estado);
                            $('#btn-cripta-editar').val(data_response.id);
                            $('#construido').val(data_response.estado_construccion);
                            $('#enterratorios_ocupados').val(enterratorios_ocupados);
                            $('#total_enterratorios').val(total_enterratorios);
                            $('#osarios').val(osarios);
                            $('#total_osarios').val(total_osarios);
                            $('#cenisarios').val(cenisarios);
                            $('#observaciones').val(data_response.observaciones);
                            $('#familia').val(data_response.familia);
                            $('#altura').val(data_response.altura);
                            $('#notable').val(data_response.notable);

                            if(data_response.foto!=null ||data_response.foto!="" ){
                                console.log("entra afoto"+data_response.foto );
                                    $('#url-foto-edit').val(data_response.foto)  ;
                                    $('#foto_actual').show();
                                    $('#foto_actual').append('<a href="'+ data_response.foto+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_actual').append('<img src="'+ data_response.foto+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_actual').empty();
                                            $('#foto_actual').hide();
                                    }

                            if(data_resp!=null){
                                $('#cripta-name').val(data_resp.nombres);
                                $('#paterno').val(data_resp.primer_apellido);
                                $('#materno').val(data_resp.segundo_apellido);
                                $('#dni').val(data_resp.ci);
                                $('#domicilio').val(data_resp.domicilio);
                                $('#genero_resp').val(data_resp.genero);
                                $('#telefono').val(data_resp.celular);

                                $('#adjudicacion').val(data_resp.adjudicacion);

                                    if(data_resp.documentos_recibidos){
                                        var ar=JSON.parse(data_resp.documentos_recibidos);
                                        console.log(ar);
                                        if(ar.bienes_m=="BIENES M"){ $('#bienes_m').prop('checked', true); }else{$('#bienes_m').prop('checked', false);}
                                        if(ar.ci!="FALTA"){ $('#ci').prop('checked', true); $('#nro_ci').val(ar.ci); $('#nro_ci').show(); $('#digital_documents').show(); }else{$('#ci').prop('checked', false);}
                                        if(ar.resolucion!="FALTA"){ $('#resolucion').prop('checked', true); $('#nro_resolucion').val(ar.resolucion); $('#nro_resolucion').show(); }else{$('#resolucion').prop('checked', false);}
                                        if(ar.planos_aprobados=="PLANOS A"){ $('#planos_aprobados').prop('checked', true); }else{$('#planos_aprobados').prop('checked', false);}
                                        if(ar.obs_resolucion!="FALTA"){ $('#obs_resolucion').prop('checked', true); $('#txt_resolucion').val(ar.obs_resolucion); $('#txt_resolucion').show(); }else{$('#obs_resolucion').prop('checked', false);}


                                        //resolucion
                                        if(ar.foto_resolucion!=null){
                                            $('#url_foto_resol').val(ar.foto_resolucion)  ;
                                            $('#url_foto_resol_edit').val(ar.foto_resolucion)  ;
                                            $('#foto_resol').append('<a href="'+ ar.foto_resolucion+'" target="_blank">Ver foto actual </a>');
                                            $('#foto_resol').append('<img src="'+ ar.foto_resolucion+'" widh="100px" heigth="100"');
                                            }else{
                                                    $('#foto_resol').empty();
                                                    $('#foto_resol').hide();
                                            }
                                        //titulo de propiedad
                                        if(ar.foto_titulo!=null){
                                            $('#url_foto_title').val(ar.foto_titulo)  ;
                                            $('#url_foto_title_edit').val(ar.foto_titulo)  ;
                                            $('#foto_title').append('<a href="'+ ar.foto_titulo+'" target="_blank">Ver foto actual </a>');
                                            $('#foto_title').append('<img src="'+ ar.foto_titulo+'" widh="100px" heigth="100"');
                                            }else{
                                                    $('#foto_title').empty();
                                                    $('#foto_title').hide();
                                            }

                                        // ci adjudicatario
                                        if(ar.foto_prop_ci!=null){
                                            $('#url_foto_prop').val(ar.foto_prop_ci)  ;
                                            $('#url_foto_prop_edit').val(ar.foto_prop_ci)  ;
                                            $('#foto_prop').append('<a href="'+ ar.foto_prop_ci+'" target="_blank">Ver foto actual </a>');
                                            $('#foto_prop').append('<img src="'+ ar.foto_prop_ci+'" widh="100px" heigth="100"');
                                            }else{
                                                    $('#foto_prop').empty();
                                                    $('#foto_prop').hide();
                                            }

                                        //planos aprobados
                                        if(ar.foto_planos!=null){
                                            $('#url_foto_planos_ap').val(ar.foto_planos)  ;
                                            $('#url_foto_planos_ap_edit').val(ar.foto_planos)  ;

                                            $('#foto_planos_ap').append('<a href="'+ ar.foto_planos+'" target="_blank">Ver foto actual </a>');
                                            $('#foto_planos_ap').append('<img src="'+ ar.foto_planos+'" widh="100px" heigth="100"');
                                            }else{
                                                    $('#foto_planos_ap').empty();
                                                    $('#foto_planos_ap').hide();
                                            }
                                    }
                             }


                            if($('#tipo_reg option:selected').val() =="CRIPTA"){
                                        $('#letra').val("C");
                                        $('#box_tipo_cripta').show();
                                        $('#box_tipo_cripta').prop('disabled', false);
                                        $('#tipo_cripta').val(data_response.tipo_cripta);
                                 }else{
                                    $('#letra').val("M");
                                    $('#box_tipo_cripta').hide();
                                    $('#box_tipo_cripta').prop('disabled', true);
                                    $('#tipo_cripta').val("");
                                 }


                        }

                    });

            });



            $(document).on('click','#new-cripta', function(){
                $('#foto_actual').empty();
                $('#foto_actual').hide();

                $('.clear').val('');
                $(".select-cuartel").val('').trigger('change');
                $('#cod-cripta').val('');
                $('#cod_cripta_ant').val('');
                $('#cripta-name').val('');
                $('#bloque').val('');
                $('#cod-sitio').val('');
                $('#superficie').val('');
                $('#construido').val(''),
                $('#enterratorios_ocupados').val(0),
                $('#total_enterratorios').val(0),

                $('#osarios').val(0),
                $('#total_osarios').val(0),

                $('#cenisarios').val(0),

                $('#observaciones').val(''),
                $('#url-foto').val(''),
                $('#domicilio').val(''),
                $('#genero').val(''),
                $('#telefono').val(''),

                //reset documentos recibidos
                $('#foto_resol').html('');
                $('#foto_title').html('');
                $('#foto_prop').html('');
                $('#foto_planos_ap').html('');


                $('#btn-cripta-editar').hide(300);
                $('#btn-cripta').show(300);
                $('#familia').val('');
                $('#tipo_cripta').val('');
                $('#resolucion').prop('checked', false);

                $('#ci').prop('checked', false);
                $('#nro_ci').val(''),
                $('#nro_resolucion').val(''),
                $('#notable').val(''),
                $('#altura').val(''),

                $('#dni').val(''),
                $('#adjudicacion').val(''),
                $('#nro_resolucion').hide();
                $('#nro_ci').hide();
                $('#txt_resolucion').hide();
                $('#obs_resolucion').prop('checked', false);

                $('#planos_aprobados').prop('checked', false);
                $('#bienes_m').prop('checked', false);

                $('#modal-cripta').modal('show');




            });


            $(".select-cuartel").select2({
                width: 'resolve', // need to override the changed default
                dropdownParent: $('#modal-cripta')
            });

               //select2 bloque
            $("#bloque").select2({
                width: 'resolve', // need to override the changed default
                dropdownParent: $('#modal-cripta')
              });

             // select cuartel for search
              $(".select_cuartel_search").select2({
                width: 'resolve', // need to override the changed default
            });
            $("#bloque_search").select2({
                width: 'resolve', // need to override the changed default

              });


            $(document).on('click','#btn-cripta', function()
            {
                var validar= validar_campos();

                   if(validar==false){
                        Swal.fire(
                            'Alerta!',
                            'Debe seleccionar una opcion en el campo notable!.',
                            'error'
                        ) ;

                   }else{



                if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="0";}else{var bloq=$('#bloque :selected').val();}
                // documentos recibido
                    if ($("#resolucion").is(":checked")) { var resolucion=$('#nro_resolucion').val(); $('#digital_documents').show(); } else { var resolucion="FALTA";}
                    if ($("#ci").is(":checked")) { var ci=$('#nro_ci').val(); $('#digital_documents').show(); } else { var ci="FALTA";}
                    if ($("#bienes_m").is(":checked")) { var bienes_m="BIENES M";} else { var bienes_m="FALTA";}
                    if ($("#planos_aprobados").is(":checked")) { var planos_aprobados="PLANOS A"; $('#digital_documents').show(); } else { var planos_aprobados="FALTA";}
                    if ($("#obs_resolucion").is(":checked")) { var obs_resolucion=$('#txt_resolucion').val(); } else { var obs_resolucion="FALTA";}

                    if($('#notable :selected').text()=="SELECCIONAR"){ var field_notable=null;}else{ var field_notable= $('#notable :selected').val(); }


                $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('cripta.save') }}",
                        async: false,
                        data: JSON.stringify({
                            'id_cuartel':  $('.select-cuartel').val(),
                            'codigo': $('#cod-cripta').val(),
                            'codigo_ant': $('#cod_cripta_ant').val(),
                            'bloque':bloq,
                            'sitio':$('#cod-sitio').val(),
                            'tipo_reg':$('#tipo_reg').val(),
                            'nombres_resp': $('#cripta-name').val(),
                            'paterno_resp' :  $('#paterno').val(),
                            'materno_resp' :  $('#materno').val(),
                            'ci_resp' :  $('#dni').val(),
                            'domicilio' :  $('#domicilio').val(),
                            'genero_resp' :  $('#genero').val(),
                            'superficie': $('#superficie').val(),
                            'estado_construccion' :  $('#construido').val(),
                            'enterratorios_ocupados' :  $('#enterratorios_ocupados').val(),
                            'total_enterratorios' :  $('#total_enterratorios').val(),
                            'osarios' :  $('#osarios').val(),
                            'total_osarios' :  $('#total_osarios').val(),
                            'cenisarios' :  $('#cenisarios').val(),
                            'observaciones' :  $('#observaciones').val(),
                            'foto' :  $('#url-foto').val(),
                            'celular' :  $('#telefono').val(),
                            'notable' :  field_notable,
                            'altura':$('#altura').val(),

                            'familia':$('#familia').val(),
                            'tipo_cripta':$('#tipo_cripta option:selected').val(),
                            'adjudicacion':$('#adjudicacion').val(),
                            'documentos_recibidos':  {
                                                       'resolucion': resolucion,
                                                       'ci': ci,
                                                       'bienes_m': bienes_m,
                                                       'planos_aprobados': planos_aprobados,
                                                       'obs_resolucion':obs_resolucion,
                                                       'foto_resolucion':$('#url_foto_resol').val(),
                                                        'foto_titulo':$('#url_foto_title').val(),
                                                        'foto_prop_ci':$('#url_foto_prop').val(),
                                                        'foto_planos':$('#url_foto_planos_ap').val()
                                                       },
                            'estado': $('#estado').val(),
                        }),
                        success: function(data_response)
                         {

                                        if(data_response.status){
                                            swal.fire({
                                            title: "Guardado!",
                                            text: "!Registro actualizado con éxito!",
                                            type: "success",
                                            timer: 2000,
                                            showCancelButton: false,
                                            showConfirmButton: false
                                        });
                                        }else{
                                            swal.fire({
                                            title: "Precaucion!",
                                            text: "!El sitio ya esta ocupado!",
                                            type: "warning",
                                            timer: 2000,
                                            showCancelButton: false,
                                            showConfirmButton: false
                                            });
                                        }

                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                        //toastr["success"]("Registro realizado con éxito!");
                                    },
                                    error: function (error) {

                                        if(error.status == 422){
                                            Object.keys(error.responseJSON.errors).forEach(function(k){
                                            toastr["error"](error.responseJSON.errors[k]);
                                            });
                                        }else if(error.status == 419){
                                            location.reload();
                                        }

                          }
                    });
                }
            });



                   $('#cripta-data').DataTable({
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
                            "sSearch": 'Buscar Cripta:',
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
        function validar_campos(){

            if($('#notable option:selected').val()==null || $('#notable option:selected').val()==""){

                return false;
            }
            return true;
        }
/**************************************************************************/
/*************combo dinamico bloque en funcion al cuartel ****************/
/*************************************************************************/

        $(document).on('change', '#cuartel', function(){
            $('#bloque').empty();
            var sel_cuartel=$('#cuartel').val();
                $('#bloque').prop('disabled', false);
                $.ajax({
                    type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('bloqueid.get') }}",
                        async: false,
                        data: JSON.stringify({
                            'cuartel': $('#cuartel').val(),
                        }),
                        success: function(data_bloque) {
                            var op1='<option >SELECCIONAR</option>';
                            $('#bloque').append(op1);
                           $.each( data_bloque.response, function( key, value ) {
                                 opt2='<option value="'+ value.id +'">'+value.codigo +'</option>';
                                 $('#bloque').append(opt2);
                            });
                        }
                });
        });




/**************************************************************************/
/*************busqueda avanzada por cuartel*****************************/
/*************************************************************************/

    $(document).on('change', '.select_cuartel_search', function(){
        $('#bloque_search').empty();
        var sel_cuartel=$('.select_cuartel_search').val();
              $('#bloque_search').prop('disabled', false);
                $.ajax({
                    type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('bloqueid.get') }}",
                        async: false,
                        data: JSON.stringify({
                            'cuartel': $('#select_cuartel_search').val(),
                        }),
                        success: function(data_bloque) {
                           var op1='<option value="" >SELECCIONAR</option>';
                            $('#bloque_search').append(op1);
                           $.each( data_bloque.response, function( key, value ) {
                                 opt2='<option value="'+ value.id +'">'+value.codigo +'</option>';
                                 $('#bloque_search').append(opt2);
                            });
                        }
                });
    });



/**************************************************************************/
/*************Generar codigo cripta****************************************/
/*************************************************************************/
    function generarCodigo(){
        var sup=$('#superficie').val();
        if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="000";}
        else{var bloq=$('#bloque :selected').text();}

        console.log(bloq);
        console.log($('#cod-sitio').val());

        var cod=($('#cuartel :selected').text()).toUpperCase()+bloq+$('#cod-sitio').val()+($('#letra').val()).toUpperCase()+parseInt(sup);
        $('#cod-cripta').val(cod);
    }


/**************************************************************************/
/*************cargado de foto cripta mausoleo *****************************/
/*************************************************************************/

$(document).ready(function ()
 {

    $("#foto").dropzone({
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
        init: function()
        {
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
                                    $('#url-foto').val('');
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
                    formData.append('collector', 'cementerio');

                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#url-foto').val(response.response[0].url_file);
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


    // $("#foto-edit").dropzone({
    //     dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
    //     dictRemoveFile: 'Remover Archivo',
    //     dictCancelUpload: 'Cancelar carga',
    //     dictResponseError: 'Server responded with  code.',
    //     dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
    //     url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
    //     paramName: "documens_files[]",
    //     addRemoveLinks: true,
    //     acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
    //     parallelUploads: 1,
    //     maxFiles: 1,
    //     init: function() {
    //     this.on("complete", function(file) {
    //         if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
    //             this.removeFile(file);
    //             toastr["error"]('No se puede subir el archivo '+ file.name);
    //             return false;
    //         }
    //     });
    //        this.on("removedfile", function(file) {
    //         $.ajax({
    //                     type: 'DELETE',
    //                     headers: {
    //                         'Content-Type':'application/json'
    //                     },
    //                     url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
    //                     async: false,
    //                     data: JSON.stringify({
    //                         'url':  JSON.parse(file.xhr.response).response[0].url_file
    //                     }),
    //                     success: function(data_response) {
    //                         $('url-foto-edit').val('');
    //                     }
    //                 })

    //     });

    //     this.on("maxfilesexceeded", function(file){
    //         file.previewElement.classList.add("dz-error");
    //         $('.dz-error-message').text('No se puede subir mas archivos!');
    //     });

    //     },
    //     sending: function(file, xhr, formData){
    //                 formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
    //                 formData.append('collector', 'cementerio');

    //             },
    //     success: function (file, response) {
    //         file.previewElement.classList.add("dz-success");
    //         $('#url-foto-edit').val(response.response[0].url_file);

    //     },
    //     error: function (file, response) {

    //         if(response == 'You can not upload any more files.'){
    //             toastr["error"]('No se puede subir mas archivos');
    //             this.removeFile(file);
    //         }
    //         file.previewElement.classList.add("dz-error");
    //         $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
    //     }

    // });


                function openFile(file) {
                var extension = file.substr( (file.lastIndexOf('.') +1) );
                switch(extension) {
                    case 'jpg':
                    case 'png':
                        return 'image';  // There's was a typo in the example where
                    break;                         // the alert ended with pdf instead of gif.
                    case 'zip':
                    case 'rar':
                        alert('was zip rar');
                    break;
                    case 'pdf':
                        return 'pdf';
                    break;
                    default:
                    return 'desconocido';
                }
            }
        });

        $(document).on('click', '#generarciresp', function() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                url: "{{ route('generateCiResp') }}",
                method: 'GET',
                dataType: 'json',
                success: function(ciresp) {
                    console.log(ciresp);
                    $('#dni').val(ciresp);

                }
            })

})


/**************************************************************************/
/*************cargado de certificado de defuncion**************************/
/*************************************************************************/
    $("#cert_defuncion").dropzone({
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
        init: function()
        {
                this.on("complete", function(file) {
                    if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                        this.removeFile(file);
                        toastr["error"]('No se puede subir el archivo '+ file.name);
                        return false;
                    }
                });

                this.on("maxfilesexceeded", function(file){
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se puede subir mas archivos!');
                });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'cementerio certificado defuncion');
                    formData.append('nro_documento', $('#resp_cm_dif').html());   /***** ci responsable ***/
                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#mdurl-certification').val(response.response[0].url_file);
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


/**************************************************************************/
/***********cargado de certificado de defuncion desde modal pagos *******/
/*************************************************************************/
$("#cert_defuncion_p").dropzone({
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
        init: function()
        {
                this.on("complete", function(file) {
                    if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                        this.removeFile(file);
                        toastr["error"]('No se puede subir el archivo '+ file.name);
                        return false;
                    }
                });

                this.on("maxfilesexceeded", function(file){
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se puede subir mas archivos!');
                });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'cementerio certificado defuncion');
                    formData.append('nro_documento', $('#resp_cm').html());   /***** ci responsable ***/
                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#mdurl-certification-p').val(response.response[0].url_file);
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

/**************************************************************************/
/*************metodo de busqueda de ci del responsable o difunto***********/
/*************************************************************************/
           $(document).on('click', '#buscarResp', function()
            {
                var ci = $('#dni').val();
                if (ci.length < 1) {

                    Swal.fire(
                        'Busqueda finalizada!',
                        'El campo C.I. esta vacio .',
                        'warning'
                    )

                } else {
                    var type = "responsable";
                    dats = buscar_ci_resp(ci, type);

                }
            });

            function buscar_ci_resp(ci, type) {
                var datos = "";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('search.difunto.responsable') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "ci": ci,
                        "type": type
                    }),
                    success: function(data) {
                        if (data.response == null) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                            )
                        } else {

                            $('#cripta-name').val(data.response.nombres);
                            $('#paterno').val(data.response.primer_apellido);
                            $('#materno').val(data.response.segundo_apellido);
                            $('#domicilio').val(data.response.domicilio);
                            $('#genero').val(data.response.genero);


                        }

                    },
                    error: function(xhr, status) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El registro no ha  sido encontrado o no existe .',
                            'error'
                        )
                    },



                });
                // return datos;
            }

/********************************************************************************/
/****controlar activacion de nro de resolucion como documetno recibido***********/
/********************************************************************************/
            //
            $(document).on('click', '#resolucion', function(){
                 if ($("#resolucion").is(":checked")) {
                    $('#nro_resolucion').show();
                } else {
                    $('#nro_resolucion').val("");
                    $('#nro_resolucion').hide();
                }
            });

             //controlar activacion de nro de ci como documetno recibido
             $(document).on('click', '#ci', function(){
                 if ($("#ci").is(":checked")) {
                    $('#nro_ci').show();
                    $('#digital_documents').show();
                } else {
                    $('#nro_ci').val("");
                    $('#nro_ci').hide();
                }
            });

            $(document).on('click', '#obs_resolucion', function(){
                 if ($("#obs_resolucion").is(":checked")) {
                    $('#txt_resolucion').show();
                } else {
                    $('#txt_resolucion').val("");
                    $('#txt_resolucion').hide();
                }
            });

/********************************************************************************/
/*******************validacion numeros o letras y telefono***********************/
/********************************************************************************/

                $(function() {
                    $('.numeroEntero').keypress(function(e) {
                            if (isNaN(this.value + String.fromCharCode(e.charCode)))
                                return false;
                        })
                        .on("cut copy paste", function(e) {
                            e.preventDefault();
                        });

                });

                $(function() {
                    $('.soloLetras').bind('keyup input', function() {
                        if (this.value.match(/[^a-zA-Z áéíóúÁÉÍÓÚüÜñÑ]/g)) {
                            this.value = this.value.replace(/[^a-zA-Z áéíóúÁÉÍÓÚüÜñÑ]/g, '');
                        }
                    });
                });


                $(document).on('keyup', '#telefono', function(e){
                    // alert(this.value + String.fromCharCode(e.charCode));

                    var number=$('#telefono').val();
                    var primer=number.charAt(0);
                    if(number.length>=1) {
                                if(primer < 4 || primer == 5  || primer == 8 || primer == 9){
                                    Swal.fire(
                                            'Error!',
                                            'El número de telefono  fijo o celular debe iniciar con 4 , 6 o 7!.',
                                            'error'
                                        ) ;
                                        $('#telefono').val("");
                                    return false;
                                }
                            }
                });

/********************************************************************************/
/****metodo para adicionar difuntos y mostrar difuntos cargados en tabla ***********/
/********************************************************************************/

        /***difuntos **/

                $(document).on('click', '#btn_add_difunto', function(){

                    // buscar si hay difuntos ingresados
                    $('#id_cripta_mausoleo_modal').val($(this).val());

                    $.ajax({
                                type: 'POST',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url:'{{ route("difuntoCripta.get") }}',
                                async: false,
                                data: JSON.stringify({
                                    'cripta_mausoleo_id': $(this).val(),
                                }),
                                success: function(data_response)
                                {
                                            if(data_response.responsable || data_response.responsable!=null)
                                            {
                                                $('#modal_add_difunto').modal('show');
                                                $('#cod_cm_dif').html(data_response.response['codigo']);
                                                $('#resp_cm_dif').html(data_response.responsable['ci'])


                                                $('#tabla_difunto_row').empty();
                                                $('#modal_save_difuntos').prop('disabled', false);

                                                console.log(data_response);
                                                var list=jQuery.parseJSON(data_response.response['difuntos']);
                                                if(data_response.response['difuntos']!=null )
                                                {

                                                    $.each(list, function(key, value)
                                                    {
                                                            console.log( value[value]);

                                                                //llenar tabla
                                                                    var row='<tr>'+
                                                                            '<td class="dtci">'+value['ci']+'</td>'+
                                                                            '<td class="dtname">'+value['nombres']+'</td>'+
                                                                            '<td class="dtprimer_apellido">'+value['primer_apellido']+'</td>'+
                                                                            '<td class="dtsegundo_apellido">'+value['segundo_apellido']+'</td>'+
                                                                            '<td class="dtcertificado_defuncion">'+value['ceresi']+'</td>'+
                                                                            '<td class="dttipo">'+value['tipo']+'</td>'+
                                                                            '<td class="dtfecha_nacimiento">'+value['fecha_nacimiento']+'</td>'+
                                                                            '<td class="dtedad">'+calcularEdad(value['fecha_nacimiento'])+'</td>'+
                                                                            '<td class="dtfecha_defuncion">'+value['fecha_defuncion']+'</td>'+
                                                                            '<td class="dtcausa">'+value['causa']+'</td>'+
                                                                            '<td class="dtfuneraria">'+value['funeraria']+'</td>'+
                                                                            '<td class="dtgenero">'+value['genero']+'</td>'+
                                                                            '<td class="enl"><a href="'+value['url']+'" target="_blank" >Ver adjunto</a></td>'+
                                                                            '<td class="dturl" >'+value['url']+'</td>'+
                                                                            '<td class="dtborrar"> <a href="#" id="remove"  onClick="$(this).parent().parent().remove();"> <i class="fas fa-trash wine fa-2x"></i></a></td></tr>';
                                                                        $('#tabla_difunto_row').append(row);
                                                                        // clear modal form
                                                                        $('.clear').val('');
                                                                        $('.clears2').val(null).trigger('change');
                                                                        $('.dz-image').html("");
                                                                        Dropzone.forElement('#cert_defuncion').removeAllFiles(true);


                                                    })

                                                    //end foreach
                                                }//end if
                                            }else{
                                                            swal.fire({
                                                                    title: "Precaución!",
                                                                    text: data_response.mensaje,
                                                                    type: "warning",
                                                                    timer: 40000,
                                                                    showCancelButton: false,
                                                                    showConfirmButton: true
                                                                });
                                                                setTimeout(function() {
                                                                    location.reload();
                                                                }, 2000);
                                            }
                                }
                    });
                });





                $("#funeraria").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_add_difunto'),
                    tags: true,
                    allowClear: true
                });

                $("#funeraria_p").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_pay_cm'),
                    tags: true,
                    allowClear: true
                });


                 $(document).on('click', 'button[aria-describedby="select2-funeraria-container"] span', function() {
                  $('#funeraria option:selected').remove();
                 });

                 $(document).on('click', 'button[aria-describedby="select2-funeraria_p-container"] span', function() {
                  $('#funeraria_p option:selected').remove();
                 });

                  $("#causa").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_add_difunto'),
                    tags: true,
                    allowClear: true
                  });

                    $(document).on('click', 'button[aria-describedby="select2-causa-container"] span', function() {
                        $('#causa option:selected').remove();
                    })


                $("#causa_p").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_pay_cm'),
                    tags: true,
                    allowClear: true
                });

                    $(document).on('click', 'button[aria-describedby="select2-causa_p-container"] span', function() {
                        $('#causa_p option:selected').remove();
                    })




                    $(document).on('click', '#add_difunto_row', function(e){
                            e.preventDefault();
                                verificar_difunto_sin_asignacion_sitio();
                    });

                    //busca si el difunto ya esta ingresado en otra unidad
                    function verificar_difunto_sin_asignacion_sitio(){
                        $.ajax({
                                        type: 'POST',
                                        headers: {
                                            'Content-Type':'application/json',
                                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                        },
                                        url: '{{ route("buscar.difunto.existente") }}',
                                        async: false,
                                        data: JSON.stringify({
                                            'cripta_mausoleo_id': $('#id_cripta_mausoleo_modal').val(),
                                            'ci': $('#mdci').val(),
                                            'nombre': $('#mdnombre').val(),
                                            'paterno': $('#mdprimer_apellido').val(),
                                            'materno': $('#mdsegundo_apellido').val(),
                                            'fecha_nacimiento': $('#mdfecha_nacimiento').val(),
                                            'fecha_defuncion': $('#mdfecha_defuncion').val()
                                        }),
                                            success: function(data) {
                                                if(data==0){
                                                        mostrar_difunto();
                                                        var nrow= $('.tabla_difunto tbody tr').length;
                                                        if(nrow>0){ $('#modal_save_difuntos').prop('disabled', false)}
                                                        else{
                                                            $('#modal_save_difuntos').prop('disabled', true)
                                                        }
                                                }else{
                                                    swal.fire({
                                                            title: "Precaución!",
                                                            text: "!El difunto ya se encuentra registrado en otra unidad!",
                                                            type: "success",
                                                            icon: "warning",
                                                            // timer: 2000,
                                                            showCancelButton: false,
                                                            showConfirmButton: true
                                                        });
                                                        return false;
                                                }
                                            }
                                });

                    }


                  // show Deceased row in table
                function mostrar_difunto()
                {
                    var row='<tr>'+
                        '<td class="dtci">'+$('#mdci').val()+'</td>'+
                        '<td class="dtname">'+$('#mdnombre').val()+'</td>'+
                        '<td class="dtprimer_apellido">'+$('#mdprimer_apellido').val()+'</td>'+
                        '<td class="dtsegundo_apellido">'+$('#mdsegundo_apellido').val()+'</td>'+
                        '<td class="dtcertificado_defuncion">'+$('#mdcertificado_defuncion').val()+'</td>'+
                        '<td class="dttipo">'+$('#mdtipo').val()+'</td>'+
                         '<td class="dtfecha_nacimiento">'+$('#mdfecha_nacimiento').val()+'</td>'+
                         '<td class="dtedad">'+calcularEdad($('#mdfecha_nacimiento').val())+'</td>'+
                        '<td class="dtfecha_defuncion">'+$('#mdfecha_defuncion').val()+'</td>'+
                        '<td class="dtcausa">'+$('#causa').val()+'</td>'+
                        '<td class="dtfuneraria">'+$('#funeraria').val()+'</td>'+
                        '<td class="dtgenero">'+$('#mdgenero').val()+'</td>'+
                        '<td class="enl" ><a href="'+$('#mdurl-certification').val()+'" target="_blank" >ver adjunto</a></td>'+
                        '<td class="dturl" >'+$('#mdurl-certification').val()+'</td>'+
                        '<td class="remove"> <a href="#" id="remove"  onClick="$(this).parent().parent().remove();"> <i class="fas fa-trash wine fa-2x"></i></a></td></tr>';
                       $('#tabla_difunto_row').append(row);
                       // clear modal form
                       $('.clear').val('');
                       $('.clears2').val(null).trigger('change');

                             Dropzone.forElement('#cert_defuncion').removeAllFiles(true);

                }

                    // convert table rows in array json for send to controller and send all data to controller
               $(document).on('click', '#modal_save_difuntos', function(e)
                {
                        e.preventDefault();
                        var id=$('#id_cripta_mausoleo_modal').val();
                                 let difuntos = [];
                                    document.querySelectorAll('.tabla_difunto tbody tr').forEach(function(e){
                                            let fila = {
                                                ci: e.querySelector('.dtci').innerText,
                                                nombres: e.querySelector('.dtname').innerText,
                                                primer_apellido: e.querySelector('.dtprimer_apellido').innerText,
                                                segundo_apellido: e.querySelector('.dtsegundo_apellido').innerText,
                                                ceresi: e.querySelector('.dtcertificado_defuncion').innerText,
                                                tipo: e.querySelector('.dttipo').innerText,
                                                fecha_nacimiento: e.querySelector('.dtfecha_nacimiento').innerText,
                                                edad: e.querySelector('.dtedad').innerText,

                                                fecha_defuncion: e.querySelector('.dtfecha_defuncion').innerText,
                                                causa: e.querySelector('.dtcausa').innerText,
                                                funeraria: e.querySelector('.dtfuneraria').innerText,
                                                genero: e.querySelector('.dtgenero').innerText,
                                                url: e.querySelector('.dturl').innerText,
                                            };
                                            difuntos.push(fila);
                                            console.log(difuntos);
                                    });

                                    $.ajax({
                                            type: 'PUT',
                                            headers: {
                                                'Content-Type':'application/json',
                                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                            },
                                            url: '{{ route("agregar.difuntos.cripta") }}',
                                            async: false,
                                            data: JSON.stringify({
                                                'id_cripta_mausoleo': id,
                                                'difuntos': difuntos,
                                            }),
                                            success: function(data)
                                            { console.log("entraaaa difuuuuuu");
                                                 console.log(data);
                                                                if(data.status==true){
                                                                    swal.fire({
                                                                            title: "Registro actualizado!",
                                                                            text: "!Se adiciono correctamente los registros de difuntos!",
                                                                            type: "success",
                                                                            timer: 2000,
                                                                            showCancelButton: false,
                                                                            showConfirmButton: false
                                                                        });
                                                                        setTimeout(function() {
                                                                            location.reload();
                                                                        }, 2000);
                                                                }else{
                                                                    swal.fire({
                                                                            title: "Error!",
                                                                            text: "!Ocurrió un error, intente nuevamente!",
                                                                            type: "error",
                                                                            timer: 2000,
                                                                            showCancelButton: false,
                                                                            showConfirmButton: false
                                                                        });
                                                                }


                                                },
                                                error: function(xhr, status) {

                                                    Swal.fire(
                                                        'Error!',
                                                        'Ocurrió un error al ejecutar la transaccion,  revise los datos e intentelo nuevamente  .',
                                                        'error'
                                                    )
                                                },
                                    })
                                    // console.log(difuntos);
                });


                    $('#tabla_difunto').DataTable({
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
                            "sSearch": 'Buscar Cripta:',
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


                    function calcularEdad(birth)
                     {
                        ageMS = Date.parse(Date()) - Date.parse(birth);
                        age = new Date();
                        age.setTime(ageMS);
                        ageYear = age.getFullYear() - 1970;

                        return ageYear;

                        // ageMonth = age.getMonth(); // Accurate calculation of the month part of the age
                        // ageDay = age.getDate();    // Approximate calculation of the day part of the age
                    }
/********************************************************************************/
/*********************abrir modal pagar servicio ********************************/
/********************************************************************************/

         $(document).on('click', '#btn_pay_cm', function()
         {
            $('.clear').val("");
            $('#tabla_difunto_row_pay').empty();
            $('#modal_pay_cm').modal('show');
            $('#id_cripta_mausoleo_modal_pay').val($(this).val());
            $('#contenedor_servicios').empty();
            // buscar si hay difuntos ingresados
            $.ajax({
                type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/cripta/get-cripta/' + $(this).val(),
                        success: function(data)
                        {
                           // alert(data.status);
                          var array_difuntos=[];
                            if(data.status==true )
                            {
                               // alert(data.response.responsable);
                                if(data.response.responsable !=null)
                                {
                                        $('#cod_cm').html(data.response.cripta.codigo);
                                        var segundo_apellido=data.response.responsable.segundo_apellido ? data.response.responsable.segundo_apellido : '';
                                        $('#resp_cm').html(data.response.responsable.nombres+" "+data.response.responsable.primer_apellido+" "+segundo_apellido);
                                        $('#resp_cm_id').html(data.response.responsable.id);
                                        $('#tipo_registro').html(data.response.cripta.tipo_registro);
                                        $('#resp_cm_nombre').val(data.response.responsable.nombres);
                                        $('#resp_cm_paterno').val(data.response.responsable.primer_apellido);
                                        $('#resp_cm_materno').val(data.response.responsable.segundo_apellido);
                                        $('#resp_cm_ci').val(data.response.responsable.ci);
                                        $('#tipo_resp').val('Titular_responsable');
                                        $('#cm_ci').val(data.response.responsable.ci);
                                        $('#cm_nombre_pago').val(data.response.responsable.nombres);
                                        $('#cm_paternopago').val(data.response.responsable.primer_apellido);
                                        $('#cm_maternopago').val(data.response.responsable.segundo_apellido);





                                        var array_difuntos = jQuery.parseJSON(data.response.cripta.difuntos);
                                         $('#difuntos_cm1').html(data.response.cripta.difuntos);
                                        $.each(array_difuntos, function(key,val)
                                        {
                                            var id_tabla="tabla_difunto_row_pay";
                                            var class_tabla="tabla_difunto_pay";
                                            add_to_list_difunto(val, id_tabla, class_tabla, 'ninguna', key);
                                        });

                                $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                                'Content-Type': 'application/json'
                                            },
                                            url: "{{ route('get.services') }}",
                                            method: 'GET',
                                            dataType: 'json',
                                            data: JSON.stringify({
                                                            }),
                                            success: function(data) {
                                                console.log("gggggggggggg");
                                                console.log(data.response);
                                                $.each(data.response, function(key,val)
                                                {
                                                          // console.log(val.descripcion );
                                                    // alert($('#tabla_difunto_row_pay').children().length);
                                                        if($('#tabla_difunto_row_pay').children().length>0)
                                                        {
                                                      //  if(val.cuenta=='15224370' || val.cuenta=='15224330' || val.cuenta=='15224380' || val.cuenta=='15224300' || val.cuenta=='15224390' ){}
                                                       // else{
                                                          if( val.cuenta=='15224330' ){}
                                                        else{
                                                            var html='<div class="form-check '+val.cuenta+'">'+
                                                                        '<input class="form-check-input services_origin" type="checkbox" id="'+val.cuenta+'" name="serv[tipo_servicio]" value="'+val.cuenta+'-'+val.descripcion+'"  onclick="cargar_sevicios_hijos(this)">'+
                                                                        '<label class="form-check-label labelservice" for="'+val.cuenta+'">'+val.descripcion+'</label>'+
                                                                        '<div id="serv_hijos'+val.cuenta+'"></div>'
                                                                        '</div>';
                                                                        $('#contenedor_servicios').append(html);


                                                                        if(val.cuenta=='15224200' || val.cuenta=="15224250" ){
                                                                          //  var html1='<p class="dif_exhumacion" style="display:none"> </p>';
                                                                           // $('.15224200').append(html1);
                                                                            $('#contenedor_dif_serv').show();
                                                                            $('#modal_save_pagos_cm').prop('disabled', true)
                                                                        }else
                                                                        {
                                                                            $('#modal_save_pagos_cm').prop('disabled', false)

                                                                        }



                                                        }
                                                        }
                                                        else{
                                                            if(val.cuenta=="15224150" || val.cuenta=="15224250" || val.cuenta=="15224410"   || val.cuenta=="15224360" || val.cuenta=="15224350"){
                                                                var html='<div class="form-check '+val.cuenta+'">'+
                                                                        '<input class="form-check-input" type="checkbox" id="'+val.cuenta+'" name="serv[tipo_servicio]" value="'+val.cuenta+'-'+val.descripcion+'"  onclick="cargar_sevicios_hijos(this)">'+
                                                                        '<label class="form-check-label labelservice" for="'+val.cuenta+'">'+val.descripcion+'</label>'+
                                                                        '<div id="serv_hijos'+val.cuenta+'"></div>'
                                                                        '</div>';
                                                                        $('#contenedor_servicios').append(html);

                                                                }
                                                        }
                                                });

                                            }
                                        })
                                //end ajax

                                    }
                                    else{
                                        Swal.fire(
                                                        'Error!',
                                                        'Debe completar los datos del responsable de la cripta o mausoleo,  revise los datos del formulario de registro de criptas/mausoleos y complete los datos.',
                                                        'error'
                                                    );
                                            //return false;
                                            setTimeout(function() {
                                               location.reload();
                                           }, 3000);

                                    }

                            }//end if
                        }
            });


         });

        //funcion para cargar servicios hijos por padre
        function cargar_sevicios_hijos(obj){

            var cuenta=$(obj).attr("id");
            var txt_cuenta=$(obj).attr("value");
            console.log(txt_cuenta);
            if ($('#'+cuenta+'').is(":checked"))
            {

                console.log("txt_cuenta si");

                        $.ajax({
                                type: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                url: "https://multiserv.cochabamba.bo/api/v1/cementerio/generate-all-servicios-cm",
                                async: false,
                                data: JSON.stringify({
                                    'data': cuenta
                                }),
                                success: function(data_response) {
                                    console.log(data_response.response);
                                    $('#servicio-hijos').empty();
                                    $.each(data_response.response, function(index, value)
                                    {
                                        //alert($('#tabla_difunto_row_pay').children().length );
                                        if($('#tabla_difunto_row_pay').children().length == 0)
                                            {
                                                if (value.num_sec == '636' || value.num_sec == '622' || value.num_sec == '623' || value.num_sec == '1990' || value.num_sec == '527' || value.num_sec == '526' || value.num_sec == '525'|| value.num_sec == '640'   )
                                                {
                                                               var html='<div class="form-check">'+
                                                                    '<input class="form-check-input service_child" type="checkbox" id="'+value.num_sec+'" name="serv[servicio]" value="'+ txt_cuenta +' => '+value.num_sec+' - '+ value.descripcion + ' - ' + value.monto1 +'- Bs." onclick="seleccionar_hijos_list()" >'+
                                                                    '<label class="form-check-label childservice" for="'+value.num_sec+'">'+value.descripcion+' - ' + value.monto1 +'- Bs.</label>'+
                                                                    '</div>';
                                                                    $('#serv_hijos'+cuenta+'').append(html);
                                                }
                                            }
                                            else{


                                                        if ( value.num_sec == '629' || value.num_sec == '631' ) {}
                                                                else {
                                                                    // console.log("asdas");
                                                                    var html='<div class="form-check">'+
                                                                    '<input class="form-check-input service_child" type="checkbox" id="'+value.num_sec+'" name="serv[servicio]" value="'+ txt_cuenta +' => '+value.num_sec+' - '+ value.descripcion + ' - ' + value.monto1 +'- Bs." onclick="seleccionar_hijos_list()" >'+
                                                                    '<label class="form-check-label childservice" for="'+value.num_sec+'">'+value.descripcion+' - ' + value.monto1 +'- Bs.</label>'+
                                                                    '</div>';
                                                                    $('#serv_hijos'+cuenta+'').append(html);
                                                                   }
                                                }

                                    });
                                }
                            });
            }else{
                $('#serv_hijos'+cuenta+'').empty();
                $('#servicios-data .row_'+cuenta+'').remove();
                calcularMonto();
            }
        }

        // funcion para enlistar servicios seleccionados y calcular total acumulado

        function seleccionar_hijos_list(){
            var tipo_serv="";
            var tipo_serv_txt="";
            var serv="";
            var serv_txt="";
            var acum=0;
            var monto=0;

           // $('#servicios-data').empty();
            $('.service_child').each(function( index ) {

                        if($(this).is(":checked"))
                        {   var info= ($(this).val()).split('=>');
                            //  alert(info);

                            id_serv= $.trim(((info[1]).split('-'))[0]);

                            if(index==0){
                                tipo_serv =$.trim(((info[0]).split('-'))[0]);
                                tipo_serv_txt=((info[0]).split('-'))[1];
                                serv= $.trim(((info[1]).split('-'))[0]);
                                serv_txt=((info[1]).split('-'))[1];

                                if(( id_serv =='623' || id_serv =='622' || id_serv =='636' || id_serv =='1990'  )&& $('#inhumacion').val()=="NO"){

                                    $('.section_difunto').show();
                                    $('#modal_save_pagos_cm').prop('disabled', true);
                                }
                                else if(( id_serv =='623' || id_serv =='622' || id_serv =='636' || id_serv =='1990')&& $('#inhumacion').val()=="SI"){
                                    $('.section_difunto').hide();
                                }
                                else if(( id_serv =='630' || id_serv =='628' || id_serv =='633' || id_serv =='634' || id_serv =='635' || id_serv =='1991' || id_serv =='1992' || id_serv =='1993')&& $('#exhumacion_txt').val()=="NO"){
                                   $('#dif_exhumado').show();
                                    seleccionar_difunto();
                                }
                                else if(( id_serv =='630' || id_serv =='628' || id_serv =='633' || id_serv =='634' || id_serv =='635'  || id_serv =='1991' || id_serv =='1992' || id_serv =='1993')&& $('#exhumacion').val()=="SI"){
                                    $('#dif_exhumado').hide();
                                }
                                   else{  $('.section_difunto').hide();
                                    $('#modal_save_pagos_cm').prop('disabled', false);
                               }
                            }else
                            {
                                var info= ($(this).val()).split('=>');
                                id_serv= $.trim(((info[1]).split('-'))[0]);
                                tipo_serv=tipo_serv+", "+ $.trim(((info[0]).split('-'))[0]);
                                tipo_serv_txt=tipo_serv_txt+", "+ $.trim(((info[0]).split('-'))[1]);
                                serv=serv+", "+ $.trim(((info[1]).split('-'))[0]);
                                serv_txt=serv_txt+", "+ $.trim(((info[1]).split('-'))[1]);
                                   // alert(id_serv);
                                            if(( id_serv =='623' || id_serv =='622' || id_serv =='636' || id_serv =='1990' )&& $('#inhumacion').val()=="NO"){

                                                $('.section_difunto').show();
                                                $('#modal_save_pagos_cm').prop('disabled', true);
                                                return false;
                                            }
                                            else if(( id_serv =='623' || id_serv =='622' || id_serv =='636' || id_serv =='1990' )&& $('#inhumacion').val()=="SI"){
                                                $('.section_difunto').hide();
                                            }
                                            else if(( id_serv =='630' || id_serv =='628'  || id_serv =='633' || id_serv =='634' || id_serv =='635'  || id_serv =='1991' || id_serv =='1992' || id_serv =='1993')&& $('#exhumacion_txt').val()=="NO"){
                                            $('#dif_exhumado').show();
                                                seleccionar_difunto();
                                            }
                                            else if(( id_serv =='630' || id_serv =='628' || id_serv =='633' || id_serv =='634' || id_serv =='635'  || id_serv =='1991' || id_serv =='1992' || id_serv =='1993')&& $('#exhumacion_txt').val()=="SI"){
                                                //$('#dif_exhumado').hide();
                                            }
                                            else{  $('.section_difunto').hide();
                                            $('#dif_exhumado').hide();
                                            $('#modal_save_pagos_cm').prop('disabled', false);

                                            }
                            }


                        }else {
                            if($('#622').is(":checked") || $('#623').is(":checked")){

                            }
                            else{
                                var info= ($(this).val()).split('=>');
                                id_serv= $.trim(((info[1]).split('-'))[0]);
                                $('.section_difunto').hide();
                                $('#modal_save_pagos_cm').prop('disabled', false);
                            }

                        }
                        drawRow();
                calcularMonto();

            });
        }

        $(document).on('click', '#1991', function(){
            if($('#1991').is(":checked") ){
                $('#contenedor_dif_serv').show();
            }else{
                $('#contenedor_dif_serv').hide();
            }
        })

        $(document).on('click', '#1992', function(){
            if($('#1992').is(":checked") ){
                $('#contenedor_dif_serv').show();
            }else{
                $('#contenedor_dif_serv').hide();
            }
        })

        $(document).on('click', '#1993', function(){
            if($('#1993').is(":checked") ){
                $('#contenedor_dif_serv').show();
            }else{
                $('#contenedor_dif_serv').hide();
            }
        })
        // adicionar datos del difunto a inhumar
            $(document).on('click', '#boton_dif_inhum', function(e){
                e.preventDefault();
                var id=$('#id_cripta_mausoleo_modal_pay').val();
                let dif_in = [];
                var ci= document.getElementById('mdpci').value;
                var nombres= document.getElementById('mdpnombre').value;
                var primer_apellido= document.getElementById('mdpprimer_apellido').value;
                var segundo_apellido =  document.getElementById('mdpsegundo_apellido').value;
                var fecha_nacimiento =  document.getElementById('mdpfecha_nacimiento').value;
                var fecha_defuncion =  document.getElementById('mdpfecha_defuncion').value;
                var fecha_ingreso =  document.getElementById('mdpfecha_ingreso').value;

                if(fecha_defuncion=='' ||  fecha_defuncion==null){
                    console.log("fecha def "+fecha_defuncion+ "fecha ongrso"+fecha_ingreso );
                    swal.fire({
                              title: "Precaucion!",
                              text: "!Debe completar la fecha de defuncion!",
                              type: "warning",
                              timer: 2000,
                              showCancelButton: false,
                              showConfirmButton: false
                          });

                             return false

                }

                if( document.getElementById('causa_p').value=='undefined'
                || document.getElementById('causa_p').value==''  ){
                    var causa_select="no definido";
                }
                else{
                    var causa_select=document.getElementById('causa_p').value;
                }


                if( document.getElementById('funeraria_p').value=='undefined' || document.getElementById('funeraria_p').value==''){
                    var fun_select="no definido";
                }
                else{
                    var fun_select=document.getElementById('funeraria_p').value;
                }
                // alert(fun_select);
                                            let fila = {
                                                ci: document.getElementById('mdpci').value,
                                                nombres: document.getElementById('mdpnombre').value,
                                                primer_apellido: document.getElementById('mdpprimer_apellido').value,
                                                segundo_apellido:  document.getElementById('mdpsegundo_apellido').value,
                                                ceresi:  document.getElementById('mdpcertificado_defuncion').value,
                                                tipo:  document.getElementById('mdptipo').value,
                                                fecha_nacimiento:  document.getElementById('mdpfecha_nacimiento').value,
                                               // edad: document.getElementById('mdpsegundo_apellido').value,
                                                fecha_defuncion:  document.getElementById('mdpfecha_defuncion').value,
                                                fecha_ingreso:  document.getElementById('mdpfecha_ingreso').value,

                                                causa:causa_select,
                                                funeraria:  fun_select,
                                                genero: document.getElementById('mdpgenero').value,
                                                url:  document.getElementById('mdurl-certification-p').value,
                                            };
                                            dif_in.push(fila);
                                           // console.log(dif_in);
                                            var verificado= verificar_asignacion_difunto(ci, nombres, primer_apellido, segundo_apellido, fecha_nacimiento, fecha_defuncion);
                                         //  alert(verificado);
                                            if(verificado==true){
                                                    // insertar_difunto_inhumado(dif_in, id);
                                                    var id_tabla="tabla_difunto_row_pay";
                                                    var class_tabla="tabla_difunto_pay";
                                                    // var array_difuntos= jQuery.parseJSON(data.response.cripta.difuntos);
                                                    var cond='inhumado';

                                                    var long = 0; var nres = 0;
                                                        $('#'+id_tabla+' tr').each(function() {
                                                            long++;
                                                        })
                                                   // let long = $('#'+id_tabla+' tbody').find('tr').length;
                                                   // alert(long);
                                                    add_to_list_difunto(dif_in[0], id_tabla, class_tabla, cond, long);
                                                    // $('.clear').val('');
                                                    $('#section_difunto').hide();
                                                    $('#inhumacion').val('SI');

                                                    if( $('#623').prop('checked') ) {
                                                        $('#623').prop('disabled', true);
                                                        }

                                                        if( $('#622').prop('checked') ) {
                                                        $('#622').prop('disabled', true);
                                                        }
                                            }
                                            else{
                                                    //mostrar mensaje de advertencia que el difunto esta en otra ubicacion

                                                            swal.fire({
                                                                            title: "Precaucion!",
                                                                            text: "!El difunto ya se encuentra en otra ubicacion!",
                                                                            type: "warning",
                                                                            timer: 2000,
                                                                            showCancelButton: false,
                                                                            showConfirmButton: false
                                                                        });
                                                                        setTimeout(function() {
                                                                           return false
                                                                        }, 2000);

                                                                    }

            });
            function add_to_list_difunto(dif_in, id_tabla_body, class_tabla, cond, key)
            {


                                  if(dif_in.nombres=="" && dif_in.primer_apellido== "" && dif_in.fecha_nacimiento=="" && dif_in.fecha_defuncion=="" )
                                  {
                                                                  swal.fire({
                                                                            title: "Precaucion!",
                                                                            text: "!Debe completar los datos del difunto en el formulario actual, luego presionar el boton para adicion de difuntos!",
                                                                            type: "warning",
                                                                            timer: 2000,
                                                                            showCancelButton: false,
                                                                            showConfirmButton: false
                                                                        });
                                                                        setTimeout(function() {
                                                                           return false
                                                                        }, 2000);
                                  }
                                  else{
                                      var row=    ' <tr class="row-dif">'
                                            +     '<td id="cond'+key+'" class="data-condicion">'+cond+ ' </td>'
                                            +     '<td id="ci'+key+'" class="data-ci">'+dif_in.ci+ ' </td>'
                                            +     '<td id="nombre'+key+'" class="data-nombre">'+dif_in.nombres+ '</td>'
                                            +     '<td id="pat'+key+'" class="data-pat">'+dif_in.primer_apellido+ '</td>'
                                            +     '<td id="mat'+key+'" class="data-mat">'+dif_in.segundo_apellido+ '</td>'
                                            +     '<td id="cereci'+key+'" class="data-ceresi">'+dif_in.ceresi+ '</td>'
                                            +     '<td id="tipo'+key+'" class="data-tipo">'+dif_in.tipo+ '</td>'
                                            +     '<td id="nac'+key+'" class="data-nac">'+dif_in.fecha_nacimiento+ '</td>'
                                            +     '<td id="ingreso'+key+'" class="data-ingreso">'+dif_in.fecha_ingreso+ '</td>'
                                           // +     '<td id="edad'+key+'" class="data-edad">'+calcularEdad(dif_in.fecha_nacimiento)+'</td>'
                                            +     '<td id="def'+key+'" class="data-def">'+dif_in.fecha_defuncion+ '</td>'
                                            +     '<td id="causa'+key+'" class="data-causa">'+dif_in.causa+ '</td>'
                                            +     '<td id="fun'+key+'" class="data-fun">'+dif_in.funeraria+ '</td>'
                                            +     '<td id="genero'+key+'" class="data-genero">'+dif_in.genero+ '</td>'
                                            +     '<td id="enl'+key+'" class="data"><a href="'+dif_in.url+'" target="_blank" >Ver adjunto</a></td>'
                                            +     '<td id="url'+key+'" class="data-url" >'+dif_in.url+'</td>'
                                            +     '<td class="data"> <a href="#" id="remove_new"  onClick="$(this).parent().parent().remove();   "> <i class="fas fa-trash wine fa-2x"></i></a></td>';
                                            +     '</tr>';
                                      $('.'+class_tabla+'').show();
                                      $('#'+id_tabla_body+'').append(row);
                                      $('#modal_save_pagos_cm').prop('disabled', false);
                                  }


            }

            $(document).on('click', '#remove_new', function(e)
            {
                if( $('#623').prop('checked') )
                 {
                     $('#623').prop('disabled', false);
                     $('#623').prop( "checked", false );
                  }

                if( $('#622').prop('checked') ) {
                    $('#622').prop('disabled', false);
                    $('#622').prop( "checked", false );

                 }

                 document.getElementById("inhumacion").value="NO";
                 drawRow();
                 calcularMonto();
            });


         /*    //insert difunto inhumado
            function insertar_difunto_inhumado(fila, id){
                console.log("888");
                console.log(fila);
                console.log("888");

                $.ajax({
                                            type: 'PUT',
                                            headers: {
                                                'Content-Type':'application/json',
                                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                            },
                                            url: '{{ route("agregar.difuntos.cripta") }}',
                                            async: false,
                                            data: JSON.stringify({
                                                'id_cripta_mausoleo': id,
                                                'difuntos': fila,
                                            }),
                                            success: function(data)
                                               {
                                                 console.log("entraaaa");
                                                 console.log(data);
                                                                if(data.status==true){

                                                                }else{

                                                                }


                                                },
                                                error: function(xhr, status) {

                                                    Swal.fire(
                                                        'Error!',
                                                        'Ocurrió un error al ejecutar la transaccion,  revise los datos e intentelo nuevamente.',
                                                        'error'
                                                    )
                                                },
                                    })

            } */

            //listar difuntos existentes en la cripta / mausoleo
            function listar_difuntos(){
                var dif=JSON.parse($('#field_difuntos').html());
                console.log('----------');
                console.log(JSON.parse($('#field_difuntos').html()));
                console.log('----------');


                     var tbl_dif='<table class="table data tbldif">'
                                +'<h4> DETALLE DE DIFUNTOS </h4>'
                                // +'  <button type="button" class="btn btn-success add_dif_row" id="add_dif_row" >AGREGAR FILA</button> '
                                + '<thead>'
                                   +'<tr>'
                                    +'<th> C.I./NRO IDENTIFICACION </th>'
                                    +'<th> NOMBRES </th>'
                                    +'<th> PATERNO </th>'
                                    +'<th> MATERNO </th>'
                                    +'<th> GENERO </th>'
                                    // +'<th> CERESI </th>'
                                    +'<th> FECHA NACIMIENTO </th>'
                                    +'<th> FECHA INGRESO </th>'
                                    +'<th> FECHA DEFUNCION </th>'
                                     +'<th> FUNERARIA</th>'
                                     +'<th> CAUSA</th>'
                                     +'<th> TIPO</th>'

                                    +'</tr>'
                                + '</thead>'
                                + '<tbody>'
                                + '</tbody>'
                                + '</table>';
                                $('#difuntos-data').append(tbl_dif);

                                $.each(dif, function(index, value) {
                                    console.log('++++++++++++++++++');
                                    console.log(value.ci);
                                    var row=    ' <tr>'
                                            +     '<td class="data-ci">'+value.ci+ '</td>'
                                            +     '<td class="data-nombre">'+value.nombres+ '</td>'
                                            +     '<td class="data-pat">'+value.primer_apellido+ '</td>'
                                            +     '<td class="data-mat">'+value.segundo_apellido+ '</td>'
                                            +     '<td class="data-genero">'+value.genero+ '</td>'
                                            +     '<td class="data-ceresi">'+value.ceresi+ '</td>'
                                            +     '<td class="data-nac">'+value.fecha_nacimiento+ '</td>'
                                            +     '<td class="data-ingreso">'+value.fecha_ingreso+ '</td>'

                                           // +     '<td class="data-edad">'+calcularEdad(value.fecha_nacimiento)+'</td>'
                                            +     '<td class="data-def">'+value.fecha_defuncion+ '</td>'
                                            +     '<td class="data-fun">'+value.funeraria+ '</td>'
                                            +     '<td class="data-causa">'+value.causa+ '</td>'
                                            +     '<td class="data-tipo">'+value.tipo+ '</td>'
                                            +     '</tr>';
                                      $('.tbldif tbody').append(row);
                                });



            }


            function verificar_asignacion_difunto(ci, nombre, paterno, materno, fecha_nacimiento, fecha_defuncion){
              //  alert(nombre +"-"+paterno+"-"+materno+"-"+fecha_nacimiento+"-"+fecha_defuncion+"-");
                let verificar=0;
                $.ajax({
                                        type: 'POST',
                                        headers: {
                                            'Content-Type':'application/json',
                                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                        },
                                        url: '{{ route("verificar.asigancion.difunto") }}',
                                        async: false,
                                        dataType: "json",
                                data: JSON.stringify({
                                            'ci': ci,
                                            'nombre': nombre,
                                            'paterno': paterno,
                                            'materno': materno,
                                            'fecha_nacimiento': fecha_nacimiento,
                                            'fecha_defuncion': fecha_defuncion

                                        }),
                                            success: function(data) {
                                               //  alert( "----"+data);
                                                 if(data==0){
                                                   return verificar=true

                                                 }
                                                 else{
                                                    return verificar=false
                                                 }
                                            }
                        });
                        return verificar;
            }


            // metodo que calcula el monto de los servicios solicitados
                function drawRow()
                    {
                        var acum = 0;
                        var cantidad=1;

                       // $('#servicios-data').empty();
                        $('.service_child').each(function(index, value) {
                            var cad=($(this).val()).split("-");
                            var cod_serv=(cad[1]).split("=>");
                            console.log("cad  "+cad);
                            console.log("cod_serv  "+cod_serv[1]);



                            var buscarValor= buscarValorEnTabla(cod_serv[1]);
                            console.log("buscar fila "+buscarValor + "index  "+index);

                            if(buscarValor==null){
                                 console.log("no encontrado  ");
                                        if($(this).is(":checked")){
                                        //console.log("caddd");
                                        //console.log(cad);
                                        $('.detalle_servicios').show();
                                        subtotal = cantidad * cad[3];
                                        $('#servicios-data').append('<tr class="row_' + cad[0] + ' dynamic-row"><td class="dt_id_tipo_cuenta">'+cad[0]+'</td><td class="dt_txt_tipo_cuenta">'+cod_serv[0]+'</td><td class="dt_id_serv">'+cod_serv[1]+'</td><td class="dt_txt_serv">'+cad[2]+'</td><td class="dt_cantidad">'+cantidad+' Bs.</td><td class="dt_precio_unitario">'+cad[3]+' Bs.</td><td class="dt_subtotal">'+subtotal+' </td><td class="dt_obs" contenteditable></td></tr>');
                                       // acum = parseFloat(acum) + parseFloat(cad[3]);
                                       // $('#totalServ').html(acum);
                                    //  console.log("///------//");
                                      //  console.log("acum....."+acum);
                                        //console.log("///------//");
                                        addDragHandlers($('#servicios-data .row_' + cad[0] + '.dynamic-row')[0]);
                                }

                            }
                            else{
                                console.log(" encontrado  ");

                                    if ($(this).is(':checked')) {
                                       // acum = parseFloat(acum) + parseFloat(cad[3]);

                                        }else{
                                            console.log("no seleccionadp "+cad[0]);
                                            //  acum = parseFloat(acum) - parseFloat(cad[3]);

                                            $('.row_'+ cad[0]+'').remove();
                                        }
                                }

                        });


                    }

                  /*  $(document).on('click', '.services_origin', function(e){
                        e.preventDefault();
                        console.log("father"+ $(this).attr('id'));
                                  if ($(this).is(':checked')) {
                                       // acum = parseFloat(acum) + parseFloat(cad[3]);

                                        }else{

                                            //  acum = parseFloat(acum) - parseFloat(cad[3]);

                                            $('.row_'+ cad[0]+'').remove();
                                        }
                        calcularMonto();
                    })*/


/************* metodo que recorre toda la grilla resumen de servicios adquiridos y calcula el total adeudado ******/
function calcularMonto(){
            var suma=0;
            $('#totalServ').html("");
            $( ".dt_subtotal" ).each(function( index ) {
                console.log( index + ": " + $( this ).val() );
                suma=parseInt(suma) + parseInt($( this ).html());
            });
            $('#totalServ').html(suma);
            $('#totalservicios').val(suma);

            return suma;
        }


                     // Función para buscar un valor en la tabla
        function buscarValorEnTabla(valor) {

            var tabla = $(".detalle_servicios");
            var encontrado = false;
            var filaEncontrada;
            var posicionEncontrada;

            console.log("valor busqueda-------------->"+valor);

            // Recorrer todas las filas del tbody
            tabla.find('tbody tr').each(function(filaIndex) {
            var fila = $(this);
          //  console.log('this fila**************'+fila);

                    // Recorrer todas las celdas de la fila
                    fila.find('td').each(function(columnaIndex) {
                        var celda = $(this);
                        var contenidoCelda = celda.text();
                  //      console.log('this contenidoCelda**************'+contenidoCelda);

                        // Compara el contenido de la celda con el valor buscado
                        if (contenidoCelda === valor) {
                       // console.log(valor+'==========='+contenidoCelda);

                        encontrado = true;
                        filaEncontrada = fila;
                        posicionEncontrada = [filaIndex, columnaIndex];
                        // Si encuentras el valor, puedes detener los bucles
                        return false; // Esto sale del bucle de las celdas
                        }
                    });

                // Si ya se encontró el valor, sale del bucle de las filas
                if (encontrado) {
                    return false;
                }
            });

                    // Devuelve el resultado de la búsqueda
                    if (encontrado) {
                     //   console.log("fila----------------->"+fila);
                      //  console.log("posicion----------------->"+posicionEncontrada);

                    return {
                        fila: filaEncontrada,
                        posicion: posicionEncontrada
                    };
            } else {
            return null; // El valor no fue encontrado en la tabla
            }
        }

    /*************************************************************************************************************************/
    /****************************************************** function guardar pagos servicios**********************************/
    /************************************************************************************************************************/
                $(document).on('click', '#modal_save_pagos_cm', function(e)
                {
                    e.preventDefault();
                    var id= $('#id_cripta_mausoleo_modal_pay').val();
                    var codigo_unidad=$('#cod_cm').html();
                    var monto_total=$('#totalServ').html();
                    let servicios = [];
                    let tipo_servicio = [];
                    let tipo_servicio_txt = [];
                    let servicio_hijos = [];
                    let txt_servicio_hijos = [];
                    let precio = [];
                    let tblobs = [];

                    let sel_exhumado="";
                    let difuntos = [];

                       document.querySelectorAll('.detalle_servicios tbody tr').forEach(function(e)
                            {
                                 let fila = {
                                                dt_id_tipo_cuenta: e.querySelector('.dt_id_tipo_cuenta').innerText,
                                                dt_txt_tipo_cuenta: e.querySelector('.dt_txt_tipo_cuenta').innerText,
                                                dt_id_serv: e.querySelector('.dt_id_serv').innerText,
                                                dt_txt_serv: e.querySelector('.dt_txt_serv').innerText,
                                                dt_precio_unitario: e.querySelector('.dt_precio_unitario').innerText,
                                                tblobs: e.querySelector('.dt_obs').innerText
                                      };
                                 servicios.push(fila);

                                            let row_tipo_servicio = {
                                                dt_id_tipo_cuenta: e.querySelector('.dt_id_tipo_cuenta').innerText,
                                            };

                                            let row_tipo_servicio_txt = {
                                                dt_txt_tipo_cuenta: e.querySelector('.dt_txt_tipo_cuenta').innerText,
                                            };

                                            let row_servicio_hijos = {
                                                dt_id_serv: e.querySelector('.dt_id_serv').innerText,
                                            };

                                            let row_txt_servicio_hijos = {
                                                dt_txt_serv: e.querySelector('.dt_txt_serv').innerText,
                                            };

                                            let row_precio = {
                                                dt_precio_unitario: e.querySelector('.dt_precio_unitario').innerText,
                                            };
                                            let row_tblobs =e.querySelector('.dt_obs').innerText;
                                            tipo_servicio.push(row_tipo_servicio);
                                            tipo_servicio_txt.push(row_tipo_servicio_txt);
                                            servicio_hijos.push(row_servicio_hijos);
                                            txt_servicio_hijos.push(row_txt_servicio_hijos);
                                            tblobs.push(row_tblobs);


                        });

                        var long = 0; var nres = 0;
                         $('#tabla_difunto_row_pay  tr').each(function() {
                            long++;
                          })
                    if( long>0)
                     {
                                       document.querySelectorAll('.tabla_difunto_pay tbody tr').forEach(function(e){
                                            let fila = {
                                                condicion: e.querySelector('.data-condicion').innerText,
                                                ci: e.querySelector('.data-ci').innerText,
                                                nombres: e.querySelector('.data-nombre').innerText,
                                                primer_apellido: e.querySelector('.data-pat').innerText,
                                                segundo_apellido: e.querySelector('.data-mat').innerText,
                                                ceresi: e.querySelector('.data-ceresi').innerText,
                                                tipo: e.querySelector('.data-tipo').innerText,
                                                fecha_nacimiento: e.querySelector('.data-nac').innerText,
                                                ingreso: e.querySelector('.data-ingreso').innerText,
                                                fecha_defuncion: e.querySelector('.data-def').innerText,
                                                causa: e.querySelector('.data-causa').innerText,
                                                funeraria: e.querySelector('.data-fun').innerText,
                                                genero: e.querySelector('.data-genero').innerText,
                                                url: e.querySelector('.data-url').innerText,
                                            };
                                            difuntos.push(fila);
                                            console.log(difuntos);
                                    });


                    }

                                     $.ajax({
                                            type: 'POST',
                                            headers: {
                                                'Content-Type':'application/json',
                                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                            },
                                            url: '{{ route("guardar.servicio.cripta") }}',
                                            async: false,
                                            data: JSON.stringify({
                                                'id_cripta_mausoleo': id,
                                                'servicios': servicios,
                                                'tipo_servicio': tipo_servicio,
                                                'tipo_servicio_txt': tipo_servicio_txt,
                                                 'servicio_hijos':servicio_hijos,
                                                'txt_servicio_hijos': txt_servicio_hijos,
                                                'tblobs': tblobs,
                                                'total_monto': monto_total,
                                                'difuntos': difuntos,
                                                'codigo_unidad': codigo_unidad,
                                                'resp_id':$('#resp_cm_id').html(),
                                                'ci': $('#cm_ci').val(),
                                                'nombrepago': $('#cm_nombre_pago').val(),
                                                'paternopago': $('#cm_paternopago').val(),
                                                'maternopago': $('#cm_maternopago').val(),
                                               // 'observacion': $('#cm_observacion').val(),
                                                'pago_por' : $('#tipo_resp').val(),
                                                'ci_resp':$('#resp_cm_id').html(),
                                                'nombre_resp':$('#resp_cm').html(),
                                                'sel_exhumado':sel_exhumado,
                                                'tipo_registro': $('#tipo_registro').html(),
                                                'domicilio' : $('#cm_domicilio').val()? $('#cm_domicilio').val() : 'NO DEFINIDO',
                                                'cuartel_nuevo': $('#select_cuartel_nuevo').val(),
                                                'bloque_nuevo': $('#bloque_nuevo').val(),
                                                'nicho_nuevo': $('#nuevo_nicho').val(),
                                                'fila_nuevo': $('#nueva_fila').val(),
                                                'nueva_fecha_ingreso':$('#nueva_fecha_ingreso').val(),
                                                'asignar_difunto_nicho':$('#asignar_difunto_nicho').val(),

                                                'ci_dif':$('#dif_asignado').val(),
                                                'nombres_dif':$('#nombres_dif').val(),
                                                'paterno_dif':$('#paterno_difunto').val(),
                                                'materno_dif':$('#materno_difunto').val(),
                                                'genero_dif':$('#genero_difunto').val(),
                                                'sereci':$('#cereci_difunto').val(),
                                                'fechanac_dif':$('#nac_difunto').val(),
                                                'fecha_dif':$('#ingreso_difunto').val(),
                                                'fecha_def_dif':$('#defuncion_difunto').val(),
                                                'funeraria':$('#funeraria_difunto').val(),
                                                'causa':$('#causa_difunto').val(),
                                                'tipo_dif':$('#tipo_difunto').val(),
                                                'urlcertificacion':$('#urlcertificacion').val(),

                                            }),
                                            success: function(data)
                                            {
console.log("llega aquiii");
                                                console.log(data);
                                                if(data.status==true){
                                                    swal.fire({
                                                        title: "Exito!",
                                                        text:data.mensage,
                                                        type: "success",
                                                        timer: 2000,
                                                        showCancelButton: false,
                                                        showConfirmButton: false
                                                        });
                                                       // location.reload();
                                                        window.location.href = "/servicios/servicios"

                                                  }
                                                    else{
                                                        swal.fire({
                                                                title: "Precaución!",
                                                                text:data.mensage,
                                                                type: "error",
                                                                timer: 2000,
                                                                showCancelButton: false,
                                                                showConfirmButton: false
                                                                });
                                                                return false;
                                                    }


                                            },
                                            error :function( data )
                                            {
                                                if( data.status === 422 ) {
                                                    var msg="";
                                                    var errors = $.parseJSON(data.responseText);
                                                    $.each(errors, function (key, value) {
                                                        // console.log(key+ " " +value);
                                                    $('#response').addClass("alert alert-danger");

                                                        if($.isPlainObject(value)) {
                                                            $.each(value, function (key, value) {
                                                                console.log(key+ " " +value);
                                                                 msg=msg+value+", ";
                                                           // $('#response').show().append(value+"<br/>");

                                                            });
                                                            swal.fire({
                                                                title: "Precaución!",
                                                                text:msg,
                                                                type: "error",
                                                                timer: 10000,
                                                                showCancelButton: false,
                                                                showConfirmButton: true
                                                                });
                                                                return false;
                                                        }
                                                        /*else{
                                                        $('#response').show().append(value+"<br/>"); //this is my div with messages
                                                        }*/
                                                    });
                                                }
                                            }


                                          });
                });
/************************* fin pagos servicios **************************************/


/******************************************************************************************************/
/***********************seccion adjuntar documentos difitales ****************************************/
/****************************************************************************************************/

    $(document).ready(function ()
    {

            $("#foto_resolucion").dropzone({
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
                init: function()
                {
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
                                            $('#url_foto_resol').val('');
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
                            formData.append('collector', 'cementerio');
                            formData.append('nro_documento', $('#nro_ci').val());

                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_resol').val(response.response[0].url_file);
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

        //foto titulo de propiedad

            $("#foto_titulo").dropzone({
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
                init: function()
                {
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
                                          $('#url_foto_title').val('');

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
                            formData.append('collector', 'cementerio');
                            formData.append('nro_documento', $('#nro_ci').val());

                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_title').val(response.response[0].url_file);
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

            //foto ci

            $("#foto_ci_prop").dropzone({
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
                init: function()
                {
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
                                              $('#url_foto_prop').val('');

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
                            formData.append('collector', 'cementerio ci adjudicatario');
                            formData.append('nro_documento', $('#nro_ci').val());

                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_prop').val(response.response[0].url_file);
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


            //planos aprobados

            $("#foto_planos").dropzone({
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
                init: function()
                {
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
                                          $('#url_foto_planos_ap').val('');

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
                            formData.append('collector', 'cementerio planos aprobados');
                            formData.append('nro_documento', $('#nro_ci').val());


                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_planos_ap').val(response.response[0].url_file);
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




                function openFile(file)
                {
                        var extension = file.substr( (file.lastIndexOf('.') +1) );
                        switch(extension) {
                            case 'jpg':
                            case 'png':
                                return 'image';  // There's was a typo in the example where
                            break;                         // the alert ended with pdf instead of gif.
                            case 'zip':
                            case 'rar':
                                alert('was zip rar');
                            break;
                            case 'pdf':
                                return 'pdf';
                            break;
                            default:
                            return 'desconocido';
                        }
                }
    });


/*********** fin adjuntar documentos digitales ************************/

/**************************************************************************/
/*****metodos de busqueda y recuperacion de responsables y difuntos********/
/*************************************************************************/
  /// recuperar difunto en modal difunto


            $(document).on('click', '#buscarDif', function(e)
              {
                e.preventDefault();
                            var ci = $('#mdci').val();


                            if (ci.length < 1) {

                                Swal.fire(
                                    'Busqueda finalizada!',
                                    'El campo C.I. esta vacio .',
                                    'warning'
                                )

                            } else {
                                var type = "deceased";
                                dats = buscar_ci_Dif(ci, type);

                            }
            });


            $(document).on('click', '#upbuscarResp', function(e)
            {
                e.preventDefault();
                            var ci = $('#upci').val();


                            if (ci.length < 1) {

                                Swal.fire(
                                    'Busqueda finalizada!',
                                    'El campo C.I. esta vacio .',
                                    'warning'
                                )

                            } else {
                                var type = "responsable";
                                dats = buscar_ci_Resp(ci, type);

                            }
            });

            //buscar info responsable
            function buscar_ci_Resp(ci, type) {
                var datos = "";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('search.difunto.responsable') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "ci": ci,
                        "type": type
                    }),
                    success: function(data) {
                        if (data.response == null) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                            )
                        } else
                        {
                            console.log(data);
                            $('#upprimer_apellido').val(data.response.primer_apellido);
                            $('#upsegundo_apellido').val(data.response.segundo_apellido);
                            $('#upnombre').val(data.response.nombres);
                        }

                    },
                    error: function(xhr, status) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El registro no ha  sido encontrado o no existe .',
                            'error'
                        )
                    },
                });
                // return datos;
            }



            function buscar_ci_Dif(ci, type) {
                var datos = "";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('search.difunto.responsable') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "ci": ci,
                        "type": type
                    }),
                    success: function(data) {
                        if (data.response == null) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                            )
                        } else
                        {
                            console.log(data);
                            $('#mdprimer_apellido').val(data.response.primer_apellido);
                            $('#mdsegundo_apellido').val(data.response.segundo_apellido);
                            $('#mdfecha_nacimiento').val(data.response.fecha_nacimiento);
                            $('#mdtipo').val(data.response.tipo);
                            $('#mdci').val(data.response.ci);
                            $('#mdnombre').val(data.response.nombres);
                            $('#mdcertificado_defuncion').val(data.response.certificado_defuncion);
                            $('#mdfecha_defuncion').val(data.response.fecha_defuncion);

                            $('#causa').val(data.response.causa).trigger('change');
                            $('#funeraria').val(data.response.funeraria).trigger('change');
                            $('#mdgenero').val(data.response.genero);

                            if(data.response.certificado_file != null){
                               $('#mdurl-certification').val(data.response.certificado_file);
                                var enlace='<a href="'+data.response.certificado_file+'" id="enl" target="_black">Archivo adjunto</a><br>'+
                                            '<img src="'+data.response.certificado_file+'" width="150px" height="150px">';
                                $('#adjunto').append(enlace);
                            }
                        }

                    },
                    error: function(xhr, status) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El registro no ha  sido encontrado o no existe .',
                            'error'
                        )
                    },
                });
                // return datos;
            }

            function seleccionar_difunto(){
                //dif_exhumacion
                var dif=JSON.parse($('#difuntos_cm1').html());

                $('#contenedor_dif_serv').empty();
                $('#contenedor_dif_serv').show();



                     var tbl_dif='<table class="table data exhum_tbldif">'
                                +'<h4> SELECCIONE EL REGISTRO DEL DIFUNTO PARA EL QUE SOLICITA EL SERVICIO</h4>'
                                // +'  <button type="button" class="btn btn-success add_dif_row" id="add_dif_row" >AGREGAR FILA</button> '
                                + '<thead>'
                                   +'<tr>'
                                    +'<td>Seleccionar</td>'
                                    +'<th> C.I./NRO IDENTIFICACION </th>'
                                    +'<th> NOMBRES </th>'
                                    +'<th> PATERNO </th>'
                                    +'<th> MATERNO </th>'
                                    +'<th> GENERO </th>'
                                    +'<th> CERESI </th>'
                                    +'<th> FECHA NACIMIENTO </th>'
                                    +'<th> FECHA INGRESO </th>'
                                    +'<th> FECHA DEFUNCION </th>'
                                    +'<th> FUNERARIA</th>'
                                    +'<th> CAUSA</th>'
                                    +'<th> TIPO</th>'

                                    +'</tr>'
                                + '</thead>'
                                + '<tbody>'
                                + '</tbody>'
                                + '</table>';
                                $('#contenedor_dif_serv').append(tbl_dif);


                                $.each(dif, function(index, value) {

                                    var row=    ' <tr>'
                                            +     '<td class="data-chk"><input type="checkbox" name="exhum_checkbox" class="exhumado_dif" value=""> </td>'
                                            +     '<td class="data-ci">'+value.ci+ ' </td>'
                                            +     '<td class="data-nombre">'+value.nombres+ '</td>'
                                            +     '<td class="data-pat">'+value.primer_apellido+ '</td>'
                                            +     '<td class="data-mat">'+value.segundo_apellido+ '</td>'
                                            +     '<td class="data-genero">'+value.genero+ '</td>'
                                            +     '<td class="data-ceresi">'+value.ceresi+ '</td>'
                                            +     '<td class="data-nac">'+value.fecha_nacimiento+ '</td>'
                                            +     '<td class="data-ingreso">'+value.fecha_ingreso+ '</td>'
                                         //   +     '<td class="data-edad">'+calcularEdad(value.fecha_nacimiento)+'</td>'
                                            +     '<td class="data-def">'+value.fecha_defuncion+ '</td>'
                                            +     '<td class="data-fun">'+value.funeraria+ '</td>'
                                            +     '<td class="data-causa">'+value.causa+ '</td>'
                                            +     '<td class="data-tipo">'+value.tipo+ '</td>'
                                            +     '</tr>';
                                      $('.exhum_tbldif tbody').append(row);
                                })


            }

            $(document).on('click', '.exhumado_dif', function(){
                $('.exhumado_dif').each(function( index ) {
                      console.log( index + ": " + $( this ).text() );

                      if($(this).is(":checked"))
                       {
                             const row = this.closest('tr');
                             const dataCi = row.querySelector('.data-ci').textContent;
                             const nombre_difunto = row.querySelector('.data-nombre').textContent;
                             const paterno_difunto = row.querySelector('.data-pat').textContent;
                             const materno_difunto = row.querySelector('.data-mat').textContent;
                             const genero_difunto = row.querySelector('.data-genero').textContent;
                             const cereci_difunto = row.querySelector('.data-ceresi').textContent;
                             const nac_difunto = row.querySelector('.data-nac').textContent;
                             const ingreso_difunto = row.querySelector('.data-ingreso').textContent;
                             const defuncion_difunto = row.querySelector('.data-def').textContent;
                             const funeraria_difunto = row.querySelector('.data-fun').textContent;
                             const causa_difunto = row.querySelector('.data-causa').textContent;
                             const tipo_difunto = row.querySelector('.data-tipo').textContent;

                            console.log('Valor de data-ci:', dataCi);
                            $('#dif_asignado').val(dataCi);
                            $('#nombres_dif').val(nombre_difunto);
                            $('#paterno_difunto').val(paterno_difunto);
                            $('#materno_difunto').val(materno_difunto);
                            $('#genero_difunto').val(genero_difunto);
                            $('#cereci_difunto').val(cereci_difunto);
                            $('#nac_difunto').val(nac_difunto);
                            $('#ingreso_difunto').val(ingreso_difunto);
                            $('#defuncion_difunto').val(defuncion_difunto);
                            $('#funeraria_difunto').val(funeraria_difunto);
                            $('#causa_difunto').val(causa_difunto);
                            $('#tipo_difunto').val(tipo_difunto);


                            $('#exhumacion_txt').val('SI');
                            $('#cond'+index+'').html("exhumado");
                            $('#modal_save_pagos_cm').prop('disabled', false);
                        }else{
                            $(this).prop('disabled', true);
                            $('#exhumacion_txt').val('NO');
                            $('#cond'+index+'').html("ninguno");
                            $('#modal_save_pagos_cm').prop('disabled', false);

                        }
                });

            });
                function addDragHandlers(elem) {
                    elem.draggable = true;

                    elem.addEventListener('dragstart', handleDragStart, false);
                    elem.addEventListener('dragover', handleDragOver, false);
                    elem.addEventListener('drop', handleDrop, false);
                }

                function handleDragStart(event) {
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/html', this.outerHTML);
                    dragSrcElement = this;
                }

                function handleDragOver(event) {
                    event.preventDefault();
                    event.dataTransfer.dropEffect = 'move';
                }

                function handleDrop(event) {
                    event.preventDefault();
                    if (dragSrcElement !== this) {
                        this.parentNode.removeChild(dragSrcElement);
                        this.insertAdjacentElement('beforebegin', dragSrcElement);
                    }
                }



                $(document).on('change', '#tipo_resp', function(e){
                    e.preventDefault();
                    if($('#tipo_resp').val()=='Titular_responsable'){
                            $('#cm_ci').val($('#resp_cm_ci').val());
                            $('#cm_nombre_pago').val($('#resp_cm_nombre').val());
                            $('#cm_paternopago').val($('#resp_cm_paterno').val());
                            $('#cm_maternopago').val($('#resp_cm_materno').val());
                    }
                    else if($('#tipo_resp').val()=='Tercero_responsable'){
                        $('#cm_ci').val("");
                        $('#cm_nombre_pago').val("");
                        $('#cm_paternopago').val("");
                        $('#cm_maternopago').val("");
                    }
                })

                $(document).on('click', '#asignar_difunto_nicho',function(){
                    if ($('#asignar_difunto_nicho').is(":checked")){
                        $('#asignar_difunto_nicho').val('asignado');
                        $('.asignar_df').show();
                        }
                    else{
                        $('.asignar_df').hide();
                        $('#asignar_difunto_nicho').val('');
                    }
                    });

                    $("#bloque_nuevo").select2({
                        selectOnClose: true
                    });



              $(document).on('change', '.select_cuartel_nuevo', function(){
                    $('#bloque_nuevo').empty();
                    var sel_cuartel=$('.select_cuartel_nuevo').val();
                    $('#bloque_nuevo').prop('disabled', false);
                    $.ajax({
                                type: 'POST',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url: "{{ route('bloqueid.get') }}",
                                async: false,
                                data: JSON.stringify({
                                    'cuartel': $('#select_cuartel_nuevo').val(),
                                }),
                                success: function(data_bloque) {
                                var op1='<option value="" >SELECCIONAR</option>';
                                    $('#bloque_nuevo').append(op1);
                                $.each( data_bloque.response, function( key, value ) {
                                        opt2='<option value="'+ value.id +'">'+value.codigo +'</option>';
                                        $('#bloque_nuevo').append(opt2);
                                    });
                                }
                             });
                });

    </script>
    @stop

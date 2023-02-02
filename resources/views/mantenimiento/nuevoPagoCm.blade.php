@extends('adminlte::page')
@section('title', 'Criptas')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)
@section('plugins.dropzone', true)


<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

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

       <table id="cripta-data" class="table table-striped table-bordered responsive" role="grid"
    aria-describedby="example">
    <thead class="bg-table-header">
            <tr role="row">
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Código</th>
                <th scope="col">Cuartel</th>
                <th scope="col">Bloque</th>
                <th scope="col">Sitio</th>
                <th scope="col">Familia</th>
                <th scope="col">Propietario</th>
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
                                echo "<psan>resolucion nro. " .$v['resolucion']. " ,  ".$v['bienes_m']. ", ci del propietario ".$v['ci'] ?? ''. ", ".$v['planos_aprobados']."  </span><br>";
                                    if(isset($v['foto_resolucion'])){if($v['foto_resolucion']!=null ){echo "<span>|<a href='" .$v['foto_resolucion']. "'> Resolución </a>|</span>"; }}
                                    if(isset($v['foto_titulo'])){if($v['foto_titulo']!=null ){echo "<span>|<a href='" .$v['foto_titulo']. "'> Titulo de propiedad </a>|</span>"; }}
                                    if(isset($v['foto_prop_ci'])){if($v['foto_prop_ci']!=null ){echo "<span>|<a href='" .$v['foto_prop_ci']. "'> ci propietario </a>|</span>"; }}
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

                        <button type="button" class="btn btn-warning" value="{{ $cripta->id }}" id="btn_pay_cm_mant" title="Pagar Mantenimiento"><i class="fa fa-wrench"></i></button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>





   @include('mantenimiento/modal_pagocm_servicios')




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
      $(document).on('click', '#gestiones_adeudadas', function(e){
        var ultpago=$('#ultima_gestion_pagada').val();
        if(ultpago==0){
            swal.fire({
                        title: "Precaución!",
                        text: "Debe ingresar la ultima gestion pagada ejm. 2022 !",
                        type: "warning",
                        showCancelButton: false,
                        showConfirmButton: true
                    });

                    setTimeout(function() {
                        return false;
                    }, 2000);

        }
        else{
               if ($(this).is(':checked')) {
                      gestionesAdeudadas(ultpago);
                }
                else{
                    $('#row-cuota').empty();
                    $('#conservacion').hide();

                }
            }
      });



            // calcular nro de gestiones adeudadas
            function gestionesAdeudadas(ultpago) {
                $('#conservacion').show();

                $('#row-cuota').empty();
                var fecha = new Date();
                var year = fecha.getFullYear();
                var gest = year - ultpago;

                if (gest > 0) {
                    drawBox(gest, ultpago);
                } else {
                    $('#infoPlazo').html('El nicho no tiene deudas pendientes');
                    swal.fire({
                        title: "Notificación!",
                        text: "El nicho no tiene deudas pendientes!",
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: true
                    });

                    setTimeout(function() {
                        return false;
                    }, 2000);
                }
            }

            function drawBox(gest, anio) {
                var html = "";

                for (var i = 1; i < gest; i++) {
                    var c = parseInt(anio) + parseInt(i);

                    if (i == 1) {
                        html = '<tr>' +
                            '<td scope="row" >' + i + '</td> ' +
                            '<td>' + c + '</td> ' +
                            '<td>' + $('#precio_unitario').html() + '</td> ' +
                            '<td> <input type="checkbox" style="width:30px;  height: 30px;" name="sel[]" class="sel"  id="' +
                            c + '" value="' + c + '"></td> ' +
                            '</tr>';
                        $('#row-cuota').append(html);
                    } else {
                        html = '<tr>' +
                            '<td scope="row" >' + i + '</td> ' +
                            '<td>' + c + '</td> ' +
                            '<td>' +  $('#precio_unitario').html()  + '</td> ' +
                            '<td> <input type="checkbox" style="width:30px;  height: 30px;" name="sel[]" class="sel" value="' +
                            c + '"  id="' + c + '" disabled></td> ' +
                            '</tr>';
                        $('#row-cuota').append(html);
                    }

                }
            }

              // calcular total a pagar

              function calcular_monto(){
                var sum = 0;
                var cant = 0;
                var gestiones_acum =[];
                var ult_pago=$('#ultima_gestion_pagada').val();
                $('.sel').each(function(index) {
                    current = $(this).val();
                    if ($(this).is(':checked')) {
                      sum = parseFloat(sum) + parseFloat($('#precio_unitario').html());
                      cant=cant+1;
                      gestion=parseInt(ult_pago)+parseInt(index)+parseInt(1);
                      gestiones_acum=gestiones_acum + gestion+",";
                      $('#gestiones_pagadas').val(current);


                    }
                });
                $('#cantidad_ges').val(cant);
                $('#gestiones_act').val(gestiones_acum);

                return sum;
              }

              function bloquear_casillas(){
                $('.sel').each(function(index) {
                    if(index==0){

                    }else{
                        $(this).prop('disabled', true);
                    }

                });
              }
              $(document).on('click', '.sel', function() {
                var sum = 0;
                var prev = 0;
                var next = 0;
                var current = 0;
                var band=0;
                let cpago = [];
                $('.sel').each(function(index) {
                    current = $(this).val();
                    next = parseInt(current) + parseInt(1);
                    if ($(this).is(':checked')) {
                       /* sum = parseFloat(sum) + parseFloat($('#precio_unitario').html());
                        */

                        cpago.push($(this).val());

                        $('#' + next + '').prop('disabled', false);
                    } else {
                     revisarCheck($(this).val());
                    }

                });

                sum= calcular_monto();

                    $('#totalServ').html(sum);
                    $('#totalservicios').val(sum);

                console.log(cpago)

            });

            // validacion seccion consecutiva
            function revisarCheck(valor) {
                var next = parseInt(valor) + parseInt(1);
                if ($('#' + next + '').is(':checked')) {
                    bloquear_casillas();

                    swal.fire({
                        title: "Precaucion!",
                        text: "!El pago de las cuotas debe ser consecutivo!",
                        type: "warning",
                        //  timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: true
                    });


                       $('#totalServ').html('0');
                       $('#totalservicios').val('0');
                       $(".sel").prop("checked", false);


                    setTimeout(function() {
                        return false;
                    }, 2000);
                    // $('#' + valor + '').prop('checked', true);

                }else{
                    return true;
                }
            }

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
                                        $('#resp_cm_info').html(data.response.responsable.nombres+" "+data.response.responsable.primer_apellido+" "+data.response.responsable.segundo_apellido);
                                        $('#respdifunto_id_cm_info').html(data.response.responsable.id);
                                        $('#ultima_gestion_pagada').val(data.response.cripta.ultima_gestion_pagada);


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
                        text: "!Debe definir si el pago se hizo por tercera persona o por el propietario!",
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
                            'estado': $('#estado').val() ,
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
                            console.log(data_query['response']);
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
                                    $('#foto_resol').append('<a href="'+ ar.foto_resolucion+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_resol').append('<img src="'+ ar.foto_resolucion+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_resol').empty();
                                            $('#foto_resol').hide();
                                    }
                                 //titulo de propiedad
                                 if(ar.foto_titulo!=null){
                                    $('#url_foto_title').val(ar.foto_titulo)  ;
                                    $('#foto_title').append('<a href="'+ ar.foto_titulo+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_title').append('<img src="'+ ar.foto_titulo+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_title').empty();
                                            $('#foto_title').hide();
                                    }

                                // ci propietario
                                 if(ar.foto_prop_ci!=null){
                                    $('#url_foto_prop').val(ar.foto_prop_ci)  ;
                                    $('#foto_prop').append('<a href="'+ ar.foto_prop_ci+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_prop').append('<img src="'+ ar.foto_prop_ci+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_prop').empty();
                                            $('#foto_prop').hide();
                                    }

                                //planos aprobados
                                if(ar.foto_planos!=null){
                                    $('#url_foto_planos_ap').val(ar.foto_planos)  ;
                                    $('#foto_planos_ap').append('<a href="'+ ar.foto_planos+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_planos_ap').append('<img src="'+ ar.foto_planos+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_planos_ap').empty();
                                            $('#foto_planos_ap').hide();
                                    }
                            }
                        }
                            if(data_response.foto!=null){
                               $('#url-foto').val(data_response.foto)  ;
                               $('#foto_actual').append('<a href="'+ data_response.foto+'" target="_blank">Ver foto actual </a>');
                               $('#foto_actual').append('<img src="'+ data_response.foto+'" widh="100px" heigth="100"');


                            }else{
                                    $('#foto_actual').empty();
                                    $('#foto_actual').hide();
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
                $('#txt_resolucion').prop('checked', false);

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
                    formData.append('collector', 'cementerio cripta-mausoleo');

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


    $("#foto-edit").dropzone({
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
                    formData.append('collector', 'cementerio cripta-mausoleo');

                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#url-foto-edit').val(response.response[0].url_file);

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
                    dropdownParent: $('#modal_pay_cmant'),
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
                    dropdownParent: $('#modal_pay_cmant'),
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
                                            'nombres': $('#mdnombre').val(),
                                            'primer_apellido': $('#mdprimer_apellido').val(),
                                            'segundo_apellido': $('#mdsegundo_apellido').val(),
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
                                            { console.log("entraaaa");
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
                                                                            text: "!Ocurrio un error, intente nuevamente!",
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

         $(document).on('click', '#btn_pay_cm_mant', function()
         {
            $('.clear').val("");
            $('#modal_pay_cmant').modal('show');
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
                            if(data.status==true )
                            {
                               // alert(data.response.responsable);
                                if(data.response.responsable !=null)
                                {
                                        $('#cod_cm').html(data.response.cripta.codigo);
                                        $('#resp_cm').html(data.response.responsable.nombres+" "+data.response.responsable.primer_apellido+" "+data.response.responsable.segundo_apellido);
                                        $('#resp_cm_id').html(data.response.responsable.id);
                                        $('#familia').html(data.response.cripta.familia);
                                        $('#tipo_registro').html(data.response.cripta.tipo_registro);
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
                                            url: "{{ route('get.services.mant') }}",
                                            method: 'GET',
                                            dataType: 'json',
                                            data: JSON.stringify({
                                                            }),
                                            success: function(data) {
                                                console.log("gggggggggggg");
                                             console.log(data.response[0]);
                                                $.each(data.response, function(key,val)
                                                {
                                                           console.log(val.descripcion );
                                                    // alert($('#tabla_difunto_row_pay').children().length);


                                                            var html='<div class="form-check '+val.cuenta+'">'+
                                                                '<h3>Pago de mantenimieto de criptas/nichos</h3>'+
                                                                        '<p><span id="num_sec" style="display:none"> '+val.num_sec+' </span><span id="cuenta"> '+val.cuenta+' </span> <span id="descripcion">  '+val.descripcion+'</span>  Precio <span id="precio_unitario"> '+val.monto1+'</span></p>'+
                                                                        '</div>';
                                                                        $('#contenedor_servicios').append(html);


                                                                        if(val.cuenta=='15224200' || val.cuenta=="15224250"){
                                                                          //  var html1='<p class="dif_exhumacion" style="display:none"> </p>';
                                                                           // $('.15224200').append(html1);
                                                                            $('#contenedor_dif_serv').show();
                                                                            $('#modal_save_pagos_cm').prop('disabled', true)
                                                                        }else
                                                                        {
                                                                            $('#modal_save_pagos_cm').prop('disabled', false)

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
                                    $.each(data_response.response, function(index, value) {
                                        //alert(value.num_sec)
                                        if (value.num_sec == '526' || value.num_sec == '525' ||
                                            value.num_sec == '629' || value.num_sec == '631') {}
                                                else {
                                                    // console.log("asdas");
                                                    var html='<div class="form-check">'+
                                                    '<input class="form-check-input service_child" type="checkbox" id="'+value.num_sec+'" name="serv[servicio]" value="'+ txt_cuenta +' => '+value.num_sec+' - '+ value.descripcion + ' - ' + value.monto1 +'- Bs." onclick="seleccionar_hijos_list()" >'+
                                                    '<label class="form-check-label childservice" for="'+value.num_sec+'">'+value.descripcion+' - ' + value.monto1 +'- Bs.</label>'+
                                                    '</div>';
                                                    $('#serv_hijos'+cuenta+'').append(html);
                                                    }

                                    });
                                }
                            });
            }else{
                $('#serv_hijos'+cuenta+'').empty();
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

            $('#servicios-data').empty();
            $('.service_child').each(function( index ) {
                // alert($(this).val());
                        if($(this).is(":checked"))
                        {   var info= ($(this).val()).split('=>');
                            //  alert(info);

                            id_serv= $.trim(((info[1]).split('-'))[0]);

                            if(index==0){
                                tipo_serv =$.trim(((info[0]).split('-'))[0]);
                                tipo_serv_txt=((info[0]).split('-'))[1];
                                serv= $.trim(((info[1]).split('-'))[0]);
                                serv_txt=((info[1]).split('-'))[1];

                                if(( id_serv =='623' || id_serv =='622' || id_serv =='636' )&& $('#inhumacion').val()=="NO"){

                                    $('.section_difunto').show();
                                    $('#modal_save_pagos_cm').prop('disabled', true);
                                }
                                else if(( id_serv =='623' || id_serv =='622' || id_serv =='636')&& $('#inhumacion').val()=="SI"){
                                    $('.section_difunto').hide();
                                }
                                else if(( id_serv =='630' || id_serv =='628' || id_serv =='633' || id_serv =='634' || id_serv =='635')&& $('#exhumacion_txt').val()=="NO"){
                                   $('#dif_exhumado').show();
                                    seleccionar_difunto();
                                }
                                else if(( id_serv =='630' || id_serv =='628' || id_serv =='633' || id_serv =='634' || id_serv =='635')&& $('#exhumacion').val()=="SI"){
                                    $('#dif_exhumado').hide();
                                }
                                else{  $('.section_difunto').hide();
                                $('#modal_save_pagos_cm').prop('disabled', false);
                            }
                            }else{
                                var info= ($(this).val()).split('=>');
                                id_serv= $.trim(((info[1]).split('-'))[0]);
                                tipo_serv=tipo_serv+", "+ $.trim(((info[0]).split('-'))[0]);
                                tipo_serv_txt=tipo_serv_txt+", "+ $.trim(((info[0]).split('-'))[1]);
                                serv=serv+", "+ $.trim(((info[1]).split('-'))[0]);
                                serv_txt=serv_txt+", "+ $.trim(((info[1]).split('-'))[1]);

                                if(( id_serv =='623' || id_serv =='622' || id_serv =='636')&& $('#inhumacion').val()=="NO"){
                                     $('.section_difunto').show();
                                    $('#modal_save_pagos_cm').prop('disabled', true);
                                     return false;
                                }
                                else if(( id_serv =='623' || id_serv =='622' || id_serv =='636')&& $('#inhumacion').val()=="SI"){
                                    $('.section_difunto').hide();
                                }
                                else if(( id_serv =='630' || id_serv =='628'  || id_serv =='633' || id_serv =='634' || id_serv =='635')&& $('#exhumacion_txt').val()=="NO"){
                                   $('#dif_exhumado').show();
                                    seleccionar_difunto();
                                }
                                else if(( id_serv =='630' || id_serv =='628' || id_serv =='633' || id_serv =='634' || id_serv =='635')&& $('#exhumacion_txt').val()=="SI"){
                                    //$('#dif_exhumado').hide();
                                }
                                else{  $('.section_difunto').hide();
                                $('#modal_save_pagos_cm').prop('disabled', false);

                                   }
                            }


                        }else {
                                var info= ($(this).val()).split('=>');
                                id_serv= $.trim(((info[1]).split('-'))[0]);
                                $('.section_difunto').hide();
                                $('#modal_save_pagos_cm').prop('disabled', false);


                        }
                calcularPrice();

            });
        }
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
                                                edad: document.getElementById('mdpsegundo_apellido').value,
                                                fecha_defuncion:  document.getElementById('mdpfecha_defuncion').value,
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
                                            +     '<td id="edad'+key+'" class="data-edad">'+dif_in.edad+ '</td>'
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
                 calcularPrice();
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
                                    +'<th> FECHA DEFUNCION </th>'
                                    // +'<th> FUNERARIA</th>'
                                    // +'<th> CAUSA</th>'
                                    // +'<th> TIPO</th>'

                                    +'</tr>'
                                + '</thead>'
                                + '<tbody>'
                                + '</tbody>'
                                + '</table>';
                                $('#difuntos-data').append(tbl_dif);

                                $.each(dif, function(index, value) {
                                   // console.log('++++++++++++++++++');
                                   // console.log(value.ci);
                                    var row=    ' <tr>'
                                            +     '<td class="data-ci">'+value.ci+ '</td>'
                                            +     '<td class="data-nombre">'+value.nombres+ '</td>'
                                            +     '<td class="data-pat">'+value.primer_apellido+ '</td>'
                                            +     '<td class="data-mat">'+value.segundo_apellido+ '</td>'
                                            +     '<td class="data-genero">'+value.genero+ '</td>'
                                            +     '<td class="data-ceresi">'+value.ceresi+ '</td>'
                                            +     '<td class="data-nac">'+value.fecha_nacimiento+ '</td>'
                                            +     '<td class="data-edad">'+calcularEdad(value.fecha_nacimiento)+'</td>'
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
                                              //   alert( "----"+data);
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
                function calcularPrice()
                    {
                        var acum = 0;
                        $('#totalServ').html(0);
                        $('#servicios-data').empty();
                        $('.service_child').each(function(index, value) {
                            if($(this).is(":checked")){
                                var cad=($(this).val()).split("-");
                                var cod_serv=(cad[1]).split("=>");

                                //console.log("caddd");
                                //console.log(cad);
                                $('.detalle_servicios').show();
                                $('#servicios-data').append('<tr><td class="dt_id_tipo_cuenta">'+cad[0]+'</td><td class="dt_txt_tipo_cuenta">'+cod_serv[0]+'</td><td class="dt_id_serv">'+cod_serv[1]+'</td><td class="dt_txt_serv">'+cad[2]+'</td><td class="dt_precio_unitario">'+cad[3]+' Bs.</p>');
                                 acum = parseFloat(acum) + parseFloat(cad[3]);
                                 $('#totalServ').html(acum);
                              //  console.log("///------//");
                                console.log(acum);
                                //console.log("///------//");

                           }

                        });
                        // $('#totalServ').html(acum);
                        // $('#totalservicios').val(acum)

                        // monto=((info[1]).split('-'))[2];
                        // $('#servicios-data').append('<p>'+((info[1]).split('-'))[1]+' ..................'+monto+'</p>');
                        // acum=parseFloat(acum)+parseFloat(monto);
                        // $('#totalServ').html(acum);
                    }


                // function guardar pagos servicios
                $(document).on('click', '#modal_save_pagos_cm', function(e)
                {
                    e.preventDefault();
                    var id= $('#id_cripta_mausoleo_modal_pay').val();
                    var codigo_unidad=$('#cod_cm').html();
                    var monto_total=$('#totalServ').html();
                    var cantidad=$('#cantidad_ges').val();
                    var gestiones_act=$('#gestiones_act').val();
                    var ultima_gestion_actual=$('#gestiones_pagadas').val();
                    var cuenta=$('#cuenta').html();
                    var descripcion=$('#descripcion').html();

                                     $.ajax({
                                            type: 'POST',
                                            headers: {
                                                'Content-Type':'application/json',
                                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                            },
                                            url: '{{ route("pay.mant.cm") }}',
                                            async: false,
                                            data: JSON.stringify({
                                                'id_cripta_mausoleo': id,
                                                'cuenta': cuenta,
                                                'descripcion': descripcion,
                                                'ultima_gestion_actual': ultima_gestion_actual,
                                                 'gestiones_act':gestiones_act,
                                                 'cantidad':cantidad,
                                                'total_monto': monto_total,
                                                'codigo_unidad': codigo_unidad,
                                                'resp_id':$('#resp_cm_id').html(),
                                                'familia':$('#familia').html(),
                                                'ci': $('#cm_ci').val(),
                                                'nombrepago': $('#cm_nombre_pago').val(),
                                                'paternopago': $('#cm_paternopago').val(),
                                                'maternopago': $('#cm_maternopago').val(),
                                                'observacion': $('#cm_observacion').val(),
                                                'person': $('#tipo_resp').val(),
                                                'pago_por' : $('#tipo_resp').val(),
                                                'domicilio' : $('#cm_domicilio').val(),
                                                'tipo_registro':$('#tipo_registro').html(),
                                                'precio_sinot':$('#precio_unitario').html(),
                                                'num_sec':$('#num_sec').html(),


                                            }),
                                            success: function(data)
                                            {
                                               // console.log("r5espuesta de servicios");
                                               // console.log(data);
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
                                                        window.location.href = "/mantenimiento/mantenimiento"

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
                                            error :function( data ) {
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
                            formData.append('collector', 'cementerio resolucion-testimonio');
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
                            formData.append('collector', 'cementerio titulo de propiedad');
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
                            formData.append('collector', 'cementerio ci propietario');
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





    </script>
    @stop

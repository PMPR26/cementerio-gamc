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
    </style>

@section('content')

<div class="card">
    <div class="card-body">

    <div class="row">
        <div class="col-sm-6">
        <button id="new-cripta" type="button" class="btn btn-info col-sm-12" > <i class="fas fa-plus-circle text-white fa-2x"></i> Nueva Cripta</button>
        </div>
        </div>


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

                <th scope="col">Propietario</th>
                <th scope="col">Superficie</th>
                <th scope="col">Enterratorio Ocupados</th>
                <th scope="col">Total Enterratorio</th>
                <th scope="col">Osarios Ocupados</th>
                <th scope="col">Total Osarios</th>
                <th scope="col">Cenisario</th>
                <th scope="col">Ultima Gestion Pagada</th>
                <th scope="col">Difuntos</th>

                <th scope="col">Documentos Recibidos</th>
                <th scope="col">Estado</th>
                <th scope="col">Operaciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
            @foreach ($cripta as $cripta)

                <tr>
                    <td scope="row">{{ $count++ }}</td>
                    <td>{{ $cripta->tipo_registro }}</td>
                    <td>{{ $cripta->codigo }}</td>
                    <td>{{ $cripta->cuartel_codigo }}</td>
                    <td>{{ $cripta->bloque_nombre ?? '' }}</td>
                    <td>{{ $cripta->sitio }}</td>

                    <td>{{ $cripta->nombre }}</td>
                    <td>{{ $cripta->superficie }}</td>
                    <td>{{ $cripta->enterratorios_ocupados }}</td>
                    <td>{{ $cripta->total_enterratorios }}</td>
                    <td>{{ $cripta->osarios }}</td>
                    <td>{{ $cripta->total_osarios }}</td>
                    <td>{{ $cripta->cenisarios }}</td>
                    <td>{{ $cripta->ultima_gestion_pagada }}</td>
                    <td><?php
                            if($cripta->difuntos !=null || !empty($cripta->difuntos)){
                                foreach (json_decode($cripta->difuntos) as $key => $value) {
                                    echo "<psan> " .$value->ci. " ".$value->nombres. " ".$value->primer_apellido ?? ''. "  </span>";
                                }

                            }
                    ?>
                       </td>
                    <td>
                      {{ $cripta->documentos_recibidos }}
                    </td>

                    <td>{{ $cripta->estado }}</td>

                    <td>
                        <button type="button" class="btn btn-info" value="{{ $cripta->id }}" id="btn-editar" title="Editar cuartel"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-warning" value="{{ $cripta->id }}" id="btn_add_difunto" title="Adicionar Difunto"><i class="fa fa-user-plus"></i></button>
                        {{-- <button type="button" class="btn btn-danger" value="{{ $cripta->id }}" id="btn_up_pay_cm" title="Actualizar pagos servicios"><i class="fa fa-refresh"></i></button>
                        <button type="button" class="btn btn-success" value="{{ $cripta->id }}" id="btn_pay_cm" title="Pagar servicios"><i class="fa fa-money"></i></button> --}}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


      <!-- Modal crear -->
<div class="modal fade  animated bounceIn" id="modal-cripta" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Criptas - Mausoleos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" id="cmform">
                <div class="row">
                    <div class="col-12">
                        <label>tipo de registro:</label> <span class="obligatorio">*</span>
                        <select  id="tipo_reg" class="form-control" required>
                            <option value="0">SELECCIONAR</option>
                            <option value="CRIPTA">CRIPTA</option>
                            <option value="MAUSOLEO">MAUSOLEO</option>
                        </select>
                    </div>
                    <input type="hidden" name="letra" id="letra" required>
                </div>
        <div id="section_data" style="display: none">
                    <br>
                    <h6 class="section_divider card text-white bg-info mb-3 p-4">
                        DATOS DEL MAUSOLEO O CRIPTA
                    </h6>
                    <br>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <label>Familia</label><span class="obligatorio">*</span>
                            <input id="familia" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-12 col-md-3 col-xl-3" id="box_tipo_cripta" style="display: none">
                            <label>Tipo de Cripta</label><span class="obligatorio">*</span>
                            <select  class="form-control select_tipo_cripta" id="tipo_cripta" style="width: 100%" required>
                                <option selected disabled>Seleccionar</option>
                                        <option value="ENTERRADA">ENTERRADA</option>
                                        <option value="ELEVADA">ELEVADA</option>
                                </select>
                        </div>
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Ultima Gestion Pagada</label>
                            <input id="ultima_gestion_pagada"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  maxlength="4" >
                        </div>

                    </div>

                    <div class="row">
                                    <div class="col-sm-2">
                                                <label>Cuartel</label><span class="obligatorio">*</span>
                                                {{-- @php(print_r($cuartel)); --}}
                                                <select  class="form-control select-cuartel" id="cuartel" style="width: 100%" onchange="generarCodigo()" required>
                                                <option selected disabled>Seleccione un cuartel</option>
                                                        @foreach ($cuartel as $value)
                                                        <option value="{{ $value->id }}">{{ $value->codigo }}</option>
                                                        @endforeach
                                                </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Bloque:</label>
                                            <select  class="form-control select-bloque" id="bloque" style="width: 100%" onchange="generarCodigo()">
                                            <option selected disabled>Seleccione un cuartel</option>
                                            </select>
                                        {{-- <input id="cod-cripta" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off"> --}}
                                    </div>

                                    <div class="col-sm-2">
                                        <label>Nro Sitio:</label> <span class="obligatorio">*</span>
                                        <input id="cod-sitio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off"  maxlength="15" onblur="generarCodigo()" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Superficie m2:</label><span class="obligatorio">*</span>
                                        <input id="superficie" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off" onblur="generarCodigo()" required>
                                    </div>



                                        <div class="col-sm-3">
                                            <label>Codigo Anterior:</label>
                                            <input id="cod_cripta_ant" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off"  >
                                            <input id="cod-cripta" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="hidden" class="form-control" autocomplete="off"  onblur="generarCodigo()" readonly>
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Estado de construcción:</label><span class="obligatorio">*</span>
                                            <select name="construido" id="construido" class="form-control" required>
                                                <option value="ABANDONADA">ABANDONADA</option>
                                                <option value="COMO_MAUSOLEO_PEQ">CONST. COMO MAUSOLEO PEQ.</option>
                                                <option value="COMO_MAUSOLEO_GRANDE">CONST. COMO MAUSOLEO GRANDE.</option>
                                                <option value="CONSTRUIDO">CONSTRUIDO</option>
                                                <option value="DETERIORO">DETERIORO</option>
                                                <option value="EN_CONSTRUCCION">EN CONSTRUCCION</option>
                                                <option value="LOTE">LOTE</option>
                                                <option value="OBRA_FINA">OBRA FINA</option>
                                                <option value="OBRA_GRUESA">OBRA GRUESA</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Enterratorios Ocupados:</label>
                                            <input id="enterratorios_ocupados" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Total Enterratorios:</label>
                                            <input id="total_enterratorios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Osarios Ocupados:</label>
                                            <input id="osarios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Total Osarios:</label>
                                            <input id="total_osarios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Cenisarios:</label>
                                            <input id="cenisarios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                        </div>



                                        <div class="col-sm-12 col-md-6 col-xl-6">
                                            <label>Foto de la Cripta o Mausoleo:</label>
                                            <div id="foto" class="dropzone" style="text-align: center"> </div>
                                            <hr>
                                            <input type="hidden" id="url-foto">
                                            <br>
                                            <p id="foto_actual"></p>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-xl-6">
                                            <label>Observaciones:</label>
                                            <textarea id="observaciones" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" rows="6"> </textarea>
                                            <hr>
                                            <input type="hidden" id="url-foto">
                                        </div>

                    </div>
                            <hr>
                            <h6 class="section_divider card text-white bg-info mb-3 p-4">
                                DATOS DEL PROPIETARIO DEL MAUSOLEO O CRIPTA
                            </h6>
                                <p><b>* No llenar esta sección en caso de que el mausoleo o cripta no tenga propietario</b></p>
                                <p><b>* Si no cuenta con la informacion de nro documento de identidad presione el boton con icono lapiz para generar uno provisional</b></p>
                                <p><b>* Si no cuenta con la informacion de Nombre propietario llenar con  "NN"</b></p>


                            <br>

                    <div class="row">

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Documento de Identidad:</label><span class="obligatorio">*</span>
                                <div class="input-group input-group-lg">
                                    <input id="dni" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control" autocomplete="off">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default" id="buscarResp">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Telefono:</label>
                                <input id="telefono"  type="number" class="form-control"
                                 oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="8" >
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Genero :</label>
                                    <select name="genero" id="genero" class="form-control">
                                        <option value="MASCULINO">MASCULINO</option>
                                        <option value="FEMENINO">FEMENINO</option>
                                    </select>
                                </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12 col-md-4 col-xl-4">
                            <label>Nombre:</label><span class="obligatorio">*</span>
                            <input id="cripta-name" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off" required>
                        </div>

                        <div class="col-sm-12 col-md-4 col-xl-4">
                            <label>Paterno:</label><span class="obligatorio">*</span>
                            <input id="paterno" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off" required>
                        </div>

                        <div class="col-sm-12 col-md-4 col-xl-4">
                            <label>Materno:</label>
                            <input id="materno" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="row pb-4">
                            <div class="col-sm-12 col-md-10 col-xl-10">
                                <label>Domicilio:</label>
                                <input id="domicilio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="col-sm-6 col-md-2 col-xl-2" id="estado" style="display: none">
                                <label>Estado:</label>
                                <select  id="estado" class="form-control">
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xl-12"><h6 class="section_divider card text-white bg-info mb-3 p-4">DOCUMENTOS RECIBIDOS</h6></div>

                        <div class="col-sm-4 col-md-3 col-xl-3">
                            <label for="">Fecha Adjudicacion</label>
                            <input type="date" name="adjudicacion" id="adjudicacion" class="form-control">
                        </div>

                        <div class="col-sm-8 col-md-9 col-xl-9">
                            <div class="row pl-4">
                                <p><b>Seleccionar los documentos presentados por el/los propietarios</b></p>
                            </div>
                            <div class="row pl-lg-4">
                                <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="resolucion" value="resolucion" >
                                    <label for="resolucion" class="custom-control-label clear">Nro Resolución / Nro Testimonio</label>
                                    <br>
                                    <input type="text" name="nro_resolucion" id="nro_resolucion" class="clear"  style="display: none">
                                </div>

                                <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="bienes_m" value="bienes_m" >
                                    <label for="bienes_m" class="custom-control-label">Bienes Municipales</label>
                                </div>

                                <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="ci" value="ci"  >
                                    <label for="ci" class="custom-control-label">Carnet de Identidad</label>
                                    <br>
                                    <input type="text" name="nro_ci" id="nro_ci"  style="display: none">
                                </div>

                                <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="planos_aprobados" value="planos_aprobados"  >
                                    <label for="planos_aprobados" class="custom-control-label">Planos Aprobados</label>
                                </div>

                                <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="obs_resolucion" value="obs_resolucion"  >
                                    <label for="obs_resolucion" class="custom-control-label">Observacion</label>
                                    <br>
                                    <input type="text" name="txt_resolucion" id="txt_resolucion" class="form-control clear" style="display: none">
                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cripta_mausoleo_id"  id="cripta_mausoleo_id" value="">
                     <hr>
                    <div class="col-sm-12" style="text-align: center">
                            <button type="button" id="btn-cripta" class="btn btn-success btn-editar">Guardar</button>
                            <button type="button" style="display:none" id="btn-cripta-editar" class="btn btn-success btn-editar">Guardar Modificación</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
      </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" id="edit-cuartel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btn-editar-va">Guardar Cambios</button> -->
        </div>
      </div>
    </div>
  </div>



   @include('cripta/modal_difunto_cripta')
   @include('cripta/modal_actualizacion_pagos')


   {{-- @include('cripta/modal_pago_servicios') --}}




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



//**** actualizacion de pagos **/
$(document).on('click', '#btn_up_pay_cm', function(){
            $('#modal_uppay_cm').modal('show');
});

/***difuntos **/

        $(document).on('click', '#btn_add_difunto', function(){
            $('#modal_add_difunto').modal('show');
            $('#id_cripta_mausoleo_modal').val($(this).val());
            // buscar si hay difuntos ingresados

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
                            $('#tabla_difunto_row').empty();
                            $('#modal_save_difuntos').prop('disabled', false);

                            console.log(data_response);
                            var list=jQuery.parseJSON(data_response.response['difuntos']);
                            if(data_response.response['difuntos']!=null )
                            {
                                // var rows = Object.keys(data_response.response['difuntos']).length;
                                //    console.log(rows);
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
                        }




            });
        });



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
       txt_resolucion
  });

        $(document).ready(function(){
            $(document).on('click','#btn-cripta-editar', function(){
                    if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="0";}
                    else{var bloq=$('#bloque :selected').val();}

                // documentos recibido
                    if ($("#resolucion").is(":checked")) { var resolucion=$('#nro_resolucion').val(); } else { var resolucion="FALTA";}
                    if ($("#ci").is(":checked")) { var ci=$('#nro_ci').val();} else { var ci="FALTA";}
                    if ($("#bienes_m").is(":checked")) { var bienes_m="BIENES M";} else { var bienes_m="FALTA";}
                    if ($("#planos_aprobados").is(":checked")) { var planos_aprobados="PLANOS A";} else { var planos_aprobados="FALTA";}
                    if ($("#obs_resolucion").is(":checked")) { var obs_resolucion=$('#txt_resolucion').val(); } else { var obs_resolucion="FALTA";}


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
                            'ultima_gestion_pagada':$('#ultima_gestion_pagada').val(),
                            'foto' :  $('#url-foto').val(),
                            'estado': $('#estado').val() ,
                            'documentos_recibidos':  {
                                                       'resolucion': resolucion,
                                                       'ci': ci,
                                                       'bienes_m': bienes_m,
                                                       'planos_aprobados': planos_aprobados,
                                                       'obs_resolucion':obs_resolucion
                                                    }


                        }),
                        success: function(data_response) {
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

            });



            $(document).on('click', '#btn-editar', function(){
                $('#cmform').find("input[type=text], input[type=checkbox], textarea").val("");
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
                        success: function(data_response) {
                            console.log(data_response);
                            $('#modal-cripta').modal('show');
                            $('#btn-cripta-editar').show(300);
                            $('#btn-cripta').hide(300);
                            $('#cripta_mausoleo_id').val(cripta_mausoleo_id);
                            $(".select-cuartel").val(data_response.response.cuartel_id).trigger('change');
                            $('#cod-cripta').val(data_response.response.codigo);
                            $('#cod_cripta_ant').val(data_response.response.codigo_antiguo);
                            $('#cod-sitio').val(data_response.response.sitio);
                            $('#bloque').val(data_response.response.bloque_id);
                            $('#tipo_reg').val(data_response.response.tipo_registro);
                            $('#cripta-name').val(data_response.response.nombres);
                            $('#superficie').val(data_response.response.superficie);
                            $('#estado').val(data_response.response.estado);
                            $('#btn-cripta-editar').val(data_response.response.id);
                            $('#paterno').val(data_response.response.primer_apellido);
                            $('#materno').val(data_response.response.segundo_apellido);
                            $('#dni').val(data_response.response.ci);
                            $('#domicilio').val(data_response.response.domicilio);
                            $('#genero_resp').val(data_response.response.genero);
                            $('#telefono').val(data_response.response.celular);
                            $('#construido').val(data_response.response.estado_construccion);
                            $('#enterratorios_ocupados').val(data_response.response.enterratorios_ocupados);
                            $('#total_enterratorios').val(data_response.response.total_enterratorios);
                            $('#osarios').val(data_response.response.osarios);
                            $('#total_osarios').val(data_response.response.total_osarios);
                            $('#cenisarios').val(data_response.response.cenisarios);
                            $('#observaciones').val(data_response.response.observaciones);
                            $('#familia').val(data_response.response.familia);
                            if(data_response.response.documentos_recibidos){
                                var ar=JSON.parse(data_response.response.documentos_recibidos);
                                console.log(ar);
                                if(ar.bienes_m=="BIENES M"){ $('#bienes_m').prop('checked', true); }else{$('#bienes_m').prop('checked', false);}
                                if(ar.ci!="FALTA"){ $('#ci').prop('checked', true); $('#nro_ci').val(ar.ci); $('#nro_ci').show(); }else{$('#ci').prop('checked', false);}
                                if(ar.resolucion!="FALTA"){ $('#resolucion').prop('checked', true); $('#nro_resolucion').val(ar.resolucion); $('#nro_resolucion').show(); }else{$('#resolucion').prop('checked', false);}
                                if(ar.planos_aprobados=="PLANOS A"){ $('#planos_aprobados').prop('checked', true); }else{$('#planos_aprobados').prop('checked', false);}
                                if(ar.obs_resolucion!="FALTA"){ $('#obs_resolucion').prop('checked', true); $('#txt_resolucion').val(ar.obs_resolucion); $('#txt_resolucion').show(); }else{$('#obs_resolucion').prop('checked', false);}

                            }



                             $('#adjudicacion').val(data_response.response.adjudicacion);
                             $('#ultima_gestion_pagada').val(data_response.response.ultima_gestion_pagada);

                             $('#familia').val(data_response.response.familia);
                            console.log( "data_response.response.foto"+data_response.response.foto)
                            if(data_response.response.foto!=null){
                               $('#url-foto').val(data_response.response.foto)  ;
                               $('#foto_actual').append('<a href="'+ data_response.response.foto+'" target="_blank">Ver foto actual </a>');
                               $('#foto_actual').append('<img src="'+ data_response.response.foto+'" widh="100px" heigth="100"');


                            }else{
                                    $('#foto_actual').empty();
                                    $('#foto_actual').hide();
                            }
                            if($('#tipo_reg option:selected').val() =="CRIPTA"){
                                        $('#letra').val("C");
                                        $('#box_tipo_cripta').show();
                                        $('#box_tipo_cripta').prop('disabled', false);
                                        $('#tipo_cripta').val(data_response.response.tipo_cripta);
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

                $('#modal-cripta').modal('show');
                $('#btn-cripta-editar').hide(300);
                $('#btn-cripta').show(300);
                $('#familia').val('');
                $('#tipo_cripta').val('');
                $('#resolucion').prop('checked', false);

                $('#ci').prop('checked', false);
                $('#nro_ci').val(''),
                $('#nro_resolucion').val(''),
              $('#ultima_gestion_pagada').val(''),


                $('#planos_aprobados').prop('checked', false);
                $('#bienes_m').prop('checked', false);





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

            $(document).on('click','#btn-cripta', function()
            {
                if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="0";}else{var bloq=$('#bloque :selected').val();}
                // documentos recibido
                    if ($("#resolucion").is(":checked")) { var resolucion=$('#nro_resolucion').val(); } else { var resolucion="FALTA";}
                    if ($("#ci").is(":checked")) { var ci=$('#nro_ci').val();} else { var ci="FALTA";}
                    if ($("#bienes_m").is(":checked")) { var bienes_m="BIENES M";} else { var bienes_m="FALTA";}
                    if ($("#planos_aprobados").is(":checked")) { var planos_aprobados="PLANOS A";} else { var planos_aprobados="FALTA";}



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
                            'ultima_gestion_pagada' :  $('#ultima_gestion_pagada').val(),

                            'familia':$('#familia').val(),
                            'tipo_cripta':$('#tipo_cripta option:selected').val(),
                            'adjudicacion':$('#adjudicacion').val(),
                            'documentos_recibidos':  {
                                                       'resolucion': resolucion,
                                                       'ci': ci,
                                                       'bienes_m': bienes_m,
                                                       'planos_aprobados': planos_aprobados,
                                                       'obs_resolucion':obs_resolucion
                                                    },

                            'estado': $('#estado').val()
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

    function generarCodigo(){
        var sup=$('#superficie').val();
        if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="000";}
        else{var bloq=$('#bloque :selected').text();}

        console.log(bloq);
        console.log($('#cod-sitio').val());

        var cod=($('#cuartel :selected').text()).toUpperCase()+bloq+$('#cod-sitio').val()+($('#letra').val()).toUpperCase()+parseInt(sup);
        $('#cod-cripta').val(cod);
    }


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
                    formData.append('collector', 'certificados de difuncion');

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
                    formData.append('collector', 'certificados de difuncion');

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


//certificado de defuncion


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



                // this.on("removedfile", function(file) {
                //     $.ajax({
                //                 type: 'DELETE',
                //                 headers: {
                //                     'Content-Type':'application/json'
                //                 },
                //                 url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                //                 async: false,
                //                 data: JSON.stringify({
                //                     'url':  JSON.parse(file.xhr.response).response[0].url_file
                //                 }),
                //                 success: function(data_response) {
                //                 }
                //             })
                // });


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


$(document).on('click', '#buscarResp', function() {
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
            //controlar activacion de nro de resolucion como documetno recibido
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

                $(document).on('click', '#add_difunto_row', function(e){
                   e.preventDefault();
                    mostrar_difunto();

                   var nrow= $('.tabla_difunto tbody tr').length;
                   if(nrow>0){ $('#modal_save_difuntos').prop('disabled', false)}
                   else{
                    $('#modal_save_difuntos').prop('disabled', true)
                   }
                });


                $("#funeraria").select2({
                width: 'resolve', // need to override the changed default
                dropdownParent: $('#modal_add_difunto'),
                tags: true,
                allowClear: true
                });

                $(document).on('click', 'button[aria-describedby="select2-funeraria-container"] span', function() {
                 $('#funeraria option:selected').remove();
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


            // show Deceased row in table
                function mostrar_difunto(){

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
                    //     $('.archivo').empty();

                    //    var ad='<div class="col-sm-8 col-md-8 col-xl-8">'
                    //            +'<label>Adjuntar certificado de defunción :</label>'
                    //            +'<div id="cert_defuncion" class="dropzone cleardrop" style="text-align: center"><div class="dz-default dz-message">'
                    //            + ' <button class="dz-button" type="button">Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)</button>'
                    //            + '</div></div><hr>'
                    //            + '<hr>'
                    //            + '<input type="hidden" id="mdurl-certification" class="form-control clear">'
                    //            + '</div>';
                    //            $('.archivo').append(ad);


                    //    $('.dz-preview .dz-processing .dz-image-preview .dz-success .dz-complete').remove();
                             Dropzone.forElement('#cert_defuncion').removeAllFiles(true);

                    }

                    // convert table rows in array json for send to controller and send all data to controller
                    $(document).on('click', '#modal_save_difuntos', function(e){
                        e.preventDefault();
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
                                    });
                                    $.ajax({
                                        type: 'PUT',
                                        headers: {
                                            'Content-Type':'application/json',
                                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                        },
                                        url: '{{ route("add.deseaced") }}',
                                        async: false,
                                        data: JSON.stringify({
                                            'cripta_mausoleo_id': $('#id_cripta_mausoleo_modal').val(),
                                            'difuntos': difuntos
                                        }),
                                            success: function(data) {
                                                 console.log(data.status);
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
                                                        'Busqueda finalizada!',
                                                        'El registro no ha  sido encontrado o no existe .',
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


                    function calcularEdad(birth) {
                        ageMS = Date.parse(Date()) - Date.parse(birth);
                        age = new Date();
                        age.setTime(ageMS);
                        ageYear = age.getFullYear() - 1970;

                        return ageYear;

                        // ageMonth = age.getMonth(); // Accurate calculation of the month part of the age
                        // ageDay = age.getDate();    // Approximate calculation of the day part of the age
                        }

// abrir modal pagar servicio
        //  $(document).on('click', '#btn_pay_cm', function(){
        //     $('#modal_pay_cm').modal('show');
        //     $('#id_cripta_mausoleo_modal').val($(this).val());
        //     // buscar si hay difuntos ingresados

        //     $.ajax({
        //                 type: 'POST',
        //                 headers: {
        //                     'Content-Type':'application/json',
        //                     'X-CSRF-TOKEN':'{{ csrf_token() }}',
        //                 },
        //                 url:'{{ route("difuntoCripta.get") }}',
        //                   async: false,
        //                 data: JSON.stringify({
        //                     'cripta_mausoleo_id': $(this).val(),
        //                 }),
        //                 success: function(data_response)
        //                 {
        //                     $('#tabla_difunto_row').empty();
        //                     $('#modal_save_difuntos').prop('disabled', false);

        //                     console.log(data_response);
        //                     var list=jQuery.parseJSON(data_response.response['difuntos']);
        //                     if(data_response.response['difuntos']!=null )
        //                     {
        //                         // var rows = Object.keys(data_response.response['difuntos']).length;
        //                         //    console.log(rows);
        //                         $.each(list, function(key, value)
        //                          {
        //                                  console.log( value[value]);

        //                                     //llenar tabla
        //                                           var row='<tr>'+
        //                                                 '<td class="dtci">'+value['ci']+'</td>'+
        //                                                 '<td class="dtname">'+value['nombres']+'</td>'+
        //                                                 '<td class="dtprimer_apellido">'+value['primer_apellido']+'</td>'+
        //                                                 '<td class="dtsegundo_apellido">'+value['segundo_apellido']+'</td>'+
        //                                                 '<td class="dtcertificado_defuncion">'+value['ceresi']+'</td>'+
        //                                                 '<td class="dttipo">'+value['tipo']+'</td>'+
        //                                                 '<td class="dtfecha_nacimiento">'+value['fecha_nacimiento']+'</td>'+
        //                                                 '<td class="dtedad">'+calcularEdad(value['fecha_nacimiento'])+'</td>'+

        //                                                 '<td class="dtfecha_defuncion">'+value['fecha_defuncion']+'</td>'+
        //                                                 '<td class="dtcausa">'+value['causa']+'</td>'+
        //                                                 '<td class="dtfuneraria">'+value['funeraria']+'</td>'+
        //                                                 '<td class="dtgenero">'+value['genero']+'</td>'+
        //                                                 '<td class="dturl">'+value['url']+'</td>'+
        //                                                 '<td class="remov"> <a href="#" id="remove"  onClick="$(this).parent().parent().remove();"> <i class="fas fa-trash wine fa-2x"></i></a></td></tr>';
        //                                             $('#tabla_difunto_row').append(row);
        //                                             // clear modal form
        //                                             $('.clear').val('');
        //                                             $('.clears2').val(null).trigger('change');


        //                         })

        //                         //end foreach
        //                     }//end if
        //                 }




        //     });
        // });

/// recuperar difunto en modal difunto


$(document).on('click', '#buscarDif', function(e) {
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
                        } else {
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




    </script>
    @stop

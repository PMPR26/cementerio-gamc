@extends('adminlte::page')
@section('title', 'Register Servicio')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.dropzone', true)
@section('plugins.Pace', true)

@section('content_header')
    <h1 class="p-2 bg-gradient-blue">Formulario de solicitud de servicios</h1>
@stop

@section('content')



        <div class="modal-body">
            <div class="col-sm-12 col-md-12 col-xl-12 card m-auto">

                <div class="card infoPlazo"  style="display:none">
                    <div class="card-header">
                        <h2 id="infoPlazo" class="clean"></h2>
                    </div>
                </div>

                  {{-- seccion servicios excepcionales - externos  --}}
                  <div class="card">
                    <div class="card-header bg-gradient-cyan">
                        <h4>SELECCIONE PARA EXTERNOS</h4>
                    </div>

                      <div class="row card-body">

                              <div class="col-sm-12 col-md-12 col-xl-12">

                                 <label>
                                    <input type="checkbox" name="servicio_externo"  id="servicio_externo" value="NO" style="width: 35px; height:35px">
                                       Seleccione la opción para habilitar el formulario para servicio externo
                                 </label>
                            </div>

                    </div>

                </div>

                {{-- datos busqueda --}}

                <div class="card busquedaNichos">
                    <div class="card-header bg-gradient-cyan">
                        <h4>BUSCAR REGISTRO</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>NRO NICHO</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control " id="nro_nicho" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>BLOQUE</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control " id="bloque" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>FILA</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control " id="fila" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3 p-4 mt-2">
                                <button type="button" class="btn btn-info" id="buscar">
                                    <span id="sp"></span> <i class="fa fa-search"></i>BUSCAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="contenido" style="display: none">
                    <div class="card complementoBusqueda"  >
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Cuartel</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="cuartel" >
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Codigo antiguo</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="anterior" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Tipo nicho</label>
                                <select name="tipo_nicho" id="tipo_nicho" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="TEMPORAL">TEMPORAL</option>
                                    <option value="PERPETUO">PERPETUO</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-12 p-3 text-blue">ESTADO DE NICHO: <span id="estado_actual_nicho"></span></div>
                    </div>


                    {{-- datos difunto --}}
                    <div class="card">
                        <div class="row bg-gradient-cyan">
                            <div class="card-header col-md-6 col-xl-6">
                                <h4> DATOS DIFUNTOS </h4>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6 p-4 nuevo_difunto">
                                <label>INGRESAR NUEVO DIFUNTO
                                    <input type="checkbox" name="add_difunto"  id="add_difunto" value="" style="width: 35px; height:35px">
                                 </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-3 col-xl-3">
                                        <label>Carnet de Identidad</label>
                                        <div class="input-group input-group-lg">
                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control clear new" id="search_dif" autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default"  id="buscarDifunto">
                                                <i class="fa fa-search"></i>
                                            </button>

                                        <input type="hidden" name="difunto_search" id="difunto_search">
                                        <input type="hidden" name="store_nro_renovacion" id="store_nro_renovacion">
                                        <input type="hidden" name="store_monto_renovacion" id="store_monto_renovacion">
                                        <input type="hidden" name="ci_difunto_actual" id="ci_difunto_actual">

                                        </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Nombres</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear new" id="nombres_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Primer apellido</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear new" id="paterno_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Segundo apellido</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear new" id="materno_dif" autocomplete="off">
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Nacimiento</label>
                                <input type="date" class="form-control clear new" id="fechanac_dif" >
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Defuncion</label>
                                <input type="date" class="form-control clear new" id="fechadef_dif" >
                            </div>

                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Causa</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear new" id="causa" autocomplete="off">
                            </div> --}}
                            <div class="form-group col-sm-12 col-md-3 col-xl-3">
                                <label>Causa :</label>
                                <select id="causa"
                                class="form-control clears2 select2-multiple select2-hidden-accessible" style="width: 100%">
                                <option value="">SELECIONAR CAUSA</option>
                                    @foreach ($causa as $c)
                                            <option value="{{ $c->causa }}">{{$c->causa }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>SERECI</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear new" id="sereci" autocomplete="off">

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Tipo Difunto</label>
                                <select name="tipo_dif" id="tipo_dif" class="form-control new clears2">
                                    <option value="">Seleccionar</option>
                                    <option value="ADULTO">ADULTO</option>
                                    <option value="PARVULO">PARVULO</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Genero</label>
                                <select name="genero" id="genero_dif" class="form-control clears2 new">
                                    <option value="">Seleccionar</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                </select>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-sm-12 col-md-12 col-xl-12" >
                                    <label>Adjuntar certificado de defunción :</label>
                                    <div class="col-sm-12" >
                                        <div id="cert-defuncion"  class="dropzone" style="text-align: center"> </div>
                                        <hr>
                                        <input type="hidden" id="url-certification" class="new">
                                    </div>
                                  </div>
                        </div>
                    </div> {{-- </div>   en section difunto --}}
                </div>

                {{-- datos responsables --}}
                <div class="card p-2">
                        <div class="card-header">
                            <h4>DATOS RESPONSABLE</h4>
                        </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                    <label>Carnet de Identidad</label>
                                    <div class="input-group input-group-lg">
                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control clear" id="search_resp" autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default"  id="buscarResp">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <input class="clear" type="hidden" name="responable_search" id="responsable_search">
                                        </div>
                                    </div>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Nombres</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="nombres_resp" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Primer apellido</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="paterno_resp" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Segundo apellido</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="materno_resp" autocomplete="off">
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="fechanac_resp" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Teléfono</label>
                                <input  type="tel"  class="form-control" id="telefono" autocomplete="off" maxlength="7">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Celular</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="celular" autocomplete="off">
                            </div>

                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Estado civil</label>
                                <select name="ecivil" id="ecivil" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="CASADO">CASADO/A</option>
                                    <option value="CONCUBINADO">CONCUBINADO/A</option>
                                    <option value="DIVORCIADO">DIVORCIADO/A</option>
                                    <option value="SOLTERO">SOLTERO/A</option>
                                    <option value="VIUDO">VIUDO/A</option>
                                </select>
                            </div> --}}
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Genero</label>
                                <select name="genero_resp" id="genero_resp" class="form-control clears2">
                                    <option value="">Seleccionar</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                    <label>E-mail</label>
                                    <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="email" autocomplete="off">
                            </div> --}}


                            {{-- <div class="col-sm-12 col-md-7 col-xl-7">
                                <label>Domicilio</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="domicilio" autocomplete="off">
                            </div> --}}

                        </div>
                    </div>
                </div>
            {{-- datos responsables --}}
                <div class="card">
                    <div class="card-header">
                        <h4>INFORMACION PAGOS</h4>
                    </div>

                    <div class="card-body">
                        <div class="row pb-2">
                            <div class="col-sm-12 col-md-8 col-xl-8">
                            Razon: <span id="razon" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                Comprobante: <span id="comprob" class="clear"></span>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                Tiempo: <span id="tiemp" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-6 col-xl-6">
                                Ultimo Pago: <span id="pago_cont" class="clear"></span>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-sm-12 col-md-12 col-xl-12">
                                Concepto: <span id="concepto" class="clear"></span>
                            </div>


                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Gestiones: <span id="gestiones" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Monto: <span id="monto_pagos" class="clear"></span>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Fecha adjudicacion: <span id="fecha_adjudicacion" class="clear"></span>
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Fecha liberacion: <span id="fecha_liberacion" class="clear"></span>
                            </div>

                        </div>
                    </div>
                </div>
            {{-- servicios --}}
                <div class="card">
                    <div class="card-header bg-gradient-danger">
                        <h4>ASIGNACION SERVICIOS</h4>
                    </div>
                    <div class="card-body" id="tipo_servicio_value">



                        @foreach ($tipo_service as $value)
                            @if($value['cuenta'] == '15224330' )
                            {{-- //$value['cuenta'] =='15224150' ||   $value['cuenta'] =='15224350' ||  --}}
                            @else
                                <div class="col-12 {{ $value['cuenta'] }}">
                                     <label>   <input type="checkbox" name="{{ $value['cuenta'] }}" value="{{ $value['descripcion'] }}" id="{{ $value['cuenta'] }}" class="serv"  >{{ $value['descripcion'] }}</label>
                                    <div  class="col-12 sev-hijos" id="serv-hijos-{{ $value['cuenta'] }}" ></div>
                                </div>
                            @endif
                        @endforeach



                    </div>
                </div>
                <div class="row">
                    <div class="col-12 p-2 bg-gradient-gray" id="section_exhum" style="display:none">
                        <label for="det_exhumacion">Detalle Exhumación</label>
                        <textarea name="det_exhumacion" id="det_exhumacion"  class="form-control"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12" id="section_obs">

                        <label for="observacion">Observacion</label>
                        <textarea id="observacion" col="100%" row="2" class="form-control"></textarea>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="detalle">
                        <h4>DETALLE DE SERVICIOS SOLICITADOS</h4>
                        <table id=tableServices>
                            <thead>
                                <tr>
                                    <td class="w-auto text-center">CUENTA T.SERV</td>
                                    <td class="w-auto text-center">TIPO SERVICIO</td>
                                    <td class="w-auto text-center">CUENTA</td>
                                    <td class="w-auto text-center">SERVICIO</td>
                                    <td class="w-auto text-center">CANTIDAD</td>
                                    <td class="w-auto text-center">PRECIO</td>
                                    <td class="w-auto text-center">SUBTOTAL</td>
                                </tr>
                            </thead>
                            <tbody id="list_detalle">

                            </tbody>
                        </table>
                            {{-- <div class="row">

                            </div>
                        <div id="list_detalle">
                        </div> --}}
                    </div>



                    <div id="cal_price" style="text-align: center">
                        <div class="card">
                            <div class="card-body" id="servicios-hijos-price" style="text-align: center">
                            </div>
                            <h1><span>Total :</span><span id="totalServ"> 0 </span> Bs</h1>

                        </div>
                    </div>
                </div>


                <div class="row pb-2" id="conservacion" style="display:none">
                    <div class="col-sm-4 col-md-4 col-xl-4" id="gestion_box">
                        <label>Gestiones</label>
                        <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clean" id="gestion_b" autocomplete="off" >
                     </div>

                        <div class="col-sm-4 col-md-4 col-xl-4" id="cantidad_box" >
                            <label>Cantidad de gestiones</label>
                                 <input style="text-transform:uppercase;" value="1" onkeyup="calcMant()" type="text" class="form-control clean" id="cantidad_b" autocomplete="off">
                        </div>


                        <div class="col-sm-4 col-md-4 col-xl-4" id="unidad_box">
                            <label>Unidad</label>
                            <input style="text-transform:uppercase;" value="Glb" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clean" id="unidad_b" autocomplete="off">
                        </div>


                      <div class="col-sm-4 col-md-4 col-xl-4" id="precio_box">
                        <label>Precio Unitario</label>
                        <input style="text-transform:uppercase;"   onkeyup="calcMant()"  type="text" class="form-control clean" id="precio_b" autocomplete="off" readonly>
                     </div>

                     <div class="col-sm-4 col-md-4 col-xl-4" id="monto_box">
                        <label>Subtotal</label>
                        <input style="text-transform:uppercase;"   type="text" class="form-control clean" id="monto_b" autocomplete="off" readonly>
                     </div>



                </div>

                <div class="row card">
                    <div class="col-12"><h4>DETALLE DE LA PERSONA QUE REALIZA EL PAGO</h4></div>
                    <div class="col-12"><input type="checkbox" name="pago_tercero" id="pago_tercero" value="responsable" style="width:50px; heigth:50px"> <label for="pago_tercero" >Pago  realizado por tercera persona</label></div>
                    <div class="col-12"><input type="checkbox" name="gratis" id="gratis" value="" style="width:50px; heigth:50px"> <label for="gratis" >Servicio gratuito</label></div>
                    <div class="row p-2 bg-gradient-gray" id="section_pago_tercero" style="display:none">
                    <div class="col-6"><label for="ci_pago">Documento de Identidad: </label><input type="text" name="ci_pago" id="ci_pago" placeholder="Documento de Identidad" class="form-control"></div>
                    <div class="col-6"> <label for="name_pago">Nombre: </label><input type="text" name="name_pago" id="name_pago" placeholder="Nombres" class="form-control" style="text-transform: uppercase;"></div>
                    <div class="col-6"><label for="paterno_pago">Primer Apellido: </label><input type="text" name="paterno_pago" id="paterno_pago" placeholder="Apellido Paterno" class="form-control"  style="text-transform: uppercase;"></div>
                    <div class="col-6"><label for="materno_pago">Segundo  Apellido: </label><input type="text" name="materno_pago" id="materno_pago" placeholder="Apellido Materno" class="form-control"  style="text-transform: uppercase;"></div>
                    </div>
                </div>




                <input type="hidden" name="origen" id="origen">
                <input type="hidden" name="pag_con" id="pag_con" value="aaa">
                <input type="hidden" name="pag_con_ant" id="pag_con_ant">
                <input type="hidden" name="tiempo" id="tiempo">
                <input type="hidden" name="vencido" id="vencido" value="asdada">
                <input type="hidden" name="renov_txt" id="renov_txt" value="NO">

                    <div class="col-sm-12" style="text-align: center">
                        <button type="button" id="btn_guardar_servicio" class="btn btn-success">Registrar servicio</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
    </div>
@stop
@section('css')
<style>

  .select2-selection__rendered{
      color:#333232;
  }
  .select2-results__option--selected{
      background-color: #175603 !important;
  }

</style>

@section('js')
    <script>

        $(document).on('click', '#add_difunto', function(){
            if ($('#add_difunto').is(":checked")){
                new_difunto();
            }else{

            }

         });


        function new_difunto(){
            $('.new').val('');

        }



$(document).ready(function ()
 {

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
                    formData.append('collector', 'cementerio certificado de difuncion');
                    formData.append('nro_documento', $('#ci_resp').val());


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
});

        /****variabbles globales de los servicios y cuentas adquiridos ******/
        let servicios_adquiridos=[];
        let precio=[];


        /******** dibujar los checkbox con los servicios hijos de cada cuenta*****/
        $(document).on('click', '.serv', function(e){
            // e.preventDefault();
            var cuenta=$(this).attr("id");
            var id_cuenta=   cuenta;
            var txt_cuenta=$(this).attr("value");


            if ($('#'+cuenta+'').is(":checked"))
                {
                    $.ajax({
                            type: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN':'{{ csrf_token() }}',
                            },
                            url: "{{route('get.serv')  }}",
                            async: false,
                            data: JSON.stringify({
                                'data': cuenta
                            }),
                            success: function(data_response) {
                                console.log("**************"+data_response.response+"*****");
                                $('#serv-hijos-'+cuenta+'').empty();
                                $.each(data_response.response, function(index, value) {

                                    // if (value.num_sec == '526' || value.num_sec == '525' || value.num_sec == '630' || value.num_sec == '628' ) {}
                                    // else {
                                                // console.log("asdas");
                                                var html='<div class="form-check">'+
                                                '<input class="form-check-input service_child" type="checkbox" id="'+value.num_sec+'" name="serv[servicio]" value="'+ id_cuenta +'-'+ txt_cuenta +' => '+value.num_sec+' - '+ value.descripcion + ' - ' + value.monto1 +'- Bs."  >'+
                                                '<label class="form-check-label childservice" for="'+value.num_sec+'" style="color:green">'+value.descripcion+' - ' + value.monto1 +'- Bs.</label>'+
                                                '</div>';
                                                $('#serv-hijos-'+cuenta+'').append(html);
                                                if (value.num_sec == '642' ){
                                                    var contenedor_renov='<div id="contenedor_renov" ></div>';
                                                    $('#serv-hijos-'+cuenta+'').append(contenedor_renov);
                                                    }
                                        // }

                                });
                            }
                        });
                }else{
                    $('#serv-hijos-'+cuenta+'').empty();
                    $('#list_detalle .row_'+cuenta+'').remove();
                }

                calcularMonto();
        });

        //metodo para poner detalle en la grilla para renovaciones
       function put_in_grid()
        {
          //  alert($('#info').val());
            var inf=($('#info').val()).split(',');
            var srv=inf[0];
            var arrar_serv=inf[1].split('=>');

            var txt_srv=arrar_serv[0];
            var cuenta=arrar_serv[1];
            var servicio=inf[2];
            var cantidad=$('#nro_renovaciones').val();
            var precio_ren=$('#monto_renov').val();
            var subtotal=$('#monto_renov').val();



           // console.log("split info"+inf);
                $('.row_ren').remove();
            //list_detalle
                var row='<tr class="w-auto row_ren">'+
                       '<td class="w-auto text-center service">'+srv+'</td>'+
                       '<td class="w-auto text-center service_txt">'+txt_srv+'</td>'+
                        '<td class="w-auto text-center service_hijo " >'+ cuenta+' </td>'+
                        '<td class="w-auto text-center service_hijo_txt">'+servicio+'</td>'+
                        '<td class="w-auto text-center cantidad_row">'+cantidad+'</td>'+
                        '<td class="w-auto text-center precio_srv">'+precio_ren+'</td>'+
                        '<td class="w-auto text-center subtotal">'+subtotal+'</td>'+
                        '</tr>';
                $('#list_detalle').append(row);
                calcularMonto();
            }

        $(document).on('click','#gratis', function(){
                if ($(this).is(':checked') ) {
                    $('#gratis').val('GRATIS');
                 }
                 else{
                    $('#gratis').val('');
                 }
        });

        $(document).on('click', '.service_child', function(e){
            var monto=0;
            var cantidad=1;
            var subtotal=0;

            $('#list_detalle').empty();
            $( ".service_child" ).each(function( index ) {
                console.log( index + ": " + $( this ).val() );
                var ar= ($( this ).val()).split('-');
                    var ar1=(ar[1]).split('=>');
                if ($(this).is(':checked') ) {
                    var ar= ($( this ).val()).split('-');
                    var ar1=(ar[1]).split('=>');
                    //  precio.push(ar[3]);
                     subtotal=cantidad*ar[3];
                  if(ar1[1]==642){

                     }
                     else{
                     var html='<tr class="row_'+ar[0]+'">'
                     +'<td class="w-auto text-center service">'+ar[0]+'</td>'
                     +'<td class="w-auto text-center service_txt">'+ar1[0]+'</td>'
                     +'<td class="w-auto text-center service_hijo">'+ar1[1]+'</td>'
                     +'<td class="w-auto text-center service_hijo_txt">'+ar[2]+'</td>'
                     +'<td class="w-auto text-center cantidad_row">'+cantidad+'</td>'
                     +'<td class="w-auto text-center precio_srv">'+ar[3]+'</td>'
                     +'<td class="w-auto text-center subtotal">'+subtotal+'</td></tr>';
                     $('#list_detalle').append(html);

                    }
                }else{

                   // $('#list_detalle .row_'+ar[0]+'').remove();

                }
            });
            calcularMonto();
            // console.log("cuenta servicio");
            // console.log(serv);
            // console.log("texto servicio");
            // console.log(serv_txt);
            // console.log("cuenta  servicio hijo" );
            // console.log(serv_hijos);
            // console.log("texto  servicio hijo" );
            // console.log(serv_hijos_txt);



        });
        /************* metodo que recorre toda la grilla resumen de servicios adquiridos y calcula el total adeudado ******/
        function calcularMonto(){
            var suma=0;
            $('#totalServ').html("");
            $( ".subtotal" ).each(function( index ) {
                console.log( index + ": " + $( this ).val() );
                suma=parseInt(suma) + parseInt($( this ).html());
            });
            $('#totalServ').html(suma);
            return suma;
        }

       /******** metodo que arma el array de cuentas y servicios adquiridos *****/
        function makeArrayServices(){
            servicios_adquiridos=[];
            let fila=[];
            var long = 0; var nres = 0;
                         $('#tableServices tbody tr').each(function() {
                            long++;
                          })
                    if( long>0)
                     {
                      document.querySelectorAll('#tableServices tbody tr').forEach(function(e)
                        {
                                       let fila = {
                                                tipo_servicio: e.querySelector('.service').innerText,
                                                txt_tipo_servicio: e.querySelector('.service_txt').innerText,
                                                serv: e.querySelector('.service_hijo').innerText,
                                                txt_serv: e.querySelector('.service_hijo_txt').innerText,
                                                precio: e.querySelector('.precio_srv').innerText,
                                                cantidad: e.querySelector('.cantidad_row').innerText,
                                      };
                                      servicios_adquiridos.push(fila);
                        });
                     }

                 console.log( "serv_txt");
                 console.log(servicios_adquiridos);
        }


      //activar input para detalle de cremacion
        $(document).on('click', '#15224200', function(){
            if ($('#15224200').is(':checked')) {
                $('#section_exhum').show();
            }else{
                $('#section_exhum').hide();
            }
        });


     //calcular renovacion
     $(document).on('click', '#642', function(){

        if ($('#642').is(':checked')) {
                $('#ren').show();
                  adicion_seccion_renovacion();
            }else{
                $('#ren').hide();
            }

     });

        function adicion_seccion_renovacion()
        {
           $('#contenedor_renov').empty();
           var info=($('#642').val()).split('-');
           console.log("informacion: "+info);
           precio_renov=$.trim(info[3]);
           console.log("----->"+precio_renov);  //class=""
           var html_renov=' <div class="card p-2 bg-gradient-cyan" id="ren"> <h4 class="card-info">CALCULAR RENOVATORIO</h4>'
                                                +'<div class="card-body">'
                                                +'<div class="row pb-2">'
                                                     +'<div class="col-sm-12 col-md-4 col-xl-4">'
                                                     +'<label for="">Precio Renovatorio</label>'
                                                     +'<input type="number" name="precio_renov" id="precio_renov" value="'+precio_renov+'" class="form-control precio_renov" readonly>'
                                                +'</div>'
                                                +'<div class="col-sm-12 col-md-4 col-xl-4">'
                                                    +'<label for=""># de renovacion anterior</label>'
                                                    +'<input type="number" name="renov_ant" id="renov_ant"  onKeyPress="if(this.value.length==2) return false;"    start="1" class="form-control renov"  onkeyup="calcRenov()">'
                                                +'</div>'
                                                +'<div class="col-sm-12 col-md-4 col-xl-4">'
                                                    +'<label for="">Ultimo cobro renovacion</label>'
                                                    +'<input type="number" name="precio_renov_ant" id="precio_renov_ant" class="form-control precio_renov_ant" onblur="calcRenov() value="0">'
                                                +'</div>'
                                                +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                                    +' <label for=""># de renovacion actual </label>'
                                                    +'<input type="number" name="renov" id="renov"onKeyPress="if(this.value.length==2) return false;"   class="form-control renov" onblur="calcRenov()">'
                                                +'</div>'
                                                +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                                    +'<label for="">Monto renovacion </label>'
                                                    +'<input type="number" name="monto_renov" id="monto_renov" class="form-control monto_renov" value="'+$('#store_monto_renovacion').val()+'">'
                                                    +'<input type="hidden" name="nro_renovaciones" id="nro_renovaciones" class="form-control nro_renovaciones" value="'+$('#store_nro_renovacion').val()+'">'
                                                    +'<input type="hidden" name="info" id="info" class="form-control info" value="'+info+'">'
                                                +'</div>'
                                                // +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                                //     +' <label for=""># Gestion/es Pagadas en renovacion </label>'
                                                //     +'<input type="text" name="gestion_renov" id="gestion_renov" class="form-control gestion_renov" placeholder="ejm: 2021,2022" >'
                                                // +'</div>'
                                                +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                                    + ' <div class="form-check">'
                                                    + '<input class="form-check-input" type="checkbox" value="" id="confirmar_ren">'
                                                    +' <label class="form-check-label" for="confirmar_ren">'
                                                    +  ' Agregar al listado de servicios solicitados'
                                                    +'</label>'
                                                    +' </div>'
                                                    // +' <label for="" class=>Solicitar </label>'
                                                    // +'<input type="checkbox" name="confirmar_ren" id="confirmar_ren" class="form-control confirmar_ren" >'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>'
                                                +'</div>';

                                    $('#contenedor_renov').append(html_renov);
                                    $('#ren').show();
                                    $('#renov_txt').val("SI");

                             //verificar el nro de renovacion que esta registrado en la base de datos
                             setValuesRenovacion();

               }

               function setValuesRenovacion()
               {
                $.ajax({
                                    type: 'POST',

                                    headers: {
                                        'Content-Type':'application/json',
                                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                    },
                                    url: "{{ route('get.nro.renov') }}",
                                    async: false,
                                    data: JSON.stringify({
                                        'nro_nicho':  $('#nro_nicho').val(),
                                        'bloque':  $('#bloque').val(),
                                        'fila':  $('#fila').val(),
                                        'cuartel':  $('#cuartel').val()
                                    }),
                                    success: function(data_response) {
                                        console.log("sql");
                                        console.log(data_response.status);
                                        if(data_response.status==true){
                                              //  consolidado();
                                                $('#btn_guardar_servicio').prop('disabled', true);
                                                if(!data_response.sql.renovacion  || data_response.sql.renovacion==null){
                                                     $('#renov_ant').val(0);
                                                     $('#precio_renov_ant').val(0);
                                                    }else{
                                                        $('#renov_ant').val(data_response.sql.renovacion);
                                                        $('#precio_renov_ant').val(data_response.sql.monto_renov);
                                                    }
                                                }
                                                else{
                                                    $('#renov_ant').val(0);
                                                     $('#precio_renov_ant').val(0);
                                                }

                                    },

                                    error: function (error) {
                                            $('#15224300').prop('checked', false);
                                            $('#serv-hijos-15224300').empty();
                                            Object.keys(error.responseJSON.errors).forEach(function(k){
                                            toastr["error"](error.responseJSON.errors[k]);
                                            });

                                    }
                         })
               }


               $(document).on('click', '#confirmar_ren', function(e){
                if ($('#confirmar_ren').is(':checked')) {
                    put_in_grid();
                }else{
                    $('.row_ren').remove();
                }

               });

                $(document).on('click', '#buscar', function() {
                    $('#contenido').hide();

                    $('.clear').val("");
                    $('.clear').html("");
                    $('.clean').val("");
                    $('.clean').html("");
                    $('.clears2').val(null).trigger('change');
                    $('#pag_con').val();
                    $('#sp').append('<i class="fa fa-spinner fa-spin"></i>');
                    $('#form').hide();
                    var bloque = $('#bloque').val();
                    var nicho = $('#nro_nicho').val();
                    var fila = $('#fila').val();
                    if ((bloque && nicho && fila) && bloque!="" && nicho!=""  && fila!=""  ) {
                        dats=  buscar_datos(bloque, nicho, fila);

                    }
                    else{
                        $('#sp').empty();
                        $('#bloque').val("");
                        $('#nro_nicho').val("");
                        $('#fila').val("");
                             Swal.fire(
                                     'Atencion!',
                                     'Debe introducir los datos a buscar.',
                                      'error'
                                    )
                                    return false
                    }

                });

        function buscar_datos(bloque, nicho, fila) {
             var datos = "";

                    $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Content-Type': 'application/json'
                            },
                            url: "{{ route('buscar.nicho') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: JSON.stringify({
                                "bloque": bloque,
                                "nicho": nicho,
                                "fila": fila
                            }),
                            success: function(data) {
                                if (data.mensaje) {
                                    $('#contenido').show();
                                        $('#sp').empty();
                                    console.log(data);
                                  // cargar campos del los forms
                                    $('#origen').val('tabla_nueva');
                                    //setear campos difuntos
                                   $('#cuartel').val(data.response.cuartel);
                                   $('#anterior').val(data.response.anterior);
                                   $('#tipo_nicho').val(data.response.tipo_nicho);

                                   if(data.response.estado_nicho=="LIBRE"){
                                            $('#search_dif').val();
                                        $('#ci_difunto_actual').val();
                                        $('#nombres_dif').val();
                                        $('#paterno_dif').val();
                                        $('#materno_dif').val();
                                        $('#fechanac_dif').val();
                                        $('#fechadef_dif').val();
                                        $('#causa').val();
                                        $('#sereci').val();
                                        $('#tipo_dif').val();
                                        $('#genero_dif').val();
                                   }
                                   else{
                                        $('#search_dif').val(data.response.ci_dif);
                                        $('#ci_difunto_actual').val(data.response.ci_dif);
                                        $('#nombres_dif').val(data.response.nombre_dif);
                                        $('#paterno_dif').val(data.response.primerap_dif);
                                        $('#materno_dif').val(data.response.segap_dif);
                                        $('#fechanac_dif').val(data.response.nacimiento_dif);
                                        $('#fechadef_dif').val(data.response.fecha_def_dif);
                                        $('#causa').val(data.response.causa_dif);
                                        $('#sereci').val(data.response.certificado_defuncion);
                                        $('#tipo_dif').val(data.response.tipo_dif);
                                        $('#genero_dif').val(data.response.genero_dif);
                                   }


                                    //setear campos responsable

                                   $('#search_resp').val(data.response.ci_resp);
                                   $('#nombres_resp').val(data.response.nombre_resp);
                                   $('#paterno_resp').val(data.response.paterno_resp);
                                   $('#materno_resp').val(data.response.segap_resp);
                                   $('#fechanac_resp').val(data.response.nacimiento_resp);
                                   $('#telefono').val(data.response.telefono);
                                   $('#celular').val(data.response.celular);
                                //    $('#ecivil').val(data.response.ecivil_resp);
                                //    $('#email').val(data.response.email_resp);
                                //    $('#domicilio').val(data.response.domicilio_resp);
                                   $('#genero_resp').val(data.response.genero_resp);
                                   $('#tiemp').html(data.response.tiempo);
                                   $('#comprob').html(data.response.fur);
                                   $('#razon').html(data.response.razon);
                                   $('#monto_pagos').html(data.response.monto);
                                   $('#pago_cont').html(data.response.fecha_pago);
                                   $('#fecha_p').html(data.response.fecha_pago);

                                   $('#fecha_liberacion').html(data.response.fecha_liberacion);
                                   $('#fecha_adjudicacion').html(data.response.fecha_adjudicacion);
                                   $('#concepto').html(data.response.servicios);
                                   $('#store_monto_renovacion').val(data.response.monto_renovacion);
                                   $('#store_nro_renovacion').val(data.response.nro_renovacion);

                                   $('#estado_actual_nicho').html(data.response.estado_nicho);
                                     autocompletar();
                                     completarInfoNicho();



                                }
                                else{
                                    $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                                    'Content-Type': 'application/json'
                                                },
                                                url:  "{{ env('URL_MULTISERVICE') }}/api/v1/cementerio/get-data",
                                                method: 'POST',
                                                dataType: 'json',
                                                data: JSON.stringify({
                                                    "bloque": bloque,
                                                    "nicho": nicho,
                                                    "fila": fila
                                                }),
                                                success: function(data) {
                                                    $('#sp').empty();
                                                    $('#form').show();
                                                    $('#contenido').show();
                                                    $('#origen').val('tabla_antigua');
                                                    if(data.response.datos_difuntos!="")
                                                        {
                                                             // datos difunto
                                                            if(data.response.datos_difuntos !="")
                                                            {
                                                                var fecha=data.response.datos_difuntos[0].fecha;
                                                                    var año= fecha.substr(0, 4);
                                                                    var mes= fecha.substr(4, 2);
                                                                    var dia= fecha.substr(6, 2);
                                                                    var nuevaf=año+"-"+mes+"-"+dia;

                                                                    $('#pag_con').val(data.response.datos_difuntos[0].pag_con);
                                                                    $('#causa').val(data.response.datos_difuntos[0].causa_fall);
                                                                    $('#nombres_dif').val(data.response.datos_difuntos[0].difunto);
                                                                    if(data.response.datos_difuntos[0].tiempo  !=""){
                                                                        $('#tiemp').html(data.response.datos_difuntos[0].tiempo);
                                                                        $('#tiempo').val(data.response.datos_difuntos[0].tiempo);
                                                                        $('#tipo_nicho').val('TEMPORAL');
                                                                        calcularPlazo(data.response.datos_difuntos[0].tiempo , año,nuevaf );

                                                                    } else{
                                                                        $('#tipo_nicho').val('PERPETUO');
                                                                    }

                                                                    $('#pago_cont').html(data.response.datos_difuntos[0].pag_con);
                                                                    $('#pago_cont_ant').html(data.response.datos_difuntos[0].pag_con);
                                                                    $('#fechadef_dif').val(nuevaf);

                                                                    var genero="";

                                                                        if (data.response.datos_difuntos[0].sexo == "M") {
                                                                            genero = "MASCULINO";
                                                                        } else {
                                                                        genero = "FEMENINO";
                                                                        }
                                                                        $('#genero_dif').val(genero);

                                                            }
                                                             // datos responsable
                                                                    if(data.response.responsable!=""){
                                                                            $('#search_resp').val(data.response.responsable[0].carnet);
                                                                            $('#telefono').val(data.response.responsable[0].telef);
                                                                            $('#domicilio').val(data.response.responsable[0].direccion);
                                                                            $('#nombres_resp').val(data.response.responsable[0].razon);
                                                                    }
                                                                    if(data.response.pagos!="")
                                                                    {
                                                                        $('#razon').html(data.response.pagos[0].razon);
                                                                        $('#comprob').html(data.response.pagos[0].comprob);
                                                                        $('#concepto').html(data.response.pagos[0].concepto);
                                                                        $('#gestiones').html(data.response.pagos[0].gestiones);
                                                                        $('#monto_pagos').html(data.response.pagos[0].monto);

                                                                            if(data.response.pagos[0].fecha){
                                                                                var ult=data.response.pagos[0].fecha;
                                                                                var ultaño= fecha.substr(0, 4);
                                                                                var ultmes= fecha.substr(4, 2);
                                                                                var ultdia= fecha.substr(6, 2);
                                                                                var ultimof=ultaño+"-"+ultmes+"-"+ultdia;
                                                                                $('#fecha_p').html(ultimof);
                                                                            }
                                                                    }
                                                        } else{
                                                            $('#sp').empty();
                                                                Swal.fire(
                                                                        'Busqueda finalizada!',
                                                                        'El registro no ha  sido encontrado o no existe .',
                                                                        'error'
                                                                        )

                                                                    $('.clear').val("");
                                                                    $('#form').hide();
                                                            }
                                                            autocompletar();
                                                            completarInfoNicho();

                                                }

                                    });
                                }
                            }
                    });
        }
        // calcularPlazo nicho
        function calcularPlazo(tiempo, año, nfecha){
           let plazo=0;
           plazo=parseInt(año)+parseInt(tiempo);
           var fecha = new Date();
	       var year = fecha.getFullYear();

            if(plazo<year){
                var vencimiento= fechaVencimiento(nfecha, tiempo);

                $('#infoPlazo').html('El plazo del enterratorio venció el año '+ plazo +' en fecha '+ vencimiento+'');
                $('.infoPlazo').show();
                $('#vencido').val(vencimiento);
                         swal.fire({
                                    title: "Notificación!",
                                    text: "!El plazo del enterratorio venció el año "+ plazo +" en fecha "+vencimiento +"!",
                                    type: "warning",
                                  //  timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: true
                                    });
                                    setTimeout(function() {
                                       return false;
                                    }, 2000);
            }
            else if(plazo==year){
                var vencimiento= fechaVencimiento(nfecha, tiempo);

                $('#infoPlazo').html('El plazo del enterratorio vence el '+ vencimiento +'');
                $('.infoPlazo').show();

               // var venc= parseInt(fecha)-parseInt(nfecha);

                $('#vencido').val(vencimiento);
                         swal.fire({
                                    title: "Notificación!",
                                    text: "!El plazo del enterratorio vence el " + vencimiento +"!",
                                    type: "warning",
                                  //  timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: true
                                    });
                                    setTimeout(function() {
                                       return false;
                                    }, 2000);
            }
            else{
                var vencimiento= fechaVencimiento(nfecha, tiempo);
                $('#vencido').val(vencimiento);
                nplazo=parseInt(year)-parseInt(plazo);


                $('#infoPlazo').html('Quedan '+ nplazo +' años de plazo del enterratorio, la fecha de vencimiento es '+ vencimiento + '');
                $('.infoPlazo').show();
                swal.fire({
                                    title: "Notificación!",
                                    text: "!El plazo del enterratorio vence el "+ plazo + " la fecha de vencimiento es " + vencimiento + "!",
                                    type: "warning",
                                  //  timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: true
                                    });
                                    setTimeout(function() {
                                       return false;
                                    }, 2000);
            }
        }

        $(document).on('click', '#pago_tercero', function(){
            if ($('#pago_tercero').is(':checked')) {
                $('#pago_tercero').val("tercero");
                $('#section_pago_tercero').show();
            }
            else{
                $('#pago_tercero').val("responsable");
                $('#section_pago_tercero').hide();

            }
        });

        $(document).on('click','#btn_guardar_servicio', function(){
                makeArrayServices();
                validarInfoEnviada();
                if ($('#servicio_externo').is(":checked")){
                    registrarServicioExterno();
                 }
                 else{
                    return  $.ajax({
                               type: 'POST',
                               headers: {
                                   'Content-Type':'application/json',
                                   'X-CSRF-TOKEN':'{{ csrf_token() }}',
                               },
                               url: "{{ route('new.servicio') }}",
                               async: false,
                               data: JSON.stringify({

                                   'nro_nicho': $('#nro_nicho').val(),
                                   'bloque':  $('#bloque').val(),
                                   'cuartel':  $('#cuartel').val(),
                                   'fila':  $('#fila').val(),
                                   'tipo_nicho':  $('#tipo_nicho').val(),
                                   'columna':  $('#columna').val(),
                                   'anterior':  $('#anterior').val(),
                                   'ci_dif':  $('#search_dif').val(),
                                   'nombres_dif':  $('#nombres_dif').val(),
                                   'paterno_dif':  $('#paterno_dif').val(),
                                   'materno_dif':  $('#materno_dif').val(),
                                   'fechanac_dif':  $('#fechanac_dif').val(),
                                   'fecha_def_dif':  $('#fechadef_dif').val(),
                                   'causa':  $('#causa').val(),
                                //    'ecivil_dif':  $('#ecivil_dif').val(),
                                   'tipo_dif':  $('#tipo_dif').val(),
                                   'genero_dif':  $('#genero_dif').val(),
                                   'ci_resp':  $('#search_resp').val(),
                                   'nombres_resp':  $('#nombres_resp').val(),
                                   'paterno_resp':  $('#paterno_resp').val(),
                                   'materno_resp':  $('#materno_resp').val(),
                                   'fechanac_resp':  $('#fechanac_resp').val(),
                                   'telefono':  $('#telefono').val(),
                                   'celular':  $('#celular').val(),
                                //    'ecivil':  $('#ecivil').val(),
                                //    'email':  $('#email').val(),
                                //    'domicilio':  $('#domicilio').val(),
                                   'genero_resp':  $('#genero_resp').val(),
                                   'pag_con':  $('#pag_con').val(),
                                   'tiempo':  $('#tiempo').val(),
                                   'name_pago':$('#name_pago').val(),
                                   'paterno_pago':$('#paterno_pago').val(),
                                   'materno_pago':$('#materno_pago').val(),
                                   'ci_pago':$('#ci_pago').val(),
                                   'pago_por':$('#pago_tercero').val(),
                                   'descripcion_exhumacion':$('#det_exhumacion').val(),
                                   'observacion':$('#observacion').val(),
                                   'servicios_adquiridos':servicios_adquiridos,
                                   'monto':$('#totalServ').html(),
                                   'monto_renov':  $('#monto_renov').val(),
                                //    'gestion_renov':  $('#gestion_renov').val(),
                                   'nro_renovacion':$('#renov').val(),
                                   'sereci':$('#sereci').val(),
                                   'gratis':$('#gratis').val(),
                                   'add_difunto':$('#add_difunto').val(),

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
                                    //    location.reload();
                                    window.location.href = "/servicios/servicios"
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
                                           title: "Registro Duplicado!",
                                           text: "!Transacción rechazada!",
                                           type: "error",
                                           timer: 2000,
                                           showCancelButton: false,
                                           showConfirmButton: false
                                           });
                                           setTimeout(function() {
                                               location.reload();
                                            // window.location.href =  "{{URL::to('serv')}} " //"{{ route('serv') }}";

                                           }, 2000);
                                   }

                               }
                           })
                 }

               });



                    $(document).on('blur', '#renov_ant', function(){
                        // Renov();
                        calcRenov();

                    })

                    $(document).on('blur', '#renov', function(){
                        // Renov();
                        calcRenov();

                    })


                function calcRenov()
                {
                    $('#monto_renov').val(0);
                    var precio_sinot=$('#precio_renov').val(); //precio devuelto por el servicio del sinot
                    var precio_ant=$('#precio_renov_ant').val();
                    var cuota_ant=$('#precio_renov_ant').val();
                  //  var cuota=$('#precio_renov_ant').val();
                    var cuota1=$('#precio_renov').val();
                    var acum=0;
                    var adicion=0;
                    var ncuota=$('#precio_renov_ant').val();
                    var nro_renov_ant=$('#renov_ant').val();
                    var nro_renov_act=$('#renov').val();
                    var nro_iteraciones=Math.abs(nro_renov_act-nro_renov_ant);
                        $('#nro_renovaciones').val(nro_iteraciones);
                        var porcentaje=20;

                    for(var i=nro_renov_ant ; i<nro_renov_act; i++){
                        if(cuota_ant==0 && i==0){
                            porcentaje=0;
                            adicion= precio_sinot*porcentaje/100;
                            cuota=  parseFloat(precio_sinot) + parseFloat(adicion);
                            ncuota=cuota;
                        }else{
                           porcentaje=20;
                           adicion=ncuota*porcentaje/100;
                           cuota=  parseFloat(ncuota) + parseFloat(adicion);
                           ncuota=cuota;
                        }
                        acum=parseFloat(acum)+ parseFloat(cuota);
                        console.log("cuota"+i+"="+cuota);
                        console.log("acum"+i+"="+acum);
                        acum=acum.toFixed(2);

                        // if(i==0){
                        //     cuota=cuota_ant;
                        //     cuota_ant=cuota_ant;
                        // }
                        // else{


                      //  }



                    }

                    $('#monto_renov').val(acum);

                    $('#pu_15224300').html(acum);
                   // consolidado();
                    //   put_in_grid();
                    $('#btn_guardar_servicio').prop('disabled', false);


                }



        // aporte george
        $(document).on('click', '#buscarDifunto', function() {

        var ci = $('#search_dif').val();
            console.log("sadasdadasd");
        //var ci ="52525252";
        if(ci.length<1)
        {
            //alert("el campo Ci esta vacio");
            Swal.fire(
                                            'Busqueda finalizada!',
                                            'El campo C.I. esta vacio .',
                                            'warning'
                                            )
        }
        else{
        var type ="deceased";
        dats=  buscar_ci(ci,type);
            // console.log("entra a estooooooooooooo"+dats);
        }

        });
        $(document).on('click', '#buscarResp', function() {
        var ci = $('#search_resp').val();
        console.log("esta es el carnet del gus:"+ ci);
        //var ci ="52525252";
        if(ci.length<1)
        {
            //alert("el campo Ci esta vacio");
            Swal.fire(
                                            'Busqueda finalizada!',
                                            'El campo C.I. esta vacio .',
                                            'warning'
                                            )

        }
        else{
        var type ="responsable";
        dats=  buscar_ci_resp(ci,type);
            // console.log("entra a esteeeeeeeeeeeeeeeee"+dats);
        }

        });
        function buscar_ci(ci,type)
        {
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
                    if(data.response==null)
                    {
                        //alert("El CI ingresado no esta registrado");
                        Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                                )
                    }
                    else{
                // console.log("si entro a esta madre"+ data.response.fecha_nacimiento);
                    $('#nombres_dif').val(data.response.nombres);
                    $('#paterno_dif').val(data.response.primer_apellido);
                    $('#materno_dif').val(data.response.segundo_apellido);
                    $('#fechanac_dif').val(data.response.fecha_nacimiento);
                    $('#fechadef_dif').val(data.response.fecha_defuncion);
                    $('#tipo_dif').val(data.response.tipo);
                    $('#sereci').val(data.response.certificado_defuncion);
                    $('#causa').val(data.response.causa);
                    $('#genero_dif').val(data.response.genero);
                    $("#difunto_search").val(data.response.id);
                    //$('#ecivil_dif').val(data.response.estado_civil);
                    }
                },
                error : function(xhr, status) {
                    //alert('Disculpe, existió un problema');
                    Swal.fire(
                        'Busqueda finalizada!',
                        'El registro no ha  sido encontrado o no existe .',
                        'error'
                    )
                },
                // complete : function(xhr, status) {
                //     alert('Petición realizada');
                // }

            });
            // return datos;
        }
        function buscar_ci_resp(ci,type)
        {
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
                    if(data.response==null)
                    {
                        Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                                )
                    }
                    else{
                    console.log("si entro a esta chingada"+ data.response.fecha_nacimiento);
                    $('#nombres_resp').val(data.response.nombres);
                    $('#paterno_resp').val(data.response.primer_apellido);
                    $('#materno_resp').val(data.response.segundo_apellido);
                    $('#fechanac_resp').val(data.response.fecha_nacimiento);
                    $('#telefono_resp').val(data.response.telefono);
                    $('#cellular_resp').val(data.response.celular);
                    $('#ecivil_resp').val(data.response.estado_civil);
                    $('#email_resp').val(data.response.email);
                    $('#domicilio_resp').val(data.response.domicilio);
                    $('#genero_resp').val(data.response.genero);
                    $("#responsable_search").val(data.response.id);
                    //$('#ecivil_dif').val(data.response.estado_civil);
                    }
                },
                error : function(xhr, status) {
                // alert('Disculpe, existió un problema');
                    Swal.fire(
                                'Busqueda finalizada!',
                                'El registro no ha  sido encontrado o no existe .',
                                'error'
                                )
                },
                // complete : function(xhr, status) {
                //     alert('Petición realizada');
                // }

            });
            // return datos;
        }
        // calcular fecha vencimiento
        function fechaVencimiento(fecha, tiempo)
            {
                var d = new Date(fecha);
                var strDate = parseInt(d.getFullYear())+parseInt(tiempo);
                var strDate =strDate + "/" + (d.getMonth()+1) + "/" + (d.getDate()+1);

                 console.log(strDate);
                 return strDate;
            }


            // completar.info-nicho
            function completarInfoNicho(){
                var datos="";
                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content'),
                                        'Content-Type': 'application/json'
                                    },
                                    url: "{{route('completar.info.nicho')}}",
                                    method: 'POST',
                                    dataType: 'json',
                                    data: JSON.stringify({
                                        "bloque": $('#bloque').val(),
                                        "nicho": $('#nro_nicho').val(),
                                        "fila": $('#fila').val()
                                    }),
                                    success: function(data)
                                    {


                                            if(data.info!=null)
                                            {
                                                $('#cuartel').val(data.info.codigo);
                                                $('#anterior').val(data.info.codigo_anterior);

                                            }

                                    }

                     });
                   return false;
            }


            function autocompletar(){
                var datos="";
                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content'),
                                        'Content-Type': 'application/json'
                                    },
                                    url: "{{route('completar.datos')}}",
                                    method: 'POST',
                                    dataType: 'json',
                                    data: JSON.stringify({
                                        "bloque": $('#bloque').val(),
                                        "nicho": $('#nro_nicho').val(),
                                        "fila": $('#fila').val()
                                    }),
                                    success: function(data)
                                    {
                                        console.log("autocompletar");
                                      console.log(data);
                                          // data difunto
                                        //   alert(data['response'].fecha_adjudicacion);
                                        //   var adj=(data['response'].fecha_adjudicacion).split(" ");
                                        //   var f_adj=adj[0];
                                        //   alert(f_adj);
                                            if(data.response!=null)
                                            {
                                                if(data.response.estado_nicho=="LIBRE"){
                                                                $('#search_dif').val();
                                                            $('#ci_difunto_actual').val();
                                                            $('#nombres_dif').val();
                                                            $('#paterno_dif').val();
                                                            $('#materno_dif').val();
                                                            $('#fechanac_dif').val();
                                                            $('#fechadef_dif').val();
                                                            $('#causa').val();
                                                            $('#sereci').val();
                                                            $('#tipo_dif').val();
                                                            $('#genero_dif').val();
                                                    }else{
                                                        $('#search_dif').val(data['response'].ci_dif);
                                                        $('#nombres_dif').val(data['response'].nombre_dif);
                                                        $('#paterno_dif').val(data['response'].primerap_dif);
                                                        $('#materno_dif').val(data['response'].segap_dif);
                                                        $('#fechanac_dif').val(data['response'].nacimiento_dif);
                                                        $('#fecha_def_dif').val(data['response'].fecha_defuncion);
                                                        $('#fechadef_dif').val(data['response'].fecha_defuncion);
                                                        $('#tipo_dif').val(data['response'].tipo_dif);
                                                        $('#genero_dif').val(data['response'].genero_dif);
                                                        $('#tiempo').val(data['response'].tiempo);
                                                        $('#sereci').val(data['response'].certificado_defuncion);
                                                        $('#funeraria').val(data['response'].funeraria).trigger('change');
                                                        $('#causa').val(data['response'].causa_dif).trigger('change');
                                                    }

                                                // data responsable
                                                $('#search_resp').val(data['response'].ci_resp);
                                                $('#nombres_resp').val(data['response'].nombre_resp);
                                                $('#paterno_resp').val(data['response'].paterno_resp);
                                                $('#materno_resp').val(data['response'].segap_resp);
                                                $('#fechanac_resp').val(data.response.nacimiento_resp);
                                                $('#telefono').val(data['response'].telefono);
                                                $('#celular').val(data['response'].celular);
                                                $('#genero_resp').val(data['response'].genero_resp);
                                                $('#domicilio').val(data['response'].domicilio_resp);
                                            }

                                    }

                     });
                   return false;
            }

            function validarInfoEnviada(){
            //   if($('#fechanac_resp').val() =="" || !$('#fechanac_resp').val()){
            //     swal.fire({
            //                         title: "Precaucion!",
            //                         text: "!Complete la fecha de nacimiento de la sección del responsable",
            //                         type: "warning",
            //                       //  timer: 2000,
            //                         showCancelButton: false,
            //                         showConfirmButton: true
            //                         });
            //                         setTimeout(function() {
            //                            return false;
            //                         }, 2000);
            //   }

              if($('#fechadef_dif').val() =="" || !$('#fechadef_dif').val()){
                swal.fire({
                                    title: "Precaucion!",
                                    text: "!Complete la fecha de defuncion de la sección del difunto",
                                    type: "warning",
                                  //  timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: true
                                    });
                                    setTimeout(function() {
                                       return false;
                                    }, 2000);
              }

            //   if($('#fechanac_dif').val() =="" || !$('#fechanac_dif').val()){
            //     swal.fire({
            //                         title: "Precaucion!",
            //                         text: "!Complete la fecha de nacimiento de la sección del difunto",
            //                         type: "warning",
            //                       //  timer: 2000,
            //                         showCancelButton: false,
            //                         showConfirmButton: true
            //                         });
            //                         setTimeout(function() {
            //                            return false;
            //                         }, 2000);
            //   }

            //   if($('#domicilio').val() =="" || !$('#domicilio').val()){
            //     swal.fire({
            //                         title: "Precaucion!",
            //                         text: "!Complete los datos del domicilio del responsable, si es desconocido introduzca 'NO DEFINIDO' ",
            //                         type: "warning",
            //                       //  timer: 2000,
            //                         showCancelButton: false,
            //                         showConfirmButton: true
            //                         });
            //                         setTimeout(function() {
            //                            return false;
            //                         }, 2000);
            //   }
            }
            $("#causa").select2({
                    width: 'resolve', // need to override the changed default
                    // dropdownParent: $('#modal_add_difunto'),
                    tags: true,
                    allowClear: true
                  });


                  /**********************************************************************************************************/
                  /***************************************SERVICIOS EXTERNOS ************************************************/
                  /**********************************************************************************************************/

                  $(document).on('click', '#servicio_externo',function(){

                        if ($('#servicio_externo').is(":checked")){
                             $('#contenido').show();
                             $('.busquedaNichos').hide();
                             $('.complementoBusqueda').hide();
                             $('.nuevo_difunto').hide();
                         }
                         else{
                             $('#contenido').hide();
                             $('.busquedaNichos').show();
                             $('.complementoBusqueda').show();
                             $('.nuevo_difunto').show();
                         }
                  });

                function registrarServicioExterno(){
                    return  $.ajax({
                               type: 'POST',
                               headers: {
                                   'Content-Type':'application/json',
                                   'X-CSRF-TOKEN':'{{ csrf_token() }}',
                               },
                               url: "{{ route('new.servicio.externo') }}",
                               async: false,
                               data: JSON.stringify({


                                   'tipo_nicho':  $('#tipo_nicho').val(),
                                    'ci_dif':  $('#search_dif').val(),
                                   'nombres_dif':  $('#nombres_dif').val(),
                                   'paterno_dif':  $('#paterno_dif').val(),
                                   'materno_dif':  $('#materno_dif').val(),
                                   'fechanac_dif':  $('#fechanac_dif').val(),
                                   'fecha_def_dif':  $('#fechadef_dif').val(),
                                   'causa':  $('#causa').val(),
                                //    'ecivil_dif':  $('#ecivil_dif').val(),
                                   'tipo_dif':  $('#tipo_dif').val(),
                                   'genero_dif':  $('#genero_dif').val(),
                                   'ci_resp':  $('#search_resp').val(),
                                   'nombres_resp':  $('#nombres_resp').val(),
                                   'paterno_resp':  $('#paterno_resp').val(),
                                   'materno_resp':  $('#materno_resp').val(),
                                   'fechanac_resp':  $('#fechanac_resp').val(),
                                   'telefono':  $('#telefono').val(),
                                   'celular':  $('#celular').val(),
                                //    'ecivil':  $('#ecivil').val(),
                                //    'email':  $('#email').val(),
                                //    'domicilio':  $('#domicilio').val(),
                                   'genero_resp':  $('#genero_resp').val(),
                                   'pag_con':  $('#pag_con').val(),
                                   'tiempo':  $('#tiempo').val(),
                                   'name_pago':$('#name_pago').val(),
                                   'paterno_pago':$('#paterno_pago').val(),
                                   'materno_pago':$('#materno_pago').val(),
                                   'ci_pago':$('#ci_pago').val(),
                                   'pago_por':$('#pago_tercero').val(),
                                   'descripcion_exhumacion':$('#det_exhumacion').val(),
                                   'observacion':$('#observacion').val(),
                                   'servicios_adquiridos':servicios_adquiridos,
                                   'monto':$('#totalServ').html(),
                                   'monto_renov':  $('#monto_renov').val(),
                                //    'gestion_renov':  $('#gestion_renov').val(),
                                   'nro_renovacion':$('#renov').val(),
                                   'sereci':$('#sereci').val(),
                                   'gratis':$('#gratis').val(),
                                   'add_difunto':$('#add_difunto').val(),

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
                                    //    location.reload();
                                    window.location.href = "/servicios/servicios"
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
                                           title: "Registro Duplicado!",
                                           text: "!Transacción rechazada!",
                                           type: "error",
                                           timer: 2000,
                                           showCancelButton: false,
                                           showConfirmButton: false
                                           });
                                           setTimeout(function() {
                                               location.reload();
                                            // window.location.href =  "{{URL::to('serv')}} " //"{{ route('serv') }}";

                                           }, 2000);
                                   }

                               }
                           })
                  }

    </script>

    @stop

@extends('adminlte::page')
@section('title', 'Register Informacion')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)
@section('plugins.dropzone', true)

@section('content_header')
    <h1>FORMULARIO RELEVAMIENTO</h1>
@stop

@section('content')



    <div class="modal-body">
        <div class="col-sm-12 col-md-12 col-xl-12 card m-auto">

            <div class="card">
                <div class="card-header">
                    <h2 id="infoPlazo" class="clean"></h2>
                </div>
            </div>

           

        <div class="col-12 interno" >   
            {{-- datos busqueda --}}

            <div class="card">
                <div class="card-header">
                    <h4>BUSCAR REGISTRO</h4>
                </div>
                <div class="card-body">
                    <div class="row">


                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>BLOQUE</label>
                            <input style="text-transform:uppercase;"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control "
                                id="bloque" autocomplete="off" maxlength="3">
                        </div>
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>NRO NICHO</label>
                            <input style="text-transform:uppercase;"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control "
                                id="nro_nicho" autocomplete="off" maxlength="5">
                        </div>
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>FILA</label>
                            <input style="text-transform:uppercase;"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control "
                                id="fila" autocomplete="off" maxlength="2">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3 p-4 mt-2">
                            <button type="button" class="btn btn-info" id="buscar" disabled>
                                <span id="sp"></span> <i class="fa fa-search"></i>BUSCAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>

           
                <div class="card">
                    <div class="row">
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Cuartel</label>
                            <input style="text-transform:uppercase;"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                class="form-control clear" id="cuartel" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Codigo antiguo</label>
                            <input style="text-transform:uppercase;"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                class="form-control clear" id="anterior" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Tipo nicho</label>
                            <select name="tipo_nicho" id="tipo_nicho" class="form-control">
                                <option value="">SELECCIONAR</option>
                                <option value="TEMPORAL">TEMPORAL</option>
                                <option value="PERPETUO">PERPETUO</option>
                            </select>
                        </div>

                    </div>
                </div>
             </div>
            <div id="contenido">
                {{-- datos difunto --}}
                <div class="card ">
                    <div class="card-header">
                        <h4>DATOS DIFUNTOS</h4>
                        <button type="button" name="addDif" id="addDif" style="display: none"><i class="fas fa-user-plus"> Adicionar difunto</i></button>
                    </div>
                    <div class="card-body difunto" id="difunto0">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Carnet de Identidad</label>
                                <div class="input-group input-group-lg">
                                    <input style="text-transform:uppercase;"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();" type="search"
                                        class="form-control clear" id="search_dif" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default" id="buscarDifunto">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-lg btn-default" id="generarcidif"
                                            title="generar carnet provisional">

                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <input type="hidden" name="difunto_search" id="difunto_search">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Nombres</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear soloLetras" id="nombres_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Primer apellido</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear soloLetras" id="paterno_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Segundo apellido</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear soloLetras" id="materno_dif" autocomplete="off">
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Nacimiento</label>
                                <input type="date"
                                    class="form-control clear" id="fechanac_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Ingreso al nicho</label>
                                <input type="date"
                                    class="form-control clear" id="fechadef_dif" autocomplete="off">
                            </div>

                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Causa</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear" id="causa" autocomplete="off">
                            </div> --}}
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Causa</label>
                                <select id="causa" style="text-transform:uppercase; width: 100%"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                class="form-control select2-multiple select2-hidden-accessible">
                                <option value="">SELECIONAR CAUSA FALLECIMIENTO</option>
                                @foreach ($causa as $causa)                                  
                                        <option value="{{ $causa->causa }}">{{$causa->causa }}</option>                                   
                                @endforeach
                            </select>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>SERECI</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear" id="sereci" autocomplete="off">

                            </div>
                        </div>


                        <div class="row">

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Tipo Difunto</label>
                                <select name="tipo_dif" id="tipo_dif" class="form-control">
                                    <option value="">SELECIONAR</option>
                                    <option value="ADULTO">ADULTO</option>
                                    <option value="PARVULO">PARVULO</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Genero</label>
                                <select name="genero" id="genero_dif" class="form-control">
                                    <option value="">SELECIONAR</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Funeraria</label>
                                <select id="funeraria" style="text-transform:uppercase; width: 100%"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                class="form-control select2-multiple select2-hidden-accessible">
                                <option value="">SELECIONAR FUNERARIA</option>
                                @foreach ($funeraria as $fun)                                  
                                        <option value="{{ $fun->funeraria }}">{{$fun->funeraria }}</option>                                   
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Tiempo</label>
                                <select name="tiempo" id="tiempo" class="form-control">
                                    <option value="2">2</option>
                                    <option value="5">5</option>
                                   
                                </select>
                               
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Nro de renovacion</label>
                                <input type="number" name="nro_renovacion" id="nro_renovacion" class="form-control">
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Ultimo importe pagado</label>
                                <input type="text" name="monto_ultima_renov" id="monto_ultima_renov" class="form-control">
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-6">
                                <label>Gestion en la que se realizo el pago del renovatorio</label>
                                <input type="number" name="gestion_renov" id="gestion_renov" class="form-control">
                            </div>
                        </div>


                    
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xl-12">
                                    <div class="col-sm-12">
                                        <label for=""> Certificado de defunción</label>
                                        <div id="cert-defuncion" class="dropzone" style="text-align: center">
                                        </div>
                                            <hr>    
                                            <input type="hidden" id="url-certification">                           
                                    </div>
                                </div>
                            </div>
                   </div>
                </div>
                {{-- datos responsables --}}
                <div class="card">
                    <div class="card-header">
                        <h4>DATOS RESPONSABLE</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Carnet de Identidad</label>
                                <div class="input-group input-group-lg">
                                    <input style="text-transform:uppercase;"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();" type="search"
                                        class="form-control" id="search_resp" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default" id="buscarResp">
                                            <i class="fa fa-search"></i>
                                        </button>

                                        {{-- <button type="button" class="btn btn-lg btn-default" id="generarciresp"
                                            title="generar carnet provisional">

                                            <i class="fa fa-pen"></i>
                                        </button> --}}

                                        <input type="hidden" name="responable_search" id="responsable_search">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Nombres</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear soloLetras" id="nombres_resp" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Primer apellido</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear soloLetras" id="paterno_resp" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Segundo apellido</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear soloLetras" id="materno_resp" autocomplete="off">
                            </div>

                        </div>


                        <div class="row">

                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Nacimiento</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="date"
                                    class="form-control" id="fechanac_resp" autocomplete="off">
                            </div> --}}

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Teléfono</label>
                                {{-- <input type="number" class="form-control" id="telefono" autocomplete="off" maxlength="7"> --}}
                                <input name="telefono" id="telefono"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="7" class="form-control" />
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Celular</label>
                                <input name="celular" id="celular"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="8" class="form-control" />
                            </div>

                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>Genero</label>
                                <select name="genero_resp" id="genero_resp" class="form-control">
                                    <option value="">SELECCIONAR</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                </select>
                            </div>

                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Estado civil</label>
                                <select name="ecivil" id="ecivil" class="form-control">
                                    <option value="">SELECCIONAR</option>
                                    <option value="CASADO">CASADO</option>
                                    <option value="CONCUBINADO">CONCUBINADO</option>
                                    <option value="DIVORCIADO">DIVORCIADO</option>
                                    <option value="SOLTERO">SOLTERO</option>
                                    <option value="VIUDO">VIUDO</option>
                                </select>
                            </div> --}}
                        </div>


                           {{-- <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>E-mail</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="email" size="50"
                                    class="form-control" id="email" autocomplete="off">
                            </div> --}}


                            <div class="col-sm-12 col-md-12 col-xl-12">
                                <label>Domicilio</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control" id="domicilio" autocomplete="off">
                            </div>
                           
                        </div>
                    </div>
                </div>

                <input type="hidden" name="origen" id="origen">
                <input type="hidden" name="pag_con" id="pag_con" value="">
               
                <input type="hidden" name="vencido" id="vencido">
                <input type="hidden" name="aniosdeuda" id="aniosdeuda">
                <input type="hidden" name="cant_cuerpos" id="cant_cuerpos" value="0">



                {{-- <div class="card interno">
                    <div class="card-header">
                        <h4>INFORMACION ULTIMO PAGO</h4>
                    </div>

                    <div class="card-body">
                        <div class="row pb-2">
                            <div class="col-sm-12 col-md-4 col-xl-4">
                                Razon: <span id="razon" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Comprobante: <span id="comprob" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Tiempo: <span id="tiemp" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Ultimo Pago: <span id="pago_cont" class="clear"></span>
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Cantidad de cuerpos: <span id="cuerpos" class="clear"></span>
                            </div>
                        </div>

                        <div class="row pb-2">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Concepto: <span id="concepto" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Fecha: <span id="fecha_p" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Gestiones: <span id="gestiones" class="clear"></span>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                Monto: <span id="monto_pagos" class="clear"></span>
                            </div>
                        </div>
                    </div>
                </div> --}}

              
               

               
            

                    <div class="col-sm-12" style="text-align: center" id="print">
                        <button type="button" id="btn_guardar_pago" class="btn btn-success">Registrar Datos</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="cancelar">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @stop
    @section('css')
   
        <style>
             .dropzone .dz-preview .dz-error-message {
                  top: 150px!important;
            }
            .select2-selection__rendered {
                color: #333232;
            }

            .select2-results__option--selected {
                background-color: #175603 !important;
            }

        </style>
  

@stop

    @section('js')
        <script>
            $(document).ready(function() {
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


    //busqueda

                $(document).on('keyup', '#bloque', function() {
                    habilitarBusqueda();
                });

                $(document).on('keyup', '#fila', function() {
                    habilitarBusqueda();
                });
                $(document).on('keyup', '#nro_nicho', function() {
                    habilitarBusqueda();
                });

                function habilitarBusqueda() {
                    if ($('#bloque').val() == "" || $('#nro_nicho').val() == "" || $('#fila').val() == "") {
                        $('#buscar').prop('disabled', true);
                    } else if ($('#bloque').val() != "" || $('#nro_nicho').val() != "" || $('#fila').val() != "") {
                        $('#buscar').prop('disabled', false);
                    }

                }

              


                function calcularPrice() {
                    var acum = 0;
                    $('#totalServ').html(0);
                    $('#totalservicios').val(0)
                    $('.costo').each(function(index) {
                        acum = parseFloat(acum) + parseFloat($(this).val());
                    });
                    $('#totalServ').html(acum);
                    $('#totalservicios').val(acum)
                    consolidado();

                }





                $(document).on('click', '#buscar', function() {
                    $('.clear').val("");
                    $('.clear').html("");
                    $('.clean').val("");
                    $('.clean').html("");
                    $('#pag_con').val();
                  
                    $('#sp').append('<i class="fa fa-spinner fa-spin"></i>');
                 
                    var bloque = $('#bloque').val();
                    var nicho = $('#nro_nicho').val();
                    var fila = $('#fila').val();
                  

                    cuartel = buscarCuartel(bloque, nicho, fila);
                    console.log(bloque);
                    console.log(nicho);
                    console.log(fila);
                    if (bloque && nicho && fila) {
                        dats = buscar_datos(bloque, nicho, fila);
                    }
                    bloque = $('#bloque').prop('readonly',true);
                     nicho = $('#nro_nicho').prop('readonly',true);
                     fila = $('#fila').prop('readonly',true);
                     $('#buscar').prop('disabled' , true);
                });



                function buscar_datos(bloque, nicho, fila) {
                    var datos = "";
                    $('#contenido').show();

                 

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        },
                        url: "{{ route('buscar.nicho.rel') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: JSON.stringify({
                            "bloque": bloque,
                            "nicho": nicho,
                            "fila": fila
                        }),
                        success: function(data) {

                            if (data.mensaje) {
                                $('#sp').empty();
                                $('#origen').val('tabla_nueva');
                                console.log(data);
                                // cargar campos del los forms
                                $('#cuartel').val(data.response.cuartel);
                                $('#anterior').val(data.response.anterior);
                                $('#tipo_nicho').val(data.response.tipo_nicho);
                                $('#search_dif').val(data.response.ci_dif);
                                $('#nombres_dif').val(data.response.nombre_dif);
                                $('#paterno_dif').val(data.response.primerap_dif);
                                $('#materno_dif').val(data.response.segap_dif);
                                $('#fechanac_dif').val(data.response.nacimiento_dif);
                                $('#fechadef_dif').val(data.response.fecha_def_dif);
                                $('#causa').val(data.response.causa_dif);
                                $('#sereci').val(data.response.certificado_defuncion);
                                $('#tipo_dif').val(data.response.tipo_dif);
                                $('#genero_dif').val(data.response.genero_dif);
                                $('#search_resp').val(data.response.ci_resp);
                                $('#nombres_resp').val(data.response.nombre_resp);
                                $('#paterno_resp').val(data.response.paterno_resp);
                                $('#materno_resp').val(data.response.segap_resp);
                                $('#fechanac_resp').val(data.response.nacimiento_resp);
                                $('#telefono').val(data.response.telefono);
                                $('#celular').val(data.response.celular);
                                $('#ecivil').val(data.response.ecivil_resp);
                                $('#email').val(data.response.email_resp);
                                $('#domicilio').val(data.response.domicilio_resp);
                                $('#genero_resp').val(data.response.genero_resp);
                               
                              
                                $('#razon').html(data.response.razon);
                                $('#tiemp').html(data.response.tiempo);
                                $('#cant_cuerpos').val(data.response.cantidad_cuerpos);
                                $('#cuerpos').html(data.response.cantidad_cuerpos);
                               
                            
                                $('#funeraria').html(data.response.funeraria);
                                $('#url-certification').html(data.response.certificado_file);

                              
                                                    if (data.response.tiempo == 2) {
                                                        $('#tipo_dif').val('PARVULO')
                                                    } else if (data.response.tiempo == 5) {
                                                        $('#tipo_dif').val('ADULTO')
                                                    }
                            } else {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content'),
                                        'Content-Type': 'application/json'
                                    },
                                    url: "https://multiservdev.cochabamba.bo/api/v1/cementerio/get-data",
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
                                       $('#buscar').prop('disabled' , false);
                                       bloque = $('#bloque').prop('readonly',false);
                                       nicho = $('#nro_nicho').prop('readonly',false);
                                       fila = $('#fila').prop('readonly',false);

                                        $('#origen').val('tabla_antigua');

                                        if (data.codigo_ni) {
                                            $('#anterior').val(data.codigo_ni);
                                        }


                                        if (data.response.datos_difuntos != "") {
                                            // datos difunto       
                                            var pg = data.response.datos_difuntos[0]
                                                .pag_con;

                                            if (pg > 10 && pg < 1000 && pg != 1999) {
                                                pg = '20' + pg;
                                            } else if (pg < 10) {
                                                pg = '200' + pg;
                                            }
                                            if (data.response.datos_difuntos != "") {
                                                var fecha = data.response.datos_difuntos[0]
                                                    .fecha;
                                                var año = fecha.substr(0, 4);
                                                var mes = fecha.substr(4, 2);
                                                var dia = fecha.substr(6, 2);
                                                var nuevaf = año + "-" + mes + "-" + dia;
                                                $('#fechadef_dif').val(nuevaf);
                                                $('#comprob').html(data.response.datos_difuntos[
                                                        0]
                                                    .comprob);
                                                $('#razon').html(data.response.datos_difuntos[0]
                                                    .razon);


                                                $('#pag_con').val(pg);
                                                $('#causa').val(data.response.datos_difuntos[0]
                                                    .causa_fall);
                                                $('#nombres_dif').val(data.response
                                                    .datos_difuntos[0].difunto);
                                                var t = data.response.datos_difuntos[0]
                                                    .tiempo;
                                            if ((data.response.datos_difuntos[0].pag_con ==
                                                        '' || data.response.datos_difuntos[0]
                                                        .pag_con ==
                                                        null) && (data.response.datos_difuntos[
                                                            0]
                                                        .tiempo != ""))
                                                         {

                                                                    if (!$.isNumeric(t)) {
                                                                        t = 30;  
                                                                        Swal.fire(
                                                                            'Se autocompletará el tiempo de permanencia del difunto como 30 años, debido a la ausencia de la información!',
                                                                            'Si no fuera correcto el dato por favor completar de manera manual',
                                                                            'warning'
                                                                        )  ;                                              
                                                                    } else if(t=="") {
                                                                    
                                                                        seTime();
                                                                    }
                                                                    if (t == 2) {
                                                                        $('#tipo_dif').val('PARVULO')
                                                                    } else if (t == 5) {
                                                                        $('#tipo_dif').val('ADULTO')
                                                                    }
                                                                    $('#tiemp').html(t);
                                                                    $('#tiempo').val(t);
                                                                    $('#tipo_nicho').val('TEMPORAL');
                                                                    calcularPlazo(t, año, nuevaf);
                                                } else if (data.response.datos_difuntos[0]
                                                    .pag_con > 0) {


                                                    $('#tiemp').html(t);
                                                    $('#tiempo').val(t);

                                                    $('#pago_cont').html(pg);
                                                    $('#pago_cont_ant').html(pg);

                                                    $('#tipo_nicho').val('PERPETUO');
                                                }

                                                var genero = "";

                                                if (data.response.datos_difuntos[0].sexo ==
                                                    "M") {
                                                    genero = "MASCULINO";
                                                } else {
                                                    genero = "FEMENINO";
                                                }
                                                $('#genero_dif').val(genero);

                                            }
                                            // datos responsable

                                            if (data.response.responsable != "") {
                                                $('#search_resp').val(data.response.responsable[
                                                    0].carnet);
                                                $('#telefono').val(data.response.responsable[0]
                                                    .telef);
                                                $('#domicilio').val(data.response.responsable[0]
                                                    .direccion);
                                                $('#nombres_resp').val(data.response
                                                    .responsable[0].razon);
                                            }
                                            if (data.response.pagos != "") {
                                                $('#razon').html(data.response.pagos[0].razon);
                                                $('#comprob').html(data.response.pagos[0]
                                                    .comprob);
                                                $('#concepto').html(data.response.pagos[0]
                                                    .concepto);
                                                $('#gestiones').html(data.response.pagos[0]
                                                    .gestiones);
                                                $('#monto_pagos').html(data.response.pagos[0]
                                                    .monto);

                                                if (data.response.pagos[0].fecha) {
                                                    var ult = data.response.pagos[0].fecha;
                                                    var ultaño = fecha.substr(0, 4);
                                                    var ultmes = fecha.substr(4, 2);
                                                    var ultdia = fecha.substr(6, 2);
                                                    var ultimof = ultaño + "-" + ultmes + "-" +
                                                        ultdia;
                                                    $('#fecha_p').html(ultimof);
                                                }

                                            }

                                        } else {
                                            $('#sp').empty();
                                            Swal.fire(
                                                'Busqueda finalizada!',
                                                'El registro no ha  sido encontrado o no existe .',
                                                'error'
                                            )

                                            $('.clear').val("");
                                            $('#form').hide();
                                        }






                                    }
                                });

                            }
                        }
                    });

                }


                // calcularPlazo nicho
                function calcularPlazo(tiempo, año, nfecha) {
                    let plazo = 0;

                    if (año.length == 2) {
                        año = '20' + año;

                    }

                    plazo = parseInt(año) + parseInt(tiempo);
                    var fecha = new Date();
                    var year = fecha.getFullYear();
                    var adeuda = year - plazo; 
                    $('#aniosdeuda').val(adeuda);

                    if (plazo < year) {
                        var vencimiento = fechaVencimiento(nfecha, tiempo);

                        $('#infoPlazo').html('El plazo del enterratorio venció el año ' + plazo + ' en fecha ' +
                            vencimiento + '');

                        $('#vencido').val(vencimiento);

                        swal.fire({
                            title: "Notificación!",
                            text: "!El plazo del enterratorio venció el año " + plazo + " en fecha " +
                                vencimiento + "!",
                            type: "warning",
                            //  timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                        setTimeout(function() {
                            return false;
                        }, 2000);
                    } else if (plazo == year) {
                        var vencimiento = fechaVencimiento(nfecha, tiempo);
                        $('#infoPlazo').html('El plazo del enterratorio vence el ' + vencimiento + '');
                        // var venc= parseInt(fecha)-parseInt(nfecha);

                        $('#vencido').val(vencimiento);
                        swal.fire({
                            title: "Notificación!",
                            text: "!El plazo del enterratorio vence el " + vencimiento + "!",
                            type: "warning",
                            //  timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                        setTimeout(function() {
                            return false;
                        }, 2000);
                    } else {
                        var vencimiento = fechaVencimiento(nfecha, tiempo);
                        $('#vencido').val(vencimiento);

                        nplazo = parseInt(year) - parseInt(plazo);
                        $('#infoPlazo').html('Quedan ' + nplazo +
                            ' años de plazo del enterratorio, la fecha de vencimiento es ' + vencimiento + '');
                        swal.fire({
                            title: "Notificación!",
                            text: "!El plazo del enterratorio vence el " + plazo +
                                " la fecha de vencimiento es " + vencimiento + "!",
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






                $(document).on('click', '#btn_guardar_pago', function() {
                    if($('#tiempo').val()==""){   seTime();}
                    if ($('#person').is(':checked')) {
                        if ($('#name_pago').val() == "" || $('#paterno_pago').val() == "" || $('#ci').val() ==
                            "") {
                            swal.fire({
                                title: "Completar los datos de la persona que esta realizando el pago!",
                                type: "warning",
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        if ($('#search_resp').val() == "" || $('#nombres_resp').val() == "" || $(
                                '#paterno_resp').val() == "") {
                            swal.fire({
                                title: "Completar los datos del responsable que esta realizando el pago!",
                                type: "warning",
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        }

                    }

                    if ($('#nrofur').val() != "") {
                        verificarfur();
                    }
                    // let cpago = [];
                    // $('.sel').each(function(index) {
                    //     if ($(this).is(':checked')) {
                    //         cpago.push($(this).val());
                    //     }
                    // });
                   

                    return $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        url: "{{ route('new.relevamiento') }}",
                        async: false,
                        data: JSON.stringify({

                            'nro_nicho': $('#nro_nicho').val(),
                            'bloque': $('#bloque').val(),
                            'cuartel': $('#cuartel').val(),
                            'fila': $('#fila').val(),
                            'tipo_nicho': $('#tipo_nicho').val(),
                            'anterior': $('#anterior').val(),
                            'ci_dif': $('#search_dif').val(),
                            // 'id_difunto': $('#difunto_search').val(),
                            'nombres_dif': $('#nombres_dif').val(),
                            'paterno_dif': $('#paterno_dif').val(),
                            'materno_dif': $('#materno_dif').val(),
                            'fechanac_dif': $('#fechanac_dif').val(),
                            'fechadef_dif': $('#fechadef_dif').val(),
                            'causa': $('#causa').val(),
                            'ecivil_dif': $('#ecivil_dif').val(),
                            'tipo_dif': $('#tipo_dif').val(),
                            'genero_dif': $('#genero_dif').val(),
                            'ci_resp': $('#search_resp').val(),
                           // 'id_responsable': $('#responsable_search').val(),
                            'nombres_resp': $('#nombres_resp').val(),
                            'paterno_resp': $('#paterno_resp').val(),
                            'materno_resp': $('#materno_resp').val(),
                           // 'fechanac_resp': $('#fechanac_resp').val(),
                            'telefono': $('#telefono').val(),
                            'celular': $('#celular').val(),
                           // 'ecivil': $('#ecivil').val(),
                           // 'email': $('#email').val(),
                            'domicilio': $('#domicilio').val(),
                            'genero_resp': $('#genero_resp').val(),
                            'pag_con': $('#pag_con').val(),
                            'tiempo': $('#tiempo').val(),
                            'nro_renovacion' : $('#nro_renovacion').val(),      
                            'monto_ultima_renov' :  $('#monto_ultima_renov').val(),       
                            'gestion_renov' : $('#gestion_renov').val()  ,  
                            // 'tipo_servicio': $('#tipo_servicio_value').val(),
                            // 'servicio_hijos': $('#servicio-hijos').val(),
                            // 'tipo_servicio_txt': $('#tipo_servicio_value option:selected').text(),
                            // 'servicio_hijos_txt': $('#servicio-hijos option:selected').text(),

                            // 'name_pago': $('#name_pago').val(),
                            // 'paterno_pago': $('#paterno_pago').val(),
                            // 'materno_pago': $('#materno_pago').val(),
                            'person': $('#person').val(),
                            // 'ci': $('#ci').val(),
                            'sereci': $('#sereci').val(),
                            // 'id_difunto': $('#difunto_search').val(),
                           // 'id_responsable': $('#responsable_search').val(),
                            'observacion': $('#observacion').val(),
                            // 'cuenta_renov': $('#cuenta_renov').val(),
                            // 'renov': $('#renov').val(),
                            // 'monto_renov': $('#monto_renov').val(),
                            // 'cuenta_renov': $('#cuenta_renov').val(),
                            // 'totalservicios': $('#totalservicios').val(),
                            // 'reg': $('#reg').val(),
                            // 'nrofur': $('#nrofur').val(),
                            // 'txttotal':$('#totalservicios').val(), 
                            // 'gratis':$('#gratis').val(), 
                            // 'externo':$('#externo').val(), 
                            'funeraria':$('#funeraria').val(), 
                            'urlcertificacion':$('#url-certificacion').val(), 
                            // 'cant':$('#cant_cuerpos').val()
                        }),
                        success: function(data_response) {
                            console.log(data_response);
                            swal.fire({
                                title: "Guardado!",
                                text: "!Registro realizado con éxito!",
                                type: "success",
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            setTimeout(function() {

                                window.location.href = "{{ route('relev') }}";


                            }, 2000);
                            //toastr["success"]("Registro realizado con éxito!");
                        },
                        error: function(error) {

                            if (error.status == 422) {
                                Object.keys(error.responseJSON.errors).forEach(function(k) {
                                    toastr["error"](error.responseJSON.errors[k]);
                                    //console.log(k + ' - ' + error.responseJSON.errors[k]);
                                });
                            } else if (error.status == 400) {
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
                                }, 2000);
                            }

                        }
                    });
                });









                $(document).on('click', '#buscarDifunto', function() {

                    var ci = $('#search_dif').val();


                    if (ci.length < 1) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El campo C.I. esta vacio .',
                            'warning'
                        )
                    } else {
                        var type = "deceased";
                        dats = buscar_ci(ci, type);

                    }
                });


                $(document).on('click', '#buscarResp', function() {
                    var ci = $('#search_resp').val();


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


                function buscar_ci(ci, type) {
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
                                console.log("si entro a esta madre" + data.response.fecha_nacimiento);
                                $('#nombres_dif').val(data.response.nombres);
                                $('#paterno_dif').val(data.response.primer_apellido);
                                $('#materno_dif').val(data.response.segundo_apellido);
                                $('#fechanac_dif').val(data.response.fecha_nacimiento);
                                $('#fechadef_dif').val(data.response.fecha_defuncion);
                                $('#tipo_dif').val(data.response.tipo);
                                $('#sereci').val(data.response.certificado_defuncion);
                                $('#causa').val(data.response.causa);
                                $('#genero_dif').val(data.response.genero);
                                // $("#difunto_search").val(data.response.id);

                            }
                        },
                        error: function(xhr, status) {

                            Swal.fire(
                                'Busqueda finalizada!',
                                'El registro no ha  sido encontrado o no existe .',
                                'error'
                            )
                        }

                    });
                    // return datos;
                }

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

                                $('#nombres_resp').val(data.response.nombres);
                                $('#paterno_resp').val(data.response.primer_apellido);
                                $('#materno_resp').val(data.response.segundo_apellido);
                                $('#fechanac_resp').val(data.response.fecha_nacimiento);
                                $('#telefono').val(data.response.telefono);
                                $('#celular').val(data.response.celular);
                                $('#ecivil').val(data.response.estado_civil);

                                $('#domicilio').val(data.response.domicilio);
                                $('#genero_resp').val(data.response.genero);
                               // $("#responsable_search").val(data.response.id);
                                $('#email').val(data.response.email);

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


                // calcular fecha vencimiento
                function fechaVencimiento(fecha, tiempo) {
                    var d = new Date(fecha);
                    var strDate = parseInt(d.getFullYear()) + parseInt(tiempo);
                    var strDate = strDate + "/" + (d.getMonth() + 1) + "/" + (d.getDate() + 1);
                    return strDate;
                }

            });


            $(document).on('click', '#reg', function() {
                if ($(this).is(':checked')) {
                    $('#fur_reg').show();
                    $('#reg').val("reg");
                } else {
                    $('#nrofur').val("");
                    $('#fur_reg').hide();
                    $('#reg').val("");

                }
            });

            $(document).on('keyup', '#nrofur', function() {
                verificarfur();
            });


            function verificarfur() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('verificarFur') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "fur": $('#nrofur').val(),
                    }),
                    success: function(verif) {
                        if (!verif) {
                            swal.fire({
                                title: "Numero de FUR no existente!",
                                text: "!Transacción rechazada!",
                                type: "error",
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            setTimeout(function() {
                                $('#btn_guardar_pago').prop('disabled', true);
                                return false;
                            }, 2000);

                        } else {
                            $('#btn_guardar_pago').prop('disabled', false);

                        }

                    }
                });
            }

            $(document).on('click', '#person', function() {
                if ($(this).is(':checked')) {
                    $('#infoperson').show();
                    $('#person').val("tercera_persona");
                } else {
                    $('#name_pago').val("");
                    $('#paterno_pago').val("");
                    $('#materno_pago').val("");
                    $('#ci').val("");
                    $('#person').val("responsable");
                    $('#infoperson').hide();
                }
            });


            $(document).on('click', '#cancelar', function() {
                window.location.href = "{{ route('mant') }}"
            });


            $(document).on('click', '#generarcidif', function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('generateCiDif') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(cidif) {
                        console.log(cidif);
                        $('#search_dif').val(cidif);

                    }
                });
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
                        $('#search_resp').val(ciresp);

                    }
                })

            })


            function buscarCuartel(bloque, nicho, fila) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('buscar.cuartel') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "bloque": bloque,
                        "nicho": nicho,
                        "fila": fila

                    }),
                    success: function(data) {
                        if (data.status == true) {
                            $('#cuartel').val(data.resp.codigo);
                        } else {
                            $('#cuartel').val("NN");
                        }
                    }
                });

            }



            $(document).ready(function() {
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
            });

      
            $(document).on('keyup', '#renov_ant', function() {
              $('#totalServ').html(0);
              $('#totalservicios').val(0);
             $('#monto_renov').val(0);

              
               buscarUltimaRenovacion();
            //    calcularPrice();
                consolidado();
            })


            function calcRenov() {
                $('#totalServ').html(0);
                $('#totalservicios').val(0);
                $('#monto_renov').val(0);
                var precio_ant = $('#precio_renov_ant').val();
                var porcentaje = 0;
                var cuota_ant = 0;
                var cuota1 = $('#precio_renov').val();
                var acum = 0;

                for (var i = 0; i < $('#renov').val(); i++) {
                    //   alert(i);
                    if (i == 0) {
                        cuota = cuota1;
                        cuota_ant = cuota1;
                    } else {
                        porcentaje = cuota_ant * (20 / 100);
                        cuota = parseFloat(cuota_ant) + parseFloat(porcentaje);
                        cuota_ant = cuota;
                    }

                    acum = parseFloat(acum) + parseFloat(cuota);

                }

                $('#monto_renov').val(acum);
               
                consolidado();

            }

            function consolidado() {
                // totalServ
                var totalgral = 0;
                var acum = 0;

                console.log("monto renov" + $('#monto_renov').val());
              
                console.log($('#totalservicios').val());
                if ($('#monto_renov').val() != 0 || $('#monto_renov').val() != null ) {

                    $('.costo').each(function(index) {
                        acum = parseFloat(acum) + parseFloat($(this).val());
                    });
                    totalgral = parseFloat($('#monto_renov').val()) + parseFloat(acum);
                    $('#totalServ').html(totalgral);
                    $('#totalservicios').val(totalgral);
                }
                else{
                    $('.costo').each(function(index) {
                        acum = parseFloat(acum) + parseFloat($(this).val());
                    });
                    $('#totalServ').html(acum);
                    $('#totalservicios').val(acum);
                }
                if ($('#gratis').is(':checked')) {
                    $('#totalServ').html(0);
                    $('#totalservicios').val(0);
                }
            }

            function buscarUltimaRenovacion(){
                $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        },
                        url: "{{ route('buscar.renovacion') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: JSON.stringify({
                            "cuartel":$('#cuartel').val(),
                              "bloque": $('#bloque').val(),
                               "nicho": $('#nro_nicho').val(),
                                "fila":$('#fila').val()
                        }),
                        success: function(data) {
                           
                            if(data.status==true){
                                $('#renov_ant').val(data.data.nro_renovacion);
                                 $('#precio_renov_ant').val(data.data.monto_renovacion);
                                 var rn=parseInt($('#renov_ant').val()) + parseInt(1);
                                 $('#renov').val(rn);
                            }
                           else {
                                var renov_ant = $('#renov_ant').val();                       
                                    if (renov_ant == 0) {                                         
                                        var precio = $('#precio_renov').val();
                                        $('#precio_renov_ant').val(precio);
                                        anios_ren = $('#aniosdeuda').val();
                                        if (anios_ren <= 0 && anios_ren =="" ) {  
                                            $('#renov').val(1);
                                        }
                                        // else if(anios_ren!=""){
                                        //     $('#renov').val(anios_ren);  
                                        // }
                                     }
                                }

                                calcRenov();
                                //consolidado();
                            }
                });

            }

           

          
            
             //causa
             $("#causa").select2({
                tags: true,
                allowClear: true

                });

            $(document).on('click' ,  'button[aria-describedby="select2-causa-container"] span', function(){
                   $('#causa option:selected').remove(); 
            })

           


            //funeraria
            $("#funeraria").select2({
                tags: true,
                allowClear: true

                });
            $(document).on('click' ,  'button[aria-describedby="select2-funeraria-container"] span', function(){
                   $('#funeraria option:selected').remove(); 
            })
           
            function seTime(){
                if($('#tipo_nicho option:selected').val()=="TEMPORAL"){
                      if($('#tipo_dif  option:selected').val()=='ADULTO' ){
                            $('#tiempo').val('5')
                        }else if($('#tipo_dif  option:selected').val()=='PARVULO' ){
                            $('#tiempo').val('2')
                        }
                    $('#addDif').hide();

                }
                else if($('#tipo_nicho  option:selected').val()=="PERPETUO"){ 
                    $('#tiempo').val('30')
                    $('#addDif').show();
                }
            }
            $(document).on('change', '#tipo_dif', function(){
                 seTime();
            })

            $(document).on('change', '#tipo_nicho', function(){
                seTime();
            })



            $(document).on('click', '#addDif', function(e){
                var divsDif = document.getElementsByClassName("difunto").length;
                    console.log("Hay " + divsDif + " elementos");
                var index=parseInt(divsDif)+1;
                const div = document.getElementsByClassName("difunto");
                // window.addEventListener('DOMContentLoaded', (event) => {
                //         console.log('DOM fully loaded and parsed');
                //     });
                const clone = div[index].cloneNode(true);
                clone.id = "difunto-"+divsDif;
                document.body.appendChild(clone);

                $('#difunto').length ;  // continuar clonacion
                 clone.find('#difunto0').prop('id', 'difunto'+$('.clonerow').length);
            });

            function Clone() {
                 var original = $('#divRow0')
                 var clone = $(original).clone(true, true);
                $('#container').append(clone);
                }

        </script>

    @stop

@extends('adminlte::page')
@section('title', 'Register Servicio')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)

@section('content_header')
    <h1>Listado de transacciones diarias</h1>
@stop

@section('content')



    <div class="modal-body">
        <div class="col-sm-12 col-md-12 col-xl-12 card m-auto">

            <div class="card">
                <div class="card-header">
                    <h2 id="infoPlazo" class="clean"></h2>
                </div>
            </div>

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

            <div id="contenido">
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

                        <input type="text" name="cuenta_tipo_servicio" id="cuenta_tipo_servicio" value="{{ $cuenta}}">
                        <input type="text" name="cuenta_servicio" id="cuenta_servicio" value="{{ $num_sec}}">
                        <input type="text" name="text_servicio" id="text_servicio" value="{{ $descrip}}">
                        <input type="text" name="costo_servicio" id="costo_servicio" value="{{ $precio}}">




                    </div>
                </div>


                {{-- datos difunto --}}
                <div class="card">
                    <div class="card-header">
                        <h4>DATOS DIFUNTOS</h4>
                    </div>
                    <div class="card-body">
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

                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>Fecha Nacimiento</label>
                                <input style="text-transform:uppercase;"
                                    type="date"
                                    class="form-control clear" id="fechanac_dif" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>Fecha Defunción</label>
                                <input type="date"
                                    class="form-control clear" id="fecha_def_dif" autocomplete="off">
                            </div>


                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>Fecha Ingreso al nicho</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="date"
                                    class="form-control clear" id="fechadef_dif" autocomplete="off">
                            </div>

                            {{-- <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Causa</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear" id="causa" autocomplete="off">
                            </div> --}}

                            <div class="col-sm-12 col-md-4 col-xl-4">
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

                            <div class="col-sm-12 col-md-2 col-xl-2">
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
                                    <option value="">Seleccionar</option>
                                    <option value="ADULTO">ADULTO</option>
                                    <option value="PARVULO">PARVULO</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Genero</label>
                                <select name="genero" id="genero_dif" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                </select>
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

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Nacimiento</label>
                                <input style="text-transform:uppercase;"
                                     type="date"
                                    class="form-control" id="fechanac_resp" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Teléfono</label>
                                {{-- <input type="number" class="form-control" id="telefono" autocomplete="off" maxlength="7"> --}}
                                <input name="telefono" id="telefono"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="7"  class="form-control" />
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Celular</label>
                                <input name="celular" id="celular"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="8"  class="form-control" />
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


                        <div class="row">
                            {{-- <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>E-mail</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="email" size="50"
                                    class="form-control" id="email" autocomplete="off">
                            </div> --}}


                            <div class="col-sm-12 col-md-7 col-xl-7">
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
                <input type="hidden" name="tiempo" id="tiempo">
                <input type="hidden" name="precio_sinot" id="precio_sinot" value="{{ $precio }}">
                <input type="hidden" name="desc_sinot" id="desc_sinot" value="{{ $descrip }}">
                <input type="hidden" name="txttotal" id="txttotal" value="">





                <div class="card">
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
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-6 col-md-12 col-xl-12">PAGO POR TERCERA PERSONA &nbsp;&nbsp;&nbsp; <input type="checkbox"
                                name="person" id="person" value="responsable" style="width: 30px; height:30px"></div>
                    </div>
                    <div class="card-body">
                        <div class="row form-group-lg" id="infoperson" style="display: none">


                            <div class="col-sm-6 col-md-2 col-xl-2">
                                <label>Nombres</label> <input type="text" name="name_pago" id="name_pago" value=""
                                    class="form-control">
                            </div>
                            <div class="col-sm-6 col-md-3 col-xl-3">
                                <label>Primer apellido</label> <input type="text" name="paterno_pago" id="paterno_pago"
                                    value="" class="form-control">
                            </div>

                            <div class="col-sm-6 col-md-3 col-xl-3">
                                <label>Segundo apellido</label> <input type="text" name="materno_pago" id="materno_pago"
                                    value="" class="form-control">
                            </div>

                            <div class="col-sm-6 col-md-4 col-xl-4">
                                <label> C.I.:</label> <input type="text" name="ci" id="ci" value="" class="form-control">
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="obs">Observaciones</label>
                                <textarea name="observacion" id="observacion" class="form-control" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="col-sm-12 col-md-12 col-xl-12 card-header">
                        <h4>GESTIONES ADEUDADAS</h4>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xl-12">Pago por {{ $descrip }}</div>
                            <div class="col-sm-6 col-md-6 col-xl-6"> Regularizar Transaccion  &nbsp;&nbsp;&nbsp;  <input type="checkbox"
                                    name="reg" id="reg" value="reg" style="width: 30px; height:30px"></div>
                            <div class="col-sm-6 col-md-6 col-xl-6" id="fur_reg" style="display: none"> FUR <input
                                    type="text" name="nrofur" id="nrofur" value=""></div>
                        </div>
                    </div>

                    <div class="card-body" id="conservacion" style="display:none">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"> CUOTA</th>
                                    <th scope="col"> GESTION</th>
                                    <th scope="col"> MONTO</th>
                                    <th scope="col"> SELECCIONAR</th>
                                </tr>
                            </thead>
                            <tbody id="row-cuota">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td id="total"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


                <div class="col-sm-12" style="text-align: center" id="print">
                    <button type="button" id="btn_guardar_pago" class="btn btn-success">Registrar servicio</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <style>
        .select2-selection__rendered {
            color: #333232;
        }

        .select2-results__option--selected {
            background-color: #175603 !important;
        }

    </style>

@section('js')
    <script>
        $(document).ready(function() {

            $(document).on('keyup', '#bloque', function(){
                habilitarBusqueda();
            });

            $(document).on('keyup', '#fila', function(){
                habilitarBusqueda();
            });
            $(document).on('keyup', '#nro_nicho', function(){
                habilitarBusqueda();
            });

            function habilitarBusqueda(){
                if($('#bloque').val()=="" || $('#nro_nicho').val()=="" || $('#fila').val()=="" ){
                    $('#buscar').prop('disabled', true);
                }
                else if($('#bloque').val()!="" || $('#nro_nicho').val()!="" || $('#fila').val()!="" ){
                    $('#buscar').prop('disabled', false);
                }

            }

            // calcular total a pagar

            $(document).on('click', '.sel', function() {
                var sum = 0;
                var prev = 0;
                var next = 0;
                var current = 0;
                let cpago = [];
                $('.sel').each(function(index) {
                    current = $(this).val();
                    next = parseInt(current) + parseInt(1);
                    if ($(this).is(':checked')) {
                        sum = parseFloat(sum) + parseFloat($('#precio_sinot').val());

                        cpago.push($(this).val());

                        $('#' + next + '').prop('disabled', false);
                    } else {
                        revisarCheck($(this).val());
                    }

                });
                $('#total').html(sum);
                $('#txttotal').val(sum);
                console.log(cpago)

            });

            // validacion seccion consecutiva
            function revisarCheck(valor) {
                var next = parseInt(valor) + parseInt(1);
                if ($('#' + next + '').is(':checked')) {
                    swal.fire({
                        title: "Precaucion!",
                        text: "!El pago de las cuotas debe ser consecutivo!",
                        type: "warning",
                        //  timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: true
                    });


                    setTimeout(function() {
                        return false;
                    }, 2000);
                    // $('#' + valor + '').prop('checked', true);
                    $(".sel").prop("checked", false);
                }
            }




            $(document).on('click', '#buscar', function() {
                $('.clear').val("");
                $('.clear').html("");
                $('.clean').val("");
                $('.clean').html("");
                $('#pag_con').val();
                $('#sp').append('<i class="fa fa-spinner fa-spin"></i>');

                $('#form').hide();
                var bloque = $('#bloque').val();
                var nicho = $('#nro_nicho').val();
                var fila = $('#fila').val();

                cuartel = buscarCuartel(bloque, nicho, fila);

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
                    url: "{{ route('buscar.registros') }}",
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
                            console.log("++++++++++");

                            console.log(data);
                            console.log("++++++++++");

                            // cargar campos del los forms
                            $('#cuartel').val(data.datos.cuartel);
                            $('#anterior').val(data.datos.anterior);
                            $('#tipo_nicho').val(data.datos.tipo_nicho);
                            $('#search_dif').val(data.datos.ci_dif);
                            $('#nombres_dif').val(data.datos.nombre_dif);
                            $('#paterno_dif').val(data.datos.paterno_dif);
                            $('#materno_dif').val(data.datos.materno_dif);
                            $('#fechanac_dif').val(data.datos.nacimiento_dif);
                            $('#fecha_def_dif').val(data.datos.fecha_defuncion);
                            $('#fechadef_dif').val(data.datos.fecha_adjudicacion);
                            $('#causa').val(data.datos.causa);
                            $('#sereci').val(data.datos.certificado_defuncion);
                            $('#tipo_dif').val(data.datos.tipo_dif);
                            $('#genero_dif').val(data.datos.genero_dif);
                            $('#search_resp').val(data.datos.ci_resp);
                            $('#nombres_resp').val(data.datos.nombre_resp);
                            $('#paterno_resp').val(data.datos.paterno_resp);
                            $('#materno_resp').val(data.datos.materno_resp);
                            $('#fechanac_resp').val(data.datos.nacimiento_resp);
                            $('#telefono').val(data.datos.telefono);
                            $('#celular').val(data.datos.celular);
                            // $('#ecivil').val(data.datos.estado_civil);
                            // $('#email').val(data.datos.email);
                            $('#domicilio').val(data.datos.dir_resp);
                            $('#genero_resp').val(data.datos.genero_resp);
                            $('#pago_cont').html(data.datos.ultimo_pago);
                            $('#pago_con').val(data.datos.ultimo_pago);
                            $('#pag_con').val(data.datos.ultimo_pago);

                            $('#pago_cont_ant').val(data.datos.ultimo_pago);
                            $('#razon').html(data.datos.nombrepago + " " + data.datos.paternopago +
                                " " + data.datos.maternopago);
                            $('#tiemp').html(data.datos.tiempo);
                            $('#concepto').html("Conservación de nichos perpetuos de forma anual");
                            $('#fecha_p').html(data.datos.fecha_pago);
                            $('#gestiones').html(data.datos.gestion);
                            $('#monto_pagos').html(data.datos.monto);
                            $('#difunto_search').val(data.datos.id_dif);
                            $('#responsable_search').val(data.datos.id_resp);
                            $('#comprob').html(data.datos.fur);
                            gestionesAdeudadas(data.datos.ultimo_pago);

                        } else {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content'),
                                    'Content-Type': 'application/json'
                                },
                                url: "https://multiserv.cochabamba.bo/api/v1/cementerio/get-data",
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
                                    $('#origen').val('tabla_antigua');
                                    bloque = $('#bloque').prop('readonly',false);
                                       nicho = $('#nro_nicho').prop('readonly',false);
                                       fila = $('#fila').prop('readonly',false);

                                    if (data.codigo_ni) {
                                        $('#anterior').val(data.codigo_ni);
                                    }


                                    if (data.response.datos_difuntos != "") {
                                        // datos difunto
                                        var pg = data.response.datos_difuntos[0]
                                            .pag_con;

                                        if (pg > 10 && pg < 1000 && pg != 1999) {
                                            pg = '20' + pg;
                                        }
                                        else if (pg < 10) {
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


                                            $('#pag_con').val(pg);
                                            $('#causa').val(data.response.datos_difuntos[0]
                                                .causa_fall);
                                            $('#nombres_dif').val(data.response
                                                .datos_difuntos[0].difunto);

                                            if ((data.response.datos_difuntos[0].pag_con ==
                                                    '') && (data.response.datos_difuntos[0]
                                                    .tiempo != "")) {
                                                $('#tiemp').html(data.response
                                                    .datos_difuntos[0].tiempo);
                                                $('#tiempo').val(data.response
                                                    .datos_difuntos[0].tiempo);
                                                $('#tipo_nicho').val('TEMPORAL');
                                            } else if (data.response.datos_difuntos[0]
                                                .pag_con > 0) {


                                                $('#tiemp').html(data.response
                                                    .datos_difuntos[0].tiempo);
                                                $('#tiempo').val(data.response
                                                    .datos_difuntos[0].tiempo);

                                                gestionesAdeudadas(pg);

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
                                        autocompletar();
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
                                    autocompletar();
                                }
                            });

                        }


                    }

                });
                autocompletar();
            }


            // calcularPlazo nicho
            function calcularPlazo(tiempo, año, nfecha) {
                let plazo = 0;
                alert(año);
                if (año.length == 2) {
                    año = '20' + año;
                    alert(año);
                }

                plazo = parseInt(año) + parseInt(tiempo);
                var fecha = new Date();
                var year = fecha.getFullYear();

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
                            '<td>' + $('#precio_sinot').val() + '</td> ' +
                            '<td> <input type="checkbox" style="width:30px;  height: 30px;" name="sel[]" class="sel"  id="' +
                            c + '" value="' + c + '"></td> ' +
                            '</tr>';
                        $('#row-cuota').append(html);
                    } else {
                        html = '<tr>' +
                            '<td scope="row" >' + i + '</td> ' +
                            '<td>' + c + '</td> ' +
                            '<td>' + $('#precio_sinot').val() + '</td> ' +
                            '<td> <input type="checkbox" style="width:30px;  height: 30px;" name="sel[]" class="sel" value="' +
                            c + '"  id="' + c + '" disabled></td> ' +
                            '</tr>';
                        $('#row-cuota').append(html);
                    }

                }
            }




            $(document).on('click', '#btn_guardar_pago', function() {

                if ($('#person').is(':checked')) {
                    if($('#name_pago').val()==""  || $('#paterno_pago').val()=="" || $('#ci').val()==""  ){
                        swal.fire({
                            title: "Completar los datos de la persona que esta realizando el pago!",
                            type: "warning",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                     }
                }else{
                    if($('#search_resp').val()==""  || $('#nombres_resp').val()=="" || $('#paterno_resp').val()==""  ){
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
                let cpago = [];
                $('.sel').each(function(index) {
                    if ($(this).is(':checked')) {
                        cpago.push($(this).val());
                    }
                });
                var codigo_nicho=$('#cuartel').val()+"."+$('#bloque').val()+"."+$('#nro_nicho').val()+"."+$('#fila').val();
                var difunto=$('#nombres_dif').val()+" "+$('#paterno_dif').val()+" "+$('#materno_dif').val();
                var glosa="Pago por Conservación de nichos perpetuos de forma anual, Codigo nicho :"+codigo_nicho +" , Bloque: "+$('#bloque').val()+", Nicho: "+$('#nro_nicho').val()+ " ,Fila:"+ $('#fila').val()+" , Difunto: "+ difunto;
                console.log(glosa);
                return $.ajax({
                    type: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    url: "{{ route('save.pay') }}",
                    async: false,
                    data: JSON.stringify({

                        'nro_nicho': $('#nro_nicho').val(),
                        'bloque': $('#bloque').val(),
                        'cuartel': $('#cuartel').val(),
                        'fila': $('#fila').val(),
                        'tipo_nicho': $('#tipo_nicho').val(),
                        'anterior': $('#anterior').val(),
                        'ci_dif': $('#search_dif').val(),
                        'id_difunto': $('#difunto_search').val(),
                        'nombres_dif': $('#nombres_dif').val(),
                        'paterno_dif': $('#paterno_dif').val(),
                        'materno_dif': $('#materno_dif').val(),
                        'fechanac_dif': $('#fechanac_dif').val(),
                        'fecha_def_dif': $('#fecha_def_dif').val(),
                        'fechadef_dif': $('#fechadef_dif').val(),
                        'causa': $('#causa').val(),
                        // 'ecivil_dif': $('#ecivil_dif').val(),
                        'tipo_dif': $('#tipo_dif').val(),
                        'genero_dif': $('#genero_dif').val(),
                        'ci_resp': $('#search_resp').val(),
                        'id_responsable': $('#responsable_search').val(),
                        'nombres_resp': $('#nombres_resp').val(),
                        'paterno_resp': $('#paterno_resp').val(),
                        'materno_resp': $('#materno_resp').val(),
                        'fechanac_resp': $('#fechanac_resp').val(),
                        'telefono': $('#telefono').val(),
                        'celular': $('#celular').val(),
                        // 'ecivil': $('#ecivil').val(),
                        // 'email': $('#email').val(),
                        'domicilio': $('#domicilio').val(),
                        'genero_resp': $('#genero_resp').val(),
                        'pag_con': $('#pag_con').val(),
                        'tiempo': $('#tiempo').val(),
                        'precio_sinot': $('#precio_sinot').val(),
                        'txttotal': $('#txttotal').val(),
                        'sel': cpago,
                        'name_pago': $('#name_pago').val(),
                        'paterno_pago': $('#paterno_pago').val(),
                        'materno_pago': $('#materno_pago').val(),
                        'person': $('#person').val(),
                        'ci': $('#ci').val(),
                        'sereci': $('#sereci').val(),
                        'id_difunto': $('#difunto_search').val(),
                        'id_responsable': $('#responsable_search').val(),
                        'observacion': $('#observacion').val(),
                        'glosa':glosa,
                        'codigo_ubicacion':codigo_nicho,
                        'cuenta_tipo_servicio':$('#cuenta_tipo_servicio').val(),
                        'cuenta_servicio':$('#cuenta_servicio').val(),
                        'text_servicio':$('#text_servicio').val(),
                        'precio':$('#precio').val(),
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

                            window.location.href = "{{ route('mant') }}";


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
                        "ci": $.trim(ci) ,
                        "type": $.trim(type)
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
                            $("#difunto_search").val(data.response.id);

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
                            // $('#ecivil').val(data.response.estado_civil);

                            $('#domicilio').val(data.response.domicilio);
                            $('#genero_resp').val(data.response.genero);
                            $("#responsable_search").val(data.response.id);
                            // $('#email').val(data.response.email);

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
            } else {
                $('#nrofur').val("");
                $('#fur_reg').hide();
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
                    if (data.status==true) {
                        $('#cuartel').val(data.resp.codigo);
                    }else{
                        $('#cuartel').val("NN");
                    }
                }
            });

        }



        $(document).ready(function(){
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
                                    //    console.log(data);
                                          // data difunto
                                        //   alert(data['response'].fecha_adjudicacion);
                                        //   var adj=(data['response'].fecha_adjudicacion).split(" ");
                                        //   var f_adj=adj[0];
                                        //   alert(f_adj);
                                            if(data.response!=null)
                                            {
                                                $('#search_dif').val(data['response'].ci_dif);
                                                $('#nombres_dif').val(data['response'].nombre_dif);
                                                $('#paterno_dif').val(data['response'].primerap_dif);
                                                $('#materno_dif').val(data['response'].segap_dif);
                                                $('#fechanac_dif').val(data['response'].nacimiento_dif);
                                                $('#fecha_def_dif').val(data['response'].fecha_defuncion);
                                                $('#fechadef_dif').val(data['response'].fecha_adjudicacion);
                                                $('#tipo_dif').val(data['response'].tipo_dif);
                                                $('#genero_dif').val(data['response'].genero_dif);
                                                $('#tiempo').val(data['response'].tiempo);
                                                $('#sereci').val(data['response'].certificado_defuncion);
                                                $('#funeraria').val(data['response'].funeraria).trigger('change');
                                                $('#causa').val(data['response'].causa_dif).trigger('change');
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

             //causa
             $("#causa").select2({
                tags: true,
                allowClear: true

                });

            $(document).on('click' ,  'button[aria-describedby="select2-causa-container"] span', function(){
                   $('#causa option:selected').remove();
            })

    </script>

@stop

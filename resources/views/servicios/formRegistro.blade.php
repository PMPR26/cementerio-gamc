@extends('adminlte::page')
@section('title', 'Register Servicio')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)

@section('content_header')
    <h1>Cobro de servicios nichos cementerio</h1>
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

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Nacimiento</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="date"
                                    class="form-control clear" id="fechanac_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Fecha Ingreso al nicho</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="date"
                                    class="form-control clear" id="fechadef_dif" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Causa</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control clear" id="causa" autocomplete="off">
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
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="date"
                                    class="form-control" id="fechanac_resp" autocomplete="off">
                            </div>

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

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Estado civil</label>
                                <select name="ecivil" id="ecivil" class="form-control">
                                    <option value="">SELECCIONAR</option>
                                    <option value="CASADO">CASADO</option>
                                    <option value="CONCUBINADO">CONCUBINADO</option>
                                    <option value="DIVORCIADO">DIVORCIADO</option>
                                    <option value="SOLTERO">SOLTERO</option>
                                    <option value="VIUDO">VIUDO</option>
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>E-mail</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="email" size="50"
                                    class="form-control" id="email" autocomplete="off">
                            </div>


                            <div class="col-sm-12 col-md-7 col-xl-7">
                                <label>Domicilio</label>
                                <input style="text-transform:uppercase;"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();" type="text"
                                    class="form-control" id="domicilio" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>Genero</label>
                                <select name="genero_resp" id="genero_resp" class="form-control">
                                    <option value="">SELECCIONAR</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="origen" id="origen">
                <input type="hidden" name="pag_con" id="pag_con" value="">
                <input type="hidden" name="tiempo" id="tiempo">
                <input type="hidden" name="vencido" id="vencido">
                <input type="hidden" name="aniosdeuda" id="aniosdeuda">

                {{-- <input type="hidden" name="precio_sinot" id="precio_sinot" value="{{ $precio }}"> --}}
                {{-- <input type="hidden" name="desc_sinot" id="desc_sinot" value="{{ $descrip }}"> --}}
                {{-- <input type="hidden" name="txttotal" id="txttotal" value=""> --}}





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
                        <div class="col-sm-6 col-md-12 col-xl-12">PAGO POR TERCERA PERSONA &nbsp;&nbsp;&nbsp; <input
                                type="checkbox" name="person" id="person" value="responsable"
                                style="width: 30px; height:30px"></div>
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
                <div class="card ">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xl-6"> Regularizar Transaccion &nbsp;&nbsp;&nbsp; <input
                                type="checkbox" name="reg" id="reg" style="width: 30px; height:30px"></div>
                        <div class="col-sm-6 col-md-6 col-xl-6" id="fur_reg" style="display: none"> FUR <input type="text"
                                name="nrofur" id="nrofur" value=""></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>ASIGNACION SERVICIOS</h4>
                    </div>

                    <div class="card-body">
                    
                        <div class="form-row " id="ren" style="display: none">
                            <div class="col-sm-12 col-md-12 col-xl-12">
                                <h2>Calcular monto renovacion de enterratorio</h2>
                                <input type="hidden" name="precio_renov" id="precio_renov" class="form-control precio_renov"
                                value="0">
                                 <input type="hidden" name="cuenta_renov" id="cuenta_renov" class="form-control cuenta_renov"
                                value="0">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label for=""># de renovacion anterior</label>
                                <input type="number" name="renov_ant" id="renov_ant" class="form-control renov"
                                    onkeyup="calcRenov()" value="0">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label for="">Ultimo cobro renovacion</label>
                                <input type="number" name="precio_renov_ant" id="precio_renov_ant"
                                    class="form-control precio_renov_ant" value="0">

                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label for=""># de renovacion </label>

                                <input type="number" name="renov" id="renov" class="form-control renov"
                                    onblur="calcRenov()">
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label for="">Monto renovacion </label>

                                <input type="number" name="monto_renov" id="monto_renov" class="form-control monto_renov"
                                    value="0">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label>Tipo Servicio</label>
                                <select id="tipo_servicio_value"
                                    class="form-control select2-multiple select2-hidden-accessible" style="width: 100%">
                                    @foreach ($tipo_service as $value)
                                        @if ($value['cuenta'] == '15224150' || $value['cuenta'] == '15224350' )
                                        @else
                                            <option value="{{ $value['cuenta'] }}">{{ $value['descripcion'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-6" id="service" style="display:none">
                                <label>Servicio</label>
                                <select id="servicio-hijos" class="form-control select2-multiple select2-hidden-accessible"
                                    style="width: 100%"></select>
                            </div>
                        </div>
                    </div>



                    <div class="card">
                        <div class="card-header">
                            <h4>DETALLE DE SERVICIOS SOLICITADOS</h4>
                        </div>

                        <div class="row" style="padding-top: 15px;">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body" id="servicios-data">
                                        Ningun dato seleccionado.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body" id="servicios-hijos">
                                        Ningun dato seleccionado.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="cal_price" style="text-align: center">
                            <div class="card">
                                <div class="card-body" id="servicios-hijos-price" style="text-align: center">



                                </div>
                                <h1><span id="totalServ"> 0 </span> Bs</h1>
                                <input type="hidden" name="totalservicios" id="totalservicios" value="0"
                                    class="form-control">
                            </div>
                        </div>




                    </div>

                    {{-- <div class="card">
                    <div class="col-sm-12 col-md-12 col-xl-12 card-header">
                        <h4>GESTIONES ADEUDADAS</h4>
                        <div class="row">
                        
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
                                    <th scope="col"> Cuota</th>
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
                </div> --}}


                    <div class="col-sm-12" style="text-align: center" id="print">
                        <button type="button" id="btn_guardar_pago" class="btn btn-success">Registrar servicio</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="cancelar">Cancelar</button>
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

                //code selected select2 services
                $('#tipo_servicio_value').select2({
                    multiple: true,
                    width: 'resolve',
                    placeholder: 'Servicios Cementerio',
                    theme: "classic",
                    allowClear: true,
                    "language": {
                        "noResults": function(e) {
                            return "Nada Encontrado";
                        }
                    }
                });




                //select event foreach
                $('#tipo_servicio_value').on('select2:select', function (e) {
                        var data_request = $(this).val();
                    
                        $('#service').show(1000);
                        $parrafos = '';
                        $('#servicios-data').empty();
                        $.each($(this).select2('data'), function( index, value ) {
                            
                            $parrafos = '<p id="'+value.id+'">' + $parrafos + (index + 1) + '.- '+ value.text+'</p>';
                            $('#servicios-data').html($parrafos);
                });

                    //carga select servicios hijos
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        url: '{{ env('URL_MULTISERVICE') }}/api/v1/cementerio/generate-all-servicios-nicho',
                        async: false,
                        data: JSON.stringify({
                            'data': data_request
                        }),
                        success: function(data_response) {
                            console.log(data_response.response);
                            $('#servicio-hijos').empty();
                            $.each(data_response.response, function(index, value) {
                                //alert(value.num_sec)
                                if (value.num_sec == '630' || value.num_sec == '628' ||
                                    value.num_sec == '526' || value.num_sec == '1995' ||
                                    value.num_sec == '525') {} else {
                                  
                                    $('#servicio-hijos').append('<option value="' + value
                                        .num_sec + '">' + value.cuenta + ' - ' + value
                                        .descripcion + ' - ' + value.monto1 +
                                        '- Bs.</option>')
                                }
                                if(value.cuenta == '15224301'){
                                        $('#precio_renov').val(value.monto1);
                                        $('#cuenta_renov').val(value.cuenta);

                                    //   $('#ren').show();
                                    //     Renov();
                                    }

                            });
                        }
                    });
                });

                //unselect event forech  //hacer que busque y limpie el html
                $('#tipo_servicio_value').on('select2:unselect', function(e) {
                    if ($(this).select2('data').length == 0) {
                        $('#servicio-hijos').empty();
                    }
                    $parrafos = '';
                    $('#servicios-data').empty();
                    $.each($("#tipo_servicio_value").select2("data"), function(index, value) {
                        $parrafos = '<p id="' + value.id + '">' + $parrafos + (index + 1) + '.- ' +
                            value.text + '</p>';
                        $('#servicios-data').html($parrafos);
                    });
                });

                setTimeout(function() {
                    $("#tipo_servicio_value").val(null).trigger('change');
                }, 100);


                //--------------------------------------------------------------------

                $('#servicio-hijos').select2({
                    multiple: true,
                    width: 'resolve',
                    placeholder: 'Servicios Cementerio',
                    theme: "classic",
                    allowClear: true,
                    "language": {
                        "noResults": function(e) {
                            return "Nada Encontrado";
                        }
                    }
                });


                //select event forech services hijo
                $('#servicio-hijos').on('select2:select', function(e) {
                    $("#tipo_servicio_value").prop("disabled", true);
                    var data_request = $(this).val();

                    $parrafos = '';
                    $('#servicios-hijos').empty();
                    $('#servicios-hijos-price').empty();
                    $.each($(this).select2('data'), function(index, value) {
                      
                        $parrafos = '<p id="' + value.id + '">' + $parrafos + (index + 1) + ' - ' +
                            value.text + '</p>';
                        $('#servicios-hijos').html($parrafos);
                        if(value.id == '642')
                            {
                                 $('#ren').show();
                                 buscarUltimaRenovacion();
                              //   Renov();
                                 calcularPrice();
                               
                            }else{
                                var v = (value.text).split('-');
                                var costo = '<input type="hidden" name="costo" value="' + v[v.length - 2] +
                                    '" class="costo" id="txt-' + value.id + '" />';
                                $('#servicios-hijos-price').append(costo);
                                calcularPrice();
                            }
                 
                    });


                });


                //unselect event forech services hijos
                $('#servicio-hijos').on('select2:unselect', function(e) {

                   var existe=0;
                    if ($("#servicio-hijos").select2("data").length == 0) {
                        $("#tipo_servicio_value").prop("disabled", false);
                    }
                    $parrafos = '';
                    $('#servicios-hijos').empty();
                    $('#servicios-hijos-price').empty();
                    $('#totalServ').html("0");

                    $.each($("#servicio-hijos").select2("data"), function(index, value) {
                            $parrafos = '<p id="' + value.id + '">' + $parrafos + (index + 1) + ' - ' +
                            value.text + '</p>';
                        $('#servicios-hijos').html($parrafos);
                        var v = (value.text).split('-'); 
                        console.log(v);
                        if(v[0]=='15224401 '){ existe=1;
                        }
                        if(existe==0){
                            $('#cuenta_renov').val("0");
                            $('#monto_renov').val("0");
                            $('#renov').val("0");
                            var costo = '<input type="hidden" name="costo" value="' + v[v.length - 2] +
                            '" class="costo" id="txt-' + value.id + '" />';
                            $('#servicios-hijos-price').append(costo);
                            calcularPrice();
                           
                        }
                    });
                    if(existe==1){
                       
                            $('#ren').show();
                            //  Renov();
                            buscarUltimaRenovacion();
                              calcularPrice();
                       
                    }else{
                        $('#cuenta_renov').val("0");
                            $('#monto_renov').val("0");
                            $('#renov').val("0");
                            calcularPrice();
                    }


                   
                });


                //  });

                function calcularPrice() {
                    var acum = 0;
                    $('.costo').each(function(index) {
                        acum = parseFloat(acum) + parseFloat($(this).val());
                    });
                    $('#totalServ').html(acum);
                    $('#totalservicios').val(acum)
                    consolidado();

                }



                // verificar si se esta solicitando renovacion de enterratorio

                // $(document).on('click', '#renovacion', function() {

                //         if ($(this).is(':checked')) {
                //             $('#ren').show();
                //           $('#renovacion').value("renovacion");                       
                //         } else {
                //             $('#ren').hide();

                //             $('#renovacion').value(null); 
                //             $('#renov').val("0");
                //             $('#monto_renov').val("0");

                //         }

                // });





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
                });



                function buscar_datos(bloque, nicho, fila) {
                    var datos = "";
                    $('#contenido').show();
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
                                $('#pago_cont').html(data.response.ultimo_pago);
                                $('#pago_con').val(data.response.ultimo_pago);
                                $('#pag_con').val(data.response.ultimo_pago);
                                $('#renov_ant').val(data.response.nro_renovacion);
                                 $('#precio_renov_ant').val(data.response.monto_renovacion);
                                $('#razon').html(data.response.nombrepago + " " + data.response.paternopago +
                                    " " + data.response.maternopago);
                                $('#tiemp').html(data.response.tiempo);
                               // $('#concepto').html("Conservación de nichos perpetuos de forma anual");
                                $('#fecha_p').html(data.response.fecha_pago);
                                $('#gestiones').html(data.response.gestion);
                                $('#monto_pagos').html(data.response.monto);
                                $('#difunto_search').val(data.response.difunto_id);
                                $('#responsable_search').val(data.response.responsable_id);
                                $('#comprob').html(data.response.fur);
                                $('#fecha_p').html(data.response.fecha_pago);
                                $('#monto_pagos').html(data.response.monto);
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
                                                        .tiempo != "")) {

                                                    if (!$.isNumeric(t)) {
                                                        t = 0;
                                                        $('#txt_tiempo').show();
                                                    } else {
                                                        $('#txt_tiempo').hide();
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
                    let cpago = [];
                    $('.sel').each(function(index) {
                        if ($(this).is(':checked')) {
                            cpago.push($(this).val());
                        }
                    });


                    return $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        url: "{{ route('new.servicio') }}",
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
                            'fechadef_dif': $('#fechadef_dif').val(),
                            'causa': $('#causa').val(),
                            'ecivil_dif': $('#ecivil_dif').val(),
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
                            'ecivil': $('#ecivil').val(),
                            'email': $('#email').val(),
                            'domicilio': $('#domicilio').val(),
                            'genero_resp': $('#genero_resp').val(),
                            'pag_con': $('#pag_con').val(),
                            'tiempo': $('#tiempo').val(),
                            'tipo_servicio': $('#tipo_servicio_value').val(),
                            'servicio_hijos': $('#servicio-hijos').val(),
                            'tipo_servicio_txt': $('#tipo_servicio_value option:selected').text(),
                            'servicio_hijos_txt': $('#servicio-hijos option:selected').text(),

                            'name_pago': $('#name_pago').val(),
                            'paterno_pago': $('#paterno_pago').val(),
                            'materno_pago': $('#materno_pago').val(),
                            'person': $('#person').val(),
                            'ci': $('#ci').val(),
                            'sereci': $('#sereci').val(),
                            'id_difunto': $('#difunto_search').val(),
                            'id_responsable': $('#responsable_search').val(),
                            'observacion': $('#observacion').val(),
                            'cuenta_renov': $('#cuenta_renov').val(),
                            'renov': $('#renov').val(),
                            'monto_renov': $('#monto_renov').val(),
                            'cuenta_renov': $('#cuenta_renov').val(),
                            'totalservicios': $('#totalservicios').val(),
                            'reg': $('#reg').val(),
                            'nrofur': $('#nrofur').val(),
                            'txttotal':$('#totalservicios').val(), //
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

                                window.location.href = "{{ route('serv') }}";


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
                                $('#ecivil').val(data.response.estado_civil);

                                $('#domicilio').val(data.response.domicilio);
                                $('#genero_resp').val(data.response.genero);
                                $("#responsable_search").val(data.response.id);
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

            // $(document).on('click', '#renovacion', function() {
            //     if ($(this).is(':checked')) {
            //         $('#renovacion').val("renovacion");
            //         $('#ren').show();
            //         $.ajax({
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //                 'Content-Type': 'application/json'
            //             },
            //             url: "{{ route('precio.renovacion') }}",
            //             method: 'GET',
            //             dataType: 'json',
            //             success: function(data) {
            //                 console.log(data);
            //                 if (data.status == true) {
            //                     $('#precio_renov').val(data.precio);
            //                     $('#cuenta_renov').val(data.cuenta);

            //                 } else {
            //                     $('#ren').hide();
            //                     $('#renovacion').val("");
            //                     $('#precio_renov').val(0);
            //                     $('#cuenta_renov').val(0);
            //                 }
            //                 Renov();
            //                 calcRenov();
            //             }


            //         });

            //     } else {
            //         $('#precio_renov').val(0);
            //         $('#cuenta_renov').val(0);
            //     }

            // });


            function Renov() {
                var renov_ant = $('#renov_ant').val();
                       
                if (renov_ant == 0) { 
                    renov_ant = 0;  
                    var precio = $('#precio_renov').val();
                    $('#precio_renov_ant').val(precio);
                    anios_ren = $('#aniosdeuda').val();
                    if (anios_ren <= 0 && anios_ren !="") {  
                        $('#renov').val(1);
                    } else if(anios_ren!=""){
                        $('#renov').val(anios_ren);  
                    }

                }else if(renov_ant >0){
                    var rn=parseInt($('#renov_ant').val()) + parseInt(1);
                        $('#renov').val(rn);
                }
                calcRenov();

            }

            $(document).on('keyup', '#renov_ant', function() {
               // Renov();
               buscarUltimaRenovacion();
                calcRenov();
            })


            function calcRenov() {
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
                console.log("monto renov" + $('#monto_renov').val());
              
                console.log($('#totalservicios').val());
                if ($('#monto_renov').val() != 0 || $('#monto_renov').val() != null || $('#totalservicios').val() != 0) {

                }
                totalgral = parseFloat($('#monto_renov').val()) + parseFloat($('#totalservicios').val());
                $('#totalServ').html(totalgral);
                $('#totalservicios').val(totalgral);
                // alert(totalgral);
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
                            console.log(data);
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
                                        if (anios_ren <= 0 && anios_ren !="") {  
                                            $('#renov').val(1);
                                        } else if(anios_ren!=""){
                                            $('#renov').val(anios_ren);  
                                        }
                                     }
                                }

                                calcRenov();
                            }
                });

            }
             
        </script>

    @stop

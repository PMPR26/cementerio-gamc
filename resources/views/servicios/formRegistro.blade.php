@extends('adminlte::page')
@section('title', 'Register Servicio')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)
@section('plugins.dropzone', true)

@section('content_header')
    <h1>Cobro de servicios nichos cementerio</h1>
@stop

@section('content')



    <div class="modal-body">
        <div class="col-sm-12 col-md-12 col-xl-12 card m-auto">

            <div class="card">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xl-12">
                        <h6>Seleccione una opcion habilitar los criterios de busqueda</h6>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-6 form-check">
                        <input type="radio"  name="tipo_servicio" id="tipo_servicio_cripta" value="cod_ant" class="form-check-input">
                        <label class="form-check-label" for="tipo_servicio_cripta">Servicio Cripta/Mausoleo</label> 
                     </div> 
                    
                     <div class="col-sm-6 col-md-6 col-xl-6 form-check">
                        <input type="radio"   name="tipo_servicio" id="tipo_servicio_nicho" value="tipo_servicio_nicho" class="form-check-input">
                        <label class="form-check-label" for="tipo_servicio_nicho">Servicio Nicho</label> 
                     </div>                    
                </div>
            </div>
            <div id="busquedas_criptas" style="display: none">
                    @include('servicios.buscarCriptaMausoleo')
            </div>

           

            <div class="card" id="busquedas_nichos" style="display: none; background: rgb(106, 119, 134);">

        <div class="col-12 interno" >   
            {{-- datos busqueda --}}

          
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
        

            <div class="card">
                <div class="card-header">
                    <h2 id="infoPlazo" class="clean"></h2>
                </div>
            </div>

            <div class="card" id="tipo_pago" style="display: none">
                <div class="card-header">
                    <h2> SELECCIONAR ANTES DE INICIAR </h2>
                    <P>Seleccione "EXTERNO" si solicitará algun servicio que no este relacionado a un nicho, seleccione "GRATIS" si el Servicio será gratuito</P>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-xl-6">
                            <label for="">EXTERNO</label>
                            <input type="checkbox" name="externo" id="externo" style="width: 30px; height:30px" >
                        </div>

                        <div class="col-sm-6 col-md-6 col-xl-6">
                            <label for="">GRATUITO</label>
                            <input type="checkbox" name="gratis" id="gratis"  style="width: 30px; height:30px"  >
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
                                class="form-control clear" id="cuartel" name="cuartel" autocomplete="off">
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
                                <input type="date"
                                    class="form-control clear" id="fechanac_dif" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>Fecha Defunción</label>
                                <input type="date"
                                    class="form-control clear" id="fecha_def_dif" autocomplete="off">
                            </div>


                            <div class="col-sm-12 col-md2 col-xl-2">
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
                                <input type="number" name="tiempo" id="tiempo" class="form-control">
                             </div>
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

        </div>
            </div>
                <div class="card interno">
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
                </div>

                <div class="card interno">
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
                <div class="card interno">
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
                                    onkeyup="calcRenov()">
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
                                        {{-- @if ($value['cuenta'] == '15224150' || $value['cuenta'] == '15224350' )
                                        @else --}}
                                            <option value="{{ $value['cuenta'] }}">{{ $value['descripcion'] }}</option>
                                        {{-- @endif --}}
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
                    <div class="row p-4" id="section_exhum" style="display: none">
                        <div class="col-12 pl-4"></div>
                        <label for="desc"> Detalle de la exhumacion</label>
                        <input type="text" name="descripcion_exhumacion" value="" id="descripcion_exhumacion" class="form-control pl-4" >
                    </div>
                   

                    <div class="col-sm-12" style="text-align: center" id="save_nichos" style="display: none">
                        <button type="button" id="btn_guardar_pago" class="btn btn-success">Registrar servicio</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="cancelar">Cancelar</button>
                    </div>

                    <div class="row" id="save_cm" style="display: none">
                        <div class="col-sm-12" style="text-align: center">
                            <button type="button" id="btn_guardar_cm" class="btn btn-success btn-editar">Guardar</button>
                            {{-- <button type="button" style="display:none" id="btn-cripta-editar" class="btn btn-success btn-editar">Guardar</button> --}}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div> 
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

               // quitar exhumacion de la lista de servicios
                    $("#tipo_servicio_value option[value='15224330']").remove();
              


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
                        url: "https://multiserv.cochabamba.bo/api/v1/cementerio/generate-all-servicios-nicho",
                        async: false,
                        data: JSON.stringify({
                            'data': data_request
                        }),
                        success: function(data_response) {
                            console.log(data_response.response);
                            $('#servicio-hijos').empty();
                            $.each(data_response.response, function(index, value) {
                                //alert(value.num_sec)
                             /*   if (value.num_sec == '526' || value.num_sec == '1995' ||
                                    value.num_sec == '525') {} else {*/
                                  
                                    $('#servicio-hijos').append('<option value="' + value
                                        .num_sec + '">' + value.cuenta + ' - ' + value
                                        .descripcion + ' - ' + value.monto1 +
                                        '- Bs.</option>')
                             //   }
                                if(value.cuenta == '15224301'){
                                        $('#precio_renov').val(value.monto1);
                                        $('#cuenta_renov').val(value.cuenta);
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
                        if(value.id == '630' || value.id == '628' ){
                            $('#descripcion_exhumacion').attr('data-id', value.id);
                            $('#section_exhum').show();
                            
                        }
                        if(value.id == '642')
                            {
                                 $('#ren').show();
                                 buscarUltimaRenovacion();
                         
                            }else{
                                var v = (value.text).split('-');
                                var costo = '<input type="hidden" name="costo" value="' + v[v.length - 2] +
                                    '" class="costo" id="txt-' + value.id + '" />';
                                $('#servicios-hijos-price').append(costo);
                               
                            }
                            // calcularPrice();
                            consolidado();
                    });


                });


                //unselect event forech services hijos
                $('#servicio-hijos').on('select2:unselect', function(e) {

                   var existe=0;
                   var existe_ex=0;

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
                        // console.log(v);
                        if(v[0]=='15224401 '){ existe=1;
                        }
                        if(v[0]=='15224201 '){
                           
                            existe_ex=1;
                        }
                        if( existe_ex==0){
                            $('#descripcion_exhumacion').val("");
                            $('#section_exhum').hide();
                            consolidado();
                        }
                        if(existe==0){
                            $('#cuenta_renov').val("0");
                            $('#monto_renov').val("0");
                            $('#renov').val("0");
                            var costo = '<input type="hidden" name="costo" value="' + v[v.length - 2] +
                            '" class="costo" id="txt-' + value.id + '" />';
                            $('#servicios-hijos-price').append(costo);
                            // calcularPrice();
                            consolidado();
                            $('#ren').hide();
                           
                        }
                    });
                    if(existe==1){
                       
                            $('#ren').show();
                            //  Renov();
                            buscarUltimaRenovacion();
                            //   calcularPrice();
                            consolidado();
                       
                    }else{
                        $('#ren').hide();
                        $('#cuenta_renov').val("0");
                            $('#monto_renov').val("0");
                            $('#renov').val("0");
                            // calcularPrice();
                            consolidado();
                    }                  
                });


                //  });

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
                        url: "{{ route('buscar.nicho') }}",
                        method: 'POST',
                        dataType: 'json',
                        data: JSON.stringify({
                            "bloque": bloque,
                            "nicho": nicho,
                            "fila": fila
                        }),
                        success: function(data) {

                            if (data.mensaje) 
                            {
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
                                $('#fecha_def_dif').val(data.response.fecha_def_dif);
                                $('#fechadef_dif').val(data.response.fecha_adjudicacion);
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
                                $('#razon').html(data.response.razon);
                                $('#tiemp').html(data.response.tiempo);
                                $('#cant_cuerpos').val(data.response.cantidad_cuerpos);
                                $('#cuerpos').html(data.response.cantidad_cuerpos);
                                $('#fecha_p').html(data.response.fecha_pago);
                                $('#gestiones').html(data.response.gestion);
                                $('#monto_pagos').html(data.response.monto);
                                $('#funeraria').html(data.response.funeraria);
                                $('#url-certification').html(data.response.certificado_file);

                                // $('#difunto_search').val(data.response.difunto_id);
                                //$('#responsable_search').val(data.response.responsable_id);
                                $('#comprob').html(data.response.fur);
                                $('#fecha_p').html(data.response.fecha_pago);
                                $('#monto_pagos').html(data.response.monto);
                                                    if (data.response.tiempo == 2) {
                                                        $('#tipo_dif').val('PARVULO')
                                                    } else if (data.response.tiempo == 5) {
                                                        $('#tipo_dif').val('ADULTO')
                                                    }
                            } else 
                            {
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
                                    success: function(data) 
                                    {
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

                                        if (data.response.datos_difuntos != "") 
                                            {
                                                        // datos difunto       
                                                        var pg = data.response.datos_difuntos[0]
                                                            .pag_con;

                                                        if (pg > 10 && pg < 1000 && pg != 1999) {
                                                            pg = '20' + pg;
                                                        } else if (pg < 10) {
                                                            pg = '200' + pg;
                                                        }




                                                            if (data.response.datos_difuntos != "") 
                                                            {
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
                                            autocompletar();

                                        } else {
                                            $('#sp').empty();
                                          
                                            // Swal.fire(
                                            //     'Busqueda finalizada!',
                                            //     'El registro no ha  sido encontrado o no existe .',
                                            //     'error'
                                            // )

                                            $('.clear').val("");
                                            $('#form').hide();
                                           
                                        }
                                       
                                    },
                                     error: function(error) {
                                        Swal.fire(
                                                'Busqueda finalizada!',
                                                'El registro no ha  sido encontrado o no existe .',
                                                'error'
                                                )
                                        }
                                });
                              

                            }
                           
                        },
                        error: function(error) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El registro no ha  sido encontrado o no existe .',
                                'error'
                                )
                        }
                    });
                    autocompletar();
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
                        url: "{{ route('new.servicio') }}",
                        async: false,
                        data: JSON.stringify({

                            'nro_nicho': $('#nro_nicho').val(),
                            'bloque': $('#bloque').val(),
                            'cuartel': $('#cuartel :selected').val(),
                            'fila': $('#fila').val(),
                            'tipo_nicho': $('#tipo_nicho').val(),
                            'anterior': $('#anterior').val(),
                            'ci_dif': $('#search_dif').val(),
                            // 'id_difunto': $('#difunto_search').val(),
                            'nombres_dif': $('#nombres_dif').val(),
                            'paterno_dif': $('#paterno_dif').val(),
                            'materno_dif': $('#materno_dif').val(),
                            'fechanac_dif': $('#fechanac_dif').val(),
                            'fecha_def_dif': $('#fecha_def_dif').val(),
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
                            // 'id_difunto': $('#difunto_search').val(),
                           // 'id_responsable': $('#responsable_search').val(),
                            'observacion': $('#observacion').val(),
                            'cuenta_renov': $('#cuenta_renov').val(),
                            'renov': $('#renov').val(),
                            'monto_renov': $('#monto_renov').val(),
                            'cuenta_renov': $('#cuenta_renov').val(),
                            'totalservicios': $('#totalservicios').val(),
                            'reg': $('#reg').val(),
                            'nrofur': $('#nrofur').val(),
                            'txttotal':$('#totalservicios').val(), 
                            'gratis':$('#gratis').val(), 
                            'externo':$('#externo').val(), 
                            'funeraria':$('#funeraria').val(), 
                            'urlcertificacion':$('#url-certificacion').val(), 
                            'cant':$('#cant_cuerpos').val(),
                            'descripcion_exhumacion':$('#descripcion_exhumacion').val()+"=>"+$('#descripcion_exhumacion').data("id")
                        }),
                        success: function(data_response) { //alert(data_response['status']);
                            // console.log(data_response);
                            if(data_response['status']==false){
                                swal.fire({
                                    title: "Nicho ocupado, debe liberar el nicho primero!",
                                    text: "!Transacción rechazada!",
                                    type: "error",
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                            else{

                         
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
                          }
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
                                $('#fecha_def_dif').val(data.response.fecha_defuncion);
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

            $(document).on('click', '#externo', function() { 
                if ($(this).is(':checked')) {
                    $('#externo').val('externo');
                    $('.externo').prop('disabled', false);
                    $('.interno').hide();
                    $('.interno').prop("disabled", true);
                } else {
                    $('.externo').prop('disabled', true);
                    $('.interno').show();

                    $('.interno').prop("disabled", false);
                    $('#externo').val('');
                }
            });

            $(document).on('click', '#gratis', function() { 
                if ($(this).is(':checked')) {
                    $('#gratis').val('gratis');
                    $('#totalServ').html(0);
                    $('#totalservicios').val(0);
                }else{
                    $('#gratis').val('');
                    consolidado();
                }
            });
           
            
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
                }
                else if($('#tipo_nicho  option:selected').val()=="PERPETUO"){
                    $('#tiempo').val('30')
                }
            }
            $(document).on('change', '#tipo_dif', function(){
                 seTime();
            })

            $(document).on('change', '#tipo_nicho', function(){
                seTime();
            })



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
                                                $('#telefono').val(data['response'].telefono);
                                                $('#celular').val(data['response'].celular);
                                                $('#genero_resp').val(data['response'].genero_resp);
                                                $('#domicilio').val(data['response'].domicilio_resp);
                                            } 
                                           
                                    }  
                                                   
                     });
                   return false;
            }

            $(document).on('click' , '#tipo_servicio_nicho', function(){
               $('#tipo_pago').show();
               $('#busquedas_nichos').show();
               $('#busquedas_nichos').prop('disabled', false);
               $('#save_nichos').show();

               $('#busquedas_criptas').prop('disabled', true);
               $('#busquedas_criptas').hide();           
               $('#save_cm').hide();

            });
            $(document).on('click' , '#tipo_servicio_cripta', function(){
               $('#tipo_pago').hide();
               $('#busquedas_nichos').prop('disabled', true);
               $('#busquedas_nichos').hide();
               $('#save_nichos').hide();
               $('#busquedas_criptas').show();
               $('#busquedas_criptas').prop('disabled', false);
               $('#save_cm').show();
            });
            // $(document).on('keyup', '#descripcion_exhumacion', function(){
            //     $('#select2-servicio-hijos-container-choice-4fa8-630').html($('#descripcion_exhumacion').val());
            // });


            /******************************************************/
            /******para criptas o mausoleos ******************************/
            /*********************************************************/
            $(document).on('click','#btn_search_field', function(){
                buscar($('input[name=buscar_cm]:checked').val());
            });


            //habilitar caja de busqueda de cripta o mausoleo
            $(document).on('click','input[name=buscar_cm]', function(){
                $('#search_field').val();
                if( $("input[name=buscar_cm]:radio").is(':checked'))
                {
                    $('#search_field').prop('disabled', false);                  
                }else{
                    $('#search_field').prop('disabled', true);
                }
            });

            function buscar(criterio){
               
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('buscar.cripta') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "tipo_busqueda": criterio,
                        "search_field":$('#search_field').val()
                      
                    }),
                    success: function(data) {
                        console.log(data);
                        $('#codigo_antiguocm').val(data.codigo_antiguo);
                        $('#codigo_nuevocm').val(data.codigo);
                        $('#tipo_cm').val(data.tipo_registro);
                        $('#cuartel_cm').val(data.cuartel_id).trigger('change');
                        $('#bloque_cm').val(data.bloque_id).trigger('change');
                        $('#sitio_cm').val(data.sitio);
                        $('#superficie_cm').val(data.superficie);
                        $('#ocupados_cm').val(data.ocupados);
                        $('#total_cm').val(data.total_cajones);
                        $('#construccion_cm').val(data.estado_construccion);
                        $('#observaciones').val(data.observaciones);
                        $('#dni').val(data.ci_resp);
                        $('#nombres_prop').val(data.nombre_resp);
                        $('#paterno_prop').val(data.paterno_resp);
                        $('#materno_prop').val(data.materno_resp);
                        $('#domicilio').val(data.domicilio);
                        $('#genero_prop').val(data.genero_resp);
                        $('#razon').html(data.nombrepago+" "+data.paternopago+" "+data.maternopago);
                        $('#comprob').html(data.fur);
                       // $('#tiemp').html(data.codigo_antiguo);
                        // $('#pago_cont').html(data.fecha_pago);
                        $('#cuerpos').html(data.ocupados);
                        $('#concepto').html(data.servicio);
                        $('#fecha_p').html(data.fecha_pago);
                        // $('#gestiones').html(data.codigo_antiguo);
                        $('#monto_pagos').html(data.monto);
                    }
                });
            }

            // $(".select-cuartel").select2({
            //     width: 'resolve', // need to override the changed default
            //    // dropdownParent: $('#modal-cripta')
            // });

            $(".select-cuartel").select2({
                tags: true,
                allowClear: true

                });
            $(document).on('click' ,  'button[aria-describedby="select2-cuartel_cm-container"] span', function(){
                $('button[aria-describedby="select2-cuartel_cm-container"] span').toUpperCase();
                   $('#cuartel_cm option:selected').remove(); 
            })


            $("#bloque_cm").select2({
                width: 'resolve', // need to override the changed default
              //  dropdownParent: $('#modal-cripta')
              });

              
          
    $(document).on('change', '#cuartel_cm', function(){
        $('#bloque_cm').empty();
        var sel_cuartel=$('#cuartel_cm').val();
              $('#bloque_cm').prop('disabled', false);
                $.ajax({
                    type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('bloqueid.get') }}",
                        async: false,
                        data: JSON.stringify({
                            'cuartel': $('#cuartel_cm').val(),
                        }),
                        success: function(data_bloque) {
                           var op1='<option >SELECCIONAR</option>';
                            $('#bloque_cm').append(op1);
                           $.each( data_bloque.response, function( key, value ) {                               
                                 opt2='<option value="'+ value.id +'">'+value.codigo +'</option>';
                                 $('#bloque_cm').append(opt2);
                            });                                                    
                        }
                });
    });


        // guardar servicio para cripta/mausoleo y mausoleo
        $(document).on('click', '#btn_guardar_cm', function() {
            // alert( $('#cuartel_cm :selected').val());
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
                    }
                    if($('#bloque_cm :selected').val()=="SELECCIONAR"){ 
                        var b=null;

                    }else{
                        var b=$('#bloque_cm :selected').val();
                    }
                  
                        return $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        url: "{{ route('new.serviciocm') }}",
                        async: false,
                        data: JSON.stringify({
                            'tipo_cm': $('#tipo_cm').val(),
                            'bloque': b,
                            'cuartel': ($('#cuartel_cm :selected').val()).toUpperCase(),
                            'sitio': $('#sitio_cm').val(),
                            'superficie': $('#superficie_cm').val(),
                            'ocupados': $('#ocupados_cm').val(),
                            'total_cm': $('#total_cm').val(),
                            'construccion_cm': $('#construccion_cm').val(),
                            'obs_cm': $('#obs_cm').val(),

                            
                            'ci_dif': $('#search_dif').val(),
                            'nombres_dif': $('#nombres_dif').val(),
                            'paterno_dif': $('#paterno_dif').val(),
                            'materno_dif': $('#materno_dif').val(),
                            'fechanac_dif': $('#fechanac_dif').val(),
                            'fecha_def_dif': $('#fecha_def_dif').val(),
                            'fechadef_dif': $('#fechadef_dif').val(),
                            'causa': $('#causa').val(),
                            'ecivil_dif': $('#ecivil_dif').val(),
                            'tipo_dif': $('#tipo_dif').val(),
                            'genero_dif': $('#genero_dif').val(),


                            'ci_resp': $('#dni').val(),
                           // 'id_responsable': $('#responsable_search').val(),
                            'nombres_resp': $('#nombres_prop').val(),
                            'paterno_resp': $('#paterno_prop').val(),
                            'materno_resp': $('#materno_prop').val(),
                            'domicilio': $('#domicilio').val(),
                            'genero_resp': $('#genero_prop').val(),
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
                            // 'id_difunto': $('#difunto_search').val(),
                           // 'id_responsable': $('#responsable_search').val(),
                            'observacion': $('#observacion').val(),
                            'cuenta_renov': $('#cuenta_renov').val(),
                            'renov': $('#renov').val(),
                            'monto_renov': $('#monto_renov').val(),
                            'cuenta_renov': $('#cuenta_renov').val(),
                            'totalservicios': $('#totalservicios').val(),
                            'reg': $('#reg').val(),
                            'nrofur': $('#nrofur').val(),
                            'txttotal':$('#totalservicios').val(), 
                            'gratis':$('#gratis').val(), 
                            'externo':$('#externo').val(), 
                            'funeraria':$('#funeraria').val(), 
                            'urlcertificacion':$('#url-certificacion').val(), 
                            'cant':$('#cant_cuerpos').val(),
                            'descripcion_exhumacion':$('#descripcion_exhumacion').val()+"=>"+$('#descripcion_exhumacion').data("id")
                        }),
                        success: function(data_response) { //alert(data_response['status']);
                            // console.log(data_response);
                            if(data_response['status']==false){
                                swal.fire({
                                    title: "Nicho ocupado, debe liberar el nicho primero!",
                                    text: "!Transacción rechazada!",
                                    type: "error",
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                            else{

                         
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
                          }
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

        </script>

    @stop

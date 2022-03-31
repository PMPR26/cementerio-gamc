@extends('adminlte::page')
@section('title', 'Register Servicio')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)

@section('content_header')
    <h1>Listado de servicios</h1>
@stop

@section('content')


  
        <div class="modal-body">
            <div class="col-sm-12 col-md-12 col-xl-12 card m-auto">

                {{-- datos busqueda --}}
                <div class="card">
                    <div class="card-header">
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

                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                 <label>Cuartel</label>                                   
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="cuartel" autocomplete="off">
                            </div> 
                            
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Codigo antiguo</label>                                   
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="anterior" autocomplete="off">
                            </div> 

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Columna</label>                                   
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control " id="columna" autocomplete="off">
                            </div>

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
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control clear" id="search_dif" autocomplete="off">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="hidden" class="form-control clear" id="id_difunto" autocomplete="off">

                            </div>
                    </div>
                </div> 

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Nombres</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="nombres_dif" autocomplete="off">
                    </div>
                
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Primer apellido</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="paterno_dif" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Segundo apellido</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="materno_dif" autocomplete="off">
                    </div>
                
                </div>

               
                <div class="row">
                    
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Fecha Nacimiento</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="date" class="form-control clear" id="fechanac_dif" autocomplete="off">
                    </div>
                
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Fecha Defuncion</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="date" class="form-control clear" id="fechadef_dif" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Causa</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="causa" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>SERECI</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="sereci" autocomplete="off">
                        
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Estado civil</label>   
                        <select name="ecivil" id="ecivil_dif" class="form-control">
                            <option value="">Seleccionar</option>
                            <option value="CASADO">CASADO</option>
                            <option value="CONCUBINADO">CONCUBINADO</option>
                            <option value="DIVORCIADO">DIVORCIADO</option>
                            <option value="SOLTERO">SOLTERO</option>
                            <option value="VIUDO">VIUDO</option>
                        </select> 
                    </div>
                    

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Clasificacion difunto</label>                                   
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
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control" id="search_resp" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="hidden" class="form-control clear" id="id_responsable" autocomplete="off">

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
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="date" class="form-control" id="fechanac_resp" autocomplete="off">
                        </div>
                    
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Teléfono</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="telefono" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Celular</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="celular" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Estado civil</label>   
                            <select name="ecivil" id="ecivil" class="form-control">
                                <option value="">Seleccionar</option>
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
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="email" autocomplete="off">
                        </div>
                        

                        <div class="col-sm-12 col-md-7 col-xl-7">
                            <label>Domicilio</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="domicilio" autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-2 col-xl-2">
                            <label>Genero</label>                                   
                            <select name="genero_resp" id="genero_resp" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="FEMENINO">FEMENINO</option>
                                <option value="MASCULINO">MASCULINO</option>                            
                            </select> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>INFORMACION PAGOS</h4>
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
                    <h4>ASIGNACION SERVICIOS</h4>
                </div>

                <div class="card-body">
                   
                         <div class="row">
                                <div class="col-sm-6">  
                                    <label>Tipo Servicio</label>   
                                         <select  id="tipo_servicio_value"  class="form-control select2-multiple select2-hidden-accessible" style="width: 100%">
                                            @foreach ($tipo_service as $value)
                                            <option value="{{ $value['cuenta'] }}">{{ $value['descripcion'] }}</option>
                                            @endforeach
                                        </select> 
                                </div>

                                <div class="col-sm-6" id="service" style="display:none">
                                    <label>Servicio</label> 
                                        <select  id="servicio-hijos" class="form-control select2-multiple select2-hidden-accessible" style="width: 100%"></select>
                                </div>
                          </div>


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
                <h1>0Bs</h1>
            </div>
            </div>
    </div>
                           
                          <div class="row pb-2">
                                <div class="col-sm-4 col-md-4 col-xl-4" id="cantidad_box" style="display:none">
                                    <label>Cantidad</label> 
                                         <input style="text-transform:uppercase;" value="1" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="cantidad_b" autocomplete="off">                  
                                </div>

                                <div class="col-sm-4 col-md-4 col-xl-4" id="unidad_box" style="display:none">
                                    <label>Unidad</label> 
                                    <input style="text-transform:uppercase;" value="Glb" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="unidad_b" autocomplete="off">                  
                                </div>

                               {{-- <div class="col-sm-4 col-md-4 col-xl-4" id="tiempo_box" style="display:none">
                                    <label>Tiempo</label> 
                                    <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="tiempo_b" autocomplete="off" readonly>                  
                              </div> --}}

                              <div class="col-sm-4 col-md-4 col-xl-4" id="precio_box" style="display:none">
                                <label>Precio Unitario</label> 
                                <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="precio_b" autocomplete="off" readonly>                  
                             </div>

                             <div class="col-sm-4 col-md-4 col-xl-4" id="monto_box" style="display:none">
                                <label>Precio</label> 
                                <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="monto_b" autocomplete="off" readonly>                  
                             </div>
                                                        
                             {{-- <div class="col-sm-4 col-md-4 col-xl-4" id="info_box" style="display:none">
                                <label>Ultima Gestion Pagada</label> 
                                <div id="info_pago" style="display:none"></div>
                            </div> --}}
                                                       
                            <div class="col-sm-4 col-md-4 col-xl-4" id="gestion_box" style="display:none">
                                <label>Gestion</label> 
                                <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="gestion_b" autocomplete="off" >                  
                             </div>

                            <div class="col-sm-2 col-md-2 col-xl-2">
                                <button type="button" class="btn btn-info" id="btn_add" style="display: none">
                                    <i class="fa fa-search"></i>AGREGAR
                                </button>
                            </div>
                        </div>
            
                            <input type="hidden" name="origen" id="origen">
                            <input type="hidden" name="pag_con" id="pag_con">
                            <input type="hidden" name="pag_con_ant" id="pag_con_ant">
                                    
                </div>

                <div class="card">
                    
    
                    <div class="card-body" style="display:none" id="grilla" >
                             <div class="row pb-2">
                                    <div class="col-sm-12 col-md-12 col-xl-12">  
                                    </div>
                             </div>
                    </div>
                </div>


                    <div class="col-sm-12" style="text-align: center">
                        <button type="button" id="btn_guardar_servicio" class="btn btn-success">Registrar servicio</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
    $(document).ready(function () {

        
        //code selected select2 services
        $('#tipo_servicio_value').select2({
            multiple: true,
            width: 'resolve',
            placeholder:'Servicios Cementerio',
            theme: "classic",
            allowClear: true,
            "language": {
            "noResults": function(e){
                return "Nada Encontrado";
            }
           }
        });


        //select event forech
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
                            'Content-Type':'application/json'
                        },
                        url: '{{ env("URL_MULTISERVICE") }}/api/v1/cementerio/generate-all-servicios-nicho',
                        async: false,
                        data: JSON.stringify({
                            'data':  data_request
                        }),
                        success: function(data_response) {
                            console.log(data_response.response);
                           $('#servicio-hijos').empty();
                           $.each(data_response.response, function( index, value ) {
                            $('#servicio-hijos').append('<option value="'+value.num_sec+'">'+value.cuenta + ' - ' +value.descripcion + ' - '+ value.monto1 + ' Bs.</option>')
                            });
                        }
                    });
        });

        //unselect event forech  //hacer que busque y limpie el html
        $('#tipo_servicio_value').on('select2:unselect', function (e) {
            if($(this).select2('data').length == 0){
                $('#servicio-hijos').empty();
            }
            $parrafos = '';
            $('#servicios-data').empty();
            $.each($("#tipo_servicio_value").select2("data"), function( index, value ) {
                $parrafos = '<p id="'+value.id+'">' + $parrafos + (index + 1) + '.- '+ value.text+'</p>';
                $('#servicios-data').html($parrafos);
                });
        });

        setTimeout( function() { 
            $("#tipo_servicio_value").val(null).trigger('change');
         }, 100);

        
        //--------------------------------------------------------------------

        $('#servicio-hijos').select2({
            multiple: true,
            width: 'resolve',
            placeholder:'Servicios Cementerio',
            theme: "classic",
            allowClear: true,
            "language": {
            "noResults": function(e){
                return "Nada Encontrado";
            }
           }
        });
        

          //select event forech services hijo
          $('#servicio-hijos').on('select2:select', function (e) {
              $("#tipo_servicio_value").prop("disabled", true);
            var data_request = $(this).val();
                    $parrafos = '';
                    $('#servicios-hijos').empty();
                    $.each($(this).select2('data'), function( index, value ) {
                        $parrafos = '<p id="'+value.id+'">' + $parrafos + (index + 1) + ' - '+ value.text+'</p>';
                        $('#servicios-hijos').html($parrafos);
                        });
          });
  

          //unselect event forech services hijos
        $('#servicio-hijos').on('select2:unselect', function (e) {
            console.log($("#servicio-hijos").select2("data").length);
            if ($("#servicio-hijos").select2("data").length == 0){
                $("#tipo_servicio_value").prop("disabled", false);
            }
            $parrafos = '';
            $('#servicios-hijos').empty();
            $.each($("#servicio-hijos").select2("data"), function( index, value ) {
                $parrafos = '<p id="'+value.id+'">' + $parrafos + (index + 1) + ' - '+ value.text+'</p>';
                $('#servicios-hijos').html($parrafos);
                });

        });

    });
    </script>
    @stop
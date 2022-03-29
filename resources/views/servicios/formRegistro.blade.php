@extends('adminlte::page')
@section('title', 'Bloque')
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
                                    <i class="fa fa-search"></i>BUSCAR
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
                    

                    <div class="col-sm-12 col-md-4 col-xl-4">
                        <label>Clasificacion difunto</label>                                   
                        <select name="ecivil" id="tipo_dif" class="form-control">
                            <option value="">Seleccionar</option>
                            <option value="ADULTO">ADULTO</option>
                            <option value="PARVULO">PARVULO</option>                            
                        </select> 
                    </div>

                    <div class="col-sm-12 col-md-4 col-xl-4">
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

                                </div>
                        </div>
                    </div> 

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Nombres</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="nombres" autocomplete="off">
                        </div>
                    
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Primer apellido</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="paterno" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Segundo apellido</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="materno" autocomplete="off">
                        </div>
                    
                    </div>

                   
                    <div class="row">
                        
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Fecha Nacimiento</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="fechanac_resp" autocomplete="off">
                        </div>
                    
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Teléfono</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="telefono" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Celular</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="cellular" autocomplete="off">
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
                            <select name="genero" id="genero_dif" class="form-control">
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
                    <h4>ASIGNACION SERVICIOS</h4>
                </div>

                <div class="card-body">
                         <div class="row pb-2">
                                <div class="col-sm-6 col-md-6 col-xl-6">  
                                    <label>Tipo Servicio</label>   
                                        <select name="tipo_servicio" id="tipo_servicio" class="form-control clear"></select>
                                </div>

                                <div class="col-sm-6 col-md-6 col-xl-6" id="service" style="display:none">
                                    <label>Servicio</label> 
                                        <select name="servicio" id="servicio" class="form-control clear"></select>
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

                               <div class="col-sm-4 col-md-4 col-xl-4" id="tiempo_box" style="display:none">
                                    <label>Tiempo</label> 
                                    <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="tiempo_b" autocomplete="off" readonly>                  
                              </div>

                              <div class="col-sm-4 col-md-4 col-xl-4" id="precio_box" style="display:none">
                                <label>Precio Unitario</label> 
                                <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="precio_b" autocomplete="off" readonly>                  
                             </div>

                             <div class="col-sm-4 col-md-4 col-xl-4" id="monto_box" style="display:none">
                                <label>Precio</label> 
                                <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="monto_b" autocomplete="off" readonly>                  
                             </div>
                                                        
                             <div class="col-sm-4 col-md-4 col-xl-4" id="info_box" style="display:none">
                                <label>Ultima Gestion Pagada</label> 
                                <div id="info_pago" style="display:none"></div>
                            </div>
                                                       
                            <div class="col-sm-4 col-md-4 col-xl-4" id="gestion_box" style="display:none">
                                <label>Gestion</label> 
                                <input style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="gestion_b" autocomplete="off" readonly>                  
                             </div>

                            <div class="col-sm-2 col-md-2 col-xl-2">
                                <button type="button" class="btn btn-info" id="btn_add" style="display: none">
                                    <i class="fa fa-search"></i>AGREGAR
                                </button>
                            </div>
                        </div>
            

                            <input type="hidden" name="origen" id="origen">
                            <input type="hidden" name="pag_con" id="pag_con">
                                    
                </div>


                    <div class="col-sm-12" style="text-align: center">
                        <button type="button" id="btn_guardar_nicho" class="btn btn-success">Registrar servicio</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div> 
            
@stop

@section('js')
    <script> 
    $(document).ready(function () {
          
//cargar combo tipo tramite
    tipo_tramite();
    
    function tipo_tramite() {
        $('#tipo_servicio').empty();
        var option1 = '<option value="0">SELECCIONAR</option>';
        $('#tipo_servicio').append(option1);
        $.ajax({
            headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            url: "https://multiservdev.cochabamba.bo/api/v1/cementerio/get-services",
            method: 'GET',
            dataType: 'json',
            data: {},
            success: function(data) {

                $.each(data.response, function(key, value) {
                    var option = '<option value="' + value.cuenta + '">' + value.descripcion +
                        '</option>';
                    $('#tipo_servicio').append(option);
                });
            }
        });
    }



    // cargar combo 2  hijo servcio

    function servicio() {
        $('#servicio').empty();
        var option1 = '<option value="0">SELECCIONAR</option>';
        $('#servicio').append(option1);
        var valor = $('#tipo_servicio option:selected').val();
        var permitido=0;
        $.ajax({
            headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            url: "https://multiservdev.cochabamba.bo/api/v1/cementerio/get-services/" + valor + "",
            method: 'GET',
            dataType: 'json',
            data: {},
            success: function(data) {

                $.each(data.response, function(key, value) {
                    if(valor=="15224350"){permitido= 1;}
                     else if(valor=="15224150"){
                         if(value.cuenta== "15224151"){permitido= 1;} else{permitido=0;}
                     }
                    else 
                    if(valor=="15141020"){
                        if(value.cuenta== "15141022"){permitido= 1;} else{permitido=0;}

                    }
                    else
                     if(valor=="15224200"){
                        if(value.cuenta== "15224203" || value.cuenta== "15224201"  ){permitido= 1;} else{permitido=0;}

                    }
                    
   

              //  if(permitido==0){
                    
                    var option = '<option value="' + value.num_sec + '">' + value.cuenta + "-" +
                                        value.descripcion + "-" + value.monto1 + '</option>';
                                    $('#servicio').append(option);
              //  }

                   /* var option = '<option value="' + value.num_sec + '">' + value.cuenta + "-" +
                        value.descripcion + "-" + value.monto1 + '</option>';
                    $('#servicio').append(option);*/
                });
            }
        });
    }

    $(document).on('change', '#tipo_servicio', function() {
        $('#monto_box').hide();
        $('#precio_box').hide();
        $('#cantidad_box').hide();
        $('#unidad_box').hide();
        $('#tiempo_box').hide();
        $('#info_box').hide();
        $('#gestion_box').hide();

        
        $('#cantidad_b').val(1);
        $('#unidad_b').val('Glb');
        $('#precio_b').val('');
        $('#monto_b').val('');
        $('#info_pago').val('');
        $('#gestion_b').val('');



        $('#service').show();
        servicio();
 
    });
    
    $(document).on('change', '#servicio', function() {
        $('#monto_box').show();
        $('#btn_add').show();
      
        $('#cantidad_b').val(1);
        $('#unidad_b').val('Glb');
        $('#precio_b').val('');
        $('#monto_b').val('');
        $('#info_pago').val('');

        var valor = $('#servicio option:selected').text();
        var frac = valor.split('-');
       
        if($('#servicio option:selected').val()=="525"){
            $('#cantidad_box').show();
            $('#unidad_box').show();   
            $('#precio_box').show();
            $('#info_box').show();
            $('#info_pago').show();
            $('#gestion_box').show();

            $('#gestion_b').val($('#pag_con').val());

          

            var precio_parcial=parseInt( $('#cantidad_b').val()) * parseInt(frac[2]);
            $('#precio_b').val(frac[2]);

            $('#monto_b').val(precio_parcial);
        }
        else{
            var precio_parcial=parseInt( $('#cantidad_b').val()) * parseInt(frac[2]);
            $('#precio_b').val(frac[2]);
             $('#monto_b').val(frac[2]);
        }
       

    });

    $(document).on('click', '#btn_add', function() {
        var ts = $('#tipo_servicio option:selected').text();
        var tsv = $('#tipo_servicio option:selected').val();

        var ssa = $('#servicio option:selected').text();
        var frac = ssa.split('-');
        var ss = frac[1]; 
        var ssv = $('#servicio option:selected').val();
        var ver = 0;
       // $('#pag_con').val($('#gestion_b').val());
        var cantidad_serv=$('#cantidad_b').val();
        var unidad=$('#unidad_b').val();
        var precio=$('#precio_b').val();
        var tiempo=$('#tiempo_b').val();
        var tiempo=$('#gestion_b').val();


        
       
        $('#grilla').show();


        // contar cantidad de servicios
        // Selector Padre
        var parent = document.querySelector('#grilla');

        // Cantidad de div
        var divs = parent.querySelectorAll('div');
        var cantidad = divs.length;
        //    cantidad de servicio

        var cant_serv = cantidad / 4;
        var collection = $(".quitar");
        collection.each(function(index, value) {
            var idrow = this.id;
            dat_ts = idrow.split('-');
            id_ts = dat_ts[0]; 
            id_s = dat_ts[1];
            if (tsv == id_ts && ssv == id_s) {
                ver = 1;
            }

        });
        if (ver == 0) {
            if(typeof cantidad_serv === 'undefined'){ cantidad_serv=1;}
            if(typeof unidad === 'undefined'){unidad="glb";}
            var monto =0;
           // monto=cantidad_serv*precio;
           monto=$('#monto_b').val();

         
var fila =   '<div class="card fila p-4">'+ 
             '<div class="row card-header" >'+
                        '<div class="col-sm-2 col-md-2 col-xl-2">Tipo servicio:</div>'+
                        '<div class="col-sm-10 col-md-4 col-xl-4"><span id="txt_tipo_serv">' +ts + '</span>'+
                        '<input type="hidden" name="tipo_serv[]" value="' +ts + '"  id="ts-' + tsv +
                        '" class="tserv form-control" readonly="true" class="form-control" /> </div>' +
                        '<div class="col-sm-2 col-md-1 col-xl-1">Servicio:</div>'+
                        '<div class="col-sm-10 col-md-4 col-xl-4"><span id="txt_serv">' + ss +'</span>'+
                        '<input type="hidden" name="hserv[]" value="' + ss +
                        '"  id="hs-' + ssv + '" class="hserv form-control" readonly="true" />'+
                        '<input type="hidden" name="servicio[]" value="' + ssv +
                        '" class="servicio  form-control" readonly="true" />'+
                        '</div>'+                       
               ' </div>'+
               '<div class="row card-body" >' +
                        '<div class="col-sm-2 col-md-2 col-xl-2">Cantidad:</div>'+
                        '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_cantidad">' + cantidad_serv + '</span>'+
                        '<input type="hidden" name="cantidad[]" value="' +cantidad_serv + '"   class="cantidad  form-control" readonly="readonly"  /></div>'+

                        '<div class="col-sm-2 col-md-2 col-xl-2">Unidad:</div>'+
                        '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_unidad">' + unidad + '</span>'+
                        '<input type="hidden" name="unidad[]" value="' +unidad + '"   class="unidad  form-control" readonly="readonly"  /></div>'+

                        '<div class="col-sm-2 col-md-2 col-xl-2">Precio:</div>'+
                        '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_precio">' + precio + '</span>'+
                          '<input type="hidden" name="precio_unitario[]" value="' +precio + '"   class="precio  form-control" readonly="readonly"  />'+
                         '<input type="hidden" name="cuenta[]" value="' + frac[0] +'"  id="cuenta" class="cuenta form-control" readonly="true"  class="form-control" /></div>' +
                       
                         '<div class="col-sm-2 col-md-2 col-xl-2">Subtotal:</div>'+
                         '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_subtotal">' + monto + '</span>'+
                         '<input type="hidden" name="monto[]" value="' +  monto +
                          '"  id="monto" class="montoserv form-control" readonly="readonly"  class="form-control"/> </div>'+

                          '<div class="col-sm-2 col-md-2 col-xl-2">Ultimo Pago:</div>'+
                         '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_subtotal">' + $('#gestion_b').val() + '</span>'+
                         '<input type="hidden" name="ultimopago" value="' +  $('#gestion_b').val() +
                          '"  id="ultimopago" class="ultimopago form-control" readonly="readonly"  class="form-control"/> </div>'+
                    
             '</div>'+
             '<div class="col-sm-12 col-md-1 col-xl-1"><a  href="#" class="btn btn-danger quitar "  id="' + tsv + '-' + ssv +
                         '" onClick="$(this).parent().parent().remove();"><i class="fas fa-minus-circle"></i></a> </div>'+
               '</card>';
            $('#grilla').append(fila);
        } else {
            alert("servicio repetido");
        }
    });
});


//  buscar 

$(document).on('click', '#buscar', function() {
   
            $('.clear').val("");
            $('#pag_con').val();
            $('#sp').append('<i class="fa fa-spinner fa-spin"></i>');
            $('#form').hide();
            var bloque = $('#bloque').val();
            var nicho = $('#nro_nicho').val();
            var fila = $('#fila').val();
            if (bloque && nicho && fila) {              
              dats=  buscar_datos(bloque, nicho, fila);
                console.log(dats);            
         
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
                    $('#sp').empty();
                 console.log(data);
                 // cargar campos del los forms

                } else{
                                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
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
                            console.log(data);
                            $('#sp').empty();
                            $('#form').show();
                            $('#origen').val('tabla_antigua');
                                    if(data.response.datos_difuntos!="")
                                    {                
                                                  
                                                    // datos difunto                         
                                                    if(data.response.datos_difuntos !=""){
                                                        var fecha=data.response.datos_difuntos[0].fecha;
                                                        var año= fecha.substr(0, 4);
                                                        var mes= fecha.substr(4, 2);
                                                        var dia= fecha.substr(6, 2);
                                                        var nuevaf=año+"-"+mes+"-"+dia; 
                                                        $('#fechanac_dif').val(nuevaf);
                                                        $('#pag_con').val(data.response.datos_difuntos[0].pag_con);
                                                        $('#causa').val(data.response.datos_difuntos[0].causa_fall);
                                                        $('#nombres_dif').val(data.response.datos_difuntos[0].difunto);                                                     
                                                       
                                                        var genero="Seleccionar";
                                                           
                                                            if (data.response.datos_difuntos[0].sexo == "M") {
                                                                genero = "1";
                                                            } else {
                                                            genero = "2";
                                                            }
                                                            $('#genero_dif').val(genero);
                                                        }
                                                
                                            if(data.response.ultimo_pago!=""){
                                                var ult=data.response.ultimo_pago[0].fecha;
                                                var ultaño= fecha.substr(0, 4);
                                                var ultmes= fecha.substr(4, 2);
                                                var ultdia= fecha.substr(6, 2);
                                                var ultimof=ultaño+"-"+ultmes+"-"+ultdia; 
                                               
                                                $('#tiempo_b').val(data.response.ultimo_pago[0].gestiones);
                                            }
                                            
                                                    // datos responsable

                                                    if(data.response.responsable!=""){
                                                            $('#search_resp').val(data.response.responsable[0].carnet);
                                                            
                                                            $('#telefono').val(data.response.responsable[0].telef);
                                                            $('#direccion_resp').val(data.response.responsable[0].direccion);
                                                            $('#nombres_resp').val(data.response.responsable[0].razon);
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
                                }
                    });
                }
               
            }
          
        });
        // return datos;
    }

    </script>
@stop
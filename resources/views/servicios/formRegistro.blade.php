@extends('adminlte::page')
@section('title', 'Bloque')
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)

@section('content_header')
    <h1>Listado de servicios</h1>
@stop

@section('content')


        </div>
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
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nro_nicho" autocomplete="off">
                            </div>

                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>BLOQUE</label>                                   
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="bloque" autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>FILA</label>                                   
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="fila" autocomplete="off">
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
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="cuartel" autocomplete="off">
                            </div> 
                            
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Codigo antiguo</label>                                   
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="anterior" autocomplete="off">
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
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control" id="search_dif" autocomplete="off">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-lg btn-default">
                                    <i class="fa fa-search"></i>
                                </button>

                            </div>
                    </div>
                </div> 

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Nombres</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombres_dif" autocomplete="off">
                    </div>
                
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Primer apellido</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="paterno_dif" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Segundo apellido</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="materno_dif" autocomplete="off">
                    </div>
                
                </div>

               
                <div class="row">
                    
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Fecha Nacimiento</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="date" class="form-control" id="fechanac_dif" autocomplete="off">
                    </div>
                
                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Fecha Defuncion</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="date" class="form-control" id="fechadef_dif" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>Causa</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="causa" autocomplete="off">
                    </div>

                    <div class="col-sm-12 col-md-3 col-xl-3">
                        <label>SERECI</label>                                   
                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="sereci" autocomplete="off">
                        
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
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombres" autocomplete="off">
                        </div>
                    
                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Primer apellido</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="paterno" autocomplete="off">
                        </div>

                        <div class="col-sm-12 col-md-3 col-xl-3">
                            <label>Segundo apellido</label>                                   
                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="materno" autocomplete="off">
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
                                <button type="button" class="btn btn-info" id="btn_add">
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

@stop
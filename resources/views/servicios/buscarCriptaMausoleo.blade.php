<div class="row p-4" style="background: rgb(106, 119, 134)">
    <div class="col-sm-12 col-md-12 col-xl-12">
        <h4>CRITERIO DE BUSQUEDA</h4>
    </div>
    <div class="col-sm-12 col-md-3 col-xl-3 form-check">
       <input type="radio" name="buscar_cm" id="cod_ant" value="cod_ant" class="form-check-input"><label class="form-check-label" for="cod_ant"> Codigo Antiguo</label> 
    </div>  
    <div class="col-sm-12 col-md-3 col-xl-3 form-check">
         <input type="radio" name="buscar_cm" id="cod_nuevo" value="cod_nuevo" class="form-check-input"> <label class="form-check-label" for="cod_nuevo">Codigo Nuevo</label> 
    </div>  
    
    <div class="col-sm-12 col-md-3 col-xl-3 form-check">
       <input type="radio" name="buscar_cm" id="propietario" value="propietario" class="form-check-input"><label class="form-check-label" for="propietario"> Propietario</label> 
    </div> 
    
    <div class="col-sm-8 col-md-8 col-xl-8">
        <input type="text" name="search_field" id="search_field" class="form-control" placeholder="Ingrese aqui el dato a buscar" disabled>
    </div>

    <div class="col-sm-4 col-md-4 col-xl-4">
        <button class="btn btn-info" id="btn_search_field"><i class="fa fa-search">Buscar</i></button>
    </div>
</div>

   <div class="card">

        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <h4>Datos generales de la cripta o mausoleo</h4>
            </div>
            <div class="col-sm-12 col-md-4 col-xl-4">
                <label for="" class="form-label"> Codigo Antiguo </label> 
                <input type="text" name="codigo_antiguocm" id="codigo_antiguocm"  value=""  class="form-control">
            </div>

            <div class="col-sm-12 col-md-4 col-xl-4">
                <label for="" class="form-label"> Codigo Nuevo </label> 
                <input type="text" name="codigo_nuevocm" id="codigo_nuevocm"  value=""  class="form-control">
            </div>

            <div class="col-sm-12 col-md-4 col-xl-4">
                <label for="">Tipo</label>
                <select name="tipo_cm" id="tipo_cm"  class="form-control">
                    <option value="0">Seleccionar</option>
                    <option value="CRIPTA">CRIPTA</option>
                    <option value="MAUSOLEO">MAUSOLEO</option>
                </select>               
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-md-3 col-xl-3">
                <label for="">Cuartel</label>
                {{-- cuarteles --}}
                <select  class="form-control select-cuartel" id="cuartel_cm" style="width: 100%" >
                    <option selected disabled>Seleccione un cuartel</option>
                            @foreach ($cuarteles as $value)
                            <option value="{{ $value->id }}">{{ $value->codigo }}</option>
                            @endforeach
                    </select>
                {{-- <input type="text" name="cuartel_cm" id="cuartel_cm" class="form-control"> --}}
            </div>

            <div class="col-sm-12 col-md-3 col-xl-3">
                <label for="">Bloque</label>

                <select  class="form-control select-bloque" id="bloque_cm" style="width: 100%" >
                    <option selected disabled>Seleccione un cuartel</option>                       
                  </select>
                {{-- <input type="text" name="bloque_cm" id="bloque_cm" class="form-control"> --}}
            </div>
            <div class="col-sm-12 col-md-3 col-xl-3">
                <label for="">Sitio</label>
                <input type="text" name="sitio_cm" id="sitio_cm" class="form-control">
            </div>

            <div class="col-sm-12 col-md-3 col-xl-3">
                <label for="">Superficie</label>
                <input type="text" name="superficie_cm" id="superficie_cm" class="form-control">
            </div>

        </div>

        <div class="row">
            <div class="col-sm-4 col-md-4 col-xl-4">
                <label for="">Ocupados</label>
                <input type="number" name="ocupados_cm" id="ocupados_cm" class="form-control">
            </div>

            <div class="col-sm-4 col-md-4 col-xl-4">
                <label for="">Total Cajones</label>
                <input type="number" name="total_cm" id="total_cm" class="form-control">
            </div>
            <div class="col-sm-4 col-md-4 col-xl-4">
                <label for="">Estado Construccion</label>
                <select name="construccion_cm" id="construccion_cm"  class="form-control">
                    <option value="0">Seleccionar</option>
                    <option value="LOTE">LOTE</option>
                    <option value="CONSTRUIDO">CONSTRUCCION</option>
                </select>             
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <label for="">Observación</label>
                <textarea name="obs_cm" id="obs_cm" cols="3" rows="2" class="form-control"></textarea>
            </div>           
        </div>
        

        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <h4>Datos Propietarios</h4>
            </div>
        </div>

        <div class="row"> 
               
            <div class="col-3">
                <label>Documento de Identidad:</label>
                <input id="dni" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
            </div>

           <div class="col-3">
            <label>Nombres:</label>
            <input id="nombres_prop" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
           </div>

           <div class="col-3">
            <label>Paterno:</label>
            <input id="paterno_prop" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
           </div>

           <div class="col-3">
            <label>Materno:</label>
            <input id="materno_prop" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
           </div>

           <div class="col-8">
            <label>Domicilio:</label>
            <input id="domicilio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
           </div>

           <div class="form-group col-sm-6 col-md-2 col-xl-2">
            <label>Genero :</label>
            <select name="genero" id="genero_prop" class="form-control">            
                <option value="MASCULINO">MASCULINO</option>
                <option value="FEMENINO">FEMENINO</option>        
            </select>
            </div>
           
           
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <h4>Datos Difuntos</h4>
        </div>
        <div class="col-sm-12 col-md-12 col-xl-12">
            <label for="">Ingrese la cantidad de difuntos a adicionar</label>
            <input type="number" name="cantidad_dif_cm" id="cantidad_dif_cm">
        </div>

      
      
        <div class="col-sm-12 col-md-12 col-xl-12">
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

                    {{-- </div>


                    <div class="row"> --}}

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
                    {{-- </div>


                    <div class="row"> --}}

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


                {{-- </div>
                <div class="row"> --}}
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


{{--  lista de difuntos existentes --}}

        <div class="col-sm-12 col-md-12 col-xl-12">
            <h4>Listado de Difuntos en la cripta</h4>
        </div>
        <div class="col-sm-12 col-md-12 col-xl-12">
            <p id="container_difunto">Actualización de datos pendientes</p>
        </div>

      

    </div>

   </div>
    
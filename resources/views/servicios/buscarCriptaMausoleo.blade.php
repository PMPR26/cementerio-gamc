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
            <p id="container_difunto">Actualización de datos pendientes</p>
        </div>
    </div>

   </div>
    
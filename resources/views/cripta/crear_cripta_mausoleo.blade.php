     <!-- Modal crear -->
     <div class="modal fade  animated bounceIn" id="modal-cripta" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Criptas - Mausoleos</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="" id="cmform">
                    <div class="row">
                        <div class="col-12">
                            <label>tipo de registro:</label> <span class="obligatorio">*</span>
                            <select  id="tipo_reg" class="form-control" required>
                                <option value="0">SELECCIONAR</option>
                                <option value="CRIPTA">CRIPTA</option>
                                <option value="MAUSOLEO">MAUSOLEO</option>
                            </select>
                        </div>
                        <input type="hidden" name="letra" id="letra" required>
                    </div>
            <div id="section_data" style="display: none">
                        <br>
                        <h6 class="section_divider card text-white bg-info mb-3 p-4">
                            DATOS DEL MAUSOLEO O CRIPTA
                        </h6>
                        <br>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Familia</label><span class="obligatorio">*</span>
                                <input id="familia" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" required>
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3" id="box_tipo_cripta" style="display: none">
                                <label>Tipo de Cripta</label><span class="obligatorio">*</span>
                                <select  class="form-control select_tipo_cripta" id="tipo_cripta" style="width: 100%" required>
                                    <option selected disabled>Seleccionar</option>
                                            <option value="ENTERRADA">ENTERRADA</option>
                                            <option value="ELEVADA">ELEVADA</option>
                                    </select>
                            </div>
                            <div class="col-sm-12 col-md-3 col-xl-3">
                                <label>Notable</label><span class="obligatorio">*</span>
                                <select name="notable" id="notable" class="form-control">
                                    <option value="">SELECCIONAR</option>
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>

                                </select>
                            </div>

                            <div class="col-sm-12 col-md-2 col-xl-2">
                                <label>altura</label><span class="obligatorio"></span>
                                <input id="altura" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" >
                            </div>

                        </div>

                        <div class="row">
                                        <div class="col-sm-2">
                                                    <label>Cuartel</label><span class="obligatorio">*</span>
                                                    {{-- @php(print_r($cuartel)); --}}
                                                    <select  class="form-control select-cuartel" id="cuartel" style="width: 100%" onchange="generarCodigo()" required>
                                                    <option selected disabled>Seleccione un cuartel</option>
                                                            @foreach ($cuartel as $value)
                                                            <option value="{{ $value->id }}">{{ $value->codigo }}</option>
                                                            @endforeach
                                                    </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Bloque:</label>
                                                <select  class="form-control select-bloque" id="bloque" style="width: 100%" onchange="generarCodigo()">
                                                <option selected disabled>Seleccione un cuartel</option>
                                                </select>
                                            {{-- <input id="cod-cripta" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off"> --}}
                                        </div>

                                        <div class="col-sm-2">
                                            <label>Nro Sitio:</label> <span class="obligatorio">*</span>
                                            <input id="cod-sitio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off"  maxlength="15" onblur="generarCodigo()" required>
                                        </div>

                                        <div class="col-sm-3">
                                            <label>Superficie m2:</label><span class="obligatorio">*</span>
                                            <input id="superficie" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off" onblur="generarCodigo()" required>
                                        </div>



                                            <div class="col-sm-3">
                                                <label>Codigo Anterior:</label>
                                                <input id="cod_cripta_ant" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off"  >
                                                <input id="cod-cripta" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="hidden" class="form-control" autocomplete="off"  onblur="generarCodigo()" readonly>
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Estado de construcción:</label><span class="obligatorio">*</span>
                                                <select name="construido" id="construido" class="form-control" required>
                                                    <option value="ABANDONADA">ABANDONADA</option>
                                                    <option value="COMO_MAUSOLEO_PEQ">CONST. COMO MAUSOLEO PEQ.</option>
                                                    <option value="COMO_MAUSOLEO_GRANDE">CONST. COMO MAUSOLEO GRANDE.</option>
                                                    <option value="CONSTRUIDO">CONSTRUIDO</option>
                                                    <option value="DETERIORO">DETERIORO</option>
                                                    <option value="EN_CONSTRUCCION">EN CONSTRUCCION</option>
                                                    <option value="LOTE">LOTE</option>
                                                    <option value="OBRA_FINA">OBRA FINA</option>
                                                    <option value="OBRA_GRUESA">OBRA GRUESA</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Enterratorios Ocupados:</label>
                                                <input id="enterratorios_ocupados" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Total Enterratorios:</label>
                                                <input id="total_enterratorios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Osarios Ocupados:</label>
                                                <input id="osarios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Total Osarios:</label>
                                                <input id="total_osarios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                            </div>

                                            <div class="col-sm-2">
                                                <label>Cenisarios:</label>
                                                <input id="cenisarios" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" >
                                            </div>



                                            <div class="col-sm-12 col-md-6 col-xl-6">
                                                <label>Foto de la Cripta o Mausoleo:</label>
                                                <div id="foto" class="dropzone" style="text-align: center"> </div>
                                                <hr>
                                                <input type="hidden" id="url-foto">
                                                <br>
                                                <p id="foto_actual"></p>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-xl-6">
                                                <label>Observaciones:</label>
                                                <textarea id="observaciones" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="number" class="form-control" autocomplete="off"  onblur="generarCodigo()" rows="6"> </textarea>
                                                <hr>
                                                <input type="hidden" id="url-foto">
                                            </div>

                        </div>
                                <hr>
                                <h6 class="section_divider card text-white bg-info mb-3 p-4">
                                    DATOS DEL PROPIETARIO DEL MAUSOLEO O CRIPTA
                                </h6>
                                    <p><b>* No llenar esta sección en caso de que el mausoleo o cripta no tenga propietario</b></p>
                                    <p><b>* Si no cuenta con la informacion de nro documento de identidad presione el boton con icono lapiz para generar uno provisional</b></p>
                                    <p><b>* Si no cuenta con la informacion de Nombre propietario llenar con  "NN"</b></p>


                                <br>

                        <div class="row">

                                <div class="col-sm-12 col-md-4 col-xl-4">
                                    <label>Documento de Identidad:</label><span class="obligatorio">*</span>
                                    <div class="input-group input-group-lg">
                                        <input id="dni" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="search" class="form-control" autocomplete="off">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default" id="buscarResp">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-xl-4">
                                    <label>Telefono:</label>
                                    <input id="telefono"  type="number" class="form-control"
                                     oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="8" >
                                </div>

                                <div class="col-sm-12 col-md-4 col-xl-4">
                                    <label>Genero :</label>
                                        <select name="genero" id="genero" class="form-control">
                                            <option value="MASCULINO">MASCULINO</option>
                                            <option value="FEMENINO">FEMENINO</option>
                                        </select>
                                    </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Nombre:</label><span class="obligatorio">*</span>
                                <input id="cripta-name" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Paterno:</label><span class="obligatorio">*</span>
                                <input id="paterno" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off" required>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-4">
                                <label>Materno:</label>
                                <input id="materno" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="row pb-4">
                                <div class="col-sm-12 col-md-10 col-xl-10">
                                    <label>Domicilio:</label>
                                    <input id="domicilio" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" autocomplete="off">
                                </div>
                                <div class="col-sm-6 col-md-2 col-xl-2" id="estado" style="display: none">
                                    <label>Estado:</label>
                                    <select  id="estado" class="form-control">
                                        <option value="ACTIVO">ACTIVO</option>
                                        <option value="INACTIVO">INACTIVO</option>
                                    </select>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-xl-12"><h6 class="section_divider card text-white bg-info mb-3 p-4">DOCUMENTOS RECIBIDOS</h6></div>

                            <div class="col-sm-4 col-md-3 col-xl-3">
                                <label for="">Fecha Adjudicacion</label>
                                <input type="date" name="adjudicacion" id="adjudicacion" class="form-control" >
                                {{-- //placeholder="1990-05-26"  required pattern="\d{4}-\d{2}-\d{2}" --}}
                            </div>

                            <div class="col-sm-8 col-md-9 col-xl-9">
                                <div class="row pl-4">
                                    <p><b>Seleccionar los documentos presentados por el/los propietarios</b></p>
                                </div>
                                <div class="row pl-lg-4">
                                    <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="resolucion" value="resolucion" >
                                        <label for="resolucion" class="custom-control-label clear">Nro Resolución / Nro Testimonio</label>
                                        <br>
                                        <input type="text" name="nro_resolucion" id="nro_resolucion" class="clear"  style="display: none">
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="bienes_m" value="bienes_m" >
                                        <label for="bienes_m" class="custom-control-label">Bienes Municipales</label>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="ci" value="ci"  >
                                        <label for="ci" class="custom-control-label">Carnet de Identidad</label>
                                        <br>
                                        <input type="text" name="nro_ci" id="nro_ci"  style="display: none">
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="planos_aprobados" value="planos_aprobados"  >
                                        <label for="planos_aprobados" class="custom-control-label">Planos Aprobados</label>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-xl-6 custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-danger clear" type="checkbox" id="obs_resolucion" value="obs_resolucion"  >
                                        <label for="obs_resolucion" class="custom-control-label">Observacion</label>
                                        <br>
                                        <input type="text" name="txt_resolucion" id="txt_resolucion" value="" class="form-control clear" style="display: none">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row" id="digital_documents" style="display: none">
                                <div class="col-sm-12 col-md-12 col-xl-12">
                                    <h6 class="section_divider card text-white bg-info mb-3 p-4">CARGAR DOCUMENTOS DIGITALIZADOS</h6>
                                </div>
                                 <div class="col-sm-12 col-md-3 col-xl-3">
                                    <label>Resolución/Testimonio:</label>
                                    <div id="foto_resolucion" class="dropzone" style="text-align: center"> </div>
                                    <hr>
                                    <input type="hidden" id="url_foto_resol">
                                    <br>
                                    <p id="foto_resol"></p>
                                 </div>

                                 <div class="col-sm-12 col-md-3 col-xl-3">
                                    <label>Título de propiedad:</label>
                                    <div id="foto_titulo" class="dropzone" style="text-align: center"> </div>
                                    <hr>
                                    <input type="hidden" id="url_foto_title">
                                    <br>
                                    <p id="foto_title"></p>
                                 </div>

                                 <div class="col-sm-12 col-md-3 col-xl-3">
                                    <label>Carnet de identidad (propietario):</label>
                                    <div id="foto_ci_prop" class="dropzone" style="text-align: center"> </div>
                                    <hr>
                                    <input type="hidden" id="url_foto_prop">
                                    <br>
                                    <p id="foto_prop"></p>
                                 </div>

                                 <div class="col-sm-12 col-md-3 col-xl-3">
                                    <label>Planos aprobados:</label>
                                    <div id="foto_planos" class="dropzone" style="text-align: center"> </div>
                                    <hr>
                                    <input type="hidden" id="url_foto_planos_ap">
                                    <br>
                                    <p id="foto_planos_ap"></p>
                                 </div>
                        </div>

                        <input type="hidden" name="cripta_mausoleo_id"  id="cripta_mausoleo_id" value="">
                         <hr>
                        <div class="col-sm-12" style="text-align: center">
                                <button type="button" id="btn-cripta" class="btn btn-success btn-editar">Guardar</button>
                                <button type="button" style="display:none" id="btn-cripta-editar" class="btn btn-success btn-editar">Guardar Modificación</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
          </div>
            </div>
            <div class="modal-footer">
              <!-- <button type="button" id="edit-cuartel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn-editar-va">Guardar Cambios</button> -->
            </div>
          </div>
        </div>
      </div>


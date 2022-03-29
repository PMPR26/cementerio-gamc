<!-- Modal complementacion de entrega de producto -->
<div class="modal fade fullscreen-modal animated bounceIn" id="modal-register-difunto" data-backdrop="static" tabindex="-1" role="dialog"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align: center">{{ $title_modal }}</h3>
            <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" >&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="card">
                <div class="card-body">
            
                    <div class="row">
                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cedula de Identidad:</label>
                                    <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="ci" autocomplete="off">
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nombre :</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombre" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Primer apellido :</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="primer_apellido" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Segundo apellido :</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="segundo_apellido" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fecha de nacimiento :</label>
                                <input type="date"  class="form-control" placeholder="fecha de nacimiento" id="fecha_nacimiento" >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fecha de defunción :</label>
                                <input type="date"  class="form-control" placeholder="fecha de defuncion" id="fecha_defuncion"  >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Certificado de defunción :</label>
                                <input  type="number" class="form-control" id="certificado_defuncion" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Causa :</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="causa" autocomplete="off">
                            </div>
                        </div>

                        {{-- <div class="col-sm-6">
                         
                            <div class="form-group">
                                <label>Estado civil:</label>
                                <select name="status" id="estado_civil" class="form-control">
            
                                    <option value="SOLTERO"> Soltero/a</option>
                                    <option value="CASADO"> Casado/a</option>
                                    <option value="DIVORCIADO"> Divociado/a</option>
                                    <option value="VIUDO"> Viudo/a</option>

                                </select>
                               
                            </div> 
                        </div> --}}

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo :</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="tipo" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-6">
                 
                            <div class="form-group">
                                <label>Genero :</label>
                                <select name="status" id="genero" class="form-control">
            
                                    <option value="MASCULINO"> Masculino</option>
                                    <option value="FEMENINO"> Femenino</option>
        
                                </select>
                               
                            </div> 
                        </div>
                        <hr>
                        <div class="col-sm-12">
                            <div id="cert-defuncion" class="dropzone" style="text-align: center">
                        </div>
                        <hr>

                        <input type="hidden" id="url-certification">
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>Domicilio :</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="domicilio" autocomplete="off">
                            </div>
                        </div> --}}
                    </div>
            
                   
                    <div class="col-sm-12" style="text-align: center">
                        <button type="button" id="{{ $id_button }}" class="btn btn-success">{{ $title_buton }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div> 
            
                </div>
              </div>
            

        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn-complementacion-producto">Guardar</button>
        </div> --}}
    </div>
</div>
</div>
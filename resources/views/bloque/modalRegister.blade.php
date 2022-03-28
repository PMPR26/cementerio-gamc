

<!-- Modal registro bloque -->
<div class="modal fade fullscreen-modal animated bounceIn" tabindex="-1" id="modal-register-bloque" data-backdrop="static" tabindex="-1" role="dialog"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" style="text-align: center">REGISTRO BLOQUE</h3>
            <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" >&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="col-sm-12 col-md-5 col-xl-5 card m-auto">
                <div class="card-body">
            
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                                <div class="col-sm-12 col-md-12 col-xl-12 form-group">

                                    <label>Cuartel</label>
                                   
                                    <select style="width: 100%"  id="cuartel" >                                      
                                        @foreach($cuartel as $c)
                                        <option value={{ $c->id}}> {{ $c->codigo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label>Codigo:</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="code" autocomplete="off">

                            </div>
                        </div>
                       
                    </div>
            


                    <div class="row" >
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="name" autocomplete="off">
                            </div> 
                        </div>                       
                    </div>

                    <div class="row" >
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <div class="form-group">
                                <label>Estado:</label>
                                <select name="status" id="status" class="form-control">
            
                                    <option value="ACTIVO"> ACTIVO</option>
                                    <option value="INACTIVO"> INACTIVO</option>

                                </select>
                               
                            </div> 
                        </div>                       
                    </div>

                   
                   
                    <div class="col-sm-12" style="text-align: center">
                        <button type="button" id="btn_guardar_bloque" class="btn btn-success">Registrar Bloque</button>
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

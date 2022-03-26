

<!-- Modal complementacion de entrega de producto -->
<div class="modal fade fullscreen-modal animated bounceIn" id="modal-register-bloque" data-backdrop="static" tabindex="-1" role="dialog"
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

            <div class="card">
                <div class="card-body">
            
                    <div class="row">
                        <div class="col-sm-6">
                                <div class="col-sm-6 form-group">
                                    <label for="select2">Cuartel</label>
                                    <select class="form-control js-example-basic-single" name="state">
                                        <option value="AL">Alabama</option>                                          
                                        <option value="WY">Wyoming</option>
                                      </select>
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Codigo Catastral:</label>
                                <input type="text" class="form-control" id="cod-catastro" autocomplete="off">
                            </div>
                        </div>
                       
                    </div>
            


                    <div class="row" >
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Coordenada X:</label>
                                <input type="text" class="form-control" id="coor-x" autocomplete="off">
                            </div> 
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Coordenada Y:</label>
                                <input type="text" class="form-control" id="coor-y" autocomplete="off">
                            </div> 
                        </div>
                    </div>

                    <div class="col-sm-12" style="text-align: center">
                            <button type="button" id="search-coordinated" class="btn btn-info col-4"><i class="fab fa-sistrix"></i> Buscar</button>
                    </div>

                    <div class="row">
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Distrito:</label>
                                <input type="text" class="form-control" id="distrito" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Sub Distrito:</label>
                                <input type="text" class="form-control" id="sub-distrito" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Comuna:</label>
                                <input type="text" style="text-transform:uppercase;" class="form-control" id="comuna" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Zona:</label>
                                <input type="text" class="form-control" id="zona" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Manzano:</label>
                                <input type="text" class="form-control" id="manzano" autocomplete="off">
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-sm-12" style="text-align: center">
                        <button type="button" id="btn-ubicacion" class="btn btn-success">Registrar Ubicación</button>
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

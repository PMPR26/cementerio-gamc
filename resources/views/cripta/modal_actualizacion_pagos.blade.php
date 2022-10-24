    <!-- Modal crear -->
    <div class="modal fade  animated bounceIn" id="modal_up_pay_info" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Actualizacion estado de pagos de servicios Cripta - Mausoleos</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form action="#" method="POST" >
                        <fieldset>
                            <legend>Información de la Cripta o Mausoleo</legend>
                                        <div class="row">
                                            <input type="hidden" name="id_cripta_mausoleo_modal_pay_info" id="id_cripta_mausoleo_modal_pay_info" >
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Código:</label>
                                                    <p id="cod_cm_info"></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Responsable :</label>
                                                    <p id="resp_cm_info"></p>
                                                </div>
                                            </div>
                                    </div>
                        </fieldset>

                        <fieldset>
                             <legend>Datos de la persona que realizó el pago</legend>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Documento de Identidad:</label><span class="obligatorio">*</span>
                                        <div class="input-group input-group-lg">
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upci" autocomplete="off" value="">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default" id="upbuscarResp">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Nombre :</label>
                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upnombre" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Primer apellido :</label>
                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upprimer_apellido" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Segundo apellido :</label>
                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upsegundo_apellido" autocomplete="off">
                                                    </div>
                                                </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Datos del pago</legend>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label>Gestiones Pagadas: <i>((*) escribir las gestiones separados por comas)</i></label>

                                            <input type="text" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upgestiones" placeholder="2019,2020,2021" autocomplete="off" min="0">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Ultima gestion Pagada:</label>
                                            <input type="number" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upultima_gestion" autocomplete="off" min="0">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>Fecha de pago:</label>
                                            <input type="date" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upfecha_pago" autocomplete="off" min="0" value="{{ Date('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nro.gestiones pagadas:</label>
                                            <input type="number" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upcantidad_gestion" autocomplete="off" min="0">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nro. FUR:</label>
                                            <input type="number" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="upfur" autocomplete="off" min="0">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Monto Pagado:</label>
                                            <input type="text" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"  class="form-control clear" id="upmonto" autocomplete="off">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Glosa:</label>
                                            <textarea name="upglosa" id="upglosa"  class="form-control clear" cols="30" rows="2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Observación/Información complementaria:</label>
                                            <textarea name="upobservacion" id="upobservacion"  class="form-control clear" cols="30" rows="2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            {{-- end row --}}


                            <div class="row">
                                <div class="col-md">
                                    <button class="btn btn-primary" id="btn_modal_up_pay_info">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- end modal body --}}
            </div>
            {{-- end modal content --}}
        </div>
     </div>


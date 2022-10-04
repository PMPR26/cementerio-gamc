    <!-- Modal crear -->
    <div class="modal fade  animated bounceIn" id="modal_uppay_cm" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <legend>Datos de la persona que realizo el pago</legend>
                                <div class="row">

                                    <input type="hidden" name="id_cripta_mausoleo_modal" id="id_cripta_mausoleo_modal" >
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Cedula de Identidad:</label>
                                                <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdci" autocomplete="off" value="">
                                            </div>
                                        </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Nombre :</label>
                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdnombre" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Primer apellido :</label>
                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdprimer_apellido" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Segundo apellido :</label>
                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdsegundo_apellido" autocomplete="off">
                                                    </div>
                                                </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Datos del pago</legend>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Ultima gestion Pagada:</label>
                                            <input type="number" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdsegundo_apellido" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Monto Pagado:</label>
                                            <input type="number" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdsegundo_apellido" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            {{-- end row --}}


                            <div class="row">
                                <div class="col-md">
                                    <button class="btn btn-primary" id="modal_save_difuntos" disabled=disabled>Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- end modal body --}}
            </div>
            {{-- end modal content --}}
        </div>
     </div>


    <!-- Modal crear -->
    <div class="modal fade  animated bounceIn" id="modal_pay_cm" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Pago servicios Cripta - Mausoleos</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form action="#" method="POST" >

                            <div class="row">
                                    <input type="hidden" name="id_cripta_mausoleo_modal_pay" id="id_cripta_mausoleo_modal_pay" >
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Código:</label>
                                            <p id="cod_cm"></p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Responsable :</label>
                                            <p id="resp_cm"></p>
                                        </div>
                                    </div>
                            </div>
                            {{-- end row --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Tipo Servicio</label>
                                    <select id="tipo_servicio_value_cm"
                                        class="form-control select2-multiple select2-hidden-accessible" style="width: 100%">

                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label>Servicio</label>
                                    <select id="servicio-hijos"
                                        class="form-control select2-multiple select2-hidden-accessible" style="width: 100%">
                                        <option value="">Seleccionar</option>

                                    </select>
                                </div>




                                <div class="col-sm-6" id="service" style="display:none">
                                    <label>Servicio</label>
                                    <select id="servicio-hijos" class="form-control select2-multiple select2-hidden-accessible"
                                        style="width: 100%"></select>
                                </div>
                            </div>


                <div class="card">
                    <div class="card-header">
                        <h4>DETALLE DE SERVICIOS SOLICITADOS</h4>
                    </div>

                    <div class="row" style="padding-top: 15px;">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body" id="servicios-data">
                                    Ningun dato seleccionado.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body" id="servicios-hijos">
                                    Ningun dato seleccionado.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="cal_price" style="text-align: center">
                        <div class="card">
                            <div class="card-body" id="servicios-hijos-price" style="text-align: center">



                            </div>
                            <h1><span id="totalServ"> 0 </span> Bs</h1>
                            <input type="hidden" name="totalservicios" id="totalservicios" value="0"
                                class="form-control">
                        </div>
                    </div>
                </div>



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


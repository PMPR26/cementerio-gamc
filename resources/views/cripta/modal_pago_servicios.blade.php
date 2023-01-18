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
                                            <p id="tipo_registro"></p>


                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Responsable :</label>
                                            <p id="resp_cm_id" style="display:none"></p>
                                            <p id="resp_cm"></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p id="difuntos_cm1" style="display: none"></p>

                                        <label>Difuntos:</label>
                                        <p id="field_difuntos">
                                                <table class="tabla_difunto_pay table table-striped table-bordered responsive"  role="grid"  aria-describedby="tabla_difunto">
                                                    <thead>
                                                        <tr>
                                                            <th>Condicion</th>
                                                            <th>Cedula</th>
                                                            <th>Nombre</th>
                                                            <th>Paterno</th>
                                                            <th>Materno</th>
                                                            <th>cereci</th>
                                                            <th>tipo</th>
                                                            <th>Fecha Nacimiento</th>
                                                            <th>Edad</th>
                                                            <th>Fecha Defunción</th>
                                                            <th>Causa</th>
                                                            <th>Funeraria</th>
                                                            <th>Genero</th>
                                                            <th>enl</th>
                                                            <th>url</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabla_difunto_row_pay" >

                                                    </tbody>
                                                </table>
                                        </p>
                                    </div>
                                    <input type="hidden" name="inhumacion"  id="inhumacion" value="NO">
                                    <input type="hidden" name="exhumacion"  id="exhumacion_txt" value="NO">
                            </div>
                            {{-- end row --}}

                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <label>Tipo Servicio</label>
                                    <select id="tipo_servicio_value_cm"
                                        class="form-control select2-multiple select2-hidden-accessible" style="width: 100%">

                                    </select>
                                </div> --}}

                                {{-- <div class="col-sm-6">
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
                                </div> --}}
                            </div>
                <div class="row">
                    <div class="col-12" id="contenedor_servicios" >
                        <h5>SERVICIOS CRIPA-MAUSOLEOS </h5>
                    </div>
                </div>



                    <div class="card row" style="padding-top: 15px;">
                        <form action="#" method="POST" >
                            <div class="row section_difunto" id="section_difunto" style="display: none;">
                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                        <label>Documento de Identidad:</label><span class="obligatorio">*</span>
                                        <div class="input-group input-group-lg">
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdpci" autocomplete="off" value="">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-lg btn-default" id="buscarDif">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nombre :</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdpnombre" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Primer apellido :</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdpprimer_apellido" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Segundo apellido :</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdpsegundo_apellido" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Fecha de nacimiento :</label>
                                            <input type="date"  class="form-control clear" max="{{ date('Y-m-d') }}" placeholder="fecha de nacimiento" id="mdpfecha_nacimiento" >
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Fecha de defunción :</label>
                                            <input type="date"  class="form-control clear" placeholder="fecha de defuncion" max="{{ date('Y-m-d') }}" id="mdpfecha_defuncion"  >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>SERECI:</label>
                                            <input  type="number" class="form-control clear" id="mdpcertificado_defuncion" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Causa :</label>
                                            <select id="causa_p"
                                            class="form-control clears2 select2-multiple select2-hidden-accessible" style="width: 100%">
                                            <option value="">SELECIONAR CAUSA</option>
                                                @foreach ($causa as $c)
                                                        <option value="{{ $c->causa }}">{{$c->causa }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tipo :</label>
                                            <select name="tipo_dif" id="mdptipo" class="form-control clears2">
                                                <option value="">Seleccionar</option>
                                                <option value="ADULTO">ADULTO</option>
                                                <option value="PARVULO">PARVULO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Genero :</label>
                                            <select name="status" id="mdpgenero" class="form-control clears">
                                                <option value="">Seleccionar</option>
                                                <option value="MASCULINO">MASCULINO</option>
                                                <option value="FEMENINO">FEMENINO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-sm-12 col-md-6 col-xl-6">
                                        <label>Funeraria</label>
                                                <select id="funeraria_p"
                                                    class="form-control clears2 select2-multiple select2-hidden-accessible" style="width: 100%">
                                                    <option value="">SELECIONAR FUNERARIA</option>
                                                    @foreach ($funeraria as $f)
                                                            <option value="{{ $f->funeraria }}">{{$f->funeraria }}</option>
                                                    @endforeach
                                                </select>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-xl-6">
                                        <div class="row archivo">
                                            <div class="col-sm-8 col-md-8 col-xl-8">
                                                <label>Adjuntar certificado de defunción :</label>
                                                <div id="cert_defuncion_p" class="dropzone cleardrop" style="text-align: center">
                                                </div>
                                                <hr>
                                                <input type="hidden" id="mdurl-certification-p" class="form-control clear">
                                            </div>
                                            <div class="col-sm-8 col-md-8 col-xl-8">
                                               <span id="adjunto_p"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-info expanding-card" id="boton_dif_inhum">Agregar datos del difunto</button>
                                    </div>


                            </div>
                       </form>

                                <div class="card-body" id="difuntos-data">
                                </div>
                     </div>




                <div class="card">
                    <div class="card-header">
                        <h4>DETALLE DE SERVICIOS SOLICITADOS</h4>
                    </div>

                    <div class="row" style="padding-top: 15px;">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body" >
                                    <table border="1" class="detalle_servicios" style="display: none">
                                        <thead>
                                            <tr>
                                                <td>Cuenta Tipo Servicio</td>
                                                <td>Cuenta Servicio</td>
                                                <td>Tipo Servicio</td>
                                                <td>Servicio</td>
                                                <td>Precio</td>
                                            </tr>
                                        </thead>
                                        <tbody id="servicios-data">

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="cal_price" style="text-align: center">
                        <div class="card">
                            <div class="card-body" id="servicios-hijos-price" style="text-align: center">
                            </div>
                            <h1><span>Total :</span><span id="totalServ"> 0 </span> Bs</h1>
                            <input type="hidden" name="totalservicios" id="totalservicios" value="0"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12"><h6>Datos de la persona que realizara el pago:</h6></div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label>Pagado por:</label>
                        <select name="tipo_resp" id="tipo_resp" class="form-control" required>
                            <option value="Titular_responsable">Titular responsable</option>
                            <option value="Tercero_responsable">Tercero Responsable</option>
                        </select>

                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label>C.I:</label>
                        <input type="text" class="form-control clear" id="cm_ci" autocomplete="off" required>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label>Nombre</label>
                        <input type="text" class="form-control clear" id="cm_nombre_pago" autocomplete="off" required>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label>Apellido Paterno:</label>
                        <input type="text" class="form-control clear" id="cm_paternopago" autocomplete="off" required>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label>Apellido Materno:</label>
                        <input type="text" class="form-control clear" id="cm_maternopago" autocomplete="off">
                    </div>



                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Observación:</label>
                        <textarea name="cm_observacion" class="form-control clear" id="cm_observacion" cols="100" rows="3"></textarea>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label>Domicilio:</label>
                        <textarea name="cm_domicilio" class="form-control clear" id="cm_domicilio" cols="100" rows="3"></textarea>
                    </div>


                </div>



                            <div class="row">
                                <div class="col-md">
                                    <button class="btn btn-primary" id="modal_save_pagos_cm" >Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- end modal body --}}
            </div>
            {{-- end modal content --}}
        </div>
     </div>


    <!-- Modal crear -->
    <div class="modal fade  animated bounceIn" id="modal_add_difunto" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicción difuntos Criptas - Mausoleos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form action="#" method="POST" >

                            <div class="row">

                                <input type="hidden" name="id_cripta_mausoleo_modal" id="id_cripta_mausoleo_modal" >


                                    <div class="col-sm-12 col-md-4 col-xl-4">
                                        <label>Documento de Identidad:</label><span class="obligatorio">*</span>
                                        <div class="input-group input-group-lg">                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control clear" id="mdci" autocomplete="off" value="">

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

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Fecha de nacimiento :</label>
                                                    <input type="date"  class="form-control clear" max="{{ date('Y-m-d') }}" placeholder="fecha de nacimiento" id="mdfecha_nacimiento" >
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Fecha de defunción :</label>
                                                    <input type="date"  class="form-control clear" placeholder="fecha de defuncion" max="{{ date('Y-m-d') }}" id="mdfecha_defuncion"  >
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>SERECI:</label>
                                                    <input  type="number" class="form-control clear" id="mdcertificado_defuncion" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Causa :</label>
                                                    <select id="causa"
                                                    class="form-control clears2 select2-multiple select2-hidden-accessible" style="width: 100%">
                                                    <option value="">SELECIONAR CAUSA</option>
                                                    @foreach ($causa as $cs)
                                                            <option value="{{ $cs->causa }}">{{$cs->causa }}</option>
                                                    @endforeach
                                                </select>

                                                </div>
                                            </div>



                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tipo :</label>
                                                    <select name="tipo_dif" id="mdtipo" class="form-control clears2">
                                                        <option value="">Seleccionar</option>
                                                        <option value="ADULTO">ADULTO</option>
                                                        <option value="PARVULO">PARVULO</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Genero :</label>
                                                    <select name="status" id="mdgenero" class="form-control clears">
                                                        <option value="">Seleccionar</option>
                                                        <option value="MASCULINO">MASCULINO</option>
                                                        <option value="FEMENINO">FEMENINO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="col-sm-12 col-md-6 col-xl-6">
                                                <label>Funeraria</label>
                                                        <select id="funeraria"
                                                            class="form-control clears2 select2-multiple select2-hidden-accessible" style="width: 100%">
                                                            <option value="">SELECIONAR FUNERARIA</option>
                                                            @foreach ($funeraria as $fun)
                                                                    <option value="{{ $fun->funeraria }}">{{$fun->funeraria }}</option>
                                                            @endforeach
                                                        </select>
                                            </div>
                                             <div class="col-sm-12 col-md-6 col-xl-6">
                                                <div class="row">
                                                    <div class="col-sm-8 col-md-8 col-xl-8">
                                                        <label>Adjuntar certificado de defunción :</label>
                                                        <div id="cert_defuncion" class="dropzone cleardrop" style="text-align: center">
                                                        </div>
                                                        <hr>
                                                        <input type="hidden" id="mdurl-certification" class="form-control clear">
                                                    </div>
                                                    <div class="col-sm-8 col-md-8 col-xl-8">
                                                       <span id="adjunto"></span>
                                                    </div>
                                                </div>

                                              </div>


                            </div>
                            {{-- end row --}}
                            <div class="row p-4">
                                <div class="col-sm-12 col-md-12 col-xl-12">
                                    <button class="btn btn-primary" id="add_difunto_row"><i class="fa fa-plus 3x"></i> Agregar Difunto</button>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-md-12 card card-info">
                                <h3>REGISTRO DE DIFUNTOS INGRESADOS</h3>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-xl-12 p-4">
                                    <table class="tabla_difunto table table-striped table-bordered responsive"  role="grid"  aria-describedby="tabla_difunto">

                                        <thead>
                                            <tr>
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
                                        <tbody id="tabla_difunto_row" >

                                        </tbody>
                                    </table>
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


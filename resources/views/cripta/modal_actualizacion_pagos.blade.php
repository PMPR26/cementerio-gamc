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
                                </div>
                            </fieldset>
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



                            </div>
                            {{-- end row --}}
                            <div class="row p-4">
                                <div class="col-sm-12 col-md-12 col-xl-12">
                                    <button class="btn btn-primary" id="add_difunto_row"><i class="fa fa-plus 3x"></i> Agregar Difunto</button>
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


@extends('adminlte::page')
@section('title', 'Criptas')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)
@section('plugins.dropzone', true)


<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

@section('content_header')
    <h1>Gestion de Criptas y Mausoleos</h1>
@stop


    <style>
        .obligatorio{
            color: red;
            font-weight: 900;
        }
        .labelservice{
            color: rgb(21, 24, 23);
            font-weight: 900;
        }
       .childservice{
            color: rgb(46, 147, 144);
            font-weight: 900;
        }

    </style>

@section('content')

<div class="card">
    <div class="card-body">

    <div class="row">
        <div class="col-sm-6">
        <button id="new-cripta" type="button" class="btn btn-info col-sm-12" > <i class="fas fa-plus-circle text-white fa-2x"></i> Nueva Cripta</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3>Busqueda avanzada</h3>
        </div>
    </div>
    <form action="{{ route('cripta.index') }}">
            <div class="row">
                <div class="col-sm-3">
                    <label>Cuartel</label>
                    <select  class="form-control select_cuartel_search" name="select_cuartel_search"  id="select_cuartel_search" style="width: 100%" >
                    <option selected disabled>Seleccione un cuartel</option>
                            @foreach ($cuartel as $val)
                            <option value="{{ $val->id }}">{{ $val->codigo }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label>Bloque</label>
                    <select  class="form-control bloque_search" name="bloque_search"  id="bloque_search" style="width: 100%" >
                    </select>
                </div>
                <div class="col-2">
                    <label>Sitio</label>
                    <input type="text"  class="form-control sitio_search" name="sitio_search"  id="sitio_search" style="width: 100%" />
                </div>
                <div class="col-2 pt-2">
                    <br>
                    <input type="submit"  class="btn btn-success" name="advanced_search" style="width: 100%" value="Buscar" />
                </div>
                <div class="col-2 pt-2">
                    <br>
                    <input type="submit"  class="btn btn-info" name="todos" style="width: 100%"  value="Cargar todos"/>
                </div>
            </div>
    </form>
        </div>
       </div>

       <table id="cripta-data" class="table table-striped table-bordered responsive" role="grid"
    aria-describedby="example">
    <thead class="bg-table-header">
            <tr role="row">
                <th scope="col">#</th>
                <th scope="col">Tipo</th>
                <th scope="col">Código</th>
                <th scope="col">Cuartel</th>
                <th scope="col">Bloque</th>
                <th scope="col">Sitio</th>
                <th scope="col">Familia</th>
                <th scope="col">Propietario</th>
                <th scope="col">Documentos Recibidos</th>
                <th scope="col">Superficie</th>
                <th scope="col">Enterratorio Ocupados</th>
                <th scope="col">Total Enterratorio</th>
                <th scope="col">Osarios Ocupados</th>
                <th scope="col">Total Osarios</th>
                <th scope="col">Cenisario</th>
                <th scope="col">Ultima Gestion Pagada</th>
                <th scope="col">Notable</th>
                <th scope="col">Difuntos</th>
                <th scope="col">Estado</th>
                <th scope="col">Operaciones</th>
            </tr>
        </thead>

        <tbody>
            @php($count = 1)
            @foreach ($cripta as $cripta)

                <tr>
                    <td scope="row">{{ $count++ }}</td>
                    <td>{{ $cripta->tipo_registro }}</td>
                    <td>{{ $cripta->codigo }}</td>
                    <td>{{ $cripta->cuartel_codigo }}</td>
                    <td>{{ $cripta->bloque_nombre ?? '' }}</td>
                    <td>{{ $cripta->sitio }}</td>
                    <td>{{ $cripta->familia ?? '' }}</td>
                    @if($cripta->estado_rel_resp=='ACTIVO')

                    <td>{{ $cripta->nombre }}</td>
                    <td>
                        <?php
                            if($cripta->documentos_recibidos !=null || !empty($cripta->documentos_recibidos)){
                                $v=json_decode($cripta->documentos_recibidos, true);
                                echo "<psan>resolucion nro. " .$v['resolucion']. " ,  ".$v['bienes_m']. ", ci del propietario ".$v['ci'] ?? ''. ", ".$v['planos_aprobados']."  </span><br>";
                                    if(isset($v['foto_resolucion'])){if($v['foto_resolucion']!=null ){echo "<span>|<a href='" .$v['foto_resolucion']. "'> Resolución </a>|</span>"; }}
                                    if(isset($v['foto_titulo'])){if($v['foto_titulo']!=null ){echo "<span>|<a href='" .$v['foto_titulo']. "'> Titulo de propiedad </a>|</span>"; }}
                                    if(isset($v['foto_prop_ci'])){if($v['foto_prop_ci']!=null ){echo "<span>|<a href='" .$v['foto_prop_ci']. "'> ci propietario </a>|</span>"; }}
                                    if(isset($v['foto_planos'])){if($v['foto_planos']!=null ){echo "<span>|<a href='" .$v['foto_planos']. "'> Planos aprobados </a>|</span>"; }}
                            }
                    ?>
                    </td>
                    @else
                    <td>SIN ASIGANCION</td>
                    <td>
                       SIN RECEPCION
                    </td>
                    @endif
                    <td>{{ $cripta->superficie }}</td>
                    <td>{{ $cripta->enterratorios_ocupados }}</td>
                    <td>{{ $cripta->total_enterratorios }}</td>
                    <td>{{ $cripta->osarios }}</td>
                    <td>{{ $cripta->total_osarios }}</td>
                    <td>{{ $cripta->cenisarios }}</td>
                    <td>{{ $cripta->ultimo_pago }}</td>
                    <td>{{ $cripta->notable }}</td>

                    <td><?php
                            if($cripta->difuntos !=null || !empty($cripta->difuntos)){
                                foreach (json_decode($cripta->difuntos) as $key => $value) {
                                    echo "<psan> " .$value->ci. " ".$value->nombres. " ".$value->primer_apellido ?? ''. "  </span>";
                                }
                            }
                    ?></td>


                    <td>{{ $cripta->estado }}</td>

                    <td>
                        <button type="button" class="btn btn-info" value="{{ $cripta->id }}" id="btn-editar" title="Editar cuartel"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-warning" value="{{ $cripta->id }}" id="btn_add_difunto" title="Adicionar Difunto"><i class="fa fa-user-plus"></i></button>
                        <button type="button" class="btn btn-danger" value="{{ $cripta->id }}" id="btn_up_pay_info" title="Actualizar información de  pagos servicios"><i class="fa fa-refresh"></i></button>

                        <button type="button" class="btn btn-success" value="{{ $cripta->id }}" id="btn_pay_cm" title="Pagar servicios"><i class="fa fa-money"></i></button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


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
                        <div class="col-sm-12 col-md-6 col-xl-6">
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



   @include('cripta/modal_difunto_cripta')
   @include('cripta/modal_actualizacion_pagos')


   @include('cripta/modal_pago_servicios')




@stop

@section('css')
<style>
    .modal {
    padding: 2% !important;
    }
    .modal .modal-dialog {
    width: 100%;
    max-width: none;

    margin: 0;
    }
    .modal .modal-content {
    height: 95%;
    border: 0;
    border-radius: 0;
    }
    .modal .modal-body {
    overflow-y: auto;
    }
</style>
@stop

@section('js')
    <script>
/*****************************************************************************************/
/***seleccion tipo de sitio-inicio de cargado de modal registro de cripta mausoleo******/
/****************************************************************************************/


  var letra="";
  $(document).on('change', '#tipo_reg', function(){
        $('#tipo_reg option').each(function() {
            if(this.selected)
            {
                var val=$('#tipo_reg option:selected').val();
                    if(val==0){
                        Swal.fire(
                            'Seleccione Cripta o Mausoleo!',
                            'Debe especificar el tipo de registro que desea realizar .',
                            'error'
                            )

                            $('#section_data').hide();
                    }else if(val=="CRIPTA"){
                         $('#letra').val("C");
                         $('#section_data').show();
                         $('#box_tipo_cripta').show();
                         $('#box_tipo_cripta').prop('disabled', false);
                    }
                    else if(val=="MAUSOLEO"){
                        $('#letra').val("M");
                        $('#section_data').show();
                        $('#box_tipo_cripta').hide();
                        $('#box_tipo_cripta').prop('disabled', true);
                    }


            }
        });

  });

/***************************************************************************************/
/******************************* modal actualizacion de pagos **************************/
/**************************************************************************************/
        $(document).on('click', '#btn_up_pay_info', function(){
                    $('#modal_up_pay_info').modal('show');
                    $('#id_cripta_mausoleo_modal_pay_info').val($(this).val());
                    // buscar si hay difuntos ingresados
                    $.ajax({
                        type: 'GET',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url: '/cripta/get-cripta/' + $(this).val(),
                                success: function(data)
                                {
                                    console.log(data);
                                    if(data.status!=null )
                                    {
                                        $('#cod_cm_info').html(data.response.cripta.codigo);
                                        $('#resp_cm_info').html(data.response.responsable.nombres+" "+data.response.responsable.primer_apellido+" "+data.response.responsable.segundo_apellido);

                                    }//end if
                                }
                    });

                    $.ajax({
                        type: 'GET',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url: '/mantenimiento/get-mantenimiento/' + $(this).val(),
                                success: function(mant)
                                {
                                    console.log(mant);
                                    if(mant.status==true )
                                    {
                                        $('#upci').val(mant.resp.ci);
                                        $('#upnombre').val(mant.resp.nombrepago);
                                        $('#upprimer_apellido').val(mant.resp.paternopago);
                                        $('#upsegundo_apellido').val(mant.resp.maternopago);
                                        $('#upgestiones').val(mant.resp.gestion);
                                        $('#upultima_gestion').val(mant.resp.ultimo_pago);
                                        $('#upcantidad_gestion').val(mant.resp.cantidad_gestiones);
                                        $('#upfur').val(mant.resp.fur);
                                        $('#upmonto').val(mant.resp.monto);
                                        $('#upglosa').val(mant.resp.glosa);
                                        $('#upobservacion').val(mant.resp.observacion);
                                        if(mant.resp.fecha_pago!=null){
                                            d=mant.resp.fecha_pago;
                                            var d=(mant.resp.fecha_pago).split(' ');
                                            $('#upfecha_pago').val(d[0]);
                                        }


                                    }//end if
                                }
                    });
        });

        //btn_modal_up_pay_info
        // send update pagos
        $(document).on('click', '#btn_modal_up_pay_info', function(e){
            e.preventDefault();

                        $.ajax({
                                            type: 'POST',
                                            headers: {
                                                'Content-Type':'application/json',
                                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                            },
                                            url: '{{ route("save.uppay.info") }}',
                                            async: false,
                                            data: JSON.stringify({
                                                'cripta_mausoleo_id': $('#id_cripta_mausoleo_modal_pay_info').val(),
                                                'nombrepago': $('#upnombre').val(),
                                                'paternopago' :  $('#upprimer_apellido').val(),
                                                'maternopago' :  $('#upsegundo_apellido').val(),
                                                'ci' :  $('#upci').val(),
                                                'ultima_gestion': $('#upultima_gestion').val(),
                                                'fur' :  $('#upfur').val(),
                                                'monto' :  $('#upmonto').val(),
                                                'glosa' :  $('#upglosa').val(),
                                                'observacion' :  $('#upobservacion').val(),
                                                'tipo_ubicacion' : "cripta-mausoleo",
                                                'codigo_ubicacion' :  $('#cod_cm_info').html(),
                                                'cantidad_gestiones' :  $('#upcantidad_gestion').val(),
                                                'gestiones' :  $('#upgestiones').val(),
                                                'fecha_pago' :  $('#upfecha_pago').val(),

                                            }),
                                            success: function(data) {
                                                console.log()

                                            }
                                });
        })




/*************************************************************************/
/************************ edicion cripta mausoleo **********************/
/***********************************************************************/
        $(document).ready(function(){
            $(document).on('click','#btn-cripta-editar', function(){

                   var validar= validar_campos();

                   if(validar==false){
                        Swal.fire(
                            'Alerta!',
                            'Debe seleccionar una opcion en el campo notable!.',
                            'error'
                        ) ;

                   }else{


                    if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="0";}
                    else{var bloq=$('#bloque :selected').val();}

                // documentos recibido
                    if ($("#resolucion").is(":checked")) { var resolucion=$('#nro_resolucion').val(); } else { var resolucion="FALTA";}
                    if ($("#ci").is(":checked")) { var ci=$('#nro_ci').val();} else { var ci="FALTA";}
                    if ($("#bienes_m").is(":checked")) { var bienes_m="BIENES M";} else { var bienes_m="FALTA";}
                    if ($("#planos_aprobados").is(":checked")) { var planos_aprobados="PLANOS A";} else { var planos_aprobados="FALTA";}
                    if ($("#obs_resolucion").is(":checked")) { var obs_resolucion=$('#txt_resolucion').val(); } else { var obs_resolucion="FALTA";}
                    if($('#notable :selected').text()=="SELECCIONAR"){ var field_notable=null;}else{ var field_notable= $('#notable :selected').val(); }

                $.ajax({
                        type: 'PUT',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                        },
                        url: '{{ route("cripta.update") }}',
                        async: false,
                        data: JSON.stringify({
                            'cripta_mausoleo_id': $('#cripta_mausoleo_id').val(),
                            'id_cripta':  $('#btn-cripta-editar').val(),
                            'id_cuartel':  $('.select-cuartel').val(),
                            'codigo': $('#cod-cripta').val(),
                            'codigo_ant': $('#cod_cripta_ant').val(),
                            'bloque':bloq,
                            'sitio':$('#cod-sitio').val(),
                            'familia':$('#familia').val(),
                            'tipo_reg':$('#tipo_reg').val(),
                            'nombres_resp': $('#cripta-name').val(),
                            'paterno_resp' :  $('#paterno').val(),
                            'materno_resp' :  $('#materno').val(),
                            'ci_resp' :  $('#dni').val(),
                            'domicilio' :  $('#domicilio').val(),
                            'genero_resp' :  $('#genero').val(),
                            'celular' :  $('#telefono').val(),

                            'superficie': $('#superficie').val(),
                            'nro_cripta' :  $('#nro-cripta').val(),
                            'enterratorios_ocupados' :  $('#enterratorios_ocupados').val(),
                            'total_enterratorios' :  $('#total_enterratorios').val(),

                            'osarios' :  $('#osarios').val(),
                            'total_osarios':$('#total_osarios').val(),
                            'cenisarios' :  $('#cenisarios').val(),

                            'observaciones' :  $('#observaciones').val(),
                            'estado_construccion' :  $('#construido').val(),
                            'tipo_cripta':$('#tipo_cripta option:selected').val(),
                            'adjudicacion':$('#adjudicacion').val(),
                            'notable':field_notable,
                            'foto' :  $('#url-foto').val(),
                            'estado': $('#estado').val() ,
                            'documentos_recibidos':  {
                                                       'resolucion': resolucion,
                                                       'ci': ci,
                                                       'bienes_m': bienes_m,
                                                       'planos_aprobados': planos_aprobados,
                                                       'obs_resolucion':obs_resolucion,
                                                       'foto_resolucion':$('#url_foto_resol').val(),
                                                        'foto_titulo':$('#url_foto_title').val(),
                                                        'foto_prop_ci':$('#url_foto_prop').val(),
                                                        'foto_planos':$('#url_foto_planos_ap').val()
                                                    }


                        }),
                        success: function(data_response) {
                            if(data_response.status){
                                        swal.fire({
                                        title: "Guardado!",
                                        text: "!Registro actualizado con éxito!",
                                        type: "success",
                                        timer: 2000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                        });
                            }else{
                                    swal.fire({
                                    title: "Precaucion!",
                                    text: "!El sitio ya esta ocupado!",
                                    type: "warning",
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                    });
                                }
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function (error) {

                            if(error.status == 422){
                                Object.keys(error.responseJSON.errors).forEach(function(k){
                                toastr["error"](error.responseJSON.errors[k]);

                                });
                            }else if(error.status == 419){
                                location.reload();
                            }

                        }
                    });
                    $('#estado').show();
                }
            });



            $(document).on('click', '#btn-editar', function(){
                $('#cmform').find("input[type=text], input[type=checkbox], textarea").val("");
                  $(this).find('form').trigger('reset');


                // $('#modal-cripta').reset();
                $('#section_data').show();
                $('#estado').show();
                var cripta_mausoleo_id = $(this).val();
                $.ajax({
                        type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/cripta/get-cripta/' + $(this).val(),
                        async: false,
                        success: function(data_query) {
                            console.log(data_query['response']);

                            console.log(data_query['response']['responsable']);
                            var data_response=data_query['response']['cripta'];
                            var data_resp=data_query['response']['responsable'];
                            $('#modal-cripta').modal('show');
                            $('#btn-cripta-editar').show(300);
                            $('#btn-cripta').hide(300);
                            $('#cripta_mausoleo_id').val(cripta_mausoleo_id);
                            $(".select-cuartel").val(data_response.cuartel_id).trigger('change');
                            $('#cod-cripta').val(data_response.codigo);
                            $('#cod_cripta_ant').val(data_response.codigo_antiguo);
                            $('#cod-sitio').val(data_response.sitio);
                            $('#bloque').val(data_response.bloque_id);
                            $('#tipo_reg').val(data_response.tipo_registro);
                            $('#superficie').val(data_response.superficie);
                            $('#estado').val(data_response.estado);
                            $('#btn-cripta-editar').val(data_response.id);

                            $('#construido').val(data_response.estado_construccion);
                            $('#enterratorios_ocupados').val(data_response.enterratorios_ocupados);
                            $('#total_enterratorios').val(data_response.total_enterratorios);
                            $('#osarios').val(data_response.osarios);
                            $('#total_osarios').val(data_response.total_osarios);
                            $('#cenisarios').val(data_response.cenisarios);
                            $('#observaciones').val(data_response.observaciones);
                            $('#familia').val(data_response.familia);

                            if(data_resp!=null){
                            $('#cripta-name').val(data_resp.nombres);
                            $('#paterno').val(data_resp.primer_apellido);
                            $('#materno').val(data_resp.segundo_apellido);
                            $('#dni').val(data_resp.ci);
                            $('#domicilio').val(data_resp.domicilio);
                            $('#genero_resp').val(data_resp.genero);
                            $('#telefono').val(data_resp.celular);

                            $('#adjudicacion').val(data_resp.adjudicacion);

                            if(data_resp.documentos_recibidos){
                                var ar=JSON.parse(data_resp.documentos_recibidos);
                                console.log(ar);
                                if(ar.bienes_m=="BIENES M"){ $('#bienes_m').prop('checked', true); }else{$('#bienes_m').prop('checked', false);}
                                if(ar.ci!="FALTA"){ $('#ci').prop('checked', true); $('#nro_ci').val(ar.ci); $('#nro_ci').show(); $('#digital_documents').show(); }else{$('#ci').prop('checked', false);}
                                if(ar.resolucion!="FALTA"){ $('#resolucion').prop('checked', true); $('#nro_resolucion').val(ar.resolucion); $('#nro_resolucion').show(); }else{$('#resolucion').prop('checked', false);}
                                if(ar.planos_aprobados=="PLANOS A"){ $('#planos_aprobados').prop('checked', true); }else{$('#planos_aprobados').prop('checked', false);}
                                if(ar.obs_resolucion!="FALTA"){ $('#obs_resolucion').prop('checked', true); $('#txt_resolucion').val(ar.obs_resolucion); $('#txt_resolucion').show(); }else{$('#obs_resolucion').prop('checked', false);}


                                //resolucion
                                if(ar.foto_resolucion!=null){
                                    $('#url_foto_resol').val(ar.foto_resolucion)  ;
                                    $('#foto_resol').append('<a href="'+ ar.foto_resolucion+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_resol').append('<img src="'+ ar.foto_resolucion+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_resol').empty();
                                            $('#foto_resol').hide();
                                    }
                                 //titulo de propiedad
                                 if(ar.foto_titulo!=null){
                                    $('#url_foto_title').val(ar.foto_titulo)  ;
                                    $('#foto_title').append('<a href="'+ ar.foto_titulo+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_title').append('<img src="'+ ar.foto_titulo+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_title').empty();
                                            $('#foto_title').hide();
                                    }

                                // ci propietario
                                 if(ar.foto_prop_ci!=null){
                                    $('#url_foto_prop').val(ar.foto_prop_ci)  ;
                                    $('#foto_prop').append('<a href="'+ ar.foto_prop_ci+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_prop').append('<img src="'+ ar.foto_prop_ci+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_prop').empty();
                                            $('#foto_prop').hide();
                                    }

                                //planos aprobados
                                if(ar.foto_planos!=null){
                                    $('#url_foto_planos_ap').val(ar.foto_planos)  ;
                                    $('#foto_planos_ap').append('<a href="'+ ar.foto_planos+'" target="_blank">Ver foto actual </a>');
                                    $('#foto_planos_ap').append('<img src="'+ ar.foto_planos+'" widh="100px" heigth="100"');
                                    }else{
                                            $('#foto_planos_ap').empty();
                                            $('#foto_planos_ap').hide();
                                    }
                            }
                        }


                             $('#notable').val(data_response.notable);


                            if(data_response.foto!=null){
                               $('#url-foto').val(data_response.foto)  ;
                               $('#foto_actual').append('<a href="'+ data_response.foto+'" target="_blank">Ver foto actual </a>');
                               $('#foto_actual').append('<img src="'+ data_response.foto+'" widh="100px" heigth="100"');


                            }else{
                                    $('#foto_actual').empty();
                                    $('#foto_actual').hide();
                            }
                            if($('#tipo_reg option:selected').val() =="CRIPTA"){
                                        $('#letra').val("C");
                                        $('#box_tipo_cripta').show();
                                        $('#box_tipo_cripta').prop('disabled', false);
                                        $('#tipo_cripta').val(data_response.tipo_cripta);
                                 }else{
                                    $('#letra').val("M");
                                    $('#box_tipo_cripta').hide();
                                    $('#box_tipo_cripta').prop('disabled', true);
                                    $('#tipo_cripta').val("");
                                 }


                        }

                    });

            });



            $(document).on('click','#new-cripta', function(){

                $(".select-cuartel").val('').trigger('change');
                $('#cod-cripta').val('');
                $('#cod_cripta_ant').val('');
                $('#cripta-name').val('');
                $('#bloque').val('');
                $('#cod-sitio').val('');
                $('#superficie').val('');
                $('#construido').val(''),
                $('#enterratorios_ocupados').val(0),
                $('#total_enterratorios').val(0),

                $('#osarios').val(0),
                $('#total_osarios').val(0),

                $('#cenisarios').val(0),

                $('#observaciones').val(''),
                $('#url-foto').val(''),
                $('#domicilio').val(''),
                $('#genero').val(''),
                $('#telefono').val(''),

                $('#modal-cripta').modal('show');
                $('#btn-cripta-editar').hide(300);
                $('#btn-cripta').show(300);
                $('#familia').val('');
                $('#tipo_cripta').val('');
                $('#resolucion').prop('checked', false);

                $('#ci').prop('checked', false);
                $('#nro_ci').val(''),
                $('#nro_resolucion').val(''),
                $('#notable').val(''),


                $('#planos_aprobados').prop('checked', false);
                $('#bienes_m').prop('checked', false);





            });


            $(".select-cuartel").select2({
                width: 'resolve', // need to override the changed default
                dropdownParent: $('#modal-cripta')
            });

               //select2 bloque
            $("#bloque").select2({
                width: 'resolve', // need to override the changed default
                dropdownParent: $('#modal-cripta')
              });

             // select cuartel for search
              $(".select_cuartel_search").select2({
                width: 'resolve', // need to override the changed default
            });
            $("#bloque_search").select2({
                width: 'resolve', // need to override the changed default

              });


            $(document).on('click','#btn-cripta', function()
            {
                var validar= validar_campos();

                   if(validar==false){
                        Swal.fire(
                            'Alerta!',
                            'Debe seleccionar una opcion en el campo notable!.',
                            'error'
                        ) ;

                   }else{



                if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="0";}else{var bloq=$('#bloque :selected').val();}
                // documentos recibido
                    if ($("#resolucion").is(":checked")) { var resolucion=$('#nro_resolucion').val(); } else { var resolucion="FALTA";}
                    if ($("#ci").is(":checked")) { var ci=$('#nro_ci').val(); $('#digital_documents').show(); } else { var ci="FALTA";}
                    if ($("#bienes_m").is(":checked")) { var bienes_m="BIENES M";} else { var bienes_m="FALTA";}
                    if ($("#planos_aprobados").is(":checked")) { var planos_aprobados="PLANOS A";} else { var planos_aprobados="FALTA";}

                    if($('#notable :selected').text()=="SELECCIONAR"){ var field_notable=null;}else{ var field_notable= $('#notable :selected').val(); }


                $.ajax({
                        type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('cripta.save') }}",
                        async: false,
                        data: JSON.stringify({
                            'id_cuartel':  $('.select-cuartel').val(),
                            'codigo': $('#cod-cripta').val(),
                            'codigo_ant': $('#cod_cripta_ant').val(),
                            'bloque':bloq,
                            'sitio':$('#cod-sitio').val(),
                            'tipo_reg':$('#tipo_reg').val(),
                            'nombres_resp': $('#cripta-name').val(),
                            'paterno_resp' :  $('#paterno').val(),
                            'materno_resp' :  $('#materno').val(),
                            'ci_resp' :  $('#dni').val(),
                            'domicilio' :  $('#domicilio').val(),
                            'genero_resp' :  $('#genero').val(),
                            'superficie': $('#superficie').val(),
                            'estado_construccion' :  $('#construido').val(),
                            'enterratorios_ocupados' :  $('#enterratorios_ocupados').val(),
                            'total_enterratorios' :  $('#total_enterratorios').val(),
                            'osarios' :  $('#osarios').val(),
                            'total_osarios' :  $('#total_osarios').val(),
                            'cenisarios' :  $('#cenisarios').val(),
                            'observaciones' :  $('#observaciones').val(),
                            'foto' :  $('#url-foto').val(),
                            'celular' :  $('#telefono').val(),
                            'notable' :  field_notable,

                            'familia':$('#familia').val(),
                            'tipo_cripta':$('#tipo_cripta option:selected').val(),
                            'adjudicacion':$('#adjudicacion').val(),
                            'documentos_recibidos':  {
                                                       'resolucion': resolucion,
                                                       'ci': ci,
                                                       'bienes_m': bienes_m,
                                                       'planos_aprobados': planos_aprobados,
                                                       'obs_resolucion':obs_resolucion,
                                                       'foto_resolucion':$('#url_foto_resol').val(),
                                                        'foto_titulo':$('#url_foto_title').val(),
                                                        'foto_prop_ci':$('#url_foto_prop').val(),
                                                        'foto_planos':$('#url_foto_planos_ap').val()
                                                       },
                            'estado': $('#estado').val(),
                        }),
                        success: function(data_response)
                         {

                                        if(data_response.status){
                                            swal.fire({
                                            title: "Guardado!",
                                            text: "!Registro actualizado con éxito!",
                                            type: "success",
                                            timer: 2000,
                                            showCancelButton: false,
                                            showConfirmButton: false
                                        });
                                        }else{
                                            swal.fire({
                                            title: "Precaucion!",
                                            text: "!El sitio ya esta ocupado!",
                                            type: "warning",
                                            timer: 2000,
                                            showCancelButton: false,
                                            showConfirmButton: false
                                            });
                                        }

                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                        //toastr["success"]("Registro realizado con éxito!");
                                    },
                                    error: function (error) {

                                        if(error.status == 422){
                                            Object.keys(error.responseJSON.errors).forEach(function(k){
                                            toastr["error"](error.responseJSON.errors[k]);
                                            });
                                        }else if(error.status == 419){
                                            location.reload();
                                        }

                          }
                    });
                }
            });



                   $('#cripta-data').DataTable({
                            "paging": true,
                            "searching": true,
                            "language": {

                            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
                            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningun registro registrado aún",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": 'Buscar Cripta:',
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst": 'Primero',
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            "buttons": {
                                "copy": "Copiar",
                                "colvis": "Visibilidad"
                            }
                        },
                    });
        });
        function validar_campos(){
            if($('#notable option:selected').val()==null || $('#notable option:selected').val()==""){

                return false;
            }
            return true;
        }
/**************************************************************************/
/*************combo dinamico bloque en funcion al cuartel ****************/
/*************************************************************************/

        $(document).on('change', '#cuartel', function(){
            $('#bloque').empty();
            var sel_cuartel=$('#cuartel').val();
                $('#bloque').prop('disabled', false);
                $.ajax({
                    type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('bloqueid.get') }}",
                        async: false,
                        data: JSON.stringify({
                            'cuartel': $('#cuartel').val(),
                        }),
                        success: function(data_bloque) {
                            var op1='<option >SELECCIONAR</option>';
                            $('#bloque').append(op1);
                           $.each( data_bloque.response, function( key, value ) {
                                 opt2='<option value="'+ value.id +'">'+value.codigo +'</option>';
                                 $('#bloque').append(opt2);
                            });
                        }
                });
        });




/**************************************************************************/
/*************busqueda avanzada por cuartel*****************************/
/*************************************************************************/

    $(document).on('change', '.select_cuartel_search', function(){
        $('#bloque_search').empty();
        var sel_cuartel=$('.select_cuartel_search').val();
              $('#bloque_search').prop('disabled', false);
                $.ajax({
                    type: 'POST',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: "{{ route('bloqueid.get') }}",
                        async: false,
                        data: JSON.stringify({
                            'cuartel': $('#select_cuartel_search').val(),
                        }),
                        success: function(data_bloque) {
                           var op1='<option value="" >SELECCIONAR</option>';
                            $('#bloque_search').append(op1);
                           $.each( data_bloque.response, function( key, value ) {
                                 opt2='<option value="'+ value.id +'">'+value.codigo +'</option>';
                                 $('#bloque_search').append(opt2);
                            });
                        }
                });
    });



/**************************************************************************/
/*************Generar codigo cripta****************************************/
/*************************************************************************/
    function generarCodigo(){
        var sup=$('#superficie').val();
        if($('#bloque :selected').text()=="" || $('#bloque :selected').text()=="SELECCIONAR" ){ var bloq="000";}
        else{var bloq=$('#bloque :selected').text();}

        console.log(bloq);
        console.log($('#cod-sitio').val());

        var cod=($('#cuartel :selected').text()).toUpperCase()+bloq+$('#cod-sitio').val()+($('#letra').val()).toUpperCase()+parseInt(sup);
        $('#cod-cripta').val(cod);
    }


/**************************************************************************/
/*************cargado de foto cripta mausoleo *****************************/
/*************************************************************************/

$(document).ready(function ()
 {

    $("#foto").dropzone({
        dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
        dictRemoveFile: 'Remover Archivo',
        dictCancelUpload: 'Cancelar carga',
        dictResponseError: 'Server responded with  code.',
        dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
        url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
        paramName: "documens_files[]",
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
        parallelUploads: 1,
        maxFiles: 1,
        init: function()
        {
                this.on("complete", function(file) {
                    if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                        this.removeFile(file);
                        toastr["error"]('No se puede subir el archivo '+ file.name);
                        return false;
                    }
                });



                this.on("removedfile", function(file) {
                    $.ajax({
                                type: 'DELETE',
                                headers: {
                                    'Content-Type':'application/json'
                                },
                                url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                                async: false,
                                data: JSON.stringify({
                                    'url':  JSON.parse(file.xhr.response).response[0].url_file
                                }),
                                success: function(data_response) {
                                }
                            })
                });

                this.on("maxfilesexceeded", function(file){
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se puede subir mas archivos!');
                });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'cementerio cripta-mausoleo');

                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#url-foto').val(response.response[0].url_file);
            // $(file._removeLink).attr('href', response.response[0].url_file);
            // $(file._removeLink).attr('id', 'btn-remove-file');
        },
        error: function (file, response) {

            if(response == 'You can not upload any more files.'){
                toastr["error"]('No se puede subir mas archivos');
                this.removeFile(file);
            }
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
        }


    });


    $("#foto-edit").dropzone({
        dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
        dictRemoveFile: 'Remover Archivo',
        dictCancelUpload: 'Cancelar carga',
        dictResponseError: 'Server responded with  code.',
        dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
        url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
        paramName: "documens_files[]",
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
        parallelUploads: 1,
        maxFiles: 1,
        init: function() {
        this.on("complete", function(file) {
            if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                this.removeFile(file);
                toastr["error"]('No se puede subir el archivo '+ file.name);
                return false;
            }
        });
           this.on("removedfile", function(file) {
            $.ajax({
                        type: 'DELETE',
                        headers: {
                            'Content-Type':'application/json'
                        },
                        url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                        async: false,
                        data: JSON.stringify({
                            'url':  JSON.parse(file.xhr.response).response[0].url_file
                        }),
                        success: function(data_response) {
                        }
                    })

        });

        this.on("maxfilesexceeded", function(file){
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se puede subir mas archivos!');
        });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'cementerio cripta-mausoleo');

                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#url-foto-edit').val(response.response[0].url_file);

        },
        error: function (file, response) {

            if(response == 'You can not upload any more files.'){
                toastr["error"]('No se puede subir mas archivos');
                this.removeFile(file);
            }
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
        }

    });


                function openFile(file) {
                var extension = file.substr( (file.lastIndexOf('.') +1) );
                switch(extension) {
                    case 'jpg':
                    case 'png':
                        return 'image';  // There's was a typo in the example where
                    break;                         // the alert ended with pdf instead of gif.
                    case 'zip':
                    case 'rar':
                        alert('was zip rar');
                    break;
                    case 'pdf':
                        return 'pdf';
                    break;
                    default:
                    return 'desconocido';
                }
            }
        });

        $(document).on('click', '#generarciresp', function() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                url: "{{ route('generateCiResp') }}",
                method: 'GET',
                dataType: 'json',
                success: function(ciresp) {
                    console.log(ciresp);
                    $('#dni').val(ciresp);

                }
            })

})


/**************************************************************************/
/*************cargado de certificado de defuncion**************************/
/*************************************************************************/
    $("#cert_defuncion").dropzone({
        dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
        dictRemoveFile: 'Remover Archivo',
        dictCancelUpload: 'Cancelar carga',
        dictResponseError: 'Server responded with  code.',
        dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
        url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
        paramName: "documens_files[]",
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
        parallelUploads: 1,
        maxFiles: 1,
        init: function()
        {
                this.on("complete", function(file) {
                    if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                        this.removeFile(file);
                        toastr["error"]('No se puede subir el archivo '+ file.name);
                        return false;
                    }
                });

                this.on("maxfilesexceeded", function(file){
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se puede subir mas archivos!');
                });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'cementerio certificado defuncion');
                    formData.append('nro_documento', $('#resp_cm_dif').html());   /***** ci responsable ***/
                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#mdurl-certification').val(response.response[0].url_file);
            // $(file._removeLink).attr('href', response.response[0].url_file);
            // $(file._removeLink).attr('id', 'btn-remove-file');
        },
        error: function (file, response) {

            if(response == 'You can not upload any more files.'){
                toastr["error"]('No se puede subir mas archivos');
                this.removeFile(file);
            }
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
        }


    });


/**************************************************************************/
/***********cargado de certificado de defuncion desde modal pagos *******/
/*************************************************************************/
$("#cert_defuncion_p").dropzone({
        dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
        dictRemoveFile: 'Remover Archivo',
        dictCancelUpload: 'Cancelar carga',
        dictResponseError: 'Server responded with  code.',
        dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
        url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
        paramName: "documens_files[]",
        addRemoveLinks: true,
        acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
        parallelUploads: 1,
        maxFiles: 1,
        init: function()
        {
                this.on("complete", function(file) {
                    if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                        this.removeFile(file);
                        toastr["error"]('No se puede subir el archivo '+ file.name);
                        return false;
                    }
                });

                this.on("maxfilesexceeded", function(file){
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se puede subir mas archivos!');
                });

        },
        sending: function(file, xhr, formData){
                    formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                    formData.append('collector', 'cementerio certificado defuncion');
                    formData.append('nro_documento', $('#resp_cm').html());   /***** ci responsable ***/
                },
        success: function (file, response) {
            file.previewElement.classList.add("dz-success");
            $('#mdurl-certification-p').val(response.response[0].url_file);
            // $(file._removeLink).attr('href', response.response[0].url_file);
            // $(file._removeLink).attr('id', 'btn-remove-file');
        },
        error: function (file, response) {

            if(response == 'You can not upload any more files.'){
                toastr["error"]('No se puede subir mas archivos');
                this.removeFile(file);
            }
            file.previewElement.classList.add("dz-error");
            $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
        }


    });

/**************************************************************************/
/*************metodo de busqueda de ci del responsable o difunto***********/
/*************************************************************************/
           $(document).on('click', '#buscarResp', function()
            {
                var ci = $('#dni').val();
                if (ci.length < 1) {

                    Swal.fire(
                        'Busqueda finalizada!',
                        'El campo C.I. esta vacio .',
                        'warning'
                    )

                } else {
                    var type = "responsable";
                    dats = buscar_ci_resp(ci, type);

                }
            });

            function buscar_ci_resp(ci, type) {
                var datos = "";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('search.difunto.responsable') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "ci": ci,
                        "type": type
                    }),
                    success: function(data) {
                        if (data.response == null) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                            )
                        } else {

                            $('#cripta-name').val(data.response.nombres);
                            $('#paterno').val(data.response.primer_apellido);
                            $('#materno').val(data.response.segundo_apellido);
                            $('#domicilio').val(data.response.domicilio);
                            $('#genero').val(data.response.genero);


                        }

                    },
                    error: function(xhr, status) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El registro no ha  sido encontrado o no existe .',
                            'error'
                        )
                    },



                });
                // return datos;
            }

/********************************************************************************/
/****controlar activacion de nro de resolucion como documetno recibido***********/
/********************************************************************************/
            //
            $(document).on('click', '#resolucion', function(){
                 if ($("#resolucion").is(":checked")) {
                    $('#nro_resolucion').show();
                } else {
                    $('#nro_resolucion').val("");
                    $('#nro_resolucion').hide();
                }
            });

             //controlar activacion de nro de ci como documetno recibido
             $(document).on('click', '#ci', function(){
                 if ($("#ci").is(":checked")) {
                    $('#nro_ci').show();
                    $('#digital_documents').show();
                } else {
                    $('#nro_ci').val("");
                    $('#nro_ci').hide();
                }
            });

            $(document).on('click', '#obs_resolucion', function(){
                 if ($("#obs_resolucion").is(":checked")) {
                    $('#txt_resolucion').show();
                } else {
                    $('#txt_resolucion').val("");
                    $('#txt_resolucion').hide();
                }
            });

/********************************************************************************/
/*******************validacion numeros o letras y telefono***********************/
/********************************************************************************/

                $(function() {
                    $('.numeroEntero').keypress(function(e) {
                            if (isNaN(this.value + String.fromCharCode(e.charCode)))
                                return false;
                        })
                        .on("cut copy paste", function(e) {
                            e.preventDefault();
                        });

                });

                $(function() {
                    $('.soloLetras').bind('keyup input', function() {
                        if (this.value.match(/[^a-zA-Z áéíóúÁÉÍÓÚüÜñÑ]/g)) {
                            this.value = this.value.replace(/[^a-zA-Z áéíóúÁÉÍÓÚüÜñÑ]/g, '');
                        }
                    });
                });


                $(document).on('keyup', '#telefono', function(e){
                    // alert(this.value + String.fromCharCode(e.charCode));

                    var number=$('#telefono').val();
                    var primer=number.charAt(0);
                    if(number.length>=1) {
                                if(primer < 4 || primer == 5  || primer == 8 || primer == 9){
                                    Swal.fire(
                                            'Error!',
                                            'El número de telefono  fijo o celular debe iniciar con 4 , 6 o 7!.',
                                            'error'
                                        ) ;
                                        $('#telefono').val("");
                                    return false;
                                }
                            }
                });

/********************************************************************************/
/****metodo para adicionar difuntos y mostrar difuntos cargados en tabla ***********/
/********************************************************************************/

        /***difuntos **/

                $(document).on('click', '#btn_add_difunto', function(){

                    // buscar si hay difuntos ingresados
                    $('#id_cripta_mausoleo_modal').val($(this).val());

                    $.ajax({
                                type: 'POST',
                                headers: {
                                    'Content-Type':'application/json',
                                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                },
                                url:'{{ route("difuntoCripta.get") }}',
                                async: false,
                                data: JSON.stringify({
                                    'cripta_mausoleo_id': $(this).val(),
                                }),
                                success: function(data_response)
                                {
                                            if(data_response.responsable || data_response.responsable!=null)
                                            {
                                                $('#modal_add_difunto').modal('show');
                                                $('#cod_cm_dif').html(data_response.response['codigo']);
                                                $('#resp_cm_dif').html(data_response.responsable['ci'])


                                                $('#tabla_difunto_row').empty();
                                                $('#modal_save_difuntos').prop('disabled', false);

                                                console.log(data_response);
                                                var list=jQuery.parseJSON(data_response.response['difuntos']);
                                                if(data_response.response['difuntos']!=null )
                                                {

                                                    $.each(list, function(key, value)
                                                    {
                                                            console.log( value[value]);

                                                                //llenar tabla
                                                                    var row='<tr>'+
                                                                            '<td class="dtci">'+value['ci']+'</td>'+
                                                                            '<td class="dtname">'+value['nombres']+'</td>'+
                                                                            '<td class="dtprimer_apellido">'+value['primer_apellido']+'</td>'+
                                                                            '<td class="dtsegundo_apellido">'+value['segundo_apellido']+'</td>'+
                                                                            '<td class="dtcertificado_defuncion">'+value['ceresi']+'</td>'+
                                                                            '<td class="dttipo">'+value['tipo']+'</td>'+
                                                                            '<td class="dtfecha_nacimiento">'+value['fecha_nacimiento']+'</td>'+
                                                                            '<td class="dtedad">'+calcularEdad(value['fecha_nacimiento'])+'</td>'+
                                                                            '<td class="dtfecha_defuncion">'+value['fecha_defuncion']+'</td>'+
                                                                            '<td class="dtcausa">'+value['causa']+'</td>'+
                                                                            '<td class="dtfuneraria">'+value['funeraria']+'</td>'+
                                                                            '<td class="dtgenero">'+value['genero']+'</td>'+
                                                                            '<td class="enl"><a href="'+value['url']+'" target="_blank" >Ver adjunto</a></td>'+
                                                                            '<td class="dturl" >'+value['url']+'</td>'+
                                                                            '<td class="dtborrar"> <a href="#" id="remove"  onClick="$(this).parent().parent().remove();"> <i class="fas fa-trash wine fa-2x"></i></a></td></tr>';
                                                                        $('#tabla_difunto_row').append(row);
                                                                        // clear modal form
                                                                        $('.clear').val('');
                                                                        $('.clears2').val(null).trigger('change');
                                                                        $('.dz-image').html("");
                                                                        Dropzone.forElement('#cert_defuncion').removeAllFiles(true);


                                                    })

                                                    //end foreach
                                                }//end if
                                            }else{
                                                            swal.fire({
                                                                    title: "Precaución!",
                                                                    text: data_response.mensaje,
                                                                    type: "warning",
                                                                    timer: 2000,
                                                                    showCancelButton: false,
                                                                    showConfirmButton: false
                                                                });
                                                                setTimeout(function() {
                                                                    location.reload();
                                                                }, 2000);
                                            }
                                }
                    });
                });


                $(document).on('click', '#add_difunto_row', function(e){
                   e.preventDefault();
                    mostrar_difunto();

                   var nrow= $('.tabla_difunto tbody tr').length;
                   if(nrow>0){ $('#modal_save_difuntos').prop('disabled', false)}
                   else{
                    $('#modal_save_difuntos').prop('disabled', true)
                   }
                });


                $("#funeraria").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_add_difunto'),
                    tags: true,
                    allowClear: true
                });

                $("#funeraria_p").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_pay_cm'),
                    tags: true,
                    allowClear: true
                });


                 $(document).on('click', 'button[aria-describedby="select2-funeraria-container"] span', function() {
                  $('#funeraria option:selected').remove();
                 });

                 $(document).on('click', 'button[aria-describedby="select2-funeraria_p-container"] span', function() {
                  $('#funeraria_p option:selected').remove();
                 });

                  $("#causa").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_add_difunto'),
                    tags: true,
                    allowClear: true
                  });

                    $(document).on('click', 'button[aria-describedby="select2-causa-container"] span', function() {
                        $('#causa option:selected').remove();
                    })


                $("#causa_p").select2({
                    width: 'resolve', // need to override the changed default
                    dropdownParent: $('#modal_pay_cm'),
                    tags: true,
                    allowClear: true
                });

                    $(document).on('click', 'button[aria-describedby="select2-causa_p-container"] span', function() {
                        $('#causa_p option:selected').remove();
                    })


                  // show Deceased row in table
                function mostrar_difunto()
                {
                    var row='<tr>'+
                        '<td class="dtci">'+$('#mdci').val()+'</td>'+
                        '<td class="dtname">'+$('#mdnombre').val()+'</td>'+
                        '<td class="dtprimer_apellido">'+$('#mdprimer_apellido').val()+'</td>'+
                        '<td class="dtsegundo_apellido">'+$('#mdsegundo_apellido').val()+'</td>'+
                        '<td class="dtcertificado_defuncion">'+$('#mdcertificado_defuncion').val()+'</td>'+
                        '<td class="dttipo">'+$('#mdtipo').val()+'</td>'+
                         '<td class="dtfecha_nacimiento">'+$('#mdfecha_nacimiento').val()+'</td>'+
                         '<td class="dtedad">'+calcularEdad($('#mdfecha_nacimiento').val())+'</td>'+
                        '<td class="dtfecha_defuncion">'+$('#mdfecha_defuncion').val()+'</td>'+
                        '<td class="dtcausa">'+$('#causa').val()+'</td>'+
                        '<td class="dtfuneraria">'+$('#funeraria').val()+'</td>'+
                        '<td class="dtgenero">'+$('#mdgenero').val()+'</td>'+
                        '<td class="enl" ><a href="'+$('#mdurl-certification').val()+'" target="_blank" >ver adjunto</a></td>'+
                        '<td class="dturl" >'+$('#mdurl-certification').val()+'</td>'+
                        '<td class="remove"> <a href="#" id="remove"  onClick="$(this).parent().parent().remove();"> <i class="fas fa-trash wine fa-2x"></i></a></td></tr>';
                       $('#tabla_difunto_row').append(row);
                       // clear modal form
                       $('.clear').val('');
                       $('.clears2').val(null).trigger('change');

                             Dropzone.forElement('#cert_defuncion').removeAllFiles(true);

                }

                    // convert table rows in array json for send to controller and send all data to controller
                    $(document).on('click', '#modal_save_difuntos', function(e)
                    {
                        e.preventDefault();
                                 let difuntos = [];
                                     document.querySelectorAll('.tabla_difunto tbody tr').forEach(function(e){
                                    let fila = {
                                        ci: e.querySelector('.dtci').innerText,
                                        nombres: e.querySelector('.dtname').innerText,
                                        primer_apellido: e.querySelector('.dtprimer_apellido').innerText,
                                        segundo_apellido: e.querySelector('.dtsegundo_apellido').innerText,
                                        ceresi: e.querySelector('.dtcertificado_defuncion').innerText,
                                        tipo: e.querySelector('.dttipo').innerText,
                                        fecha_nacimiento: e.querySelector('.dtfecha_nacimiento').innerText,
                                        edad: e.querySelector('.dtedad').innerText,

                                        fecha_defuncion: e.querySelector('.dtfecha_defuncion').innerText,
                                        causa: e.querySelector('.dtcausa').innerText,
                                        funeraria: e.querySelector('.dtfuneraria').innerText,
                                        genero: e.querySelector('.dtgenero').innerText,
                                        url: e.querySelector('.dturl').innerText,
                                    };
                                    difuntos.push(fila);
                                    });
                                    $.ajax({
                                        type: 'PUT',
                                        headers: {
                                            'Content-Type':'application/json',
                                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                        },
                                        url: '{{ route("add.deseaced") }}',
                                        async: false,
                                        data: JSON.stringify({
                                            'cripta_mausoleo_id': $('#id_cripta_mausoleo_modal').val(),
                                            'difuntos': difuntos
                                        }),
                                            success: function(data) {
                                                 console.log(data.status);
                                                 if(data.status==true){
                                                    swal.fire({
                                                            title: "Registro actualizado!",
                                                            text: "!Se adiciono correctamente los registros de difuntos!",
                                                            type: "success",
                                                            timer: 2000,
                                                            showCancelButton: false,
                                                            showConfirmButton: false
                                                        });
                                                        setTimeout(function() {
                                                            location.reload();
                                                        }, 2000);
                                                 }else{
                                                    swal.fire({
                                                            title: "Error!",
                                                            text: "!Ocurrio un error, intente nuevamente!",
                                                            type: "error",
                                                            timer: 2000,
                                                            showCancelButton: false,
                                                            showConfirmButton: false
                                                        });
                                                 }


                                                },
                                                error: function(xhr, status) {

                                                    Swal.fire(
                                                        'Busqueda finalizada!',
                                                        'El registro no ha  sido encontrado o no existe .',
                                                        'error'
                                                    )
                                                },
                                    })
                                    // console.log(difuntos);
                    });


                    $('#tabla_difunto').DataTable({
                            "paging": true,
                            "searching": true,
                            "language": {

                            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
                            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningun registro registrado aún",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": 'Buscar Cripta:',
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst": 'Primero',
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            "buttons": {
                                "copy": "Copiar",
                                "colvis": "Visibilidad"
                            }
                        },
                    });


                    function calcularEdad(birth)
                     {
                        ageMS = Date.parse(Date()) - Date.parse(birth);
                        age = new Date();
                        age.setTime(ageMS);
                        ageYear = age.getFullYear() - 1970;

                        return ageYear;

                        // ageMonth = age.getMonth(); // Accurate calculation of the month part of the age
                        // ageDay = age.getDate();    // Approximate calculation of the day part of the age
                    }
/********************************************************************************/
/*********************abrir modal pagar servicio ********************************/
/********************************************************************************/

         $(document).on('click', '#btn_pay_cm', function()
         {
            $('#modal_pay_cm').modal('show');
            $('#id_cripta_mausoleo_modal_pay').val($(this).val());
            // buscar si hay difuntos ingresados
            $.ajax({
                type: 'GET',
                        headers: {
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                        },
                        url: '/cripta/get-cripta/' + $(this).val(),
                        success: function(data)
                        {
                            console.log(data);
                            if(data.status!=null )
                            {
                                $('#cod_cm').html(data.response.cripta.codigo);
                                $('#resp_cm').html(data.response.responsable.nombres+" "+data.response.responsable.primer_apellido+" "+data.response.responsable.segundo_apellido);
                                $('#field_difuntos').html(data.response.cripta.difuntos);

                            }//end if
                        }
            });

            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('get.services') }}",
                    method: 'GET',
                    dataType: 'json',
                    data: JSON.stringify({
                                     }),
                    success: function(data) {
                        // console.log(data.response);
                        $.each(data.response, function(key,val) {
                        //    console.log(val.descripcion );
                           if(val.cuenta=='15224370' || val.cuenta=='15224330' || val.cuenta=='15224380' || val.cuenta=='15224300' || val.cuenta=='15224390' ){}
                          else{
                            var html='<div class="form-check">'+
                                        '<input class="form-check-input" type="checkbox" id="'+val.cuenta+'" name="serv[tipo_servicio]" value="'+val.cuenta+'-'+val.descripcion+'"  onclick="cargar_sevicios_hijos(this)">'+
                                        '<label class="form-check-label labelservice" for="'+val.cuenta+'">'+val.descripcion+'</label>'+
                                        '<div id="serv_hijos'+val.cuenta+'"></div>'
                                        '</div>';
                                        $('#contenedor_servicios').append(html);

                                        if(val.cuenta=='15224200'){
                                            listar_difuntos();
                                        }

                          }
                        });

                    }
                })

         });

        //funcion para cargar servicios hijos por padre
        function cargar_sevicios_hijos(obj){
            // alert($(obj).attr("id"));
            var cuenta=$(obj).attr("id");
            var txt_cuenta=$(obj).attr("value");
            console.log(txt_cuenta);
            if ($('#'+cuenta+'').is(":checked"))
            {


                        $.ajax({
                                type: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                url: "https://multiserv.cochabamba.bo/api/v1/cementerio/generate-all-servicios-cm",
                                async: false,
                                data: JSON.stringify({
                                    'data': cuenta
                                }),
                                success: function(data_response) {
                                    console.log(data_response.response);
                                    $('#servicio-hijos').empty();
                                    $.each(data_response.response, function(index, value) {
                                        //alert(value.num_sec)
                                        if (value.num_sec == '526' || value.num_sec == '525' ||
                                            value.num_sec == '629' || value.num_sec == '631') {}
                                                else {
                                                    // console.log("asdas");
                                                    var html='<div class="form-check">'+
                                                    '<input class="form-check-input service_child" type="checkbox" id="'+value.num_sec+'" name="serv[servicio]" value="'+ txt_cuenta +' => '+value.num_sec+' - '+ value.descripcion + ' - ' + value.monto1 +'- Bs." onclick="seleccionar_hijos_list()" >'+
                                                    '<label class="form-check-label childservice" for="'+value.num_sec+'">'+value.descripcion+' - ' + value.monto1 +'- Bs.</label>'+
                                                    '</div>';
                                                    $('#serv_hijos'+cuenta+'').append(html);
                                                    }

                                    });
                                }
                            });
            }else{
                $('#serv_hijos'+cuenta+'').empty();
            }
        }

        // funcion para enlistar servicios seleccionados y calcular total acumulado

        function seleccionar_hijos_list(){
            var tipo_serv="";
            var tipo_serv_txt="";
            var serv="";
            var serv_txt="";
            var acum=0;
            var monto=0;
            var activado=0;
            $('#servicios-data').empty();
            $('.service_child').each(function( index ) {
                alert($(this).is(":checked"));
            if($(this).is(":checked"))
            {   var info= ($(this).val()).split('=>');

                id_serv= $.trim(((info[1]).split('-'))[0]);
                if(index==0){
                    tipo_serv =$.trim(((info[0]).split('-'))[0]);
                     tipo_serv_txt=((info[0]).split('-'))[1];
                     serv= $.trim(((info[1]).split('-'))[0]);
                     serv_txt=((info[1]).split('-'))[1];

                     if( id_serv =='623' || id_serv =='622'){
                        activado=1;
                        $('.section_difunto').show();
                     }
                }else{
                     tipo_serv=tipo_serv+", "+ $.trim(((info[0]).split('-'))[0]);
                     tipo_serv_txt=tipo_serv_txt+", "+ $.trim(((info[0]).split('-'))[1]);
                     serv=serv+", "+ $.trim(((info[1]).split('-'))[0]);
                     serv_txt=serv_txt+", "+ $.trim(((info[1]).split('-'))[1]);

                        if(id_serv =='623' ||  id_serv =='622'){
                             activado=1;
                            $('.section_difunto').show();

                        }
                }
                monto=((info[1]).split('-'))[2];
                $('#servicios-data').append('<p>'+((info[1]).split('-'))[1]+' ..................'+monto+'</p>');
                acum=parseFloat(acum)+parseFloat(monto);
                $('#totalServ').html(acum);


            }else{
                if((id_serv =='623' ||  id_serv =='622') && activado==0 ){
                    $('.section_difunto').hide();
                }
            }

            });
        }


            //listar difuntos existentes en la cripta / mausoleo
            function listar_difuntos(){
                var dif=JSON.parse($('#field_difuntos').html());
                console.log('----------');
                console.log(JSON.parse($('#field_difuntos').html()));
                console.log('----------');


                     var tbl_dif='<table class="table data tbldif">'
                                +'<h4> DETALLE DE DIFUNTOS </h4>'
                                // +'  <button type="button" class="btn btn-success add_dif_row" id="add_dif_row" >AGREGAR FILA</button> '
                                + '<thead>'
                                   +'<tr>'
                                    +'<th> C.I./NRO IDENTIFICACION </th>'
                                    +'<th> NOMBRES </th>'
                                    +'<th> PATERNO </th>'
                                    +'<th> MATERNO </th>'
                                    +'<th> GENERO </th>'
                                    // +'<th> CERESI </th>'
                                    +'<th> FECHA NACIMIENTO </th>'
                                    +'<th> FECHA DEFUNCION </th>'
                                    // +'<th> FUNERARIA</th>'
                                    // +'<th> CAUSA</th>'
                                    // +'<th> TIPO</th>'

                                    +'</tr>'
                                + '</thead>'
                                + '<tbody>'
                                + '</tbody>'
                                + '</table>';
                                $('#difuntos-data').append(tbl_dif);

                                $.each(dif, function(index, value) {
                                    console.log('++++++++++++++++++');
                                    console.log(value.ci);
                                    var row=    ' <tr>'
                                            +     '<td class="data">'+value.ci+ ' </td>'
                                            +     '<td class="data">'+value.nombres+ '</td>'
                                            +     '<td class="data">'+value.primer_apellido+ '</td>'
                                            +     '<td class="data">'+value.segundo_apellido+ '</td>'
                                            +     '<td class="data">'+value.genero+ '</td>'
                                            // +     '<td class="data">'+value.ceresi+ '</td>'
                                            +     '<td class="data">'+value.fecha_nacimiento+ '</td>'
                                            +     '<td class="data">'+value.fecha_defuncion+ '</td>'
                                            // +     '<td class="data">'+value.funeraria+ '</td>'
                                            // +     '<td class="data">'+value.causa+ '</td>'
                                            // +     '<td class="data">'+value.tipo+ '</td>'
                                            +     '</tr>';
                                      $('.tbldif tbody').append(row);
                                })



            }


            $(document).on('click', '#boton_dif_inhum', function(e){
                e.preventDefault();
               insertar_difunto_inhumado();
               listar_difuntos();

            })

            //metodo insertar_difunto_inhumado
            function insertar_difunto_inhumado(){
                $.ajax({
                                        type: 'PUT',
                                        headers: {
                                            'Content-Type':'application/json',
                                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                        },
                                        url: '{{ route("add.deseaced") }}',
                                        async: false,
                                        data: JSON.stringify({
                                            'cripta_mausoleo_id': $('#id_cripta_mausoleo_modal').val(),
                                            'difuntos': difuntos
                                        }),
                                            success: function(data) {
                                                 console.log(data.status);
                                                 if(data.status==true){}
                                            }
                        });
            }
            // metodo que calcula el monto de los servicios solicitados
                function calcularPrice()
                    {
                        var acum = 0;
                        $('#totalServ').html(0);
                        $('#totalservicios').val(0)
                        $('.costo').each(function(index) {
                            acum = parseFloat(acum) + parseFloat($(this).val());
                        });
                        $('#totalServ').html(acum);
                        $('#totalservicios').val(acum)
                        // consolidado();

                    }


                // function guardar pagos servicios
                $(document).on('click', '#modal_save_pagos_cm', function(e){
                    e.preventDefault();
                    console.log($('#tipo_servicio_value_cm').val());
                    console.log("------1--------");
                    console.log($('#servicio-hijos').val());
                    console.log("------2--------");

                    console.log($('#tipo_servicio_value_cm option:selected').text());
                    console.log("------3--------");

                    console.log($('#servicio-hijos option:selected').text());
                    console.log("------4--------");


                    $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Content-Type': 'application/json'
                                },
                                url: "{{ route('save.service.pay.cm') }}",
                                method: 'POST',
                                dataType: 'json',
                                data: JSON.stringify({
                                    "id_cripta_mausoleo": $('#id_cripta_mausoleo_modal_pay').val(),
                                    'tipo_servicio': $('#tipo_servicio_value').val(),
                                    'servicio_hijos': $('#servicio-hijos').val(),
                                    'tipo_servicio_txt': $('#tipo_servicio_value option:selected').text(),
                                    'servicio_hijos_txt': $('#servicio-hijos option:selected').text(),

                                }),
                                success: function(data) {

                                }
                    });
                })
/************************* fin pagos servicios **************************************/


/******************************************************************************************************/
/***********************seccion adjuntar documentos difitales ****************************************/
/****************************************************************************************************/

    $(document).ready(function ()
    {

            $("#foto_resolucion").dropzone({
                dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
                dictRemoveFile: 'Remover Archivo',
                dictCancelUpload: 'Cancelar carga',
                dictResponseError: 'Server responded with  code.',
                dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
                url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
                paramName: "documens_files[]",
                addRemoveLinks: true,
                acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
                parallelUploads: 1,
                maxFiles: 1,
                init: function()
                {
                        this.on("complete", function(file) {
                            if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                                this.removeFile(file);
                                toastr["error"]('No se puede subir el archivo '+ file.name);
                                return false;
                            }
                        });



                        this.on("removedfile", function(file) {
                            $.ajax({
                                        type: 'DELETE',
                                        headers: {
                                            'Content-Type':'application/json'
                                        },
                                        url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                                        async: false,
                                        data: JSON.stringify({
                                            'url':  JSON.parse(file.xhr.response).response[0].url_file
                                        }),
                                        success: function(data_response) {
                                        }
                                    })
                        });

                        this.on("maxfilesexceeded", function(file){
                            file.previewElement.classList.add("dz-error");
                            $('.dz-error-message').text('No se puede subir mas archivos!');
                        });

                },
                sending: function(file, xhr, formData){
                            formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                            formData.append('collector', 'cementerio resolucion-testimonio');
                            formData.append('nro_documento', $('#nro_ci').val());

                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_resol').val(response.response[0].url_file);
                    // $(file._removeLink).attr('href', response.response[0].url_file);
                    // $(file._removeLink).attr('id', 'btn-remove-file');
                },
                error: function (file, response) {

                    if(response == 'You can not upload any more files.'){
                        toastr["error"]('No se puede subir mas archivos');
                        this.removeFile(file);
                    }
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
                }


            });

        //foto titulo de propiedad

            $("#foto_titulo").dropzone({
                dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
                dictRemoveFile: 'Remover Archivo',
                dictCancelUpload: 'Cancelar carga',
                dictResponseError: 'Server responded with  code.',
                dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
                url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
                paramName: "documens_files[]",
                addRemoveLinks: true,
                acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
                parallelUploads: 1,
                maxFiles: 1,
                init: function()
                {
                        this.on("complete", function(file) {
                            if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                                this.removeFile(file);
                                toastr["error"]('No se puede subir el archivo '+ file.name);
                                return false;
                            }
                        });



                        this.on("removedfile", function(file) {
                            $.ajax({
                                        type: 'DELETE',
                                        headers: {
                                            'Content-Type':'application/json'
                                        },
                                        url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                                        async: false,
                                        data: JSON.stringify({
                                            'url':  JSON.parse(file.xhr.response).response[0].url_file
                                        }),
                                        success: function(data_response) {
                                        }
                                    })
                        });

                        this.on("maxfilesexceeded", function(file){
                            file.previewElement.classList.add("dz-error");
                            $('.dz-error-message').text('No se puede subir mas archivos!');
                        });

                },
                sending: function(file, xhr, formData){
                            formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                            formData.append('collector', 'cementerio titulo de propiedad');
                            formData.append('nro_documento', $('#nro_ci').val());

                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_title').val(response.response[0].url_file);
                    // $(file._removeLink).attr('href', response.response[0].url_file);
                    // $(file._removeLink).attr('id', 'btn-remove-file');
                },
                error: function (file, response) {

                    if(response == 'You can not upload any more files.'){
                        toastr["error"]('No se puede subir mas archivos');
                        this.removeFile(file);
                    }
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
                }


            });

            //foto ci

            $("#foto_ci_prop").dropzone({
                dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
                dictRemoveFile: 'Remover Archivo',
                dictCancelUpload: 'Cancelar carga',
                dictResponseError: 'Server responded with  code.',
                dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
                url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
                paramName: "documens_files[]",
                addRemoveLinks: true,
                acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
                parallelUploads: 1,
                maxFiles: 1,
                init: function()
                {
                        this.on("complete", function(file) {
                            if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                                this.removeFile(file);
                                toastr["error"]('No se puede subir el archivo '+ file.name);
                                return false;
                            }
                        });



                        this.on("removedfile", function(file) {
                            $.ajax({
                                        type: 'DELETE',
                                        headers: {
                                            'Content-Type':'application/json'
                                        },
                                        url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                                        async: false,
                                        data: JSON.stringify({
                                            'url':  JSON.parse(file.xhr.response).response[0].url_file
                                        }),
                                        success: function(data_response) {
                                        }
                                    })
                        });

                        this.on("maxfilesexceeded", function(file){
                            file.previewElement.classList.add("dz-error");
                            $('.dz-error-message').text('No se puede subir mas archivos!');
                        });

                },
                sending: function(file, xhr, formData){
                            formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                            formData.append('collector', 'cementerio ci propietario');
                            formData.append('nro_documento', $('#nro_ci').val());

                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_prop').val(response.response[0].url_file);
                    // $(file._removeLink).attr('href', response.response[0].url_file);
                    // $(file._removeLink).attr('id', 'btn-remove-file');
                },
                error: function (file, response) {

                    if(response == 'You can not upload any more files.'){
                        toastr["error"]('No se puede subir mas archivos');
                        this.removeFile(file);
                    }
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
                }


            });


            //planos aprobados

            $("#foto_planos").dropzone({
                dictDefaultMessage: "Arrastre y suelte aquí los archivos …<br>(o haga clic para seleccionar archivos)",
                dictRemoveFile: 'Remover Archivo',
                dictCancelUpload: 'Cancelar carga',
                dictResponseError: 'Server responded with  code.',
                dictCancelUploadConfirmation: '¿Estás seguro/a de que deseas cancelar esta carga?',
                url: "{{ env('URL_FILE') }}/api/v1/repository/upload-files",
                paramName: "documens_files[]",
                addRemoveLinks: true,
                acceptedFiles: 'image/jpeg, image/png, image/jpg, application/pdf',
                parallelUploads: 1,
                maxFiles: 1,
                init: function()
                {
                        this.on("complete", function(file) {
                            if(file.type != 'application/pdf' && file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
                                this.removeFile(file);
                                toastr["error"]('No se puede subir el archivo '+ file.name);
                                return false;
                            }
                        });



                        this.on("removedfile", function(file) {
                            $.ajax({
                                        type: 'DELETE',
                                        headers: {
                                            'Content-Type':'application/json'
                                        },
                                        url: "{{ env('URL_FILE') }}/api/v1/repository/remove-file",
                                        async: false,
                                        data: JSON.stringify({
                                            'url':  JSON.parse(file.xhr.response).response[0].url_file
                                        }),
                                        success: function(data_response) {
                                        }
                                    })
                        });

                        this.on("maxfilesexceeded", function(file){
                            file.previewElement.classList.add("dz-error");
                            $('.dz-error-message').text('No se puede subir mas archivos!');
                        });

                },
                sending: function(file, xhr, formData){
                            formData.append('sistema_id', '00e8a371-8927-49b6-a6aa-0c600e4b6a19');
                            formData.append('collector', 'cementerio planos aprobados');
                            formData.append('nro_documento', $('#nro_ci').val());


                        },
                success: function (file, response) {
                    file.previewElement.classList.add("dz-success");
                    $('#url_foto_planos_ap').val(response.response[0].url_file);
                    // $(file._removeLink).attr('href', response.response[0].url_file);
                    // $(file._removeLink).attr('id', 'btn-remove-file');
                },
                error: function (file, response) {

                    if(response == 'You can not upload any more files.'){
                        toastr["error"]('No se puede subir mas archivos');
                        this.removeFile(file);
                    }
                    file.previewElement.classList.add("dz-error");
                    $('.dz-error-message').text('No se pudo subir el archivo '+ file.name);
                }


            });




                function openFile(file)
                {
                        var extension = file.substr( (file.lastIndexOf('.') +1) );
                        switch(extension) {
                            case 'jpg':
                            case 'png':
                                return 'image';  // There's was a typo in the example where
                            break;                         // the alert ended with pdf instead of gif.
                            case 'zip':
                            case 'rar':
                                alert('was zip rar');
                            break;
                            case 'pdf':
                                return 'pdf';
                            break;
                            default:
                            return 'desconocido';
                        }
                }
    });


/*********** fin adjuntar documentos digitales ************************/

/**************************************************************************/
/*****metodos de busqueda y recuperacion de responsables y difuntos********/
/*************************************************************************/
  /// recuperar difunto en modal difunto


            $(document).on('click', '#buscarDif', function(e)
              {
                e.preventDefault();
                            var ci = $('#mdci').val();


                            if (ci.length < 1) {

                                Swal.fire(
                                    'Busqueda finalizada!',
                                    'El campo C.I. esta vacio .',
                                    'warning'
                                )

                            } else {
                                var type = "deceased";
                                dats = buscar_ci_Dif(ci, type);

                            }
            });


            $(document).on('click', '#upbuscarResp', function(e)
            {
                e.preventDefault();
                            var ci = $('#upci').val();


                            if (ci.length < 1) {

                                Swal.fire(
                                    'Busqueda finalizada!',
                                    'El campo C.I. esta vacio .',
                                    'warning'
                                )

                            } else {
                                var type = "responsable";
                                dats = buscar_ci_Resp(ci, type);

                            }
            });

            //buscar info responsable
            function buscar_ci_Resp(ci, type) {
                var datos = "";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('search.difunto.responsable') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "ci": ci,
                        "type": type
                    }),
                    success: function(data) {
                        if (data.response == null) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                            )
                        } else
                        {
                            console.log(data);
                            $('#upprimer_apellido').val(data.response.primer_apellido);
                            $('#upsegundo_apellido').val(data.response.segundo_apellido);
                            $('#upnombre').val(data.response.nombres);
                        }

                    },
                    error: function(xhr, status) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El registro no ha  sido encontrado o no existe .',
                            'error'
                        )
                    },
                });
                // return datos;
            }



            function buscar_ci_Dif(ci, type) {
                var datos = "";

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    url: "{{ route('search.difunto.responsable') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "ci": ci,
                        "type": type
                    }),
                    success: function(data) {
                        if (data.response == null) {
                            Swal.fire(
                                'Busqueda finalizada!',
                                'El C.I. ingresado no esta registrado .',
                                'warning'
                            )
                        } else
                        {
                            console.log(data);
                            $('#mdprimer_apellido').val(data.response.primer_apellido);
                            $('#mdsegundo_apellido').val(data.response.segundo_apellido);
                            $('#mdfecha_nacimiento').val(data.response.fecha_nacimiento);
                            $('#mdtipo').val(data.response.tipo);
                            $('#mdci').val(data.response.ci);
                            $('#mdnombre').val(data.response.nombres);
                            $('#mdcertificado_defuncion').val(data.response.certificado_defuncion);
                            $('#mdfecha_defuncion').val(data.response.fecha_defuncion);

                            $('#causa').val(data.response.causa).trigger('change');
                            $('#funeraria').val(data.response.funeraria).trigger('change');
                            $('#mdgenero').val(data.response.genero);

                            if(data.response.certificado_file != null){
                               $('#mdurl-certification').val(data.response.certificado_file);
                                var enlace='<a href="'+data.response.certificado_file+'" id="enl" target="_black">Archivo adjunto</a><br>'+
                                            '<img src="'+data.response.certificado_file+'" width="150px" height="150px">';
                                $('#adjunto').append(enlace);
                            }
                        }

                    },
                    error: function(xhr, status) {

                        Swal.fire(
                            'Busqueda finalizada!',
                            'El registro no ha  sido encontrado o no existe .',
                            'error'
                        )
                    },
                });
                // return datos;
            }

    </script>
    @stop

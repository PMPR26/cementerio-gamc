@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Select2', true)

@section('content_header')
    <br>
@stop

@section('css')

@stop

<!-- resources/views/depositos/create.blade.php -->


@section('content')
    <div class="container-fluid">
        <div class="row card p-8">
            <div class="col-12 p-5"><h1>FORMULARIO DE GENERACI&Oacute;N DE REPORTE DE TRANSACCIONES DIARIAS</h1></div>
            <div class="col-12 p-5">
                        <form method="POST" action="{{ route('transacciones.print.report') }}" class="p-8" target="blank">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12">
                                <h3 class="p-2 badge-info">SELECCION DE PARAMETROS DEL REPORTE</h3>
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="tipo_reporte">Seleccionar tipo de reporte:</label>
                                  <select name="tipo_reporte" id="tipo_reporte" class="form-control">
                                    <option value="seleccionar">Seleccionar</option>
                                    <option value="SERVICIOS">SERVICIOS</option>
                                    <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                  </select>
                                </div>

                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="frecuencia">FRECUENCIA:</label>
                                  <select name="frecuencia" id="frecuencia" class="form-control">
                                    <option value="seleccionar">Seleccionar</option>
                                    <option value="DIARIO">DIARIO</option>
                                    <option value="RANGO">RANGO DE FECHAS</option>
                                  </select>
                                </div>

                                <div class="form-group col-sm-6 col-md-6 col-lg-6" id="dia" style="display: none">
                                    <label for="total_adeudado">FECHA:</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control"
                                      value="{{ date('Y-m-d') }}">
                                </div>

                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                <div class="row" id="por_rango" style="display: none">
                                    <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                        <label for="fecha_inicial">FECHA INICIAL:</label>
                                        <input type="date" name="fecha_inicial" id="fecha_inicial" class="form-control"
                                          value="">
                                    </div>
                                    <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                        <label for="fecha_final">FECHA FINAL:</label>
                                        <input type="date" name="fecha_final" id="fecha_final" class="form-control"
                                          value="">
                                    </div>
                                </div>
                                </div>


                            </div>
                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-row">
                                <div class="form-group col-sm-12 col-md-12 col-lg-12 align-center">
                                    <button type="submit" class="btn btn-primary align-center">Generar Reporte</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#frecuencia').change(function() {
                if ($('#frecuencia').val() == 'DIARIO') {
                    $('#dia').show();
                    $('#por_rango').hide();
                    } else if ($('#frecuencia').val() == 'RANGO') {
                        $('#dia').hide();
                        $('#por_rango').show();
                    }
            });
        });

</script>
@endsection

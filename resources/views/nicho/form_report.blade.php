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
            <div class="col-12 p-5"><h1>FORMULARIO DE GENERACI&Oacute;N DE REPORTE DE NICHOS</h1></div>
            <div class="col-12 p-5">
                        <form method="POST" action="{{ route('nicho.print.report') }}" class="p-8" target="blank">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12">
                                <h3 class="p-2 badge-info">GENERADOR DE REPORTE NICHOS VACIOS / OCUPADOS</h3>
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="total_adeudado">Seleccionar Estado del Nicho:</label>
                                  <select name="estado_nicho" id="estado_nicho">
                                    <option value="seleccionar">Seleccionar</option>
                                    <option value="OCUPADO">OCUPADO</option>
                                    <option value="LIBRE">LIBRE</option>
                                  </select>
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

</script>
@endsection

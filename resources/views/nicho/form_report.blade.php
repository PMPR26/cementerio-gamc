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
                                <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                    <label for="estado_nicho">Seleccionar Cuartel:</label>
                                    <select id="cuartel" name="cuartel"
                                    class="form-control clears2 select2-multiple select2-hidden-accessible cuartel" style="width: 100%">
                                    <option value="">Seleccionar</option>
                                        @foreach($cuartel as $cuartel)
                                        <option value="{{$cuartel->id}}">{{$cuartel->codigo}}</option>
                                        @endforeach
                                  </select>
                                </div>

                                <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                    <label for="estado_nicho">Seleccionar Estado del Nicho:</label>
                                  <select name="estado_nicho" id="estado_nicho" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="OCUPADO">OCUPADO</option>
                                    <option value="LIBRE">LIBRE</option>
                                  </select>
                                </div>

                                <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                    <label for="tipo_nicho">Seleccionar tipo de Nicho:</label>
                                  <select name="tipo_nicho" id="tipo_nicho" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="TEMPORAL">TEMPORAL</option>
                                    <option value="PERPETUO">PERPETUO</option>
                                  </select>
                                </div>

                                <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                    <label for="cenizarios">Cenizarios:</label>
                                    <select name="cenizarios" id="cenizarios" class="form-control" >
                                        <option value="">Seleccionar bloque</option>
                                        @foreach ($cenizarios as $item)
                                        <option value="{{$item->bloque}}">{{$item->bloque}}</option>
                                        @endforeach
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
        var select2 = $('.cuartel');
        // Activa el plugin Select2 en el elemento
        select2.select2();
</script>
@endsection

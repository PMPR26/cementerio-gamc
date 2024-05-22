@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)

@section('content_header')
    <br>
@stop

@section('css')

@stop

<!-- resources/views/depositos/create.blade.php -->


@section('content')
    <div class="container-fluid">
            <div class="row card">

                    <div class="col-12 bg-warning"><h1>MODIFICACI&Oacute;N DE INGRESO DE CUERPO A DEP&Oacute;SITO</h1></div>
                    <div class="col-12 p-5">

                                <form method="POST" action="{{ route('deposito.update') }}">
                                    @csrf
                                    <input type="text" name="id" id="id" value="{{ $deposito->id}}">
                                    <div class="form-row">
                                        <div class="col-sm-12 col-md-3 col-xl-3">
                                            <label>CUARTEL</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="{{ $deposito->cuartel}}" class="form-control " maxlength="3" name="cuartel"  autocomplete="off">
                                        </div>

                                        <div class="col-sm-12 col-md-3 col-xl-3">
                                            <label>BLOQUE</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="{{ $deposito->bloque}}" class="form-control " maxlength="3" name="bloque" autocomplete="off">
                                        </div>

                                        <div class="col-sm-12 col-md-3 col-xl-3">
                                            <label>NRO NICHO</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="{{ $deposito->nicho}}" class="form-control "  maxlength="5" name="nicho" autocomplete="off">
                                        </div>


                                        <div class="col-sm-12 col-md-3 col-xl-3">
                                            <label>FILA</label>
                                            <input style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" value="{{ $deposito->fila}}" class="form-control " name="fila" maxlength="3" autocomplete="off">
                                        </div>
                                    </div>
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <label for="nombre_difunto">Nombre Difunto:</label>
                                        <input type="text" name="nombre_difunto"   value="{{ $deposito->nombre_difunto}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                        <label for="impuesto">Impuesto</label>
                                        <input type="text" name="impuesto"  value="{{ $deposito->impuesto}}" id="impuesto" class="form-control" required>
                                    </div>

                                    <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                        <label for="lapida">L&aacute;pida</label>
                                        <input type="text" name="lapida"  value="{{ $deposito->lapida}}" id="lapida" class="form-control" required>
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <label for="fecha_salida_sitio">Fecha Salida Sitio:</label>
                                        <input type="date" name="fecha_salida_sitio"  value="{{ $deposito->fecha_salida_sitio ?? ''}}" class="form-control" >
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <label for="fecha_ingreso_deposito">Fecha Ingreso Dep&oacute;sito:</label>
                                        <input type="date" name="fecha_ingreso_deposito"  value="{{ $deposito->fecha_ingreso_deposito?? ''}}" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                        <label for="observacion">Observaci&oacute;n:</label>
                                        <textarea name="observacion" class="form-control">{{ $deposito->observacion??''}}</textarea>
                                    </div>
                                </div>


                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </div>
                </div>
    </div>

@endsection

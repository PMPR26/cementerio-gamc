@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Select2', true)

@section('content_header')
    <br>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<!-- resources/views/depositos/create.blade.php -->


@section('content')
    <div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="col-12 bg-warning"><h1>FORMULARIO DE INGRESO DE CUERPO A DEPOSITO</h1></div>
        </div>
        <div class="row">
                        <form method="POST" action="{{ route('deposito.store') }}">
                            @csrf
                            <div class="form-row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <label for="codigo_sitio">Código Sitio:</label>
                                <select name="codigo_sitio" class="form-control" required>
                                    @foreach ($nichos as $nicho)
                                        <option value="{{ $nicho->id }}">{{ $nicho->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <label for="nombre_difunto">Nombre Difunto:</label>
                                <input type="text" name="nombre_difunto" class="form-control" required>
                            </div>
                            </div>
                        <div class="form-row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <label for="fecha_salida_sitio">Fecha Salida Sitio:</label>
                                <input type="date" name="fecha_salida_sitio" class="form-control" required>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <label for="fecha_ingreso_deposito">Fecha Ingreso Depósito:</label>
                                <input type="date" name="fecha_ingreso_deposito" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="detalle_ingreso">Detalle Ingreso:</label>
                                <textarea name="detalle_ingreso" class="form-control" required></textarea>
                            </div>

                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="cant_cuotas_adeudadas">Cantidad Cuotas Adeudadas:</label>
                                <input type="text" name="cant_cuotas_adeudadas" id="cant_cuotas_adeudadas" class="form-control" required>
                            </div>
                        </div>
                     <div class="form-row">
                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="precio_unitario">Precio Unitario:</label>
                                <input type="text" name="precio_unitario" id="precio_unitario" class="form-control" required>
                            </div>

                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="total_adeudado">Total Adeudado:</label>
                                <input type="text" name="total_adeudado" id="total_adeudado" class="form-control" required>
                            </div>
                     </div>
                        {{--     <div class="form-group">
                                <label for="fur">FUR:</label>
                                <input type="number" name="fur" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="fecha_pago">Fecha Pago:</label>
                                <input type="date" name="fecha_pago" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="glosa">Glosa:</label>
                                <textarea name="glosa" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="responsable_pago">Responsable Pago:</label>
                                <input type="text" name="responsable_pago" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="ci_responsable_pago">CI Responsable Pago:</label>
                                <input type="text" name="ci_responsable_pago" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="estado_pago">Estado Pago:</label>
                                <input type="text" name="estado_pago" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="user_id">ID Usuario:</label>
                                <input type="number" name="user_id" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <input type="text" name="estado" class="form-control" required>
                            </div>
 --}}
                            <!-- Agrega más campos según sea necesario -->

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
    $(document).ready(function() {
        $('select').select2();


        $(document).on('input', '#cant_cuotas_adeudadas', function(e) {
            var cant = parseInt($(this).val()) || 0; // Parse the value to an integer, default to 0 if not a number
            var precio = parseFloat($('#precio_unitario').val()) || 0; // Parse the value to a float, default to 0 if not a number
            var total = cant * precio;
            $('#total_adeudado').val(total.toFixed(2)); // Display total with 2 decimal places
        });

        $(document).on('input', '#precio_unitario', function(e) {
            var cant = parseFloat($('#cant_cuotas_adeudadas').val()) || 0; // Parse the value to a float, default to 0 if not a number
            var precio = parseFloat($(this).val()) || 0; // Parse the value to a float, default to 0 if not a number
            var total = cant * precio;
            $('#total_adeudado').val(total.toFixed(2)); // Display total with 2 decimal places
        });


    });
</script>
@endsection

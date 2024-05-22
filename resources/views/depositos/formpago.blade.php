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
            <div class="col-12 p-5"><h1>FORMULARIO DE GENERACI&Oacute;N DE BOLETA DE PRELIQUIDACI&Oacute;N</h1></div>
            <div class="col-12 p-5">
                        <form method="POST" action="{{ route('deposito.preliquidacion') }}" class="p-8">
                            @csrf
                            <input type="hidden" name="deposito_id" value="{{$deposito->id}}">
                            <input type="text" name="cuenta" value="{{$cuenta}}">
                            <input type="text" name="precio" value="{{$precio}}">

                            <input type="text" name="descripcion" value="{{$descrip}}">
                            <input type="text" name="num_sec" value="{{$num_sec}}">


                            <div class="form-row">
                                <div class="form-group col-12">
                                <h3 class="p-2 badge-info">Detalle del monto adeudado</h3>
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="total_adeudado">Impuesto:</label>
                                    <input type="text" name="impuesto" id="impuesto" value="{{ $deposito->impuesto}}" class="form-control" required>
                                </div>
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="total_adeudado">Cantidad Gestiones:</label>
                                    <input type="text" name="cant_cuotas_adeudadas" id="cant_cuotas_adeudadas" value="{{ $cuotas}}" class="form-control" required readonly>
                                </div>
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="precio">Precio Unitario:</label>
                                    <input type="text" name="precio_unitario" id="precio_unitario"  value="{{ $precio}}" class="form-control" required readonly>
                                </div>

                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="total_adeudado">Total Adeudado:</label>
                                    <input type="text" name="total_adeudado" id="total_adeudado"  value="{{ $total_adeudado}}" class="form-control" required readonly>
                                </div>
                            </div>


                            <div class="form-row">
                                 <div class="form-group col-12">
                                    <h3 class="p-2 badge-info">Datos del responsable del pago</h3>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                    <label for="ci_responsable_pago">CI Responsable Pago:</label>
                                    <input type="text" name="ci_responsable_pago" class="form-control">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                    <label for="nombre_pago">Nombre(s):</label>
                                    <input type="text" name="nombre_pago" class="form-control">
                                </div>

                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                    <label for="primer_apellido_pago">Primer Apellido:</label>
                                    <input type="text" name="primer_apellido_pago" class="form-control">
                                </div>

                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                    <label for="segundo_apellido_pago">Segundo Apellido:</label>
                                    <input type="text" name="segundo_apellido_pago" class="form-control">
                                </div>
                            </div>

                            <div class="form-row">
                            <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                <label for="glosa">Glosa:</label>
                                <textarea name="glosa" class="form-control"></textarea>
                            </div>
                            </div>


                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-row">
                                <div class="form-group col-sm-12 col-md-12 col-lg-12 align-center">
                                    <button type="submit" class="btn btn-primary align-center">Generar Preliquidacion</button>
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
            function total(){
            var cant = parseInt($('#cant_cuotas_adeudadas').val()) || 0; // Parse the value to an integer, default to
            var precio = parseFloat($('#precio_unitario').val()) || 0; // Parse the value to a float, default to 0 if not
            var total = cant * precio;
            $('#total_adeudado').val(total.toFixed(2)); // Display total with 2 decimal places
        }
            $(document).on('keyup', '#impuesto', function(){
                var impuesto = $(this).val();
                var year = new Date().getFullYear(); // Get the current year
                var cantidad = year - parseInt(impuesto);
                console.log(cantidad);
                $('#cant_cuotas_adeudadas').val(cantidad);
                total();
            });


        });



</script>
@endsection

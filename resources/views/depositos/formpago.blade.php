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
        <div class="row card p-8">
            <div class="col-12 p-5"><h1>FORMULARIO DE PAGO</h1></div>
            <div class="col-12 p-5">
                        <form method="POST" action="{{ route('deposito.pagar') }}" class="p-8">
                            @csrf
                            <input type="hidden" name="deposito_id" value="{{$deposito->id}}">
                            <div class="form-row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                    <label for="total_adeudado">Total Adeudado:</label>
                                    <input type="text" name="total_adeudado" id="total_adeudado" value="{{ $deposito->total_adeudado}}" class="form-control" required>
                                </div>



                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="glosa">Glosa:</label>
                                <textarea name="glosa" class="form-control"></textarea>
                            </div>
                            </div>

                            <div class="form-row">
                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="responsable_pago">Responsable Pago:</label>
                                <input type="text" name="responsable_pago" class="form-control">
                            </div>

                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                <label for="ci_responsable_pago">CI Responsable Pago:</label>
                                <input type="text" name="ci_responsable_pago" class="form-control">
                            </div>
                            </div>


                            <!-- Agrega más campos según sea necesario -->

                            <button type="submit" class="btn btn-primary">Generar Preliquidacion</button>
                        </form>
                    </div>
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

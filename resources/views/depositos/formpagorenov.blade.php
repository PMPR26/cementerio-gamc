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
                            <input type="hidden" name="cuenta" value="{{$cuenta}}">
                            <input type="hidden" name="precio" value="{{$precio}}">

                            <input type="hidden" name="descripcion" value="{{$descrip}}">
                            <input type="hidden" name="num_sec" value="{{$num_sec}}">


                            <div class="form-row">
                                <div class="form-group col-12">
                                <h3 class="p-2 badge-info">Detalle del monto adeudado</h3>
                            </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="total_adeudado">Impuesto:</label>
                                    <input type="number" name="impuesto" id="impuesto" value="{{ $deposito->impuesto }}" class="form-control" required min="1999">
                                </div>
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="cant_cuotas_adeudadas">Cantidad Gestiones:</label>
                                    <input type="text" name="cant_cuotas_adeudadas" id="cant_cuotas_adeudadas" value="{{ $cuotas}}" class="form-control" required readonly>
                                </div>
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="precio">Precio Unitario:</label>
                                    <input type="text" name="precio_unitario" id="precio_unitario"  value="{{ $precio}}" class="form-control" required>
                                </div>
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="renov_ant">Nro de Renovacion Anterior:</label>
                                    <input type="text" name="renov_ant" id="renov_ant"  value="0" class="form-control" required>
                                </div>
                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="precio_renov_ant">Precio Renovacion Anterior:</label>
                                    <input type="text" name="precio_renov_ant" id="precio_renov_ant"  value="0" class="form-control" required>
                                </div>

                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                    <label for="calcular_cuotas">Calcular </label>
                                    <input type="checkbox" name="calcular_cuotas" id="calcular_cuotas"  value="" class="form-control" required>
                                </div>

                                <div class="form-group col-sm-12 col-md-12 col-lg-12" id="section_cuotas">
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

        $(document).on('click', '#calcular_cuotas', function(){
            $('#section_cuotas').empty();
            calcular_renovacion();
        });

        $(document).on('input', '#impuesto', function(){
            var impuesto = $(this).val();
            var year = new Date().getFullYear(); // Get the current year
            var cantidad = year - parseInt(impuesto);
            console.log(cantidad);
            $('#cant_cuotas_adeudadas').val(cantidad);
            $('#section_cuotas').empty();
        });



     function calcular_renovacion(){


            var porcentaje=20;
            var adicion=0;
            var precio_sinot=$('#precio_unitario').val();
            var ren_row="";
            var nrocuota=0;
            var nro_cuotas=$('#cant_cuotas_adeudadas').val();
            var cuota_ant=$('#renov_ant').val();
            var ncuota=$('#precio_renov_ant').val();
            console.log("hasta aqqqqqqq");
            var total_acum=0;
            var acum=0;
            console.log(precio_sinot);
            for(i=1; i<=nro_cuotas; i++){
                nrocuota=parseInt(cuota_ant)+parseInt(i);
                if(cuota_ant==0 && i==1){
                            porcentaje=0;
                            adicion= precio_sinot*porcentaje/100;
                            cuota=  parseFloat(precio_sinot) + parseFloat(adicion);
                            ncuota=cuota;
                        }else{
                           porcentaje=20;
                           adicion=ncuota*porcentaje/100;
                           cuota=  parseFloat(ncuota) + parseFloat(adicion);
                           cuota=cuota.toFixed(2);
                           ncuota=cuota;
                        }
                        acum=parseFloat(acum)+ parseFloat(cuota);
                        total_acum=total_acum+acum;
                        console.log("cuotaaaaaaa"+i+"="+cuota);
                        console.log("acum"+i+"="+acum);
                        acum=acum.toFixed(2);
                        ren_row=  '<div class="row pb-2 row_cuotas">'
                                       +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                            +'<label for="">Nro de cuota</label>'
                                            +'<input type="number" name="precio_renov" id="precio_renov-'+i+'" value="'+nrocuota+'" class="form-control precio_renov" readonly>'
                                       +'</div>'
                                       +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                            +'<label for="">Monto renovacion</label>'
                                            +'<input type="number" name="amount" id="amount-'+i+'" class="form-control amount" value="'+cuota+'" readonly>'
                                       +'</div>'
                                        +'<div class="col-sm-12 col-md-3 col-xl-3">'
                                             +'<label for="">Total acumulado</label>'
                                             +'<input type="number" name="parcial_amount" id="parcial_amount-'+i+'" class="form-control parcial_amount" value="'+acum+'" readonly>'
                                        +'</div>'
                                   +'</div>';

                            $('#section_cuotas').append(ren_row);


            }
            total_acum = Math.ceil(total_acum);
            $('#total_adeudado').val(total_acum);
        }





</script>
@endsection

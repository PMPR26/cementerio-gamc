@extends('adminlte::page')
@section('title', 'Bloque')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)


@section('content_header')
    <h1>Listado de servicios</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <button id="new-servicio" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Servicio</button>
    </div>
 </div>


       
        <div class="col-sm-12">
            <table id="servicio-data" class="table table-striped table-bordered responsive" role="grid"
            aria-describedby="example">
            <thead class="bg-table-header">
               
                    <tr role="row">
                        <th scope="col">#</th>                           
                        <th scope="col">Responable</th>  
                        <th scope="col">Difunto</th>
                        <th scope="col">Nicho</th>
                        <th scope="col">Tipo Servicio</th>
                        <th scope="col">Servicios</th>
                        <th scope="col">Monto</th>

                        <th scope="col">FUR</th>
                        <th scope="col">Gestion Pagada</th>
                        <th scope="col">Estado Pago</th>                        
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php($count = 1)
                    @foreach ($servicio as $serv)
                               
                        <tr>
                            <td scope="row">{{ $count++ }}</td>
                           
                            <td>{{ $serv->responsable }}</td> 
                            <td>{{ $serv->difunto }}</td> 
                            <td>{{ $serv->bloque }}</td>
                            <td>{{ $serv->tipo_serv }}</td>
                            <td>{{ $serv->serv }}</td>
                            <td>{{ $serv->monto }}</td>
                            <td>{{ $serv->fur }}</td>
                            <td>{{ $serv->gestion_pagada }}</td>
                            <td>{{ $serv->estado_pago }}</td>     
                            <td>{{ $serv->estado }}</td>  
                            <td>
                                <button type="button" class="btn btn-info" value="{{ $serv->id }}" id="btn-print" title="Editar imprimir"><i class="fas fa-print"></i></button>
                                                              
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        

        @include('servicios.modalRegister') 

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

@section('js')
    <script> 
    $(document).ready(function () {
        $('#new-servicio').on('click', function(){
            $('#modal-register-servicio').modal('show');
        });

        var datatable = $('#servicio-data').DataTable({
        "paging": true,
        "searching": true,
        "language": {

            "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
            //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ninguna ubicación registrada aún",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": 'Buscar Datos Por CI:',
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

   
//cargar combo tipo tramite
    tipo_tramite();


    
    function tipo_tramite() {
        $('#tipo_servicio').empty();
        var option1 = '<option value="0">SELECCIONAR</option>';
        $('#tipo_servicio').append(option1);
        $.ajax({
            headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            url: "https://multiservdev.cochabamba.bo/api/v1/cementerio/get-services",
            method: 'GET',
            dataType: 'json',
            data: {},
            success: function(data) {

                $.each(data.response, function(key, value) {
                    var option = '<option value="' + value.cuenta + '">' + value.descripcion +
                        '</option>';
                    $('#tipo_servicio').append(option);
                });
            }
        });
    }



    // cargar combo 2  hijo servcio

    function servicio() {
        $('#servicio').empty();
        var option1 = '<option value="0">SELECCIONAR</option>';
        $('#servicio').append(option1);
        var valor = $('#tipo_servicio option:selected').val();
        var permitido=0;
        $.ajax({
            headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            },
            url: "https://multiservdev.cochabamba.bo/api/v1/cementerio/get-services/" + valor + "",
            method: 'GET',
            dataType: 'json',
            data: {},
            success: function(data) {

                $.each(data.response, function(key, value) {
                    if(valor=="15224350"){permitido= 1;}
                     else if(valor=="15224150"){
                         if(value.cuenta== "15224151"){permitido= 1;} else{permitido=0;}
                     }
                    else 
                    if(valor=="15141020"){
                        if(value.cuenta== "15141022"){permitido= 1;} else{permitido=0;}

                    }
                    else
                     if(valor=="15224200"){
                        if(value.cuenta== "15224203" || value.cuenta== "15224201"  ){permitido= 1;} else{permitido=0;}

                    }
                    
   

              //  if(permitido==0){
                    
                    var option = '<option value="' + value.num_sec + '">' + value.cuenta + "-" +
                                        value.descripcion + "-" + value.monto1 + '</option>';
                                    $('#servicio').append(option);
              //  }

                   /* var option = '<option value="' + value.num_sec + '">' + value.cuenta + "-" +
                        value.descripcion + "-" + value.monto1 + '</option>';
                    $('#servicio').append(option);*/
                });
            }
        });
    }

    $(document).on('change', '#tipo_servicio', function() {
        $('#monto_box').hide();
        $('#precio_box').hide();
        $('#cantidad_box').hide();
        $('#unidad_box').hide();
        $('#tiempo_box').hide();
        $('#info_box').hide();
        $('#gestion_box').hide();

        
        $('#cantidad_b').val(1);
        $('#unidad_b').val('Glb');
        $('#precio_b').val('');
        $('#monto_b').val('');
        $('#info_pago').val('');
        $('#gestion_b').val('');



        $('#service').show();
        servicio();
 
    });
    
    $(document).on('change', '#servicio', function() {
        $('#monto_box').show();
        $('#btn_add').show();
      
        $('#cantidad_b').val(1);
        $('#unidad_b').val('Glb');
        $('#precio_b').val('');
        $('#monto_b').val('');
        $('#info_pago').val('');

        var valor = $('#servicio option:selected').text();
        var frac = valor.split('-');
       
        if($('#servicio option:selected').val()=="525"){
            $('#cantidad_box').show();
            $('#unidad_box').show();   
            $('#precio_box').show();
            $('#info_box').show();
            $('#info_pago').show();
            $('#gestion_box').show();

            $('#gestion_b').val($('#pag_con').val());

          

            var precio_parcial=parseInt( $('#cantidad_b').val()) * parseInt(frac[2]);
            $('#precio_b').val(frac[2]);

            $('#monto_b').val(precio_parcial);
        }
        else{
            var precio_parcial=parseInt( $('#cantidad_b').val()) * parseInt(frac[2]);
            $('#precio_b').val(frac[2]);
             $('#monto_b').val(frac[2]);
        }
       

    });

    $(document).on('click', '#btn_add', function() {
        var ts = $('#tipo_servicio option:selected').text();
        var tsv = $('#tipo_servicio option:selected').val();

        var ssa = $('#servicio option:selected').text();
        var frac = ssa.split('-');
        var ss = frac[1]; 
        var ssv = $('#servicio option:selected').val();
        var ver = 0;
       // $('#pag_con').val($('#gestion_b').val());
        var cantidad_serv=$('#cantidad_b').val();
        var unidad=$('#unidad_b').val();
        var precio=$('#precio_b').val();
        var tiempo=$('#tiempo_b').val();
        var tiempo=$('#gestion_b').val();


        
       
        $('#grilla').show();


        // contar cantidad de servicios
        // Selector Padre
        var parent = document.querySelector('#grilla');

        // Cantidad de div
        var divs = parent.querySelectorAll('div');
        var cantidad = divs.length;
        //    cantidad de servicio

        var cant_serv = cantidad / 4;
        var collection = $(".quitar");
        collection.each(function(index, value) {
            var idrow = this.id;
            dat_ts = idrow.split('-');
            id_ts = dat_ts[0]; 
            id_s = dat_ts[1];
            if (tsv == id_ts && ssv == id_s) {
                ver = 1;
            }

        });
        if (ver == 0) {
            if(typeof cantidad_serv === 'undefined'){ cantidad_serv=1;}
            if(typeof unidad === 'undefined'){unidad="glb";}
            var monto =0;
           // monto=cantidad_serv*precio;
           monto=$('#monto_b').val();

         
var fila =   '<div class="card fila p-4">'+ 
             '<div class="row card-header" >'+
                        '<div class="col-sm-2 col-md-2 col-xl-2">Tipo servicio:</div>'+
                        '<div class="col-sm-10 col-md-4 col-xl-4"><span id="txt_tipo_serv">' +ts + '</span>'+
                        '<input type="hidden" name="tipo_serv[]" value="' +ts + '"  id="ts-' + tsv +
                        '" class="tserv form-control" readonly="true" class="form-control" /> </div>' +
                        '<div class="col-sm-2 col-md-1 col-xl-1">Servicio:</div>'+
                        '<div class="col-sm-10 col-md-4 col-xl-4"><span id="txt_serv">' + ss +'</span>'+
                        '<input type="hidden" name="hserv[]" value="' + ss +
                        '"  id="hs-' + ssv + '" class="hserv form-control" readonly="true" />'+
                        '<input type="hidden" name="servicio[]" value="' + ssv +
                        '" class="servicio  form-control" readonly="true" />'+
                        '</div>'+                       
               ' </div>'+
               '<div class="row card-body" >' +
                        '<div class="col-sm-2 col-md-2 col-xl-2">Cantidad:</div>'+
                        '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_cantidad">' + cantidad_serv + '</span>'+
                        '<input type="hidden" name="cantidad[]" value="' +cantidad_serv + '"   class="cantidad  form-control" readonly="readonly"  /></div>'+

                        '<div class="col-sm-2 col-md-2 col-xl-2">Unidad:</div>'+
                        '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_unidad">' + unidad + '</span>'+
                        '<input type="hidden" name="unidad[]" value="' +unidad + '"   class="unidad  form-control" readonly="readonly"  /></div>'+

                        '<div class="col-sm-2 col-md-2 col-xl-2">Precio:</div>'+
                        '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_precio">' + precio + '</span>'+
                          '<input type="hidden" name="precio_unitario[]" value="' +precio + '"   class="precio  form-control" readonly="readonly"  />'+
                         '<input type="hidden" name="cuenta[]" value="' + frac[0] +'"  id="cuenta" class="cuenta form-control" readonly="true"  class="form-control" /></div>' +
                       
                         '<div class="col-sm-2 col-md-2 col-xl-2">Subtotal:</div>'+
                         '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_subtotal">' + monto + '</span>'+
                         '<input type="hidden" name="monto[]" value="' +  monto +
                          '"  id="monto" class="montoserv form-control" readonly="readonly"  class="form-control"/> </div>'+

                          '<div class="col-sm-2 col-md-2 col-xl-2">Ultimo Pago:</div>'+
                         '<div class="col-sm-4 col-md-4 col-xl-4"><span id="txt_subtotal">' + $('#gestion_b').val() + '</span>'+
                         '<input type="hidden" name="ultimopago" value="' +  $('#gestion_b').val() +
                          '"  id="ultimopago" class="ultimopago form-control" readonly="readonly"  class="form-control"/> </div>'+
                    
             '</div>'+
             '<div class="col-sm-12 col-md-1 col-xl-1"><a  href="#" class="btn btn-danger quitar "  id="' + tsv + '-' + ssv +
                         '" onClick="$(this).parent().parent().remove();"><i class="fas fa-minus-circle"></i></a> </div>'+
               '</card>';
            $('#grilla').append(fila);
        } else {
            alert("servicio repetido");
        }
    });

    </script>
@stop
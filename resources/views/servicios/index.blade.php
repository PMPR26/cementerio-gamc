@extends('adminlte::page')
@section('title', 'Servicios')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.Pace', true)


@section('content_header')
    <h1>Listado de servicios</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <a href="{{ route('load.form') }}" id="new-servicio" type="button" class="btn btn-info col-4" > <i class="fas fa-plus-circle text-white fa-2x"></i>Servicios</a>
    </div>
 </div>

        <div class="col-sm-12">
            <table id="servicio-data" class="table table-striped table-bordered responsive" role="grid"
            aria-describedby="example">
            <thead class="bg-table-header">

                    <tr role="row">
                        <th scope="col">#</th>
                        <th scope="col">TIPO</th>
                        <th scope="col">CÓDIGO </th>
                        <th scope="col">SOLICITANTE</th>
                        <th scope="col">SERVICIOS</th>
                        <th scope="col">MONTO</th>
                        <th scope="col">FUR</th>
                        <th scope="col">VERIFICAR PAGO</th>
                        <th scope="col">ESTADO PAGO</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @php($count = 1)
                    @foreach ($servicio as $serv)

                        <tr>
                            <td scope="row">{{ $count++ }}</td>
                            <td>{{ $serv->tipo??'' }}</td>
                            <td>{{ $serv->codigo_nicho??'' }}</td>
                            <td>{{ $serv->nombre_resp??' '   }} {{   $serv->primerap_resp??''    }}   {{    $serv->segap_resp??'' }}</td>
                            <td>{{ $serv->servicio?? '' }}</td>
                            <td>{{ $serv->monto ?? '0' }}</td>
                            <td>{{ $serv->fur }}</td>

                            <td><button class="btn btn-warning verificar_pago" data-id="{{ $serv->serv_id }}" value="{{ $serv->fur }}"><i
                                    class="fas fa-check-square fa-2x  accent-blue " ></i></button></td>
                            <td>@if( $serv->estado_pago==false)
                               @php( print_r( 'PENDIENTE'))
                            @else
                            @php( print_r( 'PAGADO'))
                            @endif
                        </td>
                            <td>
                                @if($serv->tipo=="NICHO" || $serv->tipo=="EXTERNO" || $serv->tipo=="EXTERNO GRATUITO" )

                                @if(( $serv->estado_pago==false)&& ($serv->tipo=="NICHO"))
                                    <button type='button' class="btn btn-danger anular"  id="{{ $serv->fur }}"  data-id="{{ $serv->serv_id }}"><i
                                        class="fas fa-trash fa-2x"></i></button>

                                @elseif($serv->tipo=="EXTERNO" || $serv->tipo=="EXTERNO GRATUITO" )
                                    <button type='button' class="btn btn-danger anularExterno"  id="{{ $serv->fur }}"  data-id="{{ $serv->serv_id }}"><i
                                        class="fas fa-trash fa-2x"></i></button>





                            @endif
                                <form action="{{ route('serv.generatePDF') }}" method="GET" target="blank">
                                    @csrf
                                    <input type="hidden" name="codigo_nicho" value={{ $serv->codigo_nicho }}>
                                    <input type="hidden" name="id" value={{ $serv->serv_id }}>
                                    <input type="hidden" name="tipo" value={{ $serv->tipo }}>
                                    <input type="hidden" name="fur" value={{ $serv->fur }}>

                                    <button type='submit' class="btn btn-info "><i
                                            class="fas fa-file-pdf fa-2x  accent-blue "></i></button>
                                </form>
                                @elseif ($serv->tipo=="CRIPTA" || $serv->tipo=="MAUSOLEO" )
                                <form action="{{ route('serv.generatePDFCM') }}" method="GET" target="blank">
                                    @csrf
                                    <input type="hidden" name="codigo_nicho" value={{ $serv->codigo_nicho }}>
                                    <input type="hidden" name="id" value={{ $serv->serv_id }}>
                                    <input type="hidden" name="fur" value={{ $serv->fur }}>

                                    <button type='submit' class="btn btn-info "><i
                                            class="fas fa-file-pdf fa-2x  accent-blue "></i></button>
                                </form>
                                @endif


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




        {{-- @include('servicios.modalRegister')  --}}

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
        // $('#new-servicio').on('click', function(){
        //     //$('#modal-register-servicio').modal('show');
        //     document.location.href="{{ route('load.form') }}"";
        // });

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
            "sSearch": 'Buscar',
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


            /*******************VERIFICAR PAGO*****************/

        $(document).on('click', '.verificar_pago', function(e){
            e.preventDefault();

            var fur = $(this).val();
            var servicios_id= $(this).attr('data-id');
            verificarQR(fur, servicios_id);
        })




        function verificarQR(fur, servicios_id)
        {

            Swal.fire({
                title: 'Verificando Pago!',
                html: `Espere un momento`,
                didOpen: () => {
                    Swal.showLoading();
                  //  new Promise((resolve, reject) => {
                        $.ajax({
                            url:"{{route('verificar.pago')}}",
                            type: "POST",
                            headers: {
                                   'Content-Type':'application/json',
                                   'X-CSRF-TOKEN':'{{ csrf_token() }}',
                               },
                            data: JSON.stringify({
                                 fur: fur,
                            }),
                            cache: false,
                            contentType: "application/json; charset=utf-8",
                            dataType: 'json',
                            success: function(data) {
                                console.log("respuesta verificacion");

                                console.log(data.estado_pago);


                                if(data.estado_pago=="AC")
                                 {
                                                Swal.fire(
                                                    'Pago realizado',
                                                    `El pago del fur ${fur} ya fue realizado`,
                                                    'success'
                                                            )
                                                    .then(() => {
                                                            location.reload();
                                                        });
                                            }else{
                                                Swal.fire(
                                                    'Pago no realizado',
                                                    'Realiza el pago con la aplicación de tu banco de preferencia o en cajas',
                                                    'info'
                                                            )
                                                    .then(() => {
                                                            return false;
                                                        });
                                            }

                                            // $('.verificar_pago').show();
                                            $('.spiner_revision').hide();

                            },
                            error: function(resp) {
                                Swal.fire(
                                    'Error de verificación',
                                    'Intente nuevamente, Si el problema continua notifica a soporte',
                                    'error'
                                );
                            }
                        });
                  //  });
                },
            });
        }



        $(document).on('click', '.anular', function(e){
            e.preventDefault();
            var fur= $(this).attr('id');

            var id = $(this).attr('data-id');
            console.log('id: '+id+" fur: "+fur);
                Swal.fire({
                        title: 'Esta seguro de anular el registro?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Realizar',
                        denyButtonText: `No realizar`,
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {

                                Swal.fire({
                                        title: 'Ejecutando la solicitud!',
                                        html: `Espere un momento`,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        //  new Promise((resolve, reject) => {
                                                $.ajax({
                                                    url:"{{route('serv.anularFur')}}",
                                                    type: "POST",
                                                    headers: {
                                                        'Content-Type':'application/json',
                                                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                                    },
                                                    data: JSON.stringify({
                                                        fur: fur,
                                                        id: id,
                                                    }),
                                                    cache: false,
                                                    contentType: "application/json; charset=utf-8",
                                                    dataType: 'json',
                                                    success: function(data) {
                                                        console.log("respuesta anulacion");

                                                        console.log(data.status==true);


                                                        if(data.status==true)
                                                        {
                                                            Swal.fire(
                                                                            'Proceso realizado con éxito',
                                                                            `FUR ${fur} : ${data.message}`,
                                                                            'success'
                                                                                    )
                                                                            .then(() => {
                                                                                    location.reload();
                                                                                });


                                                                    }else{
                                                                        Swal.fire(
                                                                            'Proceso fallado',
                                                                            ` ${data.message}`,

                                                                                    )
                                                                            .then(() => {
                                                                                    return false;
                                                                                });
                                                                    }

                                                                    // $('.verificar_pago').show();
                                                                    $('.spiner_revision').hide();

                                                    },
                                                    error: function(resp) {
                                                        Swal.fire(
                                                            'Error de verificación',
                                                            'Intente nuevamente, Si el problema continua notifica a soporte',
                                                            'error'
                                                        );
                                                    }
                                                });
                                        //  });
                                        },
                                    });
                                } else if (result.isDenied) {
                            Swal.fire('Los cambios no fueron realizados', '', 'info')
                        }
                    })
        })

        /**** anular fur de servicio externo ****/


        $(document).on('click', '.anularExterno', function(e){
            e.preventDefault();
            var fur= $(this).attr('id');

            var id = $(this).attr('data-id');
            console.log('id: '+id+" fur: "+fur);
                Swal.fire({
                        title: 'Esta seguro de anular el registro?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Realizar',
                        denyButtonText: `No realizar`,
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {

                                Swal.fire({
                                        title: 'Ejecutando la solicitud!',
                                        html: `Espere un momento`,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        //  new Promise((resolve, reject) => {
                                                $.ajax({
                                                    url:"{{route('serv.anularFurExterno')}}",
                                                    type: "POST",
                                                    headers: {
                                                        'Content-Type':'application/json',
                                                        'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                                    },
                                                    data: JSON.stringify({
                                                        fur: fur,
                                                        id: id,
                                                    }),
                                                    cache: false,
                                                    contentType: "application/json; charset=utf-8",
                                                    dataType: 'json',
                                                    success: function(data) {
                                                        console.log("respuesta anulacion");

                                                        console.log(data.status==true);


                                                        if(data.status==true)
                                                        {
                                                            Swal.fire(
                                                                            'Proceso realizado con éxito',
                                                                            `FUR ${fur} : ${data.message}`,
                                                                            'success'
                                                                                    )
                                                                            .then(() => {
                                                                                    location.reload();
                                                                                });


                                                                    }else{
                                                                        Swal.fire(
                                                                            'Proceso fallado',
                                                                            ` ${data.message}`,

                                                                                    )
                                                                            .then(() => {
                                                                                    return false;
                                                                                });
                                                                    }

                                                                    // $('.verificar_pago').show();
                                                                    $('.spiner_revision').hide();

                                                    },
                                                    error: function(resp) {
                                                        Swal.fire(
                                                            'Error de verificación',
                                                            'Intente nuevamente, Si el problema continua notifica a soporte',
                                                            'error'
                                                        );
                                                    }
                                                });
                                        //  });
                                        },
                                    });
                                } else if (result.isDenied) {
                            Swal.fire('Los cambios no fueron realizados', '', 'info')
                        }
                    })
        })



    </script>
@stop

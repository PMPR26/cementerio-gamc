@extends('adminlte::page')
@section('title', 'Lista Notificaccion')

@section('plugins.datatable-boostrap', true)

@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)

@section('content_header')
    <h1>NOTIFICACIONES</h1>
@stop


@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ route('new.notificacion') }}" id="new-notificacion" class="btn btn-info col-sm-12"> <i
                    class="fas fa-plus-circle text-white fa-2x"></i>Nueva Notificación</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <table id="n-data" class="table table-striped table-bordered responsive" role="grid" aria-describedby="example">
                <thead class="bg-table-header">
                    <tr role="row">
                        <th scope="col">#</th>
                        <th scope="col">UNIDAD NOTIFICADA</th>
                        <th scope="col">TIPO UNIDAD</th>
                        <th scope="col">NOMBRE NOTIFICACION</th>
                        <th scope="col">CONTENIDO</th>
                        <th scope="col">FECHA NOTIFICACION</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
@section('js')
<script>


  $(function ()
  {
            var table =$('#n-data').DataTable({
                "lengthMenu": [[10, 20, 50, 100, 1000, 10000], ['10', '20', '50', '100', '1000', '10000']],
                "lengthChange": true,
                "responsive": true,
                "paging": true,
                "searching": true,
                "bDestroy": true,
                "bJQueryUI": true,
                "bServerSide" : true,
                "bPaginate": true,
                "language": {
                    "url": "{{ asset('plugins/datatables/Spanish.json') }}",
                    "searchPlaceholder": "Busqueda por Nombre"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                        "url": "{{ route('get.notificacion') }}",
                        "data": {
                        "_token": "{{ csrf_token() }}",
                        },
                        "dataType": "json",
                        "type": "POST",

                        },
                        columns: [
                        {
                            sortable: false,
                            "render": function (data, type, row, meta) {
                               // console.log("sadasdadasd");
                               //
                                console.log(data);
                               // console.log( meta.row);
                                var value = meta.row + meta.settings._iDisplayStart + 1; //contador de numeros.
                                return value.toString();
                            }
                        },
                        { "data": "ubicacion_codigo" },
                        { "data": "ubicacion_tipo" },
                        { "data": "nombre_notificacion" },
                        {   sortable: false,
                            "render": function (data, type, row, meta) {

                                var enl=" ";


                                    enl = ' <a href= "{{ route('print.notificacion') }} " target= "_blank" >Ver notificacion   </a>';


                                return  enl;

                            }
                        },
                        { "data": "fecha_notificacion" },
                        { "data": "estado" },


                            {
                                sortable: false,
                                "render": function (data, type, row, meta) {

                                    var button1="";
                                        button1='<form action="{{ route('edit.notificacion') }}"  method="post" style="display:inline">'+
                                            '<input type="hidden" name="id" value="' + row.id + '" >'+
                                            '<button type = "submit" class="btn" title="rectificar" > '+
                                                '<i class="fas fa-pen-square  fa-2x" aria-hidden="true"></i> </button>'+
                                            '</form>' ;



                                        return button1;
                                }
                            }
                            ],
        });

    });


    </script>
@endsection


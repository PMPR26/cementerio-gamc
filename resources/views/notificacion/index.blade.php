@extends('adminlte::page')
@section('title', 'Tipo Notificaccion')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)

@section('content_header')
    <h1>GESTION DE TIPOS DE NOTIFICACIONES</h1>
@stop


@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ route('new-tipo-notification') }}" id="new-tipo" class="btn btn-info col-sm-12"> <i
                    class="fas fa-plus-circle text-white fa-2x"></i>Registro Nuevo</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <table id="t-data" class="table table-striped table-bordered responsive" role="grid" aria-describedby="example">
                <thead class="bg-table-header">
                    <tr role="row">
                        <th scope="col">#</th>
                        <th scope="col">NOMBRE NOTIFICACION</th>
                        <th scope="col">CONTENIDO</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    @php($count = 1)
                    @foreach ($tipos as $tipos)
                        <tr>
                            <td scope="row">{{ $count++ }}</td>
                            <td>{{ $tipos->nombre_notificacion }}</td>
                            <td>{!! $tipos->contenido !!}</td>
                            <td>{{ $tipos->estado }}</td>
                            <td>

                               <form action="{{ route('edit.Notification.Type') }}" method="POST" target="blank">
                                    @csrf
                                    <input type="hidden" name="id" value={{ $tipos->id }}>
                                    <button type='submit' class="btn btn-info "><i
                                            class="fas fa-edit fa-2x  accent-blue "></i></button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {


            var datatable = $('#t-data').DataTable({
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
                    "sSearch": 'Buscar tipo notificacion:',
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
    </script>
@stop

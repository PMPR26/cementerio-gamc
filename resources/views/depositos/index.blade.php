@extends('adminlte::page')
@section('title', 'Deposito')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)

@section('content_header')
    <br>
@stop



<!-- resources/views/depositos/index.blade.php -->


@section('content')
    <div class="container-fluid">
        <div class="row card">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Listado de Depósitos</h1></div>

                    <div class="panel-body">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('deposito.create') }}" class="btn btn-info col-4">
                                    <i class="fas fa-plus-circle text-white fa-2x"></i> Crear Nuevo Registro
                                </a>
                            </div>
                        </div>


                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Código Sitio</th>
                                    <th>Nombre Difunto</th>
                                    <th>Fecha Ingreso a deposito</th>
                                    <th>Cantidad Cuotas Adeudadas</th>
                                    <th>Monto Total Adeudado </th>
                                    <th>Fur</th>
                                    <th>Estado Pago</th>
                                    <th>Responsable Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depositos as $deposito)
                                <tr>
                                        <td>{{ $deposito->codigo_sitio }}</td>
                                        <td>{{ $deposito->nombre_difunto }}</td>
                                        <td>{{ $deposito->fecha_ingreso_deposito }}</td>
                                        <td>{{ $deposito->cant_cuotas_adeudadas }}</td>
                                        <td>{{ $deposito->total_adeudado }}</td>
                                        <td>{{ $deposito->fur }}</td>
                                        <td>{{ $deposito->fecha_pago }}</td>
                                        <td>{{ $deposito->responsable_pago }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" value="{{ route('deposito.edit', $deposito->id) }}" id="btn-editar-difunto-value" title="Editar"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-warning" value="{{ route('deposito.show', $deposito->id) }}" id="btn-editar-difunto-value" title="Ver"><i class="fas fa-eye"></i></button>

                                            {{-- <a href="{{ route('deposito.show', $deposito->id) }}" class="btn btn-primary btn-xs" alt="ver"><i class="fas fa-eye"></i></a> --}}
                                            {{-- <a href="{{ route('deposito.edit', $deposito->id) }}" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i>r</a> --}}

                                            <form action="{{ route('deposito.formPago') }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="deposito_id" id="deposito_id" value="{{ $deposito->id}}">
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-credit-card 2x"></i></button>
                                            </form>

                                            {{-- <form action="{{ route('deposito.destroy', $deposito->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

var datatable = $('.table').DataTable({
    "paging": true,
    "searching": true,
    "language": {

        "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
        //"sProcessing": '<img src="https://media.giphy.com/media/3o7bu3XilJ5BOiSGic/giphy.gif" alt="Funny image">',
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningun registro",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": 'Buscar:',
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

</script>
@stop

@extends('adminlte::page')
@section('title', 'Deposito')
@section('plugins.Datatables', true)
@section('plugins.Animation', true)
@section('plugins.Toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Pace', true)
@section('content_header')
    <br>
@stop



<!-- resources/views/depositos/index.blade.php -->


@section('content')
    <div class="container-fluid">
        @if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
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
                                <table id="example" class="table table-striped table-bordered display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nro.</th>
                                            <th>Cuartel</th>
                                            <th>Bloque</th>
                                            <th>Nicho</th>
                                            <th>Fila</th>
                                            <th>Difunto</th>
                                            <th>Impuesto</th>
                                            <th>Lapida</th>
                                            <th>Total Adeudado </th>
                                            <th>Fur</th>
                                            <th>Estado Pago</th>
                                            <th>Responsable Pago</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($depositos as $key=>$deposito)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $deposito->cuartel }}</td>
                                            <td>{{ $deposito->bloque }}</td>
                                            <td>{{ $deposito->nicho }}</td>
                                            <td>{{ $deposito->fila }}</td>
                                            <td>{{ $deposito->nombre_difunto }}</td>
                                            <td>{{ $deposito->impuesto }}</td>
                                            <td>{{ $deposito->lapida }}</td>
                                            <td>{{ $deposito->total_adeudado }}</td>
                                            <td>{{ $deposito->fur }}</td>
                                            <td>{{ $deposito->estado_pago }}</td>
                                            <td>{{ $deposito->responsable_pago }}</td>
                                            <td>


                                                <form action="{{ route('deposito.show') }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="deposito_id" id="deposito_id" value="{{ $deposito->id}}">
                                                    <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                                </form>


                                                <form action="{{ route('deposito.formPago') }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="deposito_id" id="deposito_id" value="{{ $deposito->id}}">
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-credit-card 2x"></i></button>
                                                </form>


                                                <form action="{{ route('deposito.print') }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="deposito_id" id="deposito_id" value="{{ $deposito->id}}">

                                                    <input type="hidden" name="fur" id="fur" value="{{ $deposito->fur??''}}">
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-file-pdf"></i></button>
                                                </form>

                                            </td>
                                        </tr>
                                         @endforeach
                                        <!-- Más filas -->
                                    </tbody>
                                </table>
                            </div>
                        </div>




                </div>
            </div>
        </div>
    </div>
    @stop

    @section('js')

    <script>
         $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                language: {
                    "sProcessing": '<p style="color: #012d02;">Cargando. Por favor espere...</p>',
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
            });


</script>
@stop

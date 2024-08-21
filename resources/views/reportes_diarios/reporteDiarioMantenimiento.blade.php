<!DOCTYPE html>

<html>

<head>
    <style>
       body{
      font-family: sans-serif;
    }
    @page {
      margin: 160px 50px;
    }
    header { position: fixed;
      left: 0px;
      top: -120px;
      right: 0px;
      height: 100px;

      text-align: center;
      border-bottom: 2px solid #ddd;

    }

    footer {
      position: fixed;
      left: 0px;
      bottom: -80px;
      right: 0px;
      height: 40px;
      border-top: 2px solid #ddd;
    }
    footer .page:after {
      content: counter(page);
    }
    footer table {
      width: 100%;
    }
    footer div {
      text-align: right;
    }
    footer .izq {
      text-align: left;
    }
        .txthead {
            font-size: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
        }

       .info tr:nth-child(even) {background: rgb(250, 250, 250)}
        .info tr:nth-child(odd) {background: #edeef0}
        table thead tr th {
            background-color: rgba(43, 72, 105, 0.3);
            /* padding: 5px; */
            border-collapse: collapse;
            color: rgb(4, 2, 24);

        }
.info th, .info td{
    border: 0.8px rgb(218, 215, 215) solid;
    text-align: center;
    font-size: 9px;

}
#footer .page:after {
  content: counter(page, decimal);
}
.page{
    text-align: center;
    font-size: 9px;
}
    </style>
</head>

<body>
    <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
    <header>
        <table width="100%"  cellpadding ="0" cellspacing="0">
            <tr>
               <td width="20%">
                @php($image_path1 = public_path() . '/img/admin/logogamc.png')
                @php($imageData = base64_encode(file_get_contents($image_path1)))
                @php($src = 'data:' . mime_content_type($image_path1) . ';base64,' . $imageData)
                <img src="{{ $src }}" height="100px" class="img-fluid" style="width: 70px; height: 70px">

                </td>
                <td width="60%" class="txthead">
                    <span class="txthead">GOBIERNO AUTONOMO MUNICIPAL DE COCHABAMBA <br>
                        DIVISION DE INGRESOS NO TRIBUTARIOS<br>
                        DIVISION DE CEMENTERIO</span>

                </td>

                <td width="30%">
                    <span class="txthead" align="right"> Fecha: {{ date('Y-m-d') }} <br>
                        Hora:{{ date('H:m:s') }}
                    </span>
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <div id="footer">
            <p class="page">Página </p>
        </div>
    </footer>



        <table class="info"  width="100%">
            <caption>LISTA DE PAGO MANTENIMIENTOS DEL DIA</caption>
            <thead>
                <tr>

                    <th>CODIGO UBICACION</th>
                    <th>FUR</th>
                    <th>CANTIDAD GESTIONES</th>
                    <th>MONTO</th>
                    <th>ESTADO</th>
                    <th>SERVICIO</th>
                    <th>PAGO POR</th>
                    <th>NOMBRE </th>
                    <th>FECHA</th>
                 </tr>
            </thead>
            <tbody>
                @foreach ($mantenimiento as $key => $value )
                @if($value->pagado == 1)
                @php($estado_pago="PAGADO")
                @else
                @php($estado_pago="PENDIENTE")
                @endif
                    <tr>
                        <td>{{ $value->codigo_ubicacion ?? '' }}</td>
                        <td>{{ $value->fur ?? '' }}</td>
                        <td>{{ $value->cantidad_gestiones ?? '' }}</td>
                        <td>{{ $value->monto ?? '' }}</td>
                        <td>{{ $estado_pago ?? '' }}</td>
                        <td>{{ $value->servicio ?? '' }}</td>
                        <td>{{ $value->pago_por ?? '' }}</td>
                        <td>{{ $value->nombre_completo ?? '' }}</td>
                        <td>{{ $value->created_at ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


</body>

</html>

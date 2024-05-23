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
      bottom: -100px;
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

        .txtadd {
            font-size: 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 200;
        }

        .txtred {
            font-size: 12px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            color: red;

        }

        .rotulo {
            font-size: 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            font-style: italic;

        }

        .bold {
            font-size: 12px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            font-style: italic;

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
                    <img src="{{ public_path('/img/admin/logogamc.png') }}" style="width: 70px; height: 70px">
                </td>
                <td width="60%" class="txthead">
                    <span class="txthead">GOBIERNO AUTONOMO MUNICIPAL DE COCHABAMBA <br>
                        DIVISION DE INGRESOS NO TRIBUTARIOS<br>
                        DIVISION DE CEMENTERIO</span>

                </td>
                <td width="2%"></td>

                <td width="18%">
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



        <table class="info" width=100%>
            <caption>LISTA DE CUERPOS EN DEPOSITO</caption>
            <thead>
                <tr>
                    <th>NRO.</th>
                    <th>CUARTEL</th>
                    <th>BLOQUE</th>
                    <th>NICHO</th>
                    <th>FILA</th>
                    <th>NOMBRE DEL DIFUNTO</th>
                    <th>IMPUESTOS</th>
                    <th>LAPIDA</th>
                    <th>OBSERVACION</th>
                 </tr>
            </thead>
            <tbody>
                @foreach ($deposito as $key => $value )
                    <tr>
                        <td>{{ $key+1 }}</td>

                        <td>{{ $value->cuartel ?? '' }}</td>
                        <td>{{ $value->bloque ?? '' }}</td>
                        <td>{{ $value->nicho ?? '' }}</td>
                        <td>{{ $value->fila ?? '' }}</td>
                        <td>{{ $value->nombre_difunto ?? '' }}</td>

                        <td>{{ $value->impuesto ?? '' }}</td>
                        <td>{{ $value->lapida ?? '' }}</td>
                        <td>{{ $value->observacion ?? '' }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    {{-- </main> --}}
</body>

</html>

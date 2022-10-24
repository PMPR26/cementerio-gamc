<!DOCTYPE html>

<html>

<head>
    <style>
        /**
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Defina ahora los márgenes reales de cada página en el PDF **/
        body {
            margin-top: 1cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 3cm;
            font-size: 9px !important;
            line-height: 10px !important;

        }

        /** Definir las reglas del encabezado **/
        header {
            position: fixed;
            top: 1cm;
            left: 2cm;
            right: 0cm;
            height: 4cm;
        }
        main{
            position: fixed;
            top: 2cm;
            left: 0cm;
            right: 1.5cm;
            left: 1.5cm;
            text-align: center !important;
        }
        /** Definir las reglas del pie de página **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        table tr td {
            font-size: 12px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

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
                <td width="10%"></td>

                <td width="10%">
                    <span class="txthead" align="right"> Fecha: {{ date('Y-m-d') }} <br>
                        Hora:{{ date('H:m:s') }}
                    </span>
                </td>
            </tr>
        </table>



    </header>

    <footer>
        <!-- <img src="footer.png" width="100%" height="100%"/> -->
    </footer>

    <!-- Envuelva el contenido de su PDF dentro de una etiqueta principal -->
    <main>

                   <h4 align="center">LISTA DE MAUSOLEOS NOTABLES</h4>
        <table class="info">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>COD. ANTIGUO</th>
                    <th>CUARTEL</th>
                    <th>BLOQUE</th>
                    <th>SITIO</th>
                    <th>SUPERFICIE</th>
                    <th>FAMILIA</th>
                    <th>ENT. OCUPADOS</th>
                    <th>TOT. ENTERRATORIOS</th>
                    <th>OSARIOS OCUPADOS</th>
                    <th>TOT. OSARIOS</th>
                    <th>CENISARIOS</th>
                    <th>DIFUNTOS</th>
                    <th>ULTIMA GESTION PAGADA</th>
                 </tr>
            </thead>
            <tbody>
                @foreach ($cripta as $key => $value )
                    <tr>
                        <td>{{ $value->codigo ?? '' }}</td>
                        <td>{{ $value->codigo_antiguo ?? '' }}</td>
                        <td>{{ $value->cuartel_codigo ?? '' }}</td>
                        <td>{{ $value->bloque_nombre ?? '' }}</td>
                        <td>{{ $value->sitio ?? '' }}</td>
                        <td>{{ $value->superficie ?? '' }}</td>
                        <td>{{ $value->familia ?? '' }}</td>
                        <td>{{ $value->enterratorios_ocupados ?? '' }}</td>
                        <td>{{ $value->total_enterratorios ?? '' }}</td>
                        <td>{{ $value->osarios ?? '' }}</td>
                        <td>{{ $value->total_osarios ?? '' }}</td>
                        <td>{{ $value->cenisarios ?? '' }}</td>
                        <td><?php
                            if($value->difuntos !=null || !empty($value->difuntos)){
                                foreach (json_decode($value->difuntos) as $k => $val) {
                                    echo "<p> " .$val->ci. " ".$val->nombres. " ".$val->primer_apellido ?? ''. "  </p>";
                                }
                            }
                    ?></td>
                        <td>{{ $value->ultimo_pago ?? '' }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </main>
</body>

</html>

<!DOCTYPE html>

<html>

<head>
    <style>
        body{
       font-family: sans-serif;
       font-size: 10px;
     }
     @page {
       margin: 160px 50px;
       font-size: 10px;

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
    </style>
</head>

<body>
    <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
    <header>
        <table>
            <tr>
                <td width="170px">
                    <img src="{{ public_path('/img/admin/logogamc.png') }}" style="width: 70px; height: 70px">
                </td>
                <td width="30%" class="txthead">
                    <span class="txthead">GOBIERNO AUTONOMO MUNICIPAL DE COCHABAMBA <br>
                        DIRECCIÓN DE INGRESOS NO TRIBUTARIOS<br>
                        DIVISION DE CEMENTERIO</span>

                </td>
                <td width="130px"></td>

                <td width="5%">
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
        <pre>
              {{--  @php(print_r($tableFur[0]->cuenta ))
               @php(die())--}}
        </pre>

        <!-- tabla encabezado boleta -->
        <table width="100%">
            <tr>
                <th width="100%">
                    <h4 align="center">BOLETA DE PRELIQUIDACION</h4>
                </th>
                <td width="20%">
                    <span class="txtred">Nro. FUR:{{ $deposito->fur ?? '' }}</span><br>
                    <span class="txtadd">Tasa por otros servicios</span>
                </td>

            </tr>
        </table>
        <table  width="100%">
            <tr>
                <td width="80%"> <span class="rotulo"> IDENTIFICACION DEL CONTRIBUYENTE</span></td>
                <td></td>
            </tr>
            <tr>
                <td width="80%">Nombre Responsable Pago: {{ucwords($deposito->nombre ?? '' )}}  </td><td  width=20%  class="text-right"> C.I.:{{ $deposito->ci??'' }}</td>

            </tr>

        </table>

        <h4 align="center">DETALLE LIQUIDACION</h4>
        <br>
                <table  width="100%" border="1" cellspacing="0" cellpadding="10">
                    <thead>
                        <tr>
                            <th width="100px" align="left">CUENTA</th>
                            <th width="5%" align="right">CANTIDAD</th>
                            <th width="70%" align="center">DETALLE</th>
                            <th width="10%" align="right">MONTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="100px" align="center">{{ $deposito->cobrosDetalles[0]->cuenta }}</td>
                            <td width="2%" align="center">{{ $deposito->cobrosDetalles[0]->cantidad }}</td>
                            <td width="70%" align="center">{{ $deposito->cobrosDetalles[0]->detalle }}</td>
                            <td width="10%" align="center">{{ $deposito->cobrosDetalles[0]->monto }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="odd">
                            <td width="80%" colspan="3" align="left">Total </td>
                            <td width="10%" align="right">{{ $data->total_adeudado ?? '' }}</td>
                        </tr>
                    </tfoot>
                </table>
            <p>

                    <?php $subt1 = round($data->total_adeudado, 3);
                    $subtLit = number_format(floatval($subt1), 2, ',', '.');
                    $lit = convertir($subtLit);
                    $txt = 'SON: BOLIVIANOS  ' . $lit . ' ';
                    ?>
                    <b> {{ $txt }} </b>

            </p>


    </main>
</body>

</html>

<?php

function unidad($numuero)
{
    switch ($numuero) {
        case 9:
            $numu = 'NUEVE';
            break;
        case 8:
            $numu = 'OCHO';
            break;
        case 7:
            $numu = 'SIETE';
            break;
        case 6:
            $numu = 'SEIS';
            break;
        case 5:
            $numu = 'CINCO';
            break;
        case 4:
            $numu = 'CUATRO';
            break;
        case 3:
            $numu = 'TRES';
            break;
        case 2:
            $numu = 'DOS';
            break;
        case 1:
            $numu = 'UNO';
            break;
        case 0:
            $numu = 'CERO';
            break;
    }
    return $numu;
}

function decena($numdero)
{
    if ($numdero >= 90 && $numdero <= 99) {
        $numd = 'NOVENTA ';
        if ($numdero > 90) {
            $numd = $numd . 'Y ' . unidad($numdero - 90);
        }
    } elseif ($numdero >= 80 && $numdero <= 89) {
        $numd = 'OCHENTA ';
        if ($numdero > 80) {
            $numd = $numd . 'Y ' . unidad($numdero - 80);
        }
    } elseif ($numdero >= 70 && $numdero <= 79) {
        $numd = 'SETENTA ';
        if ($numdero > 70) {
            $numd = $numd . 'Y ' . unidad($numdero - 70);
        }
    } elseif ($numdero >= 60 && $numdero <= 69) {
        $numd = 'SESENTA ';
        if ($numdero > 60) {
            $numd = $numd . 'Y ' . unidad($numdero - 60);
        }
    } elseif ($numdero >= 50 && $numdero <= 59) {
        $numd = 'CINCUENTA ';
        if ($numdero > 50) {
            $numd = $numd . 'Y ' . unidad($numdero - 50);
        }
    } elseif ($numdero >= 40 && $numdero <= 49) {
        $numd = 'CUARENTA ';
        if ($numdero > 40) {
            $numd = $numd . 'Y ' . unidad($numdero - 40);
        }
    } elseif ($numdero >= 30 && $numdero <= 39) {
        $numd = 'TREINTA ';
        if ($numdero > 30) {
            $numd = $numd . 'Y ' . unidad($numdero - 30);
        }
    } elseif ($numdero >= 20 && $numdero <= 29) {
        if ($numdero == 20) {
            $numd = 'VEINTE ';
        } else {
            $numd = 'VEINTI' . unidad($numdero - 20);
        }
    } elseif ($numdero >= 10 && $numdero <= 19) {
        switch ($numdero) {
            case 10:
                $numd = 'DIEZ ';
                break;
            case 11:
                $numd = 'ONCE ';
                break;
            case 12:
                $numd = 'DOCE ';
                break;
            case 13:
                $numd = 'TRECE ';
                break;
            case 14:
                $numd = 'CATORCE ';
                break;
            case 15:
                $numd = 'QUINCE ';
                break;
            case 16:
                $numd = 'DIECISEIS ';
                break;
            case 17:
                $numd = 'DIECISIETE ';
                break;
            case 18:
                $numd = 'DIECIOCHO ';
                break;
            case 19:
                $numd = 'DIECINUEVE ';
                break;
        }
    } else {
        $numd = unidad($numdero);
    }
    return $numd;
}

function centena($numc)
{
    if ($numc >= 100) {
        if ($numc >= 900 && $numc <= 999) {
            $numce = 'NOVECIENTOS ';
            if ($numc > 900) {
                $numce = $numce . decena($numc - 900);
            }
        } elseif ($numc >= 800 && $numc <= 899) {
            $numce = 'OCHOCIENTOS ';
            if ($numc > 800) {
                $numce = $numce . decena($numc - 800);
            }
        } elseif ($numc >= 700 && $numc <= 799) {
            $numce = 'SETECIENTOS ';
            if ($numc > 700) {
                $numce = $numce . decena($numc - 700);
            }
        } elseif ($numc >= 600 && $numc <= 699) {
            $numce = 'SEISCIENTOS ';
            if ($numc > 600) {
                $numce = $numce . decena($numc - 600);
            }
        } elseif ($numc >= 500 && $numc <= 599) {
            $numce = 'QUINIENTOS ';
            if ($numc > 500) {
                $numce = $numce . decena($numc - 500);
            }
        } elseif ($numc >= 400 && $numc <= 499) {
            $numce = 'CUATROCIENTOS ';
            if ($numc > 400) {
                $numce = $numce . decena($numc - 400);
            }
        } elseif ($numc >= 300 && $numc <= 399) {
            $numce = 'TRESCIENTOS ';
            if ($numc > 300) {
                $numce = $numce . decena($numc - 300);
            }
        } elseif ($numc >= 200 && $numc <= 299) {
            $numce = 'DOSCIENTOS ';
            if ($numc > 200) {
                $numce = $numce . decena($numc - 200);
            }
        } elseif ($numc >= 100 && $numc <= 199) {
            if ($numc == 100) {
                $numce = 'CIEN ';
            } else {
                $numce = 'CIENTO ' . decena($numc - 100);
            }
        }
    } else {
        $numce = decena($numc);
    }

    return $numce;
}

function miles($nummero)
{
    if ($nummero >= 1000 && $nummero < 2000) {
        $numm = 'MIL ' . centena($nummero % 1000);
    }
    if ($nummero >= 2000 && $nummero < 10000) {
        $numm = unidad(Floor($nummero / 1000)) . ' MIL ' . centena($nummero % 1000);
    }
    if ($nummero < 1000) {
        $numm = centena($nummero);
    }

    return $numm;
}

function decmiles($numdmero)
{
    if ($numdmero == 10000) {
        $numde = 'DIEZ MIL';
    }
    if ($numdmero > 10000 && $numdmero < 20000) {
        $numde = decena(Floor($numdmero / 1000)) . 'MIL ' . centena($numdmero % 1000);
    }
    if ($numdmero >= 20000 && $numdmero < 100000) {
        $numde = decena(Floor($numdmero / 1000)) . ' MIL ' . miles($numdmero % 1000);
    }
    if ($numdmero < 10000) {
        $numde = miles($numdmero);
    }

    return $numde;
}

function cienmiles($numcmero)
{
    if ($numcmero == 100000) {
        $num_letracm = 'CIEN MIL';
    }
    if ($numcmero >= 100000 && $numcmero < 1000000) {
        $num_letracm = centena(Floor($numcmero / 1000)) . ' MIL ' . centena($numcmero % 1000);
    }
    if ($numcmero < 100000) {
        $num_letracm = decmiles($numcmero);
    }
    return $num_letracm;
}

function millon($nummiero)
{
    if ($nummiero >= 1000000 && $nummiero < 2000000) {
        $num_letramm = 'UN MILLON ' . cienmiles($nummiero % 1000000);
    }
    if ($nummiero >= 2000000 && $nummiero < 10000000) {
        $num_letramm = unidad(Floor($nummiero / 1000000)) . ' MILLONES ' . cienmiles($nummiero % 1000000);
    }
    if ($nummiero < 1000000) {
        $num_letramm = cienmiles($nummiero);
    }

    return $num_letramm;
}

function decmillon($numerodm)
{
    if ($numerodm == 10000000) {
        $num_letradmm = 'DIEZ MILLONES';
    }
    if ($numerodm > 10000000 && $numerodm < 20000000) {
        $num_letradmm = decena(Floor($numerodm / 1000000)) . 'MILLONES ' . cienmiles($numerodm % 1000000);
    }
    if ($numerodm >= 20000000 && $numerodm < 100000000) {
        $num_letradmm = decena(Floor($numerodm / 1000000)) . ' MILLONES ' . millon($numerodm % 1000000);
    }
    if ($numerodm < 10000000) {
        $num_letradmm = millon($numerodm);
    }

    return $num_letradmm;
}

function cienmillon($numcmeros)
{
    if ($numcmeros == 100000000) {
        $num_letracms = 'CIEN MILLONES';
    }
    if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
        $num_letracms = centena(Floor($numcmeros / 1000000)) . ' MILLONES ' . millon($numcmeros % 1000000);
    }
    if ($numcmeros < 100000000) {
        $num_letracms = decmillon($numcmeros);
    }
    return $num_letracms;
}

function milmillon($nummierod)
{
    if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
        $num_letrammd = 'MIL ' . cienmillon($nummierod % 1000000000);
    }
    if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
        $num_letrammd = unidad(Floor($nummierod / 1000000000)) . ' MIL ' . cienmillon($nummierod % 1000000000);
    }
    if ($nummierod < 1000000000) {
        $num_letrammd = cienmillon($nummierod);
    }

    return $num_letrammd;
}

function convertir($numero)
{
    $num = str_replace('.', ',', $numero);
    // $num = number_format($num,  2, ',', '');

    $cents = substr($num, strlen($num) - 2, strlen($num) - 1);
    $num = (int) $num;

    $numf = milmillon($num);

    return ' ' . $numf . ' CON ' . $cents . '/100';
}

//echo convertir($numero);

function redondear_dos_decimal($valor)
{
    $float_redondeado = round($valor * 100) / 100;
    return $float_redondeado;
}
?>

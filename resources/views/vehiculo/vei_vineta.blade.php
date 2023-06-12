<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html,
        body {
            height: 90%;
            margin: 1;
            padding: 1;
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table-container {
            width: 100%;
            height: 90%;
        }

        table {
            width: 100%;
            height: 90%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 0px;
        }
        .img_1 {
        width: 90%;
        height: 90%;
    }
    </style>
    <title>NAABOL</title>

</head>

<body style="margin: 0">
    <div class="container">
        <div class="table-container">
            <table>
                <tr>
                    <td>EMPRESA</td>
                    <td colspan="2">{{ $Empresa }}</td>
                </tr>
                <tr>
                    <td>PLACA</td>
                    <td>{{ $Placa }}</td>
                    <th rowspan="5">
                        {!! '<img class="img_1" src="data:image/png;base64,' .
                            DNS2D::getBarcodePNG(
                                'cod' .
                                    $id .
                                    '|' .
                                    $Empresa .
                                    '|' .
                                    $Placa .
                                    '|' .
                                    $Marca .
                                    '|' .
                                    $Tipo .
                                    '|' .
                                    $Color .
                                    '|' .
                                    $Vence .
                                    '|' .
                                    $Areas,
                                'QRCODE',
                            ) .
                            '" alt="barcode"   />' !!}
                    </th>
                </tr>
                <tr>
                    <td>MARCA</td>
                    <td>{{ $Marca }}</td>
                </tr>
                <tr>
                    <td >TIPO/COLOR</td>
                    <td>{{ $Tipo }} <br> {{ $Color }}
                    </td>
                </tr>
                <tr>
                    <td>VENCE</td>
                    <td>{{ $Vence }}</td>
                </tr>
                <tr>
                    <td>AREAS</td>
                    <td>{{ $Areas }}</td>
                </tr>F
            </table>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Document</title>
    <style>
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        @page {
            margin-left: 0.7cm;
            margin-right: 0.7cm;
             margin-top: 0.0cm;
            margin-bottom: 0.0cm; 
        }

        body {
            /* border-style: solid;
            border-width: 1px;
            border-left-width: 1px;
            border-right-width: 1px;
            border-color: black; */
        }

        body {
            margin-right: 0px;
        }

        table {
            font-size: ;
            position: relative;
            margin-top: 20px;
            margin-left: 0px
        }

        table tr td {
            font-size: 10px
        }

        .gray {
            background-color: lightgray
        }

        .img_1 {
            width: 70px;
            height: 70px;
        }
    </style>
</head>

<body>
    <table width="100%" style="border:1px solid black;border-collapse:collapse;">
        <tr>
            <td style="font-size:7px; border:1px solid black;">EMPRESA</td>
            <td colspan="2" style="border:1px solid black;">{{ $Empresa }}</td>
        </tr>
        <tr>
            <td style="font-size:7px; border:1px  solid black;">PLACA</td>
            <td style="border:1px solid black;">{{ $Placa }}</td>
            <th rowspan="5" style="border:1px solid black;">
                {!! '<img class="img_1" src="data:image/png;base64,' .
                    DNS2D::getBarcodePNG('cod' . $id . '|' . $Empresa. '|' . $Placa. '|' . $Marca. '|' . $Tipo. '|' . $Color. '|' . $Vence. '|' . $Areas, 'QRCODE') .
                    '" alt="barcode"   />' !!}
            </th>
        </tr>
        <tr>
            <td style="font-size:7px; border:1px  solid black;">MARCA</td>
            <td style="border:1px solid black;">{{ $Marca }}</td>
        </tr>
        <tr>
            <td style="font-size:7px; border:1px  solid black;">TIPO/COLOR</td>
            <td style="border:1px solid black; font-size:10px;">{{ $Tipo }} <br> {{ $Color }}</td>
        </tr>
        <tr>
            <td style="font-size:7px; border:1px  solid black;">VENCE</td>
            <td style="border:1px solid black;">{{ $Vence }}</td>
        </tr>
        <tr>
            <td style="font-size:7px; border:1px  solid black;">AREAS</td>
            <td style="border:1px solid black;">{{ $Areas }}</td>
        </tr>
    </table>

</body>

</html>

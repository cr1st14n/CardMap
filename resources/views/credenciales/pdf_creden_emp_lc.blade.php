<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin-left: 0;
            margin-right: 0;
            margin-top: 0;
            margin-bottom: 0;
        }

        html {
            background-color: white;
        }

        body {
            background-color: papayawhip;
            /* background-image: url("{{ asset('resources/plantilla/CREDENCIALESFOTOS/NACIONALAMVERSO.jpg') }}"); */
            background-image: url("{{ asset($ruta) }}");
            background-size: cover;
            background-repeat: no-repeat;
        }

        p.a {
            position: relative;
            top: 400px;
            left: 90px;
            font-size: 30px;
            color: white;
            text-transform: uppercase;
            font-family: sans-serif;
            font-weight: bold;
        }

        p.b {
            position: fixed;

            left: 17px;
            width: 10px;
            word-wrap: break-word;
            text-align: center;
            line-height: 58px;
            font-size: 50px;
            top: 80px;
            font-family: sans-serif;
            font-weight: bold;

        }

        p.l1 {
            position: fixed;
            left: 50px;
            width: 10px;
            word-wrap: break-word;
            text-align: center;
            line-height: 58px;
            font-size: 20px;
            top: 77px;
            font-family: sans-serif;
            font-weight: bold;

        }

        p.e {
            position: fixed;
            right: 10px;
            top: 50px;
            font-size: 55px;
            color: red;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        p.f {
            position: fixed;
            right: 20px;
            top: 130px;
            font-size: 30px;
            color: black;
            font-weight: bold;
        }

        p.LCA {
            position: fixed;
            right: 20px;
            top: 50px;
            font-size: 150px;
            color: red;
            font-weight: bold;
            font-family: sans-serif;

        }


        img.img_b {
            position: fixed;
            top: 117px;
            left: 75px;
            width: 230px;
            height: 305px;

        }

        .ci {
            position: fixed;
            top: 555px;
            left: 60px;
            font-size: 40px;
            font-family: sans-serif;
            font-weight: bold;
        }

        .per {
            position: fixed;
            top: 555px;
            right: 20px;
            font-size: 40px;
            font-family: sans-serif;
            font-weight: bold;
        }

        img.s2dapag {
            /* position: fixed; */
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;

        }

        .cat {
            position: fixed;
            top: 0px;
            left: 10px;
            font-size: 40px;
            font-family: sans-serif;
            font-weight: bold;
        }

        p.ll1 {
            position: fixed;
            left: 50px;
            width: 10px;
            top: 85px;
            font-size: 20px;
            line-height: 22px;
            word-wrap: break-word;
            text-align: center;
            font-family: sans-serif;
            font-weight: bold;
        }

        p.ll2 {
            position: fixed;
            left: 50px;
            width: 10px;
            top: 200px;
            font-size: 20px;
            line-height: 22px;
            word-wrap: break-word;
            text-align: center;
            font-family: sans-serif;
            font-weight: bold;
        }

        p.ll3 {
            position: fixed;
            left: 50px;
            width: 10px;
            top: 380px;
            font-size: 20px;
            line-height: 21px;
            word-wrap: break-word;
            text-align: center;
            font-family: sans-serif;
            font-weight: bold;
        }

        p.ll4 {
            position: fixed;
            left: 50px;
            width: 10px;
            top: 600px;
            font-size: 20px;
            line-height: 22px;
            word-wrap: break-word;
            text-align: center;
            font-family: sans-serif;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="ri">

        <!-- <img class="img_a" src="{{ asset('resources/plantilla/CREDENCIALESFOTOS/LAPAZAMVERSO.jpg') }}"  alt=""> -->
        <img class="img_b" src="{{ asset($data->urlphoto) }}" alt="">
        <!-- <p class="e">{{ $M }}<br>{{ $Y }}</p> -->
        <p class="f">{{ $data->Codigo }}-{{ $aero }} </p>
        <p class="LCA">{{ $catLic }}</p>
        @if ($aero == 'LPB')
            <p class="a" style="color: black ;"> {{ $data->Nombre }} <br>{{ $data->Paterno }}
                {{ $data->Materno }}<br>{{ $data->Cargo }} <br>{{ $data->Empresa }}</p>
        @else
            <p class="a" style="color: black ;"> {{ $data->Nombre }} <br>{{ $data->Paterno }}
                {{ $data->Materno }}<br>{{ $data->Cargo }} <br>{{ $data->Empresa }}</p>
        @endif
        <p class="b">{{ $data->AreasCP }}</p>
        <p class="ci">{{ $data->CI }}</p>
        <p class="per"><strong style="color: red ;">
                @if ($data->Herramientas != '')
                    H
                @endif
            </strong>
            <br>
            @if ($data->NroRenovacion != 0)
                D
            @endif
        </p>
        <img class="s2dapag" src="{{ asset('resources/plantilla/CREDENCIALESFOTOS/TODOSREVERSOlc.jpg') }}"
            alt="">
        <p class="ll1">
            @if ($catLic == 'A'|| $catLic == 'B' || $catLic == 'C')
                {{ $LiA }}
            @endif
        </p>
        <p class="ll2">
            @if ($catLic == 'B' || $catLic == 'C')
                {{ $LiB }}
            @endif
        </p>
        <p class="ll3">
            @if ($catLic == 'C' )
                {{ $LiC }}
            @endif
        </p>
        <p class="ll4">
            @if ($catLic == 'P' || $catLic == 'M')
                {{ $LiMP }}
            @endif
        </p>
</body>

</html>

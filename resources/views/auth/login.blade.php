<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>NAABOL | Creden</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="../favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/ionicons/dist/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/icon-kit/dist/css/iconkit.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('resources/plantilla/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/dist/css/theme.min.css') }}">

    <!-- norific8 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css"
        media="screen">
    <script src="{{ asset('resources/plantilla/src/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('resources/plantilla/plugins/jquery-toast-plugin/dist/jquery.toast.min.css') }}">
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="auth-wrapper">
        <div class="container-fluid h-100">
            <div class="row flex-row h-100 bg-white">
                <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                    <div class="lavalite-bg" style="background-image: url('resources/plantilla/img/auth/login-bg.png')">
                        <div class="lavalite-overlay"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                    <div class="authentication-form mx-auto">
                        <div class="logo-centered">
                            <a href="../index.html"><img src="" alt=""></a>
                        </div>
                        <h3><strong>NAABOL</strong> SISTEMA DE CREDENCIALES</h3>
                        <form id="formLogin" onsubmit=" event.preventDefault(); login_1()">
                            @csrf
                            <p>Seleccione Aeropuerto</p>
                            <div class="form-group">
                                <select name="aeropuerto" id="aeropuerto" class="form-control">
                                    <option value="LPB">LA PAZ</option>
                                    <option value="CBB">COCHABAMBA</option>
                                    <option value="VVI">SANTA CRUZ</option>
                                </select>
                                <i class="ik ik-database"></i>
                            </div>
                            <p>Inicio de sessión</p>
                            <div class="form-group">
                                <input type="text" class="form-control" name="codusr" placeholder="Codigo"
                                    required="" value="">
                                <i class="ik ik-user"></i>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Contraseña"
                                    required="" value="">
                                <i class="ik ik-lock"></i>
                            </div>
                            <div class="sign-btn text-center">
                                <button type="submit" class="btn btn-theme">INGRESAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('resources/plantilla/src/js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/screenfull/dist/screenfull.js') }}"></script>
    <script src="{{ asset('resources/plantilla/dist/js/theme.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>
    <!-- notific8 -->
    <script>
        function login_1() {
            console.log($('#formLogin').serialize());
            $.ajax({
                type: "GET",
                url: "log1",
                data: $('#formLogin').serialize(),
                success: function(e) {
                    console.log(e);
                    if (e == 'success' ) {
                        window.location.href = 'index/';
                    } else if (e == 0) {
                        params = {
                            heading: "Alerta!",
                            text: 'Usuario o Región Incorrectos',
                            showHideTransition: "slide",
                            icon: "info",
                            loaderBg: "#46c35f",
                            position: "top-right",
                        };
                        $.toast(params);
                    } else if (e == 1) {
                        params = {
                            heading: "Alerta!",
                            text: 'Contraseña Incorrecta!',
                            showHideTransition: "slide",
                            icon: "info",
                            loaderBg: "#46c35f",
                            position: "top-right",
                        };
                        $.toast(params);
                    }
                }
            });
        }
    </script>
</body>

</html>

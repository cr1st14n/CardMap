<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Form Components | ThemeKit - Admin Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">


    <link rel="icon" href="../favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/ionicons/dist/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/icon-kit/dist/css/iconkit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/plantilla/dist/css/theme.min.css') }}">`


    <link rel="stylesheet"
        href="{{ asset('resources/plantilla/plugins/jquery-toast-plugin/dist/jquery.toast.min.css') }}">

    <script src="{{ asset('resources/plantilla/src/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    <!-- dropzone -->
    <link href="{{ asset('resources/Plantilla/dropzone/dist/dropzone.css') }}" rel="stylesheet" />
    <!-- end dropzone -->
    <style>
        #form_new_creden b {
            text-transform: capitalize;
            font-size: 11px;
        }
    </style>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="wrapper">
        <header class="header-top" header-theme="dark">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div class="top-menu d-flex align-items-center">
                        <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                        <div class="header-search">
                            <div class="input-group">
                                <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                <input type="text" class="form-control">
                                <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                            </div>
                        </div>
                        <button type="button" id="navbar-fullscreen" class="nav-link"><i
                                class="ik ik-maximize"></i></button>
                    </div>
                    <h5 id="reg_aero" name="{{ $reg }}" style="color:white ;">{{ $region }}</h5>
                    <div class="top-menu d-flex align-items-center">

                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="ik ik-plus"></i></a>
                            <div class="dropdown-menu dropdown-menu-right menu-grid" aria-labelledby="menuDropdown">
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Dashboard"><i class="ik ik-bar-chart-2"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Message"><i class="ik ik-mail"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Accounts"><i class="ik ik-users"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Sales"><i class="ik ik-shopping-cart"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Purchase"><i class="ik ik-briefcase"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Pages"><i class="ik ik-clipboard"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Chats"><i class="ik ik-message-square"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Contacts"><i class="ik ik-map-pin"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Blocks"><i class="ik ik-inbox"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Events"><i class="ik ik-calendar"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="Notifications"><i class="ik ik-bell"></i></a>
                                <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="top"
                                    title="More"><i class="ik ik-more-horizontal"></i></a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    class="avatar" src="{{ asset('resources/plantilla/img/users/us.png') }}"
                                    alt=""></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.html"><i class="ik ik-user dropdown-icon"></i>
                                    Perfil</a>
                                <a class="dropdown-item" href="#" id="btn_logout"><i
                                        class="ik ik-power dropdown-icon"></i>
                                    Salir</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrap">
            <div class="app-sidebar colored">
                <div class="sidebar-header">
                    <a class="header-brand" href="#">
                        <div class="logo-img">
                            <!-- <img src="{{ asset('resources/plantilla/src/img/brand-white.jpg') }}" class="header-brand-img" alt="lavalite"> -->
                        </div>
                        <span class="text">NAABOL</span>
                    </a>
                    <button type="button" class="nav-toggle"><i data-toggle="expanded"
                            class="ik ik-toggle-right toggle-icon"></i></button>
                    <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                </div>

                <div class="sidebar-content">
                    <div class="nav-container">
                        <nav id="main-menu-navigation" class="navigation-main">
                            <div class="nav-lavel">Indice</div>
                            @if (Auth::user()->nivel == 1)
                                <div class="nav-item">
                                    <a href="#" id="btn_menu_B_User"><i
                                            class="fa fa-user-alt"></i><span>Usuarios</span></a>
                                </div>
                            @endif
                            <div class="nav-item">
                                <a href="#" id="btn_menu_B_Empr"><i
                                        class="ik ik-bar-chart-2"></i><span>Empresas</span></a>
                            </div>
                            <div class="nav-item">
                                <a href="" id="btn_menu_A" class="menu-item"><i
                                        class="fa fa-address-card "></i> Credenciales</a>
                            </div>
                            <div class="nav-item">
                                <a href="" id="btn_menu_creden_B" class="menu-item"><i
                                        class="fa fa-address-book"></i> Crenciales Visita</a>
                            </div>
                            <div class="nav-item">
                                <a href="" id="btn_menu_viculos" class="menu-item"><i
                                        class="fa fa-address-book"></i> Viñetas Vehiculos</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div id="main_cont"> </div>
            </div>
            <footer class="footer">
                <div class="w-100 clearfix">
                    <span class="text-center text-sm-left d-md-inline-block">NAABOL.</span>
                    <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">vercion 1.2 </span>
                </div>
            </footer>
        </div>
    </div>







    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script>
        window.jQuery || document.write('<script src="../src/js/vendor/jquery-3.3.1.min.js"><\/script>')
    </script>

    <script src="{{ asset('resources/plantilla/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/plugins/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/dist/js/theme.min.js') }}"></script>
    <script src="{{ asset('resources/plantilla/js/form-components.js') }}"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <!-- js funciones del sistema -->
    <!-- js de dropzone -->
    <script type="text/javascript" src="{{ asset('resources/Plantilla/dropzone/dist/dropzone.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('resources/Plantilla/moment.min.js') }}"></script> -->
    <!-- end dropzone -->

    <script src="{{ asset('resources/js/inicio.js') }}"></script>
    <script src="{{ asset('resources/js/credenciales_1.js') }}"></script>

    <script></script>
</body>

</html>

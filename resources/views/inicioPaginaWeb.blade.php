<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <title>Dentalife</title>
        <!-- Favicons -->
        <link href="{{asset('favicon.png')}}" rel="icon">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        @include('layouts.assets.css')

        @yield('css')
        @stack('css')
        @show
    </head>

    <body>

            <!-- ======= Top Bar ======= -->
            <div id="topbar" class="d-flex align-items-center fixed-top">
                <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
                    <div class="align-items-center d-none d-md-flex">
                    <i class="bi bi-clock"></i> Atención Lunes a sabado - 8:00 a 20:00
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-phone"></i> Contactanos +591 72049931
                        <a href="/login" class="login-btn" style="font-weight: bold !important">
                            Iniciar sesión
                        </a>
                    </div>
                </div>
            </div>

            <!-- ======= Menu principal ======= -->
            <header id="header" class="fixed-top">
                <div class="container d-flex align-items-center">
                    <a href="#" class="me-auto"><img src="{{asset('logo.png')}}" alt="" style='width:160px; height:64px !important;'></a>
                    <nav id="navbar" class="navbar order-last order-lg-0">
                        <ul>
                            <li><a class="nav-link scrollto " href="#hero">Inicio</a></li>
                            <li><a class="nav-link scrollto" href="#about">Nosotros</a></li>
                            <li><a class="nav-link scrollto" href="#services">Servicios</a></li>
                            <li><a class="nav-link scrollto" href="#testimonials">Testimonios</a></li>
                            <li class="dropdown"><a style="cursor:pointer;"><span>MÁS</span> <i class="bi bi-chevron-down"></i></a>
                                <ul>
                                    <li><a class="nav-link scrollto" href="#gallery"> Galeria</a></li>
                                    <li><a class="nav-link scrollto" href="#faq">Preguntas frecuentes</a></li>

                                </ul>
                            </li>
                            <li><a class="nav-link scrollto" href="#contact">Contacto</a></li>
                        </ul>
                        <i class="bi bi-list mobile-nav-toggle"></i>
                    </nav>
                    <a href="#appointment" class="appointment-btn scrollto" style="font-weight: bold !important"><i class="bi bi-clock"></i> &nbsp;<span class="d-none d-md-inline">Realizar una</span> Cita</a>
                </div>
            </header>

            <!-- =============================================== -->
            <!-- ============== SECCION - INICIO =============== -->
            <!-- =============================================== -->
            @include('seccionesWeb.inicio')

            <!-- =============================================== -->
            <!-- ============= SECCION - NOSOTROS ============== -->
            <!-- =============================================== -->
            @include('seccionesWeb.nosotros')

            <!-- =============================================== -->
            <!-- ============= SECCION - NOSOTROS ============== -->
            <!-- =============================================== -->
            @include('seccionesWeb.servicios')

            <!-- =============================================== -->
            <!-- ============ SECCION - TESTIMONIOS ============ -->
            <!-- =============================================== -->
            @include('seccionesWeb.testimonios')

            <!-- =============================================== -->
            <!-- ============== SECCION - GALERIA ============== -->
            <!-- =============================================== -->
            @include('seccionesWeb.galeria')

            <!-- =============================================== -->
            <!-- ============= SECCION - PREG FREC ============= -->
            <!-- =============================================== -->
            @include('seccionesWeb.preguntasFrec')

            <!-- =============================================== -->
            <!-- ============ SECCION - CONTACTOS ============== -->
            <!-- =============================================== -->
            @include('seccionesWeb.contactos')

            <!-- =============================================== -->
            <!-- ========= SECCION - REALIZAR CITA ============= -->
            <!-- =============================================== -->
            @include('seccionesWeb.realizarCita')

        <!-- ======= Footer ======= -->
        @include('footer')


        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    </body>
    @include('layouts.assets.js')
    @yield('scripts')
    @stack('scripts')

</html>
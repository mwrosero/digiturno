@extends('template.app-template')
@section('content')
<div class="wrapper">
    <!-- Header -->
    <header class="header p-3">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-8 col-sm-2 col-md-3">
                    <img class="w-100 logo" src="{{ asset('assets/img/veris-large.png') }}" alt="">
                </div>
                <div class="col-12 col-sm-8 col-md-7 d-flex justify-content-end align-items-center d-none d-md-block text-end">
                    <div class="time-box badge bg-veris-dark text-center p-3 rounded-8">
                        <span class="fs-4">Fecha:</span><span class="ms-1 fs-4 text-veris-light" id="fecha"></span>
                        <span class="fs-4 ms-5">Hora:</span><span class="ms-1 fs-4 text-veris-light" id="hora"></span>
                    </div>
                </div>
                <div class="col-4 col-sm-2 col-md-2">
                    <a href="ingreso.php" class="btn border-veris-1 rounded-8 text-veris w-100 p-2 d-flex justify-content-center align-items-center h-100">
                        <img class="me-2" src="{{ asset('assets/img/exit-icon.svg') }}" alt="">Salir
                    </a>
                </div>
            </div>
        </div>
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light p-0">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img class="logo" src="images/veris-large.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Características</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> -->
    </header>

    <!-- Content -->
    <main class="content p-3">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div id="sidebar" class="col-12 col-md-3 mb-3 mb-md-0 bg-silver sidebar-expanded h-100 overflow-auto"> <!-- Sidebar content here -->
                    <div id="toggle-sidebar" class="header-sidebar cursor-pointer w-100 d-flex justify-content-between align-items-center py-3 title-servicio position-relative">
                        <img class="me-2" src="{{ asset('assets/img/circulo-familiar.svg') }}" alt="">
                        <h4 class="mb-0 me-2">Circulo Familiar</h4>
                        <img class="arrow-ico" src="{{ asset('assets/img/arrow.svg') }}" alt="">
                    </div>
                    <div class="w-100 mt-3 py-3" id="list-familiares">
                        {{-- <div class="item-coincidencia item-coincidencia-selected rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
                            <div class="letter-name border-veris-1 mx-2 bg-white">M</div>
                            <span class="flex-grow-1 name-familiar text-start text-md-center">Michael Washington<br>Rosero Peralta</span>
                        </div>
                        <div class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
                            <div class="letter-name border-veris-1 mx-2 bg-white">J</div>
                            <span class="flex-grow-1 name-familiar text-start text-md-center">Jennifer Janina<br>Rivera Ortega</span>
                        </div>
                        <div class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
                            <div class="letter-name border-veris-1 mx-2 bg-white">A</div>
                            <span class="flex-grow-1 name-familiar text-start text-md-center">Amira Francesca<br>Rosero Rivera</span>
                        </div> --}}
                    </div> 
                </div>
                <div id="content" class="col-12 col-md-9 p-0 m-0 h-100"> <!-- Main content here --> 
                    <div id="box-servicios" class="bg-silver ms-0 ms-md-2 p-3 h-100">
                        <div class="d-block d-md-flex bg-light mb-3 justify-content-between align-items-center w-100 rounded-8 text-center bg-white text-veris-dark my-2 p-3">
                            <img class="ms-2" src="{{ asset('assets/img/info-ico.svg') }}" alt="">
                            <span class="label-info ms-4 text-start flex-grow-1">Por favor verifica la información<br>correcta para continuar.</span>
                            <div id="hiddenContent" class="d-none" style="width: 300px;">
                                <img class="w-50 logo my-3" src="images/veris-large.png" alt="">
                                <div class="w-100 d-flex justify-content-end align-items-center text-end">
                                    <h2 class="mb-1 fs-3 fw-bold text-veris-dark">Tu turno será en</h2>
                                        <h2 class="fs-4 fw-bold text-center text-veris mb-1">00:10:00</h2>
                                        <h2 class="mb-1 fs-3 fw-bold text-veris-dark">apróximadamente</h2>
                                        <div class="box-turno mt-3 rounded-8 border-veris-1 fs-3 p-4 text-center">
                                            Tu turno es
                                            <div class="bg-veris text-white rounded-8 text-center fs-1 my-3 mx-auto" style="width: 100px;">
                                                001
                                            </div>
                                            Nos vemos pronto
                                        </div>
                                </div>
                            </div>
                            <div id="btnPrint" class="btn bg-veris d-none d-md-block text-white p-2 px-5 fs-5 fw-bold rounded-8 mt-3 mt-md-0">Generar turno</div>
                            <a href="turno.php" class="btn d-blocl d-md-none bg-veris text-white p-2 px-5 fs-5 fw-bold rounded-8 mt-3 mt-md-0">Generar turno</a>
                        </div>
                        <div class="row row-servicios overflow-auto">
                            <div class="col-12 mb-2">
                                <h3>Servicios</h3>
                            </div>
                            <div class="col-12 mb-2" id="list-servicios">
                                <div class="card w-100 rounded-8 py-3 px-3 mb-3">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-7">
                                            <h4 class="fw-bold title-servicio position-relative">
                                                Cita médica 
                                                <span class="text-veris fw-medium ">agendada</span>
                                            </h4>
                                        </div>
                                        <div class="col-5 d-flex flex-column align-items-end">
                                            <span class="badge bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                                                <img class="me-1" src="{{ asset('assets/img/icon-pagada.svg') }}" alt="">
                                                Pagada
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row g-0 rounded-8 d-flex justify-content-between align-items-center mt-2 bg-veris-sky p-3 px-2 fs-5 mb-2">
                                        <div class="col-12 col-md-6">
                                            <span class="text-veris fw-medium ">Centro:</span> Veris Kennedy
                                        </div>
                                        <div class="col-12 col-md-6 fw-bold fs-4 text-start text-md-end">
                                            <span class="text-veris fw-medium ">Ve al consultorio:</span> 13 <span class="text-veris fw-medium ">|</span> 
                                            <img src="{{ asset('assets/img/marker.svg') }}">
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-2">
                                            <div class="avatar-doctor border-veris-1" style="background: url({{ asset('assets/img/doctor.png') }}) no-repeat top center;background-size: cover;">
                                            </div>
                                            <div class="info-doctor ms-2 flex-grow-1">
                                                <p class="mb-1">Doctor</p>
                                                <p class="mb-1">Juan Alberto Gonzalez Rojas</p>
                                                <p class="mb-1 text-veris fw-medium">Dermatología</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="info-doctor ms-2">
                                                <p class="mb-1"><span class="text-veris fw-medium ">Fecha:</span> 11:00 - 18/10/2024</p>
                                                <p class="mb-1"><span class="text-veris fw-medium ">Beneficio:</span> Salud S.A. N-4-C Plan Ideal 4 Costa</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card w-100 rounded-8 py-3 px-3 mb-3">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-7">
                                            <h4 class="fw-bold title-servicio position-relative">
                                                Laboratorio 
                                                <span class="text-veris fw-medium ">clínico</span>
                                            </h4>
                                        </div>
                                        <div class="col-5 d-flex flex-column align-items-end">
                                            <span class="badge bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                                                <img class="me-1" src="{{ asset('assets/img/icon-pagada.svg') }}" alt="">
                                                Pagada
                                            </span>
                                            <button class="btn badge bg-veris text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2">Notificar llegada</button>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-3">
                                            <div class="avatar-doctor border-veris-1" style="background: url({{ asset('assets/img/doctor.png') }}) no-repeat top center;background-size: cover;">
                                            </div>
                                            <div class="info-doctor ms-2 flex-grow-1">
                                                <p class="mb-1 text-veris fw-medium fw-medium">Remitente</p>
                                                <p class="mb-1">Doctor</p>
                                                <p class="mb-1">Manuel Andrade Saenz</p>
                                                <p class="mb-1 text-veris fw-medium">Medicina General</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="info-orden d-md-flex justify-content-between align-items-center d-none">
                                                <div>
                                                    <p class="mb-1 fw-medium text-veris">Escanea
                                                    <p class="mb-1">Para ver la orden completa</p>
                                                </div>
                                                <img class="qr-orden" src="{{ asset('assets/img/qr.svg') }}" alt="">
                                            </div>
                                            <div class="info-orden d-flex justify-content-between align-items-center d-md-none text-center">
                                                <a href="https://www.akold.com/digiturno/orden.pdf" target="_blank" class="btn badge bg-veris text-white px-4 py-2 fs-6 rounded-8 border-0 d-block mt-2 mx-auto">Ver Orden</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6">
                                            <div class="info-doctor ms-2">
                                                <p class="mb-1"><span class="text-veris fw-medium ">Fecha:</span> 11:00 - 18/10/2024</p>
                                                <p class="mb-1"><span class="text-veris fw-medium ">Beneficio:</span> Salud S.A. N-4-C Plan Ideal 4 Costa</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center">
                                            <div class="info-doctor ms-2 flex-grow-1">
                                                <p class="w-100 mb-1 fw-bold fs-4 text-start">
                                                    <span class="text-veris fw-medium ">Ubicación:</span> LABORATORIO <span class="text-veris fw-medium ">|</span> 
                                                    <img src="{{ asset('assets/img/marker.svg') }}">
                                                </p>
                                                <p class="mb-1"><span class="text-veris fw-medium ">Centro:</span> Veris Kennedy</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-pendiente-1 w-100 rounded-8 py-3 px-3 mb-3">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-7">
                                            <h4 class="fw-bold title-servicio title-servicio-pendiente position-relative">
                                                Cita médica 
                                                <span class="text-pendiente">pendiente</span>
                                            </h4>
                                        </div>
                                        <div class="col-5 d-flex flex-column align-items-end">
                                            <span class="badge bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                                                <img class="me-1" src="{{ asset('assets/img/icon-pendiente.svg') }}" alt="">
                                                Por pagar
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row g-0 rounded-8 d-flex justify-content-between align-items-center mt-2 bg-veris-sky p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 offset-md-3 text-center fs-5 fw-bold ">
                                            <div class="w-100 border-veris-1 rounded-8 mb-3 bg-white py-2">
                                                <span class="text-veris fw-medium  px-4 py-2 text-center">TIEMPO PARA PAGAR:</span> 01:00:00
                                            </div>
                                        </div>
                                        <div class="col-12 d-block d-md-flex justify-content-center align-items-center gap-2">
                                            <span class="text-veris fw-medium -dark me-2 p-2 my-2 w-100 w-md-auto">Método de pago</span>
                                            <button class="btn badge bg-veris text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block me-2 p-2 my-2 w-100 w-md-auto">Pagar en caja</button>
                                            <button class="btn badge bg-veris text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block p-2 my-2 w-100 w-md-auto">Link de pago</button>
                                        </div>
                                    </div>
                                    <div class="row g-0 rounded-8 d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5 mb-2 border-veris-light-1">
                                        <div class="col-12 col-md-6">
                                            <span class="text-veris fw-medium ">Centro:</span> Veris Kennedy
                                        </div>
                                        <div class="col-12 col-md-6 fw-bold fs-4 text-start text-md-end">
                                            <span class="text-veris fw-medium ">Ve al consultorio:</span> 13 <span class="text-veris fw-medium ">|</span> 
                                            <img src="{{ asset('assets/img/marker.svg') }}">
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-2">
                                            <div class="avatar-doctor border-veris-1" style="background: url({{ asset('assets/img/doctor.png') }}) no-repeat top center;background-size: cover;">
                                            </div>
                                            <div class="info-doctor ms-2 flex-grow-1">
                                                <p class="mb-1">Doctor</p>
                                                <p class="mb-1">Juan Alberto Gonzalez Rojas</p>
                                                <p class="mb-1 text-veris fw-medium">Dermatología</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="info-doctor ms-2">
                                                <p class="mb-1"><span class="text-veris fw-medium ">Fecha:</span> 11:00 - 18/10/2024</p>
                                                <p class="mb-1"><span class="text-veris fw-medium ">Beneficio:</span> Salud S.A. N-4-C Plan Ideal 4 Costa</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    function actualizarFechaHora() {
        const now = new Date();

        // Formatear la fecha en dd/mm/yyyy
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();
        const formattedDate = `${day}/${month}/${year}`;

        // Formatear la hora en hh:mm
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const formattedTime = `${hours}:${minutes}`;

        // Actualizar los elementos con jQuery
        $('#fecha').text(formattedDate);
        $('#hora').text(formattedTime);
    }

    setInterval(actualizarFechaHora, 1000);

    let local = localStorage.getItem('turno-{{ $portalToken }}');
    let dataTurno = JSON.parse(local);

    $(document).ready(async function() {
        $('#toggle-sidebar').on('click', function() {
            $('#sidebar').toggleClass('sidebar-collapsed sidebar-expanded');
            if ($('#sidebar').hasClass('sidebar-collapsed')) {
                $('#sidebar').removeClass('col-md-3').addClass('col-md-1');
                $('#content').removeClass('col-md-9').addClass('col-md-11');
                $('#toggle-sidebar h4, .name-familiar').addClass('d-none')
                $('#toggle-sidebar').addClass('title-servicio-sm');
                $('.arrow-ico').addClass('rotate-arrow');
                if(isMobile()){
                    $('#list-familiares').addClass('d-none');
                }
            } else {
                $('#sidebar').removeClass('col-md-1').addClass('col-md-3');
                $('#content').removeClass('col-md-11').addClass('col-md-9');
                $('#toggle-sidebar h4, .name-familiar').removeClass('d-none');
                $('#toggle-sidebar').removeClass('title-servicio-sm');
                $('.arrow-ico').removeClass('rotate-arrow');
                if(isMobile()){
                    $('#list-familiares').removeClass('d-none');
                }
            }
        });

        await drawListFamiliares()

        $('#btnPrint').on('click', function () {
            var htmlContent = $('#hiddenContent').html();
            var _htmlContent = `
                <div style="text-align: center; font-family: Arial, sans-serif; width: 80mm;">
                    <img src="https://via.placeholder.com/150" alt="Logo" style="width: 100%; max-width: 150px; margin-bottom: 20px;">
                    <h1>Turno: <span style="font-size: 2em;">A001</span></h1>
                    <p>Gracias por su visita</p>
                </div>
            `;

            // Usar Print.js para imprimir directamente
            printJS({
                printable: htmlContent,
                type: 'raw-html',
                style: `
                    @media print {
                        body {
                            font-size: 14px;
                            margin: 0;
                            padding: 0;
                        }
                    }
                `
            });
        });
    });
    function isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    async function drawListFamiliares(){
        let elem = ``;
        elem += `<div data-rel='${JSON.stringify(dataTurno)}' class="item-coincidencia item-coincidencia-selected rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
            <div class="letter-name border-veris-1 mx-2 bg-white">${ dataTurno.paciente.nombreCompleto.charAt(0) }</div>
                <span class="flex-grow-1 name-familiar text-start text-md-center">${ dataTurno.paciente.nombreCompleto }</span>
        </div>`;

        $.each(dataTurno.paciente.lsGrupoFamiliar, function(key, value){
            elem += `<div data-rel='${JSON.stringify(value)}' class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
                <div class="letter-name border-veris-1 mx-2 bg-white">${ value.nombreCompleto.charAt(0) }</div>
                <span class="flex-grow-1 name-familiar text-start text-md-center">${ value.nombreCompleto }</span>
            </div>`;
        })
        $('#list-familiares').html(elem);
    }
</script>
<style>
    .cursor-pointer{
        cursor: pointer;
    }
    #sidebar{
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    #box-servicios{
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .rotate-arrow{
        transform: rotate(180deg)
    }
    .letter-name {
        width: 36px;
        height: 36px;
        min-width: 32px;
        min-height: 32px;
        border-radius: 100%;
        line-height: 32px;
        font-weight: 700;
    }
    .label-info{
        font-size: 1.25rem;
        line-height: 1.25rem;
    }
    .avatar-doctor {
        border-radius: 100%;
        width: 100px;
        height: 100px;
    }
    .title-servicio:after{
        content: "";
        position: absolute;
        bottom: -5px;
        left: 0px;
        width: 75px;
        height: 3px;
        background: var(--veris-blue);
    }
    .title-servicio-pendiente:after{
        background: var(--pendiente);
    }
    .title-servicio-sm:after{
        width: 50px;
    }
    .row-servicios {
        max-height: 82%;
    }
    p{
        font-size: 16px;
        line-height: 18px;
    }
    .qr-orden{
        max-width: 150px;
    }
    @media print {
        body {
            margin: 0; /* Sin márgenes */
            width: 80mm; /* Ancho estándar para tickets */
            height: auto; /* Automático según el contenido */
        }
    }
</style>
@endsection
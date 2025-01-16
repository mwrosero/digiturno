@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/print.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/print.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- Modal de pago --}}
<div class="modal modal-top fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel">
    <div class="modal-dialog modal modal-sm modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="detallePago">
                <h5 class="fs--20 line-height-24 mt-3 mb-3">{{ __('Pago en línea:') }}</h5>
                <ul class="nav nav-pills justify-content-between bg-white w-100 rounded-3 mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 px-8 px-md-5 d-flex justify-content-center align-items-center active" id="pills-email-tab" data-bs-toggle="pill" data-bs-target="#pills-email" type="button" role="tab" aria-controls="pills-email" aria-selected="true">
                            <i class="fa-regular fa-envelope icon-tab d-none d-md-inline-block me-2"></i>
                            Email                                
                        </button>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <button data-rel="N" class="nav-link w-100 px-8 px-md-5 d-flex justify-content-center align-items-center" id="pills-qr-tab" data-bs-toggle="pill" data-bs-target="#pills-qr" type="button" role="tab" aria-controls="pills-qr" aria-selected="false">
                            <i class="fa-solid fa-qrcode me-2"></i>
                            Código QR
                        </button>
                    </li>
                </ul>
                <div class="tab-content bg-transparent w-100 pt-2" id="pills-tabContent">
                    <div class="tab-pane fade mt-3 px-2 w-100 show active text-center" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab" tabindex="0">
                        <input autofocus autocomplete="off" id="email_link_pago" type="text" class="w-100 keyboard-input p-1 rounded-8 text-center fs-1">
                        <div type="button" class="btn bg-veris-dark btn-enviar-mail text-white mx-auto mb-5 rounded-8 my-5 fs-20">
                            ENVIAR LINK DE PAGO
                            <i class="fa-regular fa-paper-plane ms-2 text-white"></i>
                        </div>
                    </div>
                    <div class="tab-pane fade mt-3 px-2 w-100" id="pills-qr" role="tabpanel" aria-labelledby="pills-qr-tab" tabindex="0">
                        <div class="w-100 text-center my-3" id="qrcode"></div>
                        <p class="text-veris-dark fw-medium fs-4 text-center mt-2">
                            Escanea el Código QR con su celular<br>para realizar el pago.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto fs-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
</div>
{{-- Modal notificar llegada --}}
<div class="modal modal-top fade" id="modalNotificarLlegada" tabindex="-1" aria-labelledby="modalNotificarLlegadaLabel">
    <div class="modal-dialog modal modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb-3">{{ __('Detalle la orden:') }}</h5>
                <div class="row gx-2 justify-content-between align-items-center">
                    <ul class="list-group border-0 p-0" id="listaPrestaciones">
                    </ul>
                    <div class="my-2 box-info-detalle-orden-apoyo p-2 bg-silver">
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <button type="button" class="btn fw-normal text-white fs--16 badge bg-veris-dark px-4 py-2 mx-2 fs-4 btn-print-notificar-llegada" data-bs-dismiss="modal">Notificar</button>
                <a href="#" class="btn fw-normal fs--16 badge bg-veris px-4 py-2 mx-2 fs-4 btn-salir text-white" data-bs-dismiss="modal">CERRAR</a>
            </div>
        </form>
    </div>
</div>
{{-- Modal luego notificar llegada dirigirse --}}
<div class="modal modal-top fade" id="modalNotificarLlegadaDirigirLugar" tabindex="-1" aria-labelledby="modalNotificarLlegadaDirigirLugarLabel" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center" id="direccionDirigirseLlegada">Dirigirse a</h5>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto fs-4 btn-salir">CERRAR</a>
            </div>
        </form>
    </div>
</div>
{{-- Modal detalle paquete --}}
<div class="modal modal-top fade" id="modalDetallePaquete" tabindex="-1" aria-labelledby="modalDetallePaqueteLabel">
    <div class="modal-dialog modal modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb-3" id="tituloPaqueteDetalle"></h5>
                <ul class="list-group border-0 p-0 my-2" id="detalleComponentesPaquete">
                </ul>
                <div class="my-2 box-info-detalle p-2 bg-silver">
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto fs-4" data-bs-dismiss="modal">CERRAR</a>
            </div>
        </form>
    </div>
</div>
{{-- Modal detalle chequeo --}}
<div class="modal modal-top fade" id="modalDetalleChequeo" tabindex="-1" aria-labelledby="modalDetalleChequeoLabel">
    <div class="modal-dialog modal modal-dialog-centered modal-lg mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb-3" id="tituloChequeoDetalle"></h5>
                <input type="hidden" id="dataChequeo">
                {{-- <div class="accordion border-0 p-0 my-2" id="detalleComponentesChequeo">
                </div> --}}
                 <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    </div>
                    <div class="tab-content flex-grow-1 ms-2 rounded-8 border-veris-1" id="v-pills-tabContent">
                    </div>
                </div>

            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <a href="#" class="btn fw-normal fs--16 badge bg-veris-dark text-white m-0 px-4 py-2 mx-2 fs-4 btn-activar" data-bs-dismiss="modal">ACTIVAR</a>
                <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-2 fs-4" data-bs-dismiss="modal">CERRAR</a>
            </div>
        </form>
    </div>
</div>
<div class="wrapper">
    <!-- Header -->
    <header class="header p-3">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-8 col-sm-2 col-md-3">
                    {{-- <img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
                    @if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
                    @else
                    @endif --}}
                    {{-- <img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt=""> --}}
                    <img class="w-100 logo" src="" alt="">
                </div>
                <div class="col-12 col-sm-8 col-md-7 d-flex justify-content-end align-items-center d-none d-md-block text-end">
                    <div class="time-box badge bg-veris-dark text-center p-3 rounded-8">
                        <span class="fs-4">Fecha:</span><span class="ms-1 fs-4 text-veris-light" id="fecha"></span>
                        <span class="fs-4 ms-5">Hora:</span><span class="ms-1 fs-4 text-veris-light" id="hora"></span>
                    </div>
                </div>
                <div class="col-4 col-sm-2 col-md-2">
                    <a href="#" class="btn btn-salir border-veris-1 rounded-8 text-veris w-100 p-2 d-flex justify-content-center align-items-center h-100 fw-bold">
                        <img class="me-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exit-icon.svg" alt="">Salir
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content p-0 p-md-3">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div id="sidebar" class="col-12 col-md-3 mb-3 mb-md-0 bg-silver sidebar-expanded h-100 overflow-auto"> <!-- Sidebar content here -->
                    <div id="toggle-sidebar" class="header-sidebar cursor-pointer w-100 d-flex justify-content-between align-items-center py-3 title-servicio position-relative">
                        <img class="me-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/circulo-familiar.svg" alt="">
                        <h4 class="mb-0 me-2 d-none d-md-block text-center">Circulo Familiar</h4>
                        <p class="name-selected-sidebar d-block d-md-none m-0 text-veris fw-medium fs-3 mx-2"></p>
                        <img class="arrow-ico" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/arrow.svg" alt="">
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
                        {{-- <div class="d-block d-md-flex bg-light mb-3 justify-content-between align-items-center w-100 rounded-8 text-center bg-white text-veris-dark my-2 p-3 box-with-data"> --}}
                        <div class="d-none bg-light mb-3 justify-content-between align-items-center w-100 rounded-8 text-center bg-white text-veris-dark my-2 p-3 box-with-data">
                            <img class="ms-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/info-ico.svg" alt="">
                            <span class="label-info ms-4 text-start flex-grow-1">Genera tu turno en caja para <br>atención específica.</span>
                            <div id="btnPrint" class="btn bg-veris text-white p-2 px-5 fs-1 fw-bold rounded-8 mt-3 mt-md-0 btn-turno">Generar turno</div>
                        </div>
                        <div class="d-none h-100 bg-light mb-3 w-100 rounded-8 text-center bg-white text-veris-dark my-2 p-3 box-without-data justify-content-center align-items-center">
                            {{-- <div class="d-flex justify-content-center align-items-center mb-3">
                                <img class="ms-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/info-ico.svg" alt="">
                                <span class="label-info ms-4 text-start">Por favor verifica la información<br>correcta para continuar.</span>
                            </div> --}}
                            <div id="btnPrint" class="btn bg-veris text-white p-2 px-5 fs-1 fw-bold rounded-8 mt-3 mt-md-0 btn-turno">Generar<br>turno</div>
                        </div>
                        <div class="row row-servicios overflow-auto">
                            {{-- <div class="col-12 mb-2">
                                <h3>Servicios</h3>
                                <hr class="w-100">
                            </div> --}}
                            <div class="col-12 mb-2" id="list-servicios">
                                {{-- <div class="card w-100 rounded-8 py-3 px-3 mb-3">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-7">
                                            <h4 class="fw-bold title-servicio position-relative">
                                                Cita médica 
                                                <span class="text-veris fw-medium ">agendada</span>
                                            </h4>
                                        </div>
                                        <div class="col-5 d-flex flex-column align-items-end">
                                            <span class="badge bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                                                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pagada.svg" alt="">
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
                                            <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/marker.svg">
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-2">
                                            <div class="avatar-doctor border-veris-1" style="background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/doctor.png') }}) no-repeat top center;background-size: cover;">
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
                                                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pagada.svg" alt="">
                                                Pagada
                                            </span>
                                            <button class="btn badge bg-veris text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2">Notificar llegada</button>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-3">
                                            <div class="avatar-doctor border-veris-1" style="background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/doctor.png') }}) no-repeat top center;background-size: cover;">
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
                                                <img class="qr-orden" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/qr.svg" alt="">
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
                                                    <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/marker.svg">
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
                                                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pendiente.svg" alt="">
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
                                            <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/marker.svg">
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                                        <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-2">
                                            <div class="avatar-doctor border-veris-1" style="background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/doctor.png') }}) no-repeat top center;background-size: cover;">
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
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/keyboard.js?v=1.0.2"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/qrcode.js"></script>
<script>
    let dataServicios;
    let dataParametrosGenerales;
    let groupedData = [];
    var estadosVigentes = ["REG", "ENTS", "FAC","PFAC","AUT","EXC"];

    setInterval(actualizarFechaHora, 1000);

    let local = localStorage.getItem('turno-{{ $portalToken }}');
    let dataTurno = JSON.parse(local);
    let puedeEnviar = false;
    buscarUsuarioFlag = false;

    $(document).ready(async function() {
        const $keyboard = $(".keyboard");
        const $inputField = $("#email_link_pago");

        const macsParami = @json(\App\Models\Veris::MACS_PARAMI);

        if(macsParami.includes(dataTurno.mac)){
            $('.logo').attr('src',`{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png`);
        }else{
            $('.logo').attr('src',`{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png`);
        }

        let url_salir = `/${ dataTurno.mac }`;
        if(isMobile()){
            url_salir = `/ingreso/${ dataTurno.mac }`;
        }
        $('.btn-salir').attr('href',url_salir);

        const tiempoInactividad = 45; // Tiempo de inactividad en segundos
        const tiempoMaximoRespuesta = 15; // Tiempo máximo de respuesta al modal en segundos

        let temporizadorInactividad;
        let temporizadorRespuesta;

        // Función para mostrar el modal
        function mostrarModal() {
            // Mostrar el modal
            $("#modalEstasAhi").modal("show");

            // Iniciar temporizador para esperar respuesta
            temporizadorRespuesta = setTimeout(() => {
                $("#modalEstasAhi").modal("hide");
                console.log("No hubo respuesta a tiempo.");
                location.href = url_salir;
            }, tiempoMaximoRespuesta * 1000);
        }

        // Función para reiniciar el conteo de inactividad
        function reiniciarConteo() {
            clearTimeout(temporizadorInactividad);
            temporizadorInactividad = setTimeout(mostrarModal, tiempoInactividad * 1000);
        }

        // Detectar interacción del usuario
        $(document).on("mousemove keydown click scroll", function () {
            reiniciarConteo();
        });

        // Manejar clic en el botón "Sí"
        $("#btnSi").on("click", function () {
            clearTimeout(temporizadorRespuesta);
            $("#modalEstasAhi").fadeOut();
            console.log("El usuario sigue presente.");
            reiniciarConteo();
        });

        if(!isMobile()){
            console.log("Iniciando conteo")
            // Iniciar el conteo inicial
            reiniciarConteo();
        }

        // Ocultar el teclado si se hace clic fuera de su contenedor
        $(document).on("click", function (event) {
            if (!$keyboard.is(event.target) && $keyboard.has(event.target).length === 0 &&
                !$inputField.is(event.target)) {
                puedeEnviar = false;
                Keyboard.close();
            }
        });
        await parametrosGenerales();

        $('#toggle-sidebar').on('click', function() {
            $('#sidebar').toggleClass('sidebar-collapsed sidebar-expanded');
            if ($('#sidebar').hasClass('sidebar-collapsed')) {
                $('#sidebar').removeClass('col-md-3').addClass('col-md-1');
                $('#content').removeClass('col-md-9').addClass('col-md-11');
                $('.name-familiar').addClass('d-none')
                $('#toggle-sidebar').addClass('title-servicio-sm');
                $('.arrow-ico').addClass('rotate-arrow');
                if(isMobile()){
                    $('#list-familiares').addClass('d-none');
                }else{
                    $('#toggle-sidebar h4').addClass('d-md-none')
                }
            } else {
                $('#sidebar').removeClass('col-md-1').addClass('col-md-3');
                $('#content').removeClass('col-md-11').addClass('col-md-9');
                $('.name-familiar').removeClass('d-none');
                $('#toggle-sidebar').removeClass('title-servicio-sm');
                $('.arrow-ico').removeClass('rotate-arrow');
                if(isMobile()){
                    $('#list-familiares').removeClass('d-none');
                }else{
                    $('#toggle-sidebar h4').removeClass('d-md-none');
                }
            }
        });

        await drawListFamiliares();
        await cargarServicios();

        $('body').on('click', '.item-coincidencia', async function(){
            $('.item-coincidencia').removeClass('item-coincidencia-selected')
            $(this).addClass('item-coincidencia-selected');
            await cargarServicios();
        });

        $('body').on('click', '#btn-redirect-turno', function(){
            dataTurno.pacienteSeleccionado = JSON.parse($('.item-coincidencia-selected').attr("data-rel"));
            localStorage.setItem('turno-{{ $portalToken }}', JSON.stringify(dataTurno));
            location.href = $(this).attr('url-rel');
        })

        $('body').on('click', '.btn-turno', async function(){
            await generarTurno();
        })

        $('body').on('click', '.btn-notificar-llegada', async function(){
            let detalle = $(this).attr('data-rel');
            mostrarPrestaciones(JSON.parse(detalle))
            $('.btn-print-notificar-llegada').attr('data-rel',detalle)
            $('#modalNotificarLlegada').modal('show');
        })

        $('body').on('click', '.btn-print-notificar-llegada', async function(){
            let detalle = JSON.parse($(this).attr('data-rel'));
            // console.log(detalle)
            await notificarLlegada(detalle);
        })

        $('body').on('click', '.btn-detalle-orden', async function(){
            let detalle = JSON.parse($(this).attr('data-rel'));
            console.log(detalle)
            $('#tituloPaqueteDetalle').html(`Detall de Orden Médica: ${detalle.numeroOrden}`);
            
            $('.box-info-detalle').html(`<div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge bg-pendiente text-center badge-pill me-2">
                        <i class="fa-solid fa-triangle-exclamation text-white"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Pendiente de pago</p>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge text-center bg-success badge-pill me-2">
                        <i class="fa-solid fa-check text-white"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Muestra recepcionada</p>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge bg-veris-light text-center badge-pill me-2">
                        <i class="fa-solid fa-stopwatch text-veris-dark"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Muestra pendiente de entrega</p>
                </div>
            `);

            let elem = ``;
            $.each(detalle.detallesOrden, function(key, value){
                let badge = ``;
                if(estadosVigentes.includes(value.codigoEstado)){
                    if(value.fechaRecepcion == null){
                        badge = `<span style="width: 25px;" class="badge bg-veris-light text-center badge-pill ms-2">
                                <i class="fa-solid fa-stopwatch text-veris-dark"></i>
                            </span>`;
                    }else{
                        badge = `<span style="width: 25px;" class="badge text-center bg-success badge-pill ms-2">
                                <i class="fa-solid fa-check text-white"></i>
                            </span>`
                    }
                }else{
                    badge = `<span style="width: 25px;" class="badge bg-pendiente text-center badge-pill ms-2">
                            <i class="fa-solid fa-triangle-exclamation text-white"></i>
                        </span>`;
                }
                elem += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 line-height-16 d-flex justify-content-between align-items-start">
                    ${ value.nombrePrestacion }
                    ${ badge }
                </li>`
                // ${ value.nombreServicio }/${ value.nombrePrestacion }
            })
            $('#detalleComponentesPaquete').html(elem);
            $('#modalDetallePaquete').modal('show');
        })

        $('body').on('click', '.btn-detalle-paquete', async function(){
            let detalle = JSON.parse($(this).attr('data-rel'));
            console.log(detalle)
            $('#tituloPaqueteDetalle').html(`${detalle.nombrePaquete}`);
            // si el detalle de cantidadDisponible > 0 Tiene la prestacion pendiente por activar
            // si el campo cantidadUtilizada == 0 y el campo estaRecepcionado == false significa que el paquete no ha sido utilizado en la atencion

            $('.box-info-detalle').html(`<div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge bg-pendiente text-center badge-pill me-2">
                        <i class="fa-solid fa-triangle-exclamation text-white"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Pendiente de pago</p>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge text-center bg-success badge-pill me-2">
                        <i class="fa-solid fa-check text-white"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Muestra recepcionada</p>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge bg-veris-light text-center badge-pill me-2">
                        <i class="fa-solid fa-stopwatch text-veris-dark"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Muestra pendiente de entrega</p>
                </div>
            `);

            let elem = ``;
            $.each(detalle.detallesDisponibles, function(key, value){
                let badge = ``;
                if(value.cantidadDisponible > 0 || (value.cantidadUtilizada == 0 && !value.estaRecepcionado)){
                    badge = `<span style="width: 25px;" class="badge bg-veris-light text-center badge-pill ms-2">
                            <i class="fa-solid fa-stopwatch text-veris-dark"></i>
                        </span>`;
                }else{
                    badge = `<span style="width: 25px;" class="badge text-center bg-success badge-pill ms-2">
                            <i class="fa-solid fa-check text-white"></i>
                        </span>`
                }
                elem += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 line-height-16 d-flex justify-content-between align-items-start">
                    ${ value.nombrePrestacion }
                    ${ badge }
                </li>`
                // ${ value.nombreServicio }/${ value.nombrePrestacion }
            })
            $('#detalleComponentesPaquete').html(elem);
            $('#modalDetallePaquete').modal('show');
        })

        $('body').on('click', '.btn-detalle-chequeo', async function(){
            let dataChequeo = $(this).attr('data-rel');
            $('#dataChequeo').val(dataChequeo)
            let detalle = JSON.parse(dataChequeo);
            console.log(detalle)
            $('#tituloChequeoDetalle').html(`${detalle.nombreTipoContrato} - ${detalle.nombreConvenio}`);

            let elem_header = ``;
            let elem_content = ``
            
            $.each(detalle.prestaciones, function(key, value){
                let class_active = ``;
                let class_show = ``;
                if(key == 0){
                    class_active = `active`;
                    class_show = `show`;
                }
                elem_header += `<button class="nav-link nav-link-servicios ${class_active}" id="prestacion-${ value.codigoServicioNivel1 }-tab" data-bs-toggle="pill" data-bs-target="#prestacion-${ value.codigoServicioNivel1 }" type="button" role="tab" aria-controls="prestacion-${ value.codigoServicioNivel1 }" aria-selected="true" codigoServicio-rel="${ value.codigoServicioNivel1 }">
                        ${ value.nombreServicioNivel1 }
                    </button>`;

                elem_content += `<div class="tab-pane pane-items-${ value.codigoServicioNivel1 } p-2 fade ${class_active} ${class_show}" id="prestacion-${ value.codigoServicioNivel1 }" role="tabpanel" aria-labelledby="prestacion-${ value.codigoServicioNivel1 }-tab">`;

                elem_content += `<div class="d-flex justify-content-center align-items-center mt-2 mb-3">
                    <div class="btn bg-veris text-white me-2 select-all" codigoServicio-rel="${ value.codigoServicioNivel1 }">
                        <i class="fa-regular fa-square-check me-2"></i> Todos
                    </div>
                    <div class="btn bg-veris-dark text-white me-2 unselect-all" codigoServicio-rel="${ value.codigoServicioNivel1 }">
                        <i class="fa-regular fa-square-minus me-2"></i> Ninguno
                    </div>
                </div>`;
                $.each(value.items, function(k,v){
                    let disabledAttr = ``;
                    if(v.requiereAgendamiento && v.cantidadUtilizada == 0 && v.cantidadDisponible != v.cantidadUtilizada){
                        disabledAttr = `disabled`;
                    }
                    elem_content += `<div class="d-flex justify-content-start align-items-start fs-16 line-height-16 mb-2">
                            <div class="form-check flex-grow-1">
                                <input ${disabledAttr} class="form-check-input my-0" type="checkbox" value="" id="item-prestacion-${ v.codigoPrestacion }" codigoServicio-rel="${ value.codigoServicioNivel1 }" data-rel='${ JSON.stringify(v) }'>
                                <label class="form-check-label" for="item-prestacion-${ v.codigoPrestacion }">
                                ${ v.nombrePrestacion }
                                </label>
                            </div>
                            <!--div class="flex-grow-1 ms-2">
                                <span class="badge badge-pill bg-veris-sky text-veris-dark fw-normal">${v.nombreServicio}/${ v.nombreServicioN2 }</span>
                            </div-->
                        </div>`;
                })
                elem_content += `</div>`;
            })

            $('#v-pills-tab').html(elem_header);
            $('#v-pills-tabContent').html(elem_content);
            $('#modalDetalleChequeo').modal('show');
        })

        $('body').on('click', '.select-all', function(){
            let id = $(this).attr('codigoServicio-rel');
            $('.pane-items-' + id).find('input:not(:disabled)').prop('checked', true);
        })

        $('body').on('click', '.unselect-all', function(){
            let id = $(this).attr('codigoServicio-rel');
            $('.pane-items-' + id).find('input:not(:disabled)').prop('checked', false);
        })

        $('body').on('click', '.btn-activar', async function(){
            await activarPrestacionesChequeos();
        })

        $('body').on('click', '.btn-link-pago', async function(){
            let detalle = $(this).attr('data-rel');
            $('#detallePago').val(detalle)
            await crearLinkpasarela(detalle);
        })

        $('body').on('focus', '#email_link_pago', function(){
            Keyboard.open();
        });

        $('body').on('click', '.btn-enviar-mail', async function(){
            await enviarLinkMailPago();
        })

        /*$('#btnPrint').on('click', function () {
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
        });*/
    });

    async function enviarLinkMailPago(){
        let email = $('#email_link_pago').val();
        if(isValidEmailAddress(email)){
            let detalle = JSON.parse($('#detallePago').val());
            let codigoPrincipal;
            if(detalle.tipoServicio == "ORDEN_MEDICA"){
                codigoPrincipal = detalle.numeroOrden;
            }else{
                codigoPrincipal = detalle.codigoReserva;
            }
            let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
            let paciente = JSON.parse(dataAttr);

            let args = [];

            args["endpoint"] =  `${api_url}/${api_war}/notificaciones/enviar_link_pago?idPaciente=${paciente.idPaciente}&tipoServicio=${detalle.tipoServicio}&codigoPrincipal=${codigoPrincipal}&correoDestinatario=${email}`;
            //dataCita.paciente.numeroPaciente
            args["method"] = "POST";
            args["token"] = accessToken;
            args["showLoader"] = true;
            const data = await call(args);
            // console.log(data);
            if(data.code == 200){
                $('#modalPago').modal('hide');
                $('#mensajeError').html(`Hemos enviado un correo.<br>Por favor, revisa tu bandeja de entrada para completar el pago.`);
                $('#modalAlerta').modal('show');
            }
        }else{
            toastr.warning('Atención', 'Email inválido', { timeOut: 5000 });
            setTimeout(function(){
                $('#email_link_pago').focus();
            },1000);
            // $('#mensajeError').html(`Email inválido`);
            // $('#modalAlerta').modal('show');
        }
    }

    async function parametrosGenerales(){
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/util/parametros_generales?macAddress=${ dataTurno.mac }`;
        args["method"] = "GET";
        args["showLoader"] = false;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
        // console.log(data);

        if(data.code == 200){
            dataParametrosGenerales = data.data
        }
    }

    async function crearLinkpasarela(datos){
        let detalle = JSON.parse(datos);
        let codigoPrincipal;
        if(detalle.tipoServicio == "ORDEN_MEDICA"){
            codigoPrincipal = detalle.numeroOrden;
        }else{
            codigoPrincipal = detalle.codigoReserva;
        }

        // if(!isMobile()){}

        let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let paciente = JSON.parse(dataAttr);

        let args = [];

        args["endpoint"] =  `${api_url}/${api_war}/notificaciones/enviar_link_pago?idPaciente=${paciente.idPaciente}&tipoServicio=${detalle.tipoServicio}&codigoPrincipal=${codigoPrincipal}&correoDestinatario=`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data);
        if(data.code == 200){
            if(isMobile()){
                //window.open(data.data.urlLinkPago, '_blank')
                location.href = data.data.urlLinkPago;
            }else{
                generarLinkQr(data.data);
                $('#email_link_pago').val(paciente.mail)
                $('#modalPago').modal('show');
                puedeEnviar = true;
            }
        }
    }

    async function generarLinkQr(data){
        $('#qrcode').empty();
        $('#qrcode').qrcode({
            width: 200,
            height: 200,
            color: "#000",
            bgColor: "#FFF",
            text: data.urlLinkPago
        });
    }

    async function printTurnoAPI(detalle){
        let args = [];
        args["endpoint"] = `http://localhost:3002/printer-ticket/v1/turnero?turno=${detalle.turno}&sucursal=${detalle.nombreSucursalTurnero.toUpperCase()}&paciente=${detalle.nombreCompleo}&fechaTicket=${detalle.fechaEmision}&nombreMuestraTurnero=${dataParametrosGenerales.nombreMuestraTurnero}`;
        args["method"] = "GET";
        const data = await call(args);
        if(data.code == 200){
            console.log(data)
        }
        return;
    }

    async function printTurno(detalle){
        console.log(detalle);
        // {
        //     "turno": "TG-008",
        //     "mensajeLlegada": "WOOOW!! ERES EL NUMERO 3 PRONTO TOCA TU TURNO",
        //     "nombreCompleo": "ROSENBERG MIRANDA DENISSE ALEXANDRA",
        //     "nombreMuestraTurnero": "Veris",
        //     "nombreSucursalTurnero": "Veris Kennedy",
        //     "prioridad": 0,
        //     "nemonicoPrioridad": "NORMAL"
        // }
        //<img style="width:220px" class="logo mx-auto my-3" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
        var content = $('#turnoDisplay').html();
        var htmlContent = `
            <html>
            <head>
                <!-- Incluye Bootstrap o tu CSS personalizado -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-digiturno.css?v=1.0">
                <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/bootstrap-icons.min.css?v=1.0">
            </head>
            <body>
                <h3>${detalle.nombreSucursalTurnero.toUpperCase()}</h3>
                <h1>Turno: ${detalle.turno}</h1>
                <p class="fs-14 text-wrap"><strong>Paciente: </strong>${detalle.nombreCompleo}</p>
            </body>
            </html>
        `;
        //<p class="fs-14 text-wrap"><strong>Fecha emisión: </strong>${obtenerFechaHoraEnCurso()}</p>
// @page {
//                         size: 80mm 100mm; /* Define el tamaño exacto del papel */
//                         margin: 0; /* Elimina márgenes adicionales */
//                     }
        printJS({
            printable: htmlContent,
            type: 'raw-html',
            style: `
                @media print {
                    header, footer { display: none; }
                    body {
                        font-size: 14px;
                        margin: 0;
                        padding: 0;
                    }
                }
            `
        });
    }

    async function activarPrestacionesChequeos(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/inicializar?codigoEmpresa=1&tipoPreTransaccion=FACTURA`;
        let payload = {
            "secuenciaUsuario": dataParametrosGenerales.secuenciaUsuario,
            "idTurno": null,
            "caja": dataParametrosGenerales.caja,
            "nemonicoCanalFacturacion": "CAJA",
            "esFarmaciaDomicilio": false,
            "codigoSolicitudServDomicilio": null,
            "numSolicitudLabDomicilio": null
        }
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        const data = await call(args);
        if(data.code == 200){
            let idPreTransaccion = data.data.idPreTransaccion
            await agregarItemChequeo(idPreTransaccion);
        }
    }

    function generateUUIDv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = (Math.random() * 16) | 0; // Genera un número aleatorio entre 0 y 15
            const v = c === 'x' ? r : (r & 0x3) | 0x8; // Asegura que el formato cumple con UUID v4
            return v.toString(16); // Convierte el número a hexadecimal
        });
    }

    function obtenerPrestacionesParaActivar(){
        let arr = []
        $('#v-pills-tabContent').find('input:checked').each(function(index, element) {
            let prestacion = JSON.parse($(this).attr('data-rel'))
            arr.push({
                "_id": generateUUIDv4(),
                "secuenciaPreXAfi": prestacion.secuenciaPreXAfi
            })
        });
        return arr;
    }

    async function agregarItemChequeo(idPreTransaccion){
        let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let paciente = JSON.parse(dataAttr);
        
        let dataChequeo = JSON.parse($('#dataChequeo').val());

        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${idPreTransaccion}/agregar_item?codigoEmpresa=1&idPreTransaccion=${idPreTransaccion}`;
        let payload = {
            "idPaciente": paciente.idPaciente,
            "bateriaPrestaciones": {
                "beneficio": {
                    "convenio": {
                        "codigoConvenio": dataChequeo.codigoConvenio
                    }
                },
                "prestaciones": obtenerPrestacionesParaActivar()
            }
        }
        args["method"] = "PUT";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        const data = await call(args);
        if(data.code == 200){
            await facturarChequeo(idPreTransaccion, data.data);
        }
    }

    async function facturarChequeo(idPreTransaccion, detalle){
        let idAgrupacion = [];

        $.each(detalle, function(key, value){
            idAgrupacion.push(parseInt(value.idAgrupacion));
        })

        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${idPreTransaccion}/facturar?codigoEmpresa=1&idPreTransaccion=${idPreTransaccion}`;
        let payload = {
            "idAgrupacion": idAgrupacion
        }
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        const data = await call(args);
        if(data.code == 200){
            console.log(data);
            $('#direccionDirigirseLlegada').html(`Por favor, diríjase al área de chequeos.`);
            $('#modalNotificarLlegadaDirigirLugar').modal('show');
        }
    }

    async function mostrarPrestaciones(detalle){
        let elem = ``;
        $('.box-info-detalle-orden-apoyo').html(`
            <div class="d-flex align-items-center mb-1">
                <span style="width: 25px;" class="badge text-center bg-success badge-pill me-2">
                    <i class="fa-solid fa-check text-white"></i>
                </span>
                <p class="text-900 fs-12 mb-0"> Muestra recepcionada</p>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span style="width: 25px;" class="badge bg-veris-light text-center badge-pill me-2">
                    <i class="fa-solid fa-stopwatch text-veris-dark"></i>
                </span>
                <p class="text-900 fs-12 mb-0"> Muestra pendiente de entrega</p>
            </div>
        `);

        $.each(detalle.detallesOrden, function(key,value){
            console.log(value)
            //let class_estado_prestacion = (value.)
            let badge = ``;
            if(estadosVigentes.includes(value.codigoEstado)){
                if(value.fechaRecepcion == null){
                    badge = `<span style="width: 25px;" class="badge bg-veris-light text-center badge-pill ms-2">
                            <i class="fa-solid fa-stopwatch text-veris-dark"></i>
                        </span>`;
                }else{
                    badge = `<span style="width: 25px;" class="badge text-center bg-success badge-pill ms-2">
                            <i class="fa-solid fa-check text-white"></i>
                        </span>`
                }
            }else{
                badge = `<span style="width: 25px;" class="badge bg-pendiente text-center badge-pill ms-2">
                        <i class="fa-solid fa-triangle-exclamation text-white"></i>
                    </span>`;
            }
            elem += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 line-height-16 d-flex justify-content-between align-items-center">
                ${ value.nombrePrestacion }
                ${badge}
                </li>`
        })
        $('#listaPrestaciones').html(elem);
    }

    async function notificarLlegada(detalle){
        // console.log(detalle);
        let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/orden/activa_orden_laboratorio?macAddress=${ dataTurno.mac }&codigoOrdenApoyo=${ detalle.codigoOrdApoyo }`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data);
        if(data.code == 200){
            $('#direccionDirigirseLlegada').html(`Por favor, diríjase al área de <span class="fw-bold text-capitalize text-veris-dark">${detalle.tipoOrdenApoyo.toLowerCase()}</span>.`);
            $('#modalNotificarLlegadaDirigirLugar').modal('show');
        }
    }

    async function agruparDatos(){
        $.each(dataServicios, (index, item) => {
            const existingGroup = groupedData.find(group => group.tipoServicio === item.tipoServicio);
          
            if (existingGroup) {
                // Si el grupo ya existe, agrega el item a "items"
                existingGroup.items.push(
                    $.extend({}, item, { tipoServicio: undefined }) // Eliminar tipoServicio de los items
                );
            } else {
                // Si no existe, crea el grupo con el primer item
                groupedData.push({
                    tipoServicio: item.tipoServicio,
                    nombreServicioNivel1: item.nombreServicioNivel1,
                    items: [$.extend({}, item, { tipoServicio: undefined })] // Eliminar tipoServicio de los items
                });
            }
        });
    }

    async function drawListFamiliares(){
        let elem = ``;
        elem += `<div data-rel='${JSON.stringify(dataTurno.paciente)}' class="item-coincidencia item-coincidencia-selected rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
            <div class="letter-name border-veris-1 mx-2 bg-white" style="aspect-ratio: 1;width: 30px !important;height: 30px !important;">${ dataTurno.paciente.nombreCompleto.charAt(0) }</div>
                <span class="flex-grow-1 name-familiar text-start text-md-center">${ dataTurno.paciente.nombreCompleto }</span>
        </div>`;

        $('.name-selected-sidebar').html(`${dataTurno.paciente.primerNombre} ${dataTurno.paciente.primerApellido}`);

        $.each(dataTurno.paciente.lsGrupoFamiliar, function(key, value){
            elem += `<div data-rel='${JSON.stringify(value)}' class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
                <div class="letter-name border-veris-1 mx-2 bg-white" style="aspect-ratio: 1;width: 30px !important;height: 30px !important;">${ value.nombreCompleto.charAt(0) }</div>
                <span class="flex-grow-1 name-familiar text-start text-md-center">${ value.nombreCompleto }</span>
            </div>`;
        })
        $('#list-familiares').html(elem);
    }
    async function cargarServicios(){
        let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let paciente = JSON.parse(dataAttr);
        $('.name-selected-sidebar').html(`${paciente.primerNombre} ${paciente.primerApellido}`);
        let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/paciente/servicios?macAddress=${ dataTurno.mac }&idPaciente=${ paciente.idPaciente }`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data);
        $('#list-servicios').empty();
        if(data.code == 200){
            dataServicios = data.data;
            if(data.data.length > 0){
                groupedData = [];
                await agruparDatos();
                await drawServicioAgrupado(data.data);
                $('.box-with-data').removeClass('d-none');
                $('.box-with-data').addClass('d-block d-md-flex');
                $('.box-without-data').addClass('d-none');
                $('.box-without-data').removeClass('d-flex');
            }else{
                $('.box-with-data').removeClass('d-block d-md-flex');
                $('.box-with-data').addClass('d-none');
                $('.box-without-data').removeClass('d-none');
                $('.box-without-data').addClass('d-flex');
                // $('#list-servicios').html(`Sin servicios que mostrar`);
            }
        }else{
            $('#mensajeError').html(`${data.message}`)
            $('#modalAlerta').modal('show');
        }

        if(isMobile()){
            //hideListFamiliares()
        }
    }

    function hideListFamiliares(){
        $('#list-familiares').addClass('d-none');
        $('#sidebar').addClass('sidebar-collapsed');
        $('#sidebar').removeClass('sidebar-expanded');
        $('.arrow-ico').addClass('rotate-arrow');
    }

    function nombreComercialServicio(str){
        switch(str){
            case 'ORDEN_MEDICA':
                return 'Órdenes Médicas por Pagar';
            break;
            case 'ORDENES_APOYO_PENDIENTE':
                return 'Órdenes Médicas Pagadas';
            break;
            case 'RESERVA':
                return 'Citas Médicas';
            break;
            case 'BATERIA_PRESTACIONES':
                return 'Chequeos';
            break;
            case 'PAQUETES_PROMOCIONALES':
                return 'Paquetes promocionales';
            break;
        }
    }

    async function drawServicioAgrupado(){
        let elem = ``;
        $.each(groupedData, function(key, value){
            //if(value.tipoServicio != "BATERIA_PRESTACIONES"){
                elem += `<h3>${ nombreComercialServicio(value.tipoServicio) }</h3>`;
                elem += `<div class="swiper swiper-servicio swiper-servicio-${key} position-relative pb-4 mb-3">
                    <div class="swiper-wrapper py-2" id="contenedorServicios${key}">`;
                $.each(value.items, function(k, v){
                    elem += `<div class="swiper-slide">
                                ${ drawCard(v) }
                            </div>`;
                })
                elem += `</div>
                    <button type="button" class="mt-n4 btn btn-prev rounded-circle"></button>
                    <button type="button" class="mt-n4 btn btn-next rounded-circle"></button>
                </div>`;
            //}
        })
        $('#list-servicios').html(elem);
        swiper = new Swiper('.swiper-servicio', {
            spaceBetween: 8,
            navigation: {
                nextEl: '.btn-next',
                prevEl: '.btn-prev',
            },
            autoplay: false,
            // watchOverflow: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                300: {
                    // slidesPerView: 1.1,
                    slidesPerView: 1,
                    centeredSlides: false,
                    // loop: true,
                    spaceBetween: 4,
                },
                640: {
                    slidesPerView: 1.2,
                    // spaceBetween: 8,
                },
                768: {
                    slidesPerView: 1.3,
                    // spaceBetween: 8,
                },
                1024: {
                    slidesPerView: 1.5,
                    // spaceBetween: 8,
                },
            },
        });
        iniciarCountdownDesdeAtributos();
    }

    function sectionStatusPago(detalle){
        if(!tieneTiempo(detalle.horaInicio)){
            return `<span class="badge d-flex align-items-center bg-perdida text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-cita-perdida.svg" alt="">
                No asistió a tiempo
            </span>`;
        }
        if(detalle.estaPagado){
            return `<span class="badge d-flex align-items-center bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pagada.svg" alt="">
                Pagada
            </span>`;
        }else{
            return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pendiente.svg" alt="">
                Por pagar
            </span>`;
        }
    }

    function sectionStatusPagoPaquete(detalle){
        if(estadosVigentes.includes(detalle.codigoEstado)){
            if(obtenerDiferenciaDiasIntl(detalle.fechaVigencia) >= 0){
                return `<span class="badge d-flex align-items-center bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                    <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pagada.svg" alt="">
                    Vigente
                </span>`;
            }else{
                return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                    <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pendiente.svg" alt="">
                    Caducado
                </span>`;
            }
        }else{
            return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pendiente.svg" alt="">
                Por pagar
            </span>`;
        }
    }

    function sectionStatusPagoChequeo(detalle){
        if(obtenerDiferenciaDiasIntl(detalle.fechaCoberturaHasta) >= 0){
            return `<span class="badge d-flex align-items-center bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pagada.svg" alt="">
                Vigente
            </span>`;
        }else{
            return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pendiente.svg" alt="">
                Caducado
            </span>`;
        }
    }

    function mostrarTiempoVigencia(fecha){
        //estadosVigentes.includes(detalle.codigoEstado)
        // detalle.fecha
        let dias = obtenerDiferenciaDiasIntl(fecha);
        return `<div class="col-12 text-center fs-16 line-height-16 mb-3 fw-bold d-flex justify-content-center align-items-center">
                <div class="me-3">
                    <span class="text-veris fw-bold py-2 text-center">Días restantes:</span> ${dias}
                </div>
                <div class="border-caution-1 text-caution rounded-8 bg-white p-2">
                    Expira el ${fecha}</span>
                </div>
            </div>`;
    }
    
    function mostrarMetodosPagoPaquete(detalle){
        if(obtenerDiferenciaDiasIntl(detalle.fechaVigencia) >= 0){
            return `<div class="row g-0 rounded-8 mt-2 bg-veris-sky p-3 px-2 fs-5">
                <div class="col-12 d-block d-md-flex justify-content-center align-items-center gap-2">
                    <span class="text-veris fw-medium -dark me-2 p-2 my-2 text-end">Método de pago</span>
                    <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 me-2 my-2 btn-turno">Pagar en caja</button>
                    <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2">Link de pago</button>
                </div>
            </div>`;
        }
    }

    function verificarEstadoOrden(detalle){
        // console.log(detalle);
        var estaPagada = true
        //console.log(detalle.detallesOrden)
        $.each(detalle.detallesOrden, function(k,v) {
            if(detalle.tipoServicio == 'ORDENES_APOYO_PENDIENTE'){
                if(!estadosVigentes.includes(v.codigoEstado)){
                    estaPagada = false;
                }    
            }else{
                if(!v.estaFacturado){
                    estaPagada = false;
                }
            }
        });
        return estaPagada;
    }

    function sectionStatusPagoOrdenes(detalle){
        let estaPagado = verificarEstadoOrden(detalle)

        if(estaPagado){
            let notificar = `<button data-rel='${ JSON.stringify(detalle) }' class="btn badge bg-veris btn-notificar-llegada text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2 btn-turno">Generar turno</button>`;
            if(detalle.tipoServicio == 'ORDENES_APOYO_PENDIENTE'){
                notificar = `<button data-rel='${ JSON.stringify(detalle) }' class="btn badge bg-veris btn-notificar-llegada text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2">Notificar llegada</button>`
            }
            return `<span class="badge d-flex align-items-center bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pagada.svg" alt="">
                Pagada
            </span>
            ${ notificar }`;
        }else{
            return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/icon-pendiente.svg" alt="">
                Por pagar
            </span>`;
        }
    }

    function mostrarMetodosPago(detalle){
        if(detalle.estaPagado){
            return ``;
        }
        const countdownId = `countdown-${Math.random().toString(36).substring(2, 9)}`;
        let elem = `<div class="row g-0 rounded-8 mt-2 bg-veris-sky p-3 px-2 fs-5">
            <div class="col-8 offset-2 text-center fs-5 fw-bold ">
                <div class="w-100 border-veris-1 rounded-8 mb-3 bg-white py-2">
                    <span class="text-veris fw-bold py-2 text-center">TIEMPO PARA PAGAR:</span> <span id="${countdownId}" class="countdown" data-rel='${detalle.horaInicio}'></span>
                </div>
            </div>
            <div class="col-12 d-block d-md-flex justify-content-center align-items-center gap-2">
                <span class="text-veris fw-medium -dark me-2 p-2 my-2 text-end">Método de pago</span>
                <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 me-2 my-2 btn-turno">Pagar en caja</button>`;
            if(detalle.permitePago){
                elem += `<button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2 btn-link-pago" data-rel='${ JSON.stringify(detalle) }'>Link de pago</button>`;
            }
            elem += `</div>
            </div>`;
        return elem
    }

    function mostrarMetodosPagoOrden(detalle){
        let elem = `<div class="row g-0 rounded-8 mt-2 bg-veris-sky p-3 px-2 fs-5">
            <div class="col-12 d-block d-md-flex justify-content-center align-items-center gap-2">
                <span class="text-veris fw-medium -dark me-2 p-2 my-2 text-end">Método de pago</span>
                <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 me-2 my-2 btn-turno">Pagar en caja</button>`;
        if(detalle.permitePago){
            elem += `<button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2 btn-link-pago" data-rel='${ JSON.stringify(detalle) }'>Link de pago</button>`;
        }
        elem += `</div>
            </div>`;
        return elem
    }

    function iniciarCountdown(horaFin, elemento) {
        // Convertir la hora de finalización a un objeto Date
        const fechaFin = new Date(horaFin);

        function actualizarCountdown() {
            // Obtener la fecha actual
            const fechaActual = new Date();

            // Calcular la diferencia en milisegundos
            const diferenciaMS = fechaFin - fechaActual;

            if (diferenciaMS <= 0) {
                // Detener el countdown si ya pasó la hora
                clearInterval(intervalo);
                document.querySelector(elemento).textContent = "¡Tiempo agotado!";
                return;
            }

            // Convertir la diferencia a horas, minutos y segundos
            const horas = Math.floor(diferenciaMS / (1000 * 60 * 60));
            const minutos = Math.floor((diferenciaMS % (1000 * 60 * 60)) / (1000 * 60));
            const segundos = Math.floor((diferenciaMS % (1000 * 60)) / 1000);

            // Formatear usando Intl.NumberFormat para asegurarse de que sean siempre dos dígitos
            const formatter = new Intl.NumberFormat('en-US', { minimumIntegerDigits: 2 });
            const tiempoRestante = `${formatter.format(horas)}:${formatter.format(minutos)}:${formatter.format(segundos)}`;

            // Actualizar el contenido del elemento en la página
            document.querySelector(elemento).textContent = `TIEMPO PARA PAGAR: ${tiempoRestante}`;
        }

        // Actualizar el countdown cada segundo
        const intervalo = setInterval(actualizarCountdown, 1000);

        // Ejecutar una vez inmediatamente para evitar el retraso del primer segundo
        actualizarCountdown();
    }

    function mostrarConsultorio(detalle){
        if(detalle.estaPagado){
            return `<div class="row g-0 rounded-8 d-flex justify-content-between align-items-center mt-2 bg-veris-sky p-3 px-2 fs-5 mb-2">
                <div class="col-12 col-md-6">
                    <span class="text-veris fw-medium ">Centro:</span> ${detalle.nombreSucursal}
                </div>
                <div class="col-12 col-md-6 fw-bold fs-5 text-start text-md-end">
                    <span class="text-veris fw-medium ">Ve al ${(detalle.nombreSitioConsultorio.split(' '))[0].toLowerCase()}:</span> ${(detalle.nombreSitioConsultorio.split(' '))[1]} <!--span class="text-veris fw-medium ">|</span--> 
                    <!--img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/marker.svg"-->
                </div>
            </div>`;
        }
        return ``;
    }

    function mostrarReservaCaducada(detalle){
        return `<div class="row g-0 rounded-8 d-flex justify-content-between align-items-center mt-2 bg-veris-sky p-3 px-2 fs-5 mb-2">
            <div class="col-12 col-md-6 line-height-22">
                <span class="text-veris fw-medium">Lamentamos que no pudiste asistir a tu cita.</span> Genera un turno para ayudarte a reprogramarla.
            </div>
            <div class="col-12 col-md-6 fw-bold fs-4 text-end">
                <button data-rel='${ JSON.stringify(detalle) }' class="btn btn-turno badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 d-block me-2 my-2 mx-auto">Generar turno</button>
            </div>
        </div>`;
    }

    function mostrarPaqueteCaducada(detalle){
        return `<div class="row g-0 rounded-8 d-flex justify-content-between align-items-center bg-veris-sky p-3 px-2 fs-5 mb-2">
            <div class="col-12 col-md-6 line-height-22">
                <span class="text-veris fw-medium">Paquete caducado.</span> Genera un turno para revisarlo en Caja.
            </div>
            <div class="col-12 col-md-6 fw-bold fs-4 text-end">
                <button data-rel='${ JSON.stringify(detalle) }' class="btn btn-turno badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 d-block me-2 my-2 mx-auto">Generar turno</button>
            </div>
        </div>`;
    }

    function obtenerBeneficio(beneficio){
        if(beneficio  == null){
            return `Particular`;
        }
        if(beneficio.convenio != null){
            return beneficio.convenio.nombreConvenio;
        }else if(beneficio.paquete != null){
            return beneficio.paquete.nombrePaquete;
        }else if(beneficio.tarjeta != null){
            return beneficio.tarjeta.nombreTarjeta;
        }else{
            return ``;
        }
    }

    function drawCard(value){
        let classBorderPerdida = "";
        if( value.tipoServicio == "RESERVA" && !tieneTiempo(value.horaInicio) ){
            classBorderPerdida = "border-perdida";
        }
        if(value.tipoServicio == "ORDEN_MEDICA" || value.tipoServicio == "ORDENES_APOYO_PENDIENTE"){
            var ordenPagada = verificarEstadoOrden(value);
            // console.log({ordenPagada})
            // console.log(value)
            // console.log(value.nombreServicioNivel1 + ' - ' + value.numeroOrden)
            if(!ordenPagada){
                classBorderPerdida = "border-pendiente-1";
            }
        }
        let elem = `<div class="card h-100 w-100 rounded-8 py-3 px-3 mb-3 ${classBorderPerdida}">`;
        switch(value.tipoServicio){
            case 'RESERVA':
                elem += `<div class="row d-flex align-items-center mb-3">
                    <div class="col-7">
                        <h4 class="fw-bold title-servicio position-relative">
                            Cita médica
                            <span class="text-veris fw-medium "> agendada</span>
                        </h4>
                    </div>
                    <div class="col-5 d-flex flex-column align-items-end">
                        ${ sectionStatusPago(value) }
                    </div>
                </div>`;
                if(tieneTiempo(value.horaInicio)){
                    elem += `${ mostrarMetodosPago(value) }`;
                    elem += `${ mostrarConsultorio(value) }`;
                }else{
                    elem += `${ mostrarReservaCaducada(value) }`;
                }
                elem += `<div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                    <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-2">
                        <div class="avatar-doctor border-veris-1 ${classBorderPerdida}" style="background: url(${ (value.fotoMedicoApp != null) ? value.fotoMedicoApp : `https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg` }) no-repeat top center;background-size: cover;">
                        </div>
                        <div class="info-doctor ms-2 flex-grow-1">
                            <p class="mb-1">Doctor</p>
                            <p class="mb-1 fw-medium">${value.nombreMedico}</p>
                            <p class="mb-1 text-veris fw-medium">${value.nombreEspecialidad}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="info-doctor ms-2">
                            <p class="mb-1 d-flex justify-content-start align-items-start"><span class="text-veris fw-medium me-2">Fecha:</span> ${value.horaInicio}</p>
                            <p class="mb-1"><span class="text-veris fw-medium me-2">Beneficio:</span> ${obtenerBeneficio(value.beneficio)}</p>
                        </div>
                    </div>
                </div>`;
            break;
            case 'ORDEN_MEDICA':
            case 'ORDENES_APOYO_PENDIENTE':
                let nombreServicio = ``;
                if(value.tipoServicio == "ORDEN_MEDICA"){
                    nombreServicio = value.nombreServicioNivel1.toLowerCase()
                    if( value.nombreServicioNivel1 == "PROCEDIMIENTOS"){
                        nombreServicio = value.detallesOrden[0].nombreServicio.toLowerCase()
                    }
                }else{
                    nombreServicio = value.tipoOrdenApoyo.toLowerCase()
                }
                elem += `<div class="row d-flex align-items-start mb-3">
                    <div class="col-12 col-md-8">
                        <h4 class="fw-bold title-servicio text-capitalize position-relative">
                            ${nombreServicio}
                            <!--span class="text-veris fw-medium "> agendada</span-->
                        </h4>
                    </div>
                    <div class="col-12 col-md-4 mt-2 mt-md-0 d-flex flex-column align-items-start align-items-md-end">
                        ${ sectionStatusPagoOrdenes(value) }
                    </div>
                </div>`;
                if(!ordenPagada){
                    elem += `${ mostrarMetodosPagoOrden(value) }`;
                }

                let detallesOrden = ``;
                if(value.tipoServicio == "ORDEN_MEDICA"){
                    detallesOrden += `<button data-rel='${ JSON.stringify(value) }' class="btn btn-detalle-orden badge bg-veris-dark text-white p-2 fs-14 rounded-8 border-0 d-block ms-2">Ver detalles</button>`
                }

                elem += `<div class="row d-flex justify-content-between align-items-center mt-2 p-2 fs-18 line-height-18">
                        <div class="col-12 text-center fw-bold text-veris-dark d-flex justify-content-center align-items-center">
                        Fecha de Orden emitida: ${ (value.fechaOrden.split(' '))[0] }
                        ${ detallesOrden }
                        </div>
                    </div>`;

                let nombreEspecialidad = ``;
                if(value.nombreEspecialidad && value.nombreEspecialidad != null){
                    nombreEspecialidad = `<p class="mb-1"><span class="text-veris fw-medium me-2">Especialidad:</span> ${ value.nombreEspecialidad }</p>`;
                }
                if(value.doctorAtencion != null){
                    elem += `<div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <div class="avatar-doctor border-veris-1 ${classBorderPerdida}" style="background: url(${ (value.fotoMedicoApp != null) ? value.fotoMedicoApp : `https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg` }) no-repeat top center;background-size: cover;">
                            </div>
                            <div class="info-doctor ms-2 flex-grow-1">
                                <p class="mb-1">Doctor</p>
                                <p class="mb-1 fw-medium">${value.doctorAtencion}</p>
                                ${ nombreEspecialidad }
                                <p class="mb-1"><span class="text-veris fw-medium me-2">Beneficio:</span> ${obtenerBeneficio(value.beneficio)}</p>
                            </div>
                        </div>
                    </div>`;
                }else if(value.beneficio.convenio != null && value.beneficio.paquete != null && value.beneficio.tarjeta != null){
                    elem += `<div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <div class="info-doctor ms-2 flex-grow-1">
                                <p class="mb-1"><span class="text-veris fw-medium me-2">Beneficio:</span> ${obtenerBeneficio(value.beneficio)}</p>
                            </div>
                        </div>
                    </div>`;
                }
            break;
            case 'PAQUETES_PROMOCIONALES':
                let tiempoVigencia = obtenerDiferenciaDiasIntl(value.fechaVigencia);
                //if(tiempoVigencia >= 0){
                    elem += `<div class="row d-flex align-items-center mb-3">
                        <div class="col-7">
                            <h4 class="fw-bold title-servicio position-relative">
                                Empaquetado
                            </h4>
                        </div>
                        <div class="col-5 d-flex flex-column align-items-end">
                            ${ sectionStatusPagoPaquete(value) }
                        </div>
                        <div class="col-12 text-center my-2">
                            <span class="text-veris fw-bold fs-14 line-height-14"> ${value.nombrePaquete}</span>
                        </div>
                    </div>`;
                    if (estadosVigentes.includes(value.codigoEstado)){
                        if(tiempoVigencia >= 0){
                            elem += `${ mostrarTiempoVigencia(value.fechaVigencia) }`;
                        }else{
                            elem += `${ mostrarPaqueteCaducada(value) }`;
                        }
                    }else{
                        elem += `${ mostrarMetodosPagoPaquete(value) }`;
                    }
                    if(tiempoVigencia >= 0){
                        elem += `<div class="row g-0 rounded-8 d-flex justify-content-between align-items-center bg-veris-sky p-3 px-2 fs-5 mb-2">
                            <div class="col-12 col-md-6 line-height-22">
                                <span class="text-veris fw-medium">Detalles</span> del paquete promocional.
                            </div>
                            <div class="col-12 col-md-6 fw-bold fs-4 text-end">
                                <button data-rel='${ JSON.stringify(value) }' class="btn btn-detalle-paquete badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 d-block me-2 my-2 mx-auto">Ver detalles</button>
                            </div>
                        </div>`
                    }
                //}
            break;
            case 'BATERIA_PRESTACIONES':
                let tiempoVigenciaChequeo = obtenerDiferenciaDiasIntl(value.fechaCoberturaHasta);
                elem += `<div class="row d-flex align-items-center mb-3">
                    <div class="col-7">
                        <h4 class="fw-bold title-servicio position-relative">
                            ${value.nombreTipoContrato}
                        </h4>
                    </div>
                    <div class="col-5 d-flex flex-column align-items-end">
                        ${ sectionStatusPagoChequeo(value) }
                    </div>
                    <div class="col-12 text-center my-2">
                        <span class="text-veris fw-bold fs-14 line-height-14"> ${value.nombreConvenio}</span>
                    </div>
                </div>`;
                if(tiempoVigenciaChequeo >= 0){
                    elem += `${ mostrarTiempoVigencia(value.fechaCoberturaHasta) }`;
                }else{
                    elem += `${ mostrarPaqueteCaducada(value) }`;
                }
                if(tiempoVigenciaChequeo >= 0){
                    elem += `<div class="row g-0 rounded-8 d-flex justify-content-between align-items-center bg-veris-sky p-3 px-2 fs-5 mb-2">
                        <div class="col-12 col-md-6 line-height-22">
                            <span class="text-veris fw-medium">Detalles</span> del chequeo.
                        </div>
                        <div class="col-12 col-md-6 fw-bold fs-4 text-end">
                            <button data-rel='${ JSON.stringify(value) }' class="btn btn-detalle-chequeo badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 d-block me-2 my-2 mx-auto">Ver detalles</button>
                        </div>
                    </div>`
                }
            break;
        }
        elem += `</div>`;
        return elem;
    }

    async function generarTurno(){
        let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let paciente = JSON.parse(dataAttr);
        let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/generar_ticket?macAddress=${ dataTurno.mac }&tipoIdentificacion=${paciente.nombreTipoIdentificacion}&numeroIdentificacion=${paciente.numeroIdentificacion}&nombreCompleto=${ paciente.nombreCompleto }`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data);
        if(data.code == 200){
            $('#turnoModalLabel').html(`Turno - ${data.data.nombreSucursalTurnero}`);
            $('.turno-codigo').html(`${data.data.turno}`);
            // <p class="turno-prioridad">${data.data.nemonicoPrioridad}</p>
            $('.info-box').html(`<p class="text-wrap"><strong>Paciente:</strong> ${data.data.nombreCompleo}</p>`);
            $('#turnoModal').modal('show')
            // console.log("iniciar conteo para enviar a home")
            if(!isMobile()){
                // printTurno(data.data)
                if(dataTurno.mac == "00-22-4D-7B-2A-F5"){
                    printTurno(data.data)
                }else{
                    printTurnoAPI(data.data)
                }
            }
        }else{
            $('#mensajeError').html(`${data.message}`)
            $('#modalAlerta').modal('show');
        }
    }
</script>
<style>
    .toast-title {
        color: #fff !important;
    }
    #toast-container > .toast-warning{
        background-image: url("{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exclamation.svg") !important;
    }
    .keyboard{
        z-index: 99999;
    }
    button.keyboard-key.keyboard-dark {
        background: #0071CE;
    }
    .name-selected-sidebar{
        line-height: 22px;
    }
    #listaPrestaciones {
        max-height: 400px;
        overflow-y: auto;
    }
    #detalleComponentesPaquete {
        max-height: 400px;
        overflow-y: auto;
    }
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
    .line-height-22{line-height: 22px}
    .label-info{
        font-size: 1.25rem;
        line-height: 1.25rem;
    }
    .avatar-doctor {
        border-radius: 100%;
        width: 100px;
        height: 100px;
        aspect-ratio: 1
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
    .border-perdida .title-servicio:after{
        background: #d84316;
    }
    .border-pendiente-1 .title-servicio:after{
        background: var(--pendiente);
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
    .btn-prev-arrow::after,
    .btn-prev::after,
    .swiper-button-prev::after {
      margin-right: .0625rem;
      content: "\F284" !important;
    }

    .btn-next-arrow::after,
    .btn-next::after,
    .swiper-button-next::after {
      margin-left: .0625rem;
      content: "\F285" !important;
    }

    .btn-next-arrow,
    .btn-prev-arrow,
    .btn-next::after,
    .btn-prev::after,
    .swiper-button-next::after,
    .swiper-button-prev::after {
      font-family: bootstrap-icons !important;
      font-weight: 900 !important;
      font-size: 1.5rem !important;
      line-height: 2rem !important;
    }

    .btn-prev-arrow {
      left: -10px !important;
    }

    .btn-prev {
      left: 0 !important;
    }

    .btn-next-arrow {
      right: -10px !important;
    }

    .btn-next {
      right: 0 !important;
    }

    .btn-next,
    .btn-prev,
    .swiper-button-next,
    .swiper-button-prev {
      position: absolute !important;
      top: 50% !important;
      width: 2.25rem !important;
      height: 2.25rem !important;
      padding: 0;
      transition: all .3s ease-in-out !important;
      border-radius: 50% !important;
      background-color: #E0E6E9 !important;
      color: rgba(0, 113, 206, 0.25) !important;
      text-align: center !important;
      border: 0 !important;
      box-shadow: 0 .125rem .125rem -.125rem rgba(31, 27, 45, .08), 0 .25rem .75rem rgba(31, 27, 45, .08) !important;
      z-index: 10 !important;
    }

    .btn-next:not(.swiper-button-disabled),
    .btn-prev:not(.swiper-button-disabled) {
      /* Estilos aquí */
      color: #0071CE !important;
      background: rgba(204, 234, 250, 0.80) !important;
      box-shadow: 0px 0px 8px 0px rgba(0, 0, 0, 0.10);
    }

    .btn-next-arrow,
    .btn-prev-arrow {
      position: absolute !important;
      top: 60% !important;
      width: 2.25rem !important;
      height: 2.25rem !important;
      padding: 0;
      transition: all .3s ease-in-out !important;
      color: #0071CE !important;
      text-align: center !important;
      border: 0 !important;
      z-index: 10 !important;
      box-shadow: none !important;
    }
    .btn.disabled, .btn:disabled, fieldset:disabled .btn{
        opacity: 0 !important;
    }
    .swiper .swiper-slide{
        color: inherit !important;
    }
    .swiper .swiper-slide {
        height: auto;
    }

    .tab-pane {
        min-height: 300px;
        max-height: 450px;
        overflow-y: auto;
    }
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #0071ce;
    }
    .nav-pills .nav-link {
        background: #ebebeb;
        border-radius: 0;
        color: var(--veris-blue-dark);
    }
    .modal-dialog{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media (min-width: 1200px) {
        .modal-lg {
            max-width: 850px !important;
        }
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
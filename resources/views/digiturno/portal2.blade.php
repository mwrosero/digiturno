@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/kioskboard-2.3.0.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/print.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-2.3.0.min.js"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/print.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- Modal de pago --}}
<div class="modal fade mt-4" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel">
    <div class="modal-dialog modal-sm modal-dialog-top modal-dialog-scrollable mx-auto">
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
                        <input autofocus autocomplete="off" id="email_link_pago" type="text" class="w-100 keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1" data-kioskboard-specialcharacters="true">
                        <div type="button" class="btn bg-veris-dark btn-enviar-mail text-white mx-auto mb-5 rounded-8 my-5 fs-20">
                            ENVIAR LINK DE PAGO
                            <i class="fa-regular fa-paper-plane ms-2 text-white"></i>
                        </div>
                    </div>
                    <div class="tab-pane fade mt-3 px-2 w-100" id="pills-qr" role="tabpanel" aria-labelledby="pills-qr-tab" tabindex="0">
                        <div class="w-100 text-center my-3" id="qrcode"></div>
                        <p class="text-veris-dark fw-medium fs-4 text-center mt-2">
                            Escanea el Código QR con tu celular<br>para realizar el pago.
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
                {{-- <h5 class="fs--20 line-height-24 mt-3 mb-3">{{ __('Detalle la orden:') }}</h5> --}}
                <h5 class="fs--20 line-height-24 mt-3 mb-3" id="tituloPaqueteDetalleNotificar"></h5>
                <div class="row gx-2 justify-content-between align-items-center">
                    <ul class="list-group border-0 p-0" id="listaPrestaciones">
                    </ul>
                    <div class="my-2 box-info-detalle-orden-apoyo p-2 bg-silver">
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <button type="button" class="btn fw-normal text-white fs--16 badge bg-veris-dark px-4 py-2 mx-2 fs-4 btn-print-notificar-llegada" data-bs-dismiss="modal">Activar</button>
                <a href="#" class="btn fw-normal fs--16 badge bg-veris px-4 py-2 mx-2 fs-4 btn-salir text-white" data-bs-dismiss="modal">CERRAR</a>
            </div>
        </form>
    </div>
</div>
{{-- Modal Confirmar Cita --}}
<div class="modal modal-top fade" id="modalConfirmarCita" tabindex="-1" aria-labelledby="modalConfirmarCitaLabel">
    <div class="modal-dialog modal modal-sm modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center">
                {{-- <h5 class="fs--20 line-height-24 mt-3 mb-3">{{ __('Detalle la orden:') }}</h5> --}}
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-start">Cita confirmada</h5>
                <div class="box-info-consultorio d-flex justify-content-center align-items-center fw-bold text-dark fs-25 bg-silver-light py-2 rounded-8 my-2">
                </div>
                <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/confirmar-cita.svg" alt="" style="min-width: 350px;">
                <h3 class="fw-medium text-veris-dark">¿Deseas gestionar algo más?</h3>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <button type="button" class="btn fw-normal bg-veris text-white fs--16 badge bg-veris-dark px-4 py-2 mx-2 fs-4 btn-salir" data-bs-dismiss="modal">No</button>
                <a href="#" class="btn fw-normal fs--16 badge bg-white px-4 py-2 mx-2 fs-4 btn-salir text-veris border-veris-1" data-bs-dismiss="modal">Si</a>
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
{{-- Modal detalle orden --}}
<div class="modal modal-top fade" id="modalDetalleOrden" tabindex="-1" aria-labelledby="modalDetalleOrdenLabel">
    <div class="modal-dialog modal modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb-3" id="tituloOrdenDetalle"></h5>
                <div class="bg-silver-light rounded-8 text-veris-dark text-center fs-16 fw-bold p-2 mb-2">Muestras</div>
                <ul class="row border-0 p-0 my-2" id="detalleComponentesOrden">
                    <div class="col-12 col-md-6 d-flex flex-fill flex-column prestaciones-pagadas">
                        <ul class="list-group flex-grow-1"></ul>
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-fill flex-column prestaciones-porpagar">
                        <ul class="list-group flex-grow-1"></ul>
                    </div>
                </ul>
                <div class="box-opciones-orden">
                </div>
            </div>
            <div class="modal-footer d-block pt-0 pb-3 px-3 border-0">
                <div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge text-center badge-pill me-2">
                        <i class="fa-solid fa-circle-check text-verde"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Muestra realizada y pagada.</p>
                </div>
                <div class="d-flex align-items-center mb-1">
                    <span style="width: 25px;" class="badge text-center badge-pill me-2">
                        <i class="fa-solid fa-triangle-exclamation text-pendiente"></i>
                    </span>
                    <p class="text-900 fs-12 mb-0"> Muestra pendiente por realizar o por pagar.</p>
                </div>
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
    @include('template.header', ['showInfo' => true])
    <main class="familia p-2 p-md-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <h4 class="mb-0">Tu círculo familiar</h4>
                </div>
                <div class="col-12 px-0">
                    <!-- ESPECIALIDAD -->
                    <div class="modal modal-top fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
                            <form class="modal-content rounded-4">
                                <div class="modal-header d-none">
                                    <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <h4 class="mb-3">Elegir paciente</h4>
                                    <div class="row gx-2 justify-content-between align-items-center">
                                        <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaPacientes">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="modal-footer pt-0 pb-3 px-3">
                                    <button type="button" class="btn w-100 fw-medium fs--16 waves-effect line-height-20 m-0 p-3" style="color: #0071CE;" data-bs-dismiss="modal">Cancelar</button>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                    <div class="my-2 box-btn-familia border-veris-1 rounded-8">
                        <div class="btn w-100 btn-sm d-flex justify-content-between align-items-center pt-3 pb-3 border-veris-1 rounded-8" data-bs-toggle="modal" data-bs-target="#pacienteModal" id="btn-paciente" data-rel="">
                            <p class="fw-light fs-20 line-height-20 mb-0 text-truncate nombrePacienteElegido ms-3"></p>
                            <i class="fa-solid fa-chevron-right mx-2 text-veris fs-20 fw-bold"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Content -->
    <main class="content p-2 p-md-2">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-12 h-100 px-0 rounded-t-8 border-silver-light-1 bg-silver-light">
                    <ul class="nav nav-pills justify-content-between bg-white w-100 rounded-t-8 border-silver-light-1 border-start-0 border-start-0" id="pills-tab-servicios" role="tablist">
                        {{-- <li class="nav-item flex-fill" role="presentation">
                            <button data-rel="C" class="nav-link tipoServicio w-100 px-8 px-md-5 d-flex justify-content-center align-items-center text-veris-dark fs-20 active" id="pills-servicio1-tab" data-bs-toggle="pill" data-bs-target="#pills-servicio1" type="button" role="tab" aria-controls="pills-servicio1" aria-selected="true">
                                Para hoy
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button data-rel="N" class="nav-link tipoServicio w-100 px-8 px-md-5 d-flex justify-content-center align-items-center text-veris-dark fs-20" id="pills-servicio3-tab" data-bs-toggle="pill" data-bs-target="#pills-servicio3" type="button" role="tab" aria-controls="pills-servicio3" aria-selected="false">
                                Mis Paquetes
                            </button>
                        </li> --}}
                    </ul>
                    <div class="tab-content bg-transparent pt-2" id="pills-tabContent-servicios">
                        <div class="tab-pane fade mt-3 px-3 show active" id="pills-servicio1" role="tabpanel" aria-labelledby="pills-servicio1-tab" tabindex="0">
                            {{-- <div class="row row-flex mb-3 pb-3" style="max-height: 75vh;">
                                <div class="col-12 col-lg-6 col-xxl-4 d-flex mb-5 mt-0">
                                    <div class="w-100 mt-1">
                                        <div class="tab-card bg-citas d-inline-block py-2 px-4 rounded-t-8">
                                            <span class="fs-16 fw-medium text-veris-dark">Citas</span>
                                        </div>
                                        <div class="card d-flex flex-column content-card rounded-8 p-2 border-citas-1 rounded-ts-0">
                                            <div class="card-header p-0 bg-transparent border-0 d-flex justify-content-start align-items-center">
                                                <img class="me-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/consultas-ico.svg" alt="">
                                                <span class="fs-16 fw-medium text-veris me-2 flex-grow-1">Cita Médica</span>
                                                <div class="text-end ms-2">
                                                    <div class="text-verde fw-medium fs-14">
                                                        <i class="fa-solid fa-circle me-1"></i>
                                                        Pagado
                                                    </div>
                                                    <div class="text-silver-dark fw-medium fs-14">
                                                        <i class="fa-regular fa-calendar-check me-1"></i>
                                                        Por realizar
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-0 bg-transparent border-0">
                                                <div class="d-flex justify-content-center align-items-center fw-bold text-dark fs-18 bg-silver-light py-2 rounded-8 my-2">
                                                    Ve al consultorio <span class="text-veris ms-2 fs-25">13</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div class="avatar-doctor border-veris-1" style="background: url(https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg) no-repeat top center;background-size: cover;">
                                                    </div>
                                                    <div class="info-doctor text-veris-dark mx-2">
                                                        <p class="mb-1 fw-medium">Dr(a) Moreno Obando Jaime Roberto</p>
                                                        <p class="mb-1">Medicina General</p>
                                                    </div>
                                                    <div class="info-doctor ms-2">
                                                        <p class="mb-1 fw-bold text-veris">Agendado</p>
                                                        <p class="mb-1">AGO 09, 2025 <span class="text-veris">11:20 AM</span></p>
                                                        <p class="mb-1">Veris Alborada</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start align-items-start mt-2">
                                                    <p class="text-veris-dark fw-medium mb-1">Beneficio:</p>
                                                    <p class="mb-1 ms-2">SALUDSA-PLANSMART</p>
                                                </div>
                                            </div>
                                            <div class="card-footer mt-auto p-0 bg-transparent border-0">
                                                <button type="button" class="btn w-100 d-flex bg-veris text-white justify-content-center align-items-center p-2 py-3 mt-3">
                                                    Confirmar cita
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="tab-pane fade mt-3 px-2 w-100" id="pills-servicio2" role="tabpanel" aria-labelledby="pills-servicio2-tab" tabindex="0">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item bg-transparent border-0">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                            Accordion Item #1
                                        </div>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body px-2">
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="card rounded-8 p-2">
                                                        AA1
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="card rounded-8 p-2">
                                                        AA1
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="card rounded-8 p-2">
                                                        AA1
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item bg-transparent border-0">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                        <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            Accordion Item #2
                                        </div>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                        <div class="accordion-body px-2">
                                            <strong>This is the second item's accordion body.</strong> It is hidden by.
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

    <!-- Content -->
    <main class="content p-0 p-md-3 d-none">
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
                                            <button class="btn badge bg-veris text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block p-2 my-2 w-100 w-md-auto">Paga aquí</button>
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
{{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/keyboard.js?v=1.0.8"></script> --}}
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/qrcode.js"></script>
<script>
    let dataServicios;
    let groupedData = [];
    var estadosVigentes = ["REG", "ENTS", "FAC","PFAC","AUT","EXC"];

    setInterval(actualizarFechaHora, 1000);

    let local = localStorage.getItem('turno-{{ $portalToken }}');
    let dataTurno = JSON.parse(local);
    let puedeEnviar = false;
    buscarUsuarioFlag = false;

    $(document).ready(async function() {
        if(!isMobile()){
            KioskBoard.init({
                keysJsonUrl: '{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-keys-spanish.json',
                // keysNumeric: true,
                //keysArrayOfObjects: null, // Usa el teclado QWERTY predeterminado
                language: 'es',          // Idioma (ejemplo: 'es' para español)
                theme: 'light',          // Tema del teclado ('light' o 'dark')
                keysSpacebarText: 'Espacio',
                allowMobileKeyboard: false,
                capsLockActive: true,
                keysEnterText: '<i class="material-icons enter-key-icon">check_circle</i>',
            });

            KioskBoard.run('.virtual-keyboard-all', {});
        }
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
            // reiniciarConteo();
        });

        // Manejar clic en el botón "Sí"
        $("#btnSi").on("click", function () {
            clearTimeout(temporizadorRespuesta);
            $("#modalEstasAhi").fadeOut();
            console.log("El usuario sigue presente.");
            // reiniciarConteo();
        });

        $('body').on('click','.btn-confirmar-cita', function(){
            let detalle = JSON.parse($(this).attr('data-rel'));
            console.log(detalle);
            $('.box-info-consultorio').html(`Ve al ${(detalle.nombreSitioConsultorio.split(' '))[0].toLowerCase()} <span class="text-veris ms-2 fs-40">${(detalle.nombreSitioConsultorio.split(' '))[1]}</span>`);
            $('#modalConfirmarCita').modal('show')
        })

        if(!isMobile()){
            console.log("Iniciando conteo")
            // Iniciar el conteo inicial
            // reiniciarConteo();
        }
        
        await parametrosGenerales(dataTurno.mac);

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

        await drawListFamiliaresModal();
        $('body').on('click','.paciente-item', async function(){
            let detalle = JSON.parse($(this).attr('data-rel'))
            $(`.nombrePacienteElegido`).html(`${ detalle.nombreCompleto }`);
            $('.paciente-item').removeClass('paciente-item-selected');
            $(this).addClass('paciente-item-selected');
            await cargarServicios();
        })

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
            $('#tituloOrdenDetalle').html(`Detalle de Orden Médica: <span class="text-veris fw-bold">${detalle.numeroOrden}</span>`);
            
            //if(detalle.tieneOrdenApoyoPendiente || detalle.tipoServicio == "ORDENES_APOYO_PENDIENTE")
            let qtyPrestacionesPagadas = 0;
            let prestacionesPagadas = `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-18 fw-medium ms-1 p-0 line-height-18 d-flex justify-content-center align-items-start">Pagadas</li>`;
            let qtyPrestacionesPorPagar = 0;
            let prestacionesPorPagar = `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-18 fw-medium ms-1 p-0 line-height-18 d-flex justify-content-center align-items-start">Por pagar</li>`;
            let elem = ``;
            $.each(detalle.detallesOrden, function(key, value){
                let badge = ``;

                if(estadosVigentes.includes(value.codigoEstado)){
                    if(value.fechaRecepcion == null){
                        badge = `<span style="width: 25px;" class="badge text-center badge-pill ms-2">
                                <i class="fa-solid fa-triangle-exclamation text-pendiente"></i>
                            </span>`;
                        qtyPrestacionesPagadas++;
                    }else{
                        badge = `<span style="width: 25px;" class="badge text-center badge-pill ms-2">
                                <i class="fa-solid fa-circle-check text-verde"></i>
                            </span>`
                    }
                    prestacionesPagadas += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 ms-1 p-0 line-height-16 d-flex justify-content-start align-items-start">
                        ${ badge }
                        ${ value.nombrePrestacion }
                    </li>`
                }else{
                    qtyPrestacionesPorPagar++;
                    badge = `<span style="width: 25px;" class="badge text-center badge-pill ms-2">
                            <i class="fa-solid fa-triangle-exclamation text-pendiente"></i>
                        </span>`;
                    prestacionesPorPagar += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 ms-1 p-0 line-height-16 d-flex justify-content-start align-items-start">
                        ${ badge }
                        ${ value.nombrePrestacion }
                    </li>`
                }
                // ${ value.nombreServicio }/${ value.nombrePrestacion }
            })
            console.log({qtyPrestacionesPagadas})
            console.log(detalle.tieneOrdenApoyoPendiente)
            if(detalle.tieneOrdenApoyoPendiente && qtyPrestacionesPagadas > 0){
                prestacionesPagadas += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 ms-1 p-0 line-height-16 d-flex justify-content-start align-items-start mt-auto">
                        <div class="d-flex flex-wrap w-100 justify-content-between align-items-center mt-auto p-0 bg-transparent border-0 gap-2">
                            <button type="button" data-rel='${JSON.stringify(detalle)}' class="btn flex-fill bg-veris text-white btn-notificar-llegada p-2 py-3 mt-3" data-bs-dismiss="modal">
                                Activar orden
                            </button>
                        </div>
                    </li>`
            }
            if(qtyPrestacionesPagadas > 0){
                $('.prestaciones-pagadas').removeClass('d-none');
            }else{
                $('.prestaciones-pagadas').addClass('d-none');
            }
            
            if(qtyPrestacionesPorPagar > 0){
                prestacionesPorPagar += `<li class="list-group-item bg-white border-0 mb-2 py-0 fs-16 ms-1 p-0 line-height-16 d-flex justify-content-start align-items-start mt-auto">
                        <div class="d-flex flex-wrap w-100 justify-content-between align-items-center mt-auto p-0 bg-transparent border-0 gap-2">
                            <button type="button" data-rel='${JSON.stringify(detalle)}' class="btn flex-fill bg-white border-veris-1 text-veris btn-link-pago p-2 py-3 mt-3" data-bs-dismiss="modal">
                                Pagar aquí
                            </button>
                            <button type="button" data-rel='${JSON.stringify(detalle)}' class="btn flex-fill bg-veris text-white btn-turno p-2 py-3 mt-3" data-bs-dismiss="modal">
                                Quiero un cajero
                            </button>
                        </div>
                    </li>`
                $('.prestaciones-porpagar').removeClass('d-none');
            }else{
                $('.prestaciones-porpagar').addClass('d-none');
            }
            $('.prestaciones-pagadas ul').html(prestacionesPagadas);
            $('.prestaciones-porpagar ul').html(prestacionesPorPagar);
            $('#modalDetalleOrden').modal('show');
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
                                <input ${disabledAttr} class="form-check-input my-0" type="checkbox" value="" id="item-prestacion-${ v.codigoPrestacion }" codigoServicio-rel="${ value.codigoServicioNivel1 }" nombreServicio-rel="${ value.nombreServicioNivel1 }" data-rel='${ JSON.stringify(v) }'>
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

        // $('body').on('focus', '#email_link_pago', function(){
        //     Keyboard.open();
        // });

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

            args["endpoint"] =  `${api_url}/${api_war}/notificaciones/enviar_link_pago?idPaciente=${paciente.idPaciente}&tipoServicio=${detalle.tipoServicio}&codigoPrincipal=${codigoPrincipal}&correoDestinatario=${email}&macAddress={{ $mac }}`;
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

        args["endpoint"] =  `${api_url}/${api_war}/notificaciones/enviar_link_pago?idPaciente=${paciente.idPaciente}&tipoServicio=${detalle.tipoServicio}&codigoPrincipal=${codigoPrincipal}&correoDestinatario=&macAddress={{ $mac }}`;
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
        console.log(detalle);
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
            // $('#direccionDirigirseLlegada').html(`Por favor, diríjase al área de chequeos.`);
            let debeActivar = await validarActivarLaboratorioChequeos();
            if(debeActivar){
                $.each(data.data.transacciones, async function(key, value){
                    await activarLaboratorioChequeo(value);
                })
            }
            let lugares = await labelLugaresChequeos();
            $('#direccionDirigirseLlegada').html(`Tu orden ya está activada, por favor  dirígete al área de <span class="fw-bold text-capitalize text-veris-dark">${lugares.join(", ").toLowerCase()}</span>. Y espera a ser llamado.`);
            $('#modalNotificarLlegadaDirigirLugar').modal('show');
        }
    }

    async function activarLaboratorioChequeo(detalle){
        let numeroTransaccion = detalle.numeroTransaccion;
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/transacciones/genera_atencion_pac_laboratorio?codigoEmpresa=1&nemonicoCanalFacturacion=CAJA`;
        let payload = {
            "enviaOrdenesLaboratorio": true,
            "numeroTransaccion": [
                numeroTransaccion
            ]
        }

        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
    }

    async function validarActivarLaboratorioChequeos(){
        let activar = false;
        $('#v-pills-tabContent').find('input:checked').each(function(index, element) {
            let prestacion = JSON.parse($(this).attr('data-rel'))
            let nombreServicio = $(this).attr("nombreServicio-rel");
            if(nombreServicio == "LABORATORIO"){
                activar = true;
            }
        });

        return activar;
    }

    async function labelLugaresChequeos(){
        let lugares = [];
        $('#v-pills-tabContent').find('input:checked').each(function(index, element) {
            let prestacion = JSON.parse($(this).attr('data-rel'))
            let nombreServicio = $(this).attr("nombreServicio-rel")
            // console.log(nombreServicio)
            // console.log(prestacion)
            if(nombreServicio != "PROCEDIMIENTOS"){
                lugares.push(nombreServicio);
            }else{
                lugares.push(prestacion.nombreServicio);
            }
        });
        const uniqueArray = [...new Set(lugares)];
        return uniqueArray;
    }

    async function mostrarPrestaciones(detalle){
        $('#tituloPaqueteDetalleNotificar').html(`Detalle de Orden Médica: ${detalle.numeroOrden}`);
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
            //$('#direccionDirigirseLlegada').html(`Por favor, diríjase al área de <span class="fw-bold text-capitalize text-veris-dark">${detalle.tipoOrdenApoyo.toLowerCase()}</span> .`);
            $('#direccionDirigirseLlegada').html(`Tu orden ya está activada, por favor  dirígete al área de <span class="fw-bold text-capitalize text-veris-dark">${detalle.tipoOrdenApoyo.toLowerCase()}</span> y espera a ser llamado.`);
            $('#modalNotificarLlegadaDirigirLugar').modal('show');
        }
    }

    async function drawTabs(){
        let elem = `<li class="nav-item flex-fill" role="presentation">
            <button data-rel="Hoy" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-20 active" id="pills-Hoy-tab" data-bs-toggle="pill" data-bs-target="#pills-Hoy" type="button" role="tab" aria-controls="pills-Hoy" aria-selected="true">
                Para hoy
            </button>
        </li>`;
        let elemContent = `<div class="tab-pane fade mt-3 px-3 show active" id="pills-Hoy" role="tabpanel" aria-labelledby="pills-Hoy-tab" tabindex="0"></div>`;
        $.each(groupedData2, function(key, value){
            elem += `<li class="nav-item flex-fill" role="presentation">
                <button data-rel="${value.tipoServicio}" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-20" id="pills-${value.tipoServicio}-tab" data-bs-toggle="pill" data-bs-target="#pills-${value.tipoServicio}" type="button" role="tab" aria-controls="pills-${value.tipoServicio}" aria-selected="false">
                    ${value.labelServicio}
                </button>
            </li>`;
            if(value.tipoServicio == "Promociones" || value.tipoServicio == "Chequeos"){
                elemContent += `<div class="tab-pane bg-silver-light fade mt-3 px-3" id="pills-${value.tipoServicio}" role="tabpanel" aria-labelledby="pills-${value.tipoServicio}-tab" tabindex="0">
                    <div class="accordion" id="accordion-${value.tipoServicio}">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="panelsStayOpen-pagadas-${value.tipoServicio}">
                                <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-pagadas-${value.tipoServicio}-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-pagadas-${value.tipoServicio}-collapseOne">
                                    Mis ${value.tipoServicio}
                                </div>
                            </h2>
                            <div id="panelsStayOpen-pagadas-${value.tipoServicio}-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-pagadas-${value.tipoServicio}">
                                <div class="accordion-body px-2">
                                    <div class="row" id="row-pagadas-${value.tipoServicio}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            }else{
                elemContent += `<div class="tab-pane bg-silver-light fade mt-3 px-3" id="pills-${value.tipoServicio}" role="tabpanel" aria-labelledby="pills-${value.tipoServicio}-tab" tabindex="0">
                    <div class="accordion" id="accordion-${value.tipoServicio}">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="panelsStayOpen-pagadas-${value.tipoServicio}">
                                <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-pagadas-${value.tipoServicio}-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-pagadas-${value.tipoServicio}-collapseOne">
                                    Pagadas
                                </div>
                            </h2>
                            <div id="panelsStayOpen-pagadas-${value.tipoServicio}-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-pagadas-${value.tipoServicio}">
                                <div class="accordion-body px-2">
                                    <div class="row" id="row-pagadas-${value.tipoServicio}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="panelsStayOpen-porpagar-${value.tipoServicio}">
                                <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-porpagar-${value.tipoServicio}-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-porpagar-${value.tipoServicio}-collapseTwo">
                                    Por pagar
                                </div>
                            </h2>
                            <div id="panelsStayOpen-porpagar-${value.tipoServicio}-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-porpagar-${value.tipoServicio}">
                                <div class="accordion-body px-2">
                                    <div class="row" id="row-porpagar-${value.tipoServicio}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            }
        })
        $('#pills-tab-servicios').html(elem);
        $('#pills-tabContent-servicios').html(elemContent);
    }

    async function drawServicioAgrupadoTabs(){
        drawHoy();
        let elem = ``;
        $.each(groupedData2, function(key, value){
            $.each(value.items, function(k, v){
                drawCardItem(value.tipoServicio, value.labelServicio, v);
            })
        })
    }

    async function drawCardItem(tipoServicio, labelServicio, detalle){
        let detalleRel = JSON.stringify(detalle);
        let icon_service_name = ``;
        let sectionEstadoPago = `pagadas`;
        let labelEstadoItem = `Pagado`;
        let classEstadoItem = `text-verde`;

        let textColorServicio = `text-veris`;
        
        let iconEstadoItemReserva = `<i class="fa-regular fa-calendar-check me-1"></i>`;
        let classEstadoItemReserva = `text-veris`;
        let strEstadoItemReserva = `Por realizar`;

        let numeroOrden = ``;
        
        let elemHeaderCard = ``;
        let elemBodyCard = ``;
        let elemFooterCard = ``;

        switch(detalle.tipoServicio){
            case 'ORDEN_MEDICA':
            case 'ORDENES_APOYO_PENDIENTE':
                var ordenPagada = verificarEstadoOrden(detalle);
                numeroOrden = detalle.numeroOrden;
                var permiteAgendar = await verificarSiTienePrestacionAgendable(detalle);
                if(permiteAgendar){
                    classEstadoItemReserva = `text-silver-dark`;
                    strEstadoItemReserva = `Por agendar`;
                }
                if(detalle.permitePago || detalle.tipoServicio == "ORDENES_APOYO_PENDIENTE"){
                    if(!ordenPagada){
                        let ordenParcial = await verificarEstadoOrdenParcialmente(detalle);
                        if(ordenParcial > 0){
                            labelEstadoItem = `Pagado parcialmente`;
                            let cantidadPagados = ` (${ordenParcial}) <span class="text-veris-dark fw-medium">${ (ordenParcial == 1) ? `Examen pagado` : `Exámenes pagados` }</span>`
                            strEstadoItemReserva = `Por realizar ${cantidadPagados}`;
                        }else{
                            labelEstadoItem = `Por pagar`;
                        }
                        sectionEstadoPago = `porpagar`;
                        classEstadoItem = `text-pendiente`;
                        classEstadoItem = `text-pendiente`;
                        if(ordenParcial > 0){
                            elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-white border-veris-1 text-veris btn-detalle-orden p-2 py-3 mt-3">
                                Ver detalle
                            </button>`;
                        }else{
                            elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-white border-veris-1 text-veris btn-link-pago p-2 py-3 mt-3">
                                Pagar aquí
                            </button>
                            <button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-veris text-white btn-turno p-2 py-3 mt-3">
                                Quiero un cajero
                            </button>`;
                        }
                    }else{
                        elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-white border-veris-1 text-veris btn-detalle-orden p-2 py-3 mt-3">
                                Ver detalle
                            </button>`;
                        if(detalle.tieneOrdenApoyoPendiente || detalle.tipoServicio == "ORDENES_APOYO_PENDIENTE"){
                            elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-veris text-white btn-notificar-llegada p-2 py-3 mt-3">
                                Activar orden
                            </button>`;
                        }
                    }
                }else{
                    sectionEstadoPago = `porpagar`;
                        labelEstadoItem = `Por pagar`;
                        classEstadoItem = `text-pendiente`;
                        classEstadoItem = `text-pendiente`;
                        elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-white border-veris-1 text-veris btn-detalle-orden p-2 py-3 mt-3">
                                    Ver detalle
                                </button>`;
                }

                if(detalle.nombreServicioNivel1 == "PROCEDIMIENTOS"){
                    icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/procedimiento-ico.svg`;
                }else if(detalle.nombreServicioNivel1 == "IMAGENES"){
                    textColorServicio = `text-purple`;
                    icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/imagenes-ico.svg`;
                }else if(detalle.nombreServicioNivel1 == "LABORATORIO"){
                    textColorServicio = `text-green-dark`;
                    icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/laboratorio-ico.svg`;
                }else if(detalle.tipoServicio == 'ORDENES_APOYO_PENDIENTE'){
                    textColorServicio = `text-green-dark`;
                    icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/laboratorio-ico.svg`;  
                }

                let infoMedico = ``;
                if(detalle.doctorAtencion !== null){
                    infoMedico += `<div class="avatar-doctor border-veris-1" style="background: url(${ (detalle.fotoMedicoApp != null) ? detalle.fotoMedicoApp : `https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg` }) no-repeat top center;background-size: cover;">
                    </div>
                    <div class="info-doctor text-veris-dark mx-2 me-2">
                        <p class="mb-1 fs-18 fw-bold text-capitalize">Dr(a) ${detalle.doctorAtencion.toLowerCase()}</p>
                        <p class="mb-1 text-capitalize">${(detalle.nombreEspecialidad !== null) ?? detalle.nombreEspecialidad.toLowerCase()}</p>
                    </div>`;
                }

                // let fechaHoraAgenda = (formatearFechaMesDia(detalle.horaInicio)).split('|');
                elemBodyCard += `<div class="d-flex justify-content-between align-items-center mt-3">
                    ${infoMedico}
                    <div class="info-doctor">
                        <p class="mb-1 fw-bold text-veris">Orden emitida:</p>
                        <p class="mb-1 text-capitalize">${detalle.fechaOrden}</p>
                        <p class="mb-1 text-capitalize">${detalle.nombreSucursal.toLowerCase()}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-start mt-2">
                    <p class="text-veris-dark fw-bold mb-1">Beneficio:</p>
                    <p class="mb-1 ms-2 text-capitalize">${obtenerBeneficio(detalle.beneficio).toLowerCase()}</p>
                </div>`
            break;
            // case 'ORDENES_APOYO_PENDIENTE':
            //     icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/laboratorio-ico.svg`;                
            // break;
            case 'RESERVA':
                let fechaHoraAgenda = (formatearFechaMesDia(detalle.horaInicio)).split('|');
                
                icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/consultas-ico.svg`;
                
                if(!detalle.estaPagado){
                    iconEstadoItemReserva = ``;
                    strEstadoItemReserva = ``;
                    sectionEstadoPago = `porpagar`;
                    labelEstadoItem = `Por pagar`;
                    classEstadoItem = `text-pendiente`;
                    elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-veris text-white btn-link-pago p-2 py-3 mt-3">
                            Pagar aquí
                        </button>
                        <button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-white border-veris-1 text-veris btn-turno p-2 py-3 mt-3">
                            Quiero un cajero
                        </button>`;
                }else{
                    elemBodyCard += `<div class="d-flex justify-content-center align-items-center fw-bold text-dark fs-18 bg-silver-light py-2 rounded-8 my-2">
                        Ve al ${(detalle.nombreSitioConsultorio.split(' '))[0].toLowerCase()} <span class="text-veris ms-2 fs-25">${(detalle.nombreSitioConsultorio.split(' '))[1]}</span>
                    </div>`;
                    elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-veris text-white btn-confirmar-cita p-2 py-3 mt-3">
                            Confirmar cita
                        </button>`;
                }

                let classHoraAgendada = `text-veris`;
                
                if(!tieneTiempo(detalle.horaInicioTiempoEspera)){
                    iconEstadoItemReserva = `<i class="fa-regular fa-calendar-xmark me-1"></i>`;
                    classEstadoItemReserva = `text-caution`;
                    strEstadoItemReserva = `Atrasada`;
                    classHoraAgendada = `text-caution`
                }

                if(detalle.nombreServicio == "TERAPIA FISICA"){
                    icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/terapia-ico.svg`;
                    labelServicio = `Terapia Física`;
                }

                elemBodyCard += `<div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="avatar-doctor border-veris-1" style="background: url(${ (detalle.fotoMedicoApp != null) ? detalle.fotoMedicoApp : `https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg` }) no-repeat top center;background-size: cover;">
                    </div>
                    <div class="info-doctor text-veris-dark mx-2">
                        <p class="mb-1 fs-18 fw-bold text-capitalize">Dr(a) ${detalle.nombreMedico.toLowerCase()}</p>
                        <p class="mb-1 text-capitalize">${detalle.nombreEspecialidad.toLowerCase()}</p>
                    </div>
                    <div class="info-doctor ms-2">
                        <p class="mb-1 fw-bold text-veris">Agendado para:</p>
                        <p class="mb-1 text-capitalize">${fechaHoraAgenda[0].toLowerCase()} <span class="${classHoraAgendada}">${fechaHoraAgenda[1]}</span></p>
                        <p class="mb-1 text-capitalize">${detalle.nombreSucursal.toLowerCase()}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-start mt-2">
                    <p class="text-veris-dark fw-bold mb-1">Beneficio:</p>
                    <p class="mb-1 ms-2 text-capitalize">${obtenerBeneficio(detalle.beneficio).toLowerCase()}</p>
                </div>`;
            break;
            case 'BATERIA_PRESTACIONES':
                icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/consultas-ico.svg`;
            break;
            case 'PAQUETES_PROMOCIONALES':
                icon_service_name = `{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/promocion-ico.svg`;

                labelServicio = `${detalle.nombrePaquete.toLowerCase()}`;
                
                iconEstadoItemReserva = ``;
                strEstadoItemReserva = ``;

                let dias = obtenerDiferenciaDiasIntl(detalle.fechaVigencia);
                
                if(!estadosVigentes.includes(detalle.codigoEstado)){
                    sectionEstadoPago = `porpagar`;
                    labelEstadoItem = `Por pagar`;
                    classEstadoItem = `text-pendiente`;
                }else{
                    if(dias >= 0){
                        labelEstadoItem = `Vigente`;
                    }else{
                        labelEstadoItem = `Caducado`;
                        classEstadoItem = `text-caution`;
                    }
                }

                elemFooterCard += `<div class="col-12 text-center fs-16 line-height-16 mb-3 fw-bold">
                    <div class="mt-4 mb-3 fs-16 line-height-18 d-flex justify-content-center align-items-center">
                        <span class="fw-bold text-veris-dark">Válido hasta:</span>
                        <span class="ms-2 ${ (dias < 0) ? `text-caution` : `text-veris` }">${detalle.fechaVigencia}</span>
                    </div>
                    <div class="mb-1 text-veris fs-16 line-height-18 d-flex justify-content-center align-items-center">
                        <span class="fw-bold text-veris-dark">Días restantes:</span> <div class="rounded-8 bg-veris-sky border-veris-1 py-2 px-3 ms-2">${ (dias > 0) ? dias : `0` }</div>
                    </div>
                </div>`;

                elemFooterCard += `<button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-white border-veris-1 text-veris btn-detalle-paquete p-2 py-3 mt-3">
                        Ver detalle
                    </button>
                    <button type="button" data-rel='${detalleRel}' class="btn flex-fill bg-veris text-white btn-turno p-2 py-3 mt-3">
                        Asistencia en caja
                    </button>`;
            break;
        }

        let elem = `<div class="col-12 col-lg-6 col-xxl-4 d-flex mb-3 mt-0">
                <div class="w-100 mt-1">
                    <div class="card d-flex flex-column content-card rounded-8 p-2 px-3 border-citas-1">
                        <div class="card-header p-0 bg-transparent border-0 d-flex justify-content-start align-items-center">
                            <img class="me-2" src="${icon_service_name}" alt="">
                            <div class="me-2 flex-grow-1">
                                <span class="fs-16 fw-medium ${textColorServicio} d-block text-capitalize">${labelServicio}</span>
                                <span class="d-block ${textColorServicio}">${numeroOrden}</span>
                            </div>
                            <div class="text-end ms-2" style="min-width: 100px;">
                                <div class="${classEstadoItem} fw-medium fs-14">
                                    <i class="fa-solid fa-circle me-1"></i>
                                    ${labelEstadoItem}
                                </div>
                                <div class="${classEstadoItemReserva} fw-medium fs-14">
                                    ${iconEstadoItemReserva}
                                    ${strEstadoItemReserva}
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 bg-transparent border-0">
                            ${elemBodyCard}
                        </div>
                        <div class="card-footer d-flex flex-wrap w-100 justify-content-between align-items-center mt-auto p-0 bg-transparent border-0 gap-2">
                            ${elemFooterCard}
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $(`#row-${sectionEstadoPago}-${tipoServicio}`).append(elem);

    }

    async function verificarSiTienePrestacionAgendable(detalle){
        let permiteAgenda = false;
        $.each(detalle.detallesOrden, function(k,v) {
            if(v.esAgendable == "S"){
                permiteAgenda = true;
            }
        });
        return permiteAgenda;
    }

    async function drawHoy(){
        let elem = `<div class="row row-flex mb-3 pb-3" style="max-height: 75vh;">
            <div class="col-12 col-lg-6 col-xxl-4 d-flex mb-5 mt-0">
                <div class="w-100 mt-1">
                    <div class="tab-card bg-citas d-inline-block py-2 px-4 rounded-t-8">
                        <span class="fs-16 fw-medium text-veris-dark">Citas</span>
                    </div>
                    <div class="card d-flex flex-column content-card rounded-8 p-2 border-citas-1 rounded-ts-0">
                        <div class="card-header p-0 bg-transparent border-0 d-flex justify-content-start align-items-center">
                            <img class="me-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/consultas-ico.svg" alt="">
                            <span class="fs-16 fw-medium text-veris me-2 flex-grow-1">Cita Médica</span>
                            <div class="text-end ms-2">
                                <div class="text-verde fw-medium fs-14">
                                    <i class="fa-solid fa-circle me-1"></i>
                                    Pagado
                                </div>
                                <div class="text-silver-dark fw-medium fs-14">
                                    <i class="fa-regular fa-calendar-check me-1"></i>
                                    Por realizar
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 bg-transparent border-0">
                            <div class="d-flex justify-content-center align-items-center fw-bold text-dark fs-18 bg-silver-light py-2 rounded-8 my-2">
                                Ve al consultorio <span class="text-veris ms-2 fs-25">13</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="avatar-doctor border-veris-1" style="background: url(https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg) no-repeat top center;background-size: cover;">
                                </div>
                                <div class="info-doctor text-veris-dark mx-2">
                                    <p class="mb-1 fw-medium">Dr(a) Moreno Obando Jaime Roberto</p>
                                    <p class="mb-1">Medicina General</p>
                                </div>
                                <div class="info-doctor ms-2">
                                    <p class="mb-1 fw-bold text-veris">Agendado</p>
                                    <p class="mb-1">AGO 09, 2025 <span class="text-veris">11:20 AM</span></p>
                                    <p class="mb-1">Veris Alborada</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start align-items-start mt-2">
                                <p class="text-veris-dark fw-medium mb-1">Beneficio:</p>
                                <p class="mb-1 ms-2">SALUDSA-PLANSMART</p>
                            </div>
                        </div>
                        <div class="card-footer mt-auto p-0 bg-transparent border-0">
                            <button type="button" class="btn w-100 d-flex bg-veris text-white justify-content-center align-items-center p-2 py-3 mt-3">
                                Confirmar cita
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        $('#pills-Hoy').html(elem);
    }

    let groupedData2 = [];
    let tipoServicioFilter = ['Citas','Laboratorio','Imagenes','Procedimientos','OrdenesApoyo','Odontologia','Promociones','Chequeos'];
    async function agruparDatos2(){
        $.each(dataServicios, (index, item) => {
            let tipoServicioItem;
            let labelServicio;
            switch(item.tipoServicio){
                case 'ORDEN_MEDICA':
                    if(item.nombreServicioNivel1 == "PROCEDIMIENTOS"){
                        tipoServicioItem = 'Procedimientos';
                        labelServicio = 'Procedimientos';
                    }else if(item.nombreServicioNivel1 == "IMAGENES"){
                        tipoServicioItem = 'Imagenes';
                        labelServicio = 'Imágenes';
                    }else if(item.nombreServicioNivel1 == "LABORATORIO"){
                        tipoServicioItem = 'Laboratorio';
                        labelServicio = 'Laboratorio';
                    }
                break;
                case 'ORDENES_APOYO_PENDIENTE':
                    tipoServicioItem = 'Laboratorio';
                    labelServicio = 'Laboratorio';
                break;
                case 'RESERVA':
                    tipoServicioItem = 'Citas';
                    labelServicio = 'Citas';
                break;
                case 'BATERIA_PRESTACIONES':
                    tipoServicioItem = 'Chequeos';
                    labelServicio = 'Chequeo Empresarial';
                break;
                case 'PAQUETES_PROMOCIONALES':
                    tipoServicioItem = 'Promociones';
                    labelServicio = 'Promociones';
                break;
            }

            const existingGroup = groupedData2.find(group => group.tipoServicio === tipoServicioItem);

            if (existingGroup) {
                // Si el grupo ya existe, agrega el item a "items"
                existingGroup.items.push(
                    $.extend({}, item, { tipoServicio: undefined }) // Eliminar tipoServicio de los items
                );
            } else {
                // Si no existe, crea el grupo con el primer item
                groupedData2.push({
                    tipoServicio: tipoServicioItem,
                    labelServicio: labelServicio,
                    nombreServicioNivel1: item.nombreServicioNivel1,
                    items: [$.extend({}, item, { tipoServicio: undefined })] // Eliminar tipoServicio de los items
                });
            }
        });
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

    async function drawListFamiliaresModal(){
        $(`.nombrePacienteElegido`).html(`${ dataTurno.paciente.nombreCompleto }`);
        let elem = ``;
        elem += `<div data-rel='${JSON.stringify(dataTurno.paciente)}' class="paciente-item mb-2 paciente-item-selected shadow-sm border-veris-1 rounded-8 p-2" data-bs-dismiss="modal">
            <div class="list-group-item bg-transparent border-0 d-flex justify-content-between align-items-center">
                <div class="box-check text-start me-3">
                    <i class="fa-solid fs-25 fa-check text-veris fw-bold"></i>
                </div>
                <label class="text-veris-dark fs-20 fw-bold line-height-20 cursor-pointer flex-grow-1">
                    ${ dataTurno.paciente.nombreCompleto }
                </label> 
            </div>
        </div>`;
        $.each(dataTurno.paciente.lsGrupoFamiliar, function(key, value){
            elem += `<div data-rel='${JSON.stringify(value)}' class="paciente-item mb-2 shadow-sm border-veris-1 rounded-8 p-2" data-bs-dismiss="modal">
                <div class="list-group-item bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <div class="box-check text-start me-3">
                        <i class="fa-solid fs-25 fa-check text-veris fw-bold"></i>
                    </div>
                    <label class="text-veris-dark fs-20 fw-bold line-height-20 cursor-pointer flex-grow-1">
                        ${ value.nombreCompleto }
                    </label> 
                </div>
            </div>`;
        })

        $('#listaPacientes').html(elem);
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
        $('#pills-tab-servicios').empty();
        // let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let dataAttr = $('.paciente-item-selected').attr("data-rel");

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
        groupedData2 = [];
        $('#list-servicios').empty();
        if(data.code == 200){
            dataServicios = data.data;
            await agruparDatos2();
            if(data.data.length > 0){
                groupedData = [];
                await agruparDatos();
                await drawTabs();
                await drawServicioAgrupadoTabs();
                // await drawServicioAgrupado(data.data);
                // $('.box-with-data').removeClass('d-none');
                // $('.box-with-data').addClass('d-block d-md-flex');
                // $('.box-without-data').addClass('d-none');
                // $('.box-without-data').removeClass('d-flex');
            }else{
                await drawTabs();
                $('#pills-Hoy').html(`
                    <div class="row row-flex mb-3 pb-3">
                        <div class="col-10 col-md-6 mx-auto text-center mt-3">
                            <img class="w-100 mb-3" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/empty-data.svg" />
                            <button type="button" class="btn fw-normal text-white fs-25 badge bg-veris px-4 py-3 btn-turno">¿Deseas gestionar algo?</button>
                        </div>
                    </div>
                `)
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
        const prioridad = ['RESERVA','ORDENES_APOYO_PENDIENTE','BATERIA_PRESTACIONES','PAQUETES_PROMOCIONALES','ORDEN_MEDICA'];
        groupedData.sort((a, b) => {
            return prioridad.indexOf(a.tipoServicio) - prioridad.indexOf(b.tipoServicio);
        });

        let elem = ``;
        $.each(groupedData, function(key, value){
            // if(value.tipoServicio != "ORDEN_MEDICA"){
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
            // }
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
                    <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2">Paga aquí</button>
                </div>
            </div>`;
        }
    }

    function verificarEstadoOrdenParcialmente(detalle){
        // console.log(detalle);
        var qtyEstaPagadaParcialmente = 0
        //console.log(detalle.detallesOrden)
        $.each(detalle.detallesOrden, function(k,v) {
            if(detalle.tipoServicio == 'ORDENES_APOYO_PENDIENTE'){
                if(estadosVigentes.includes(v.codigoEstado)){
                    qtyEstaPagadaParcialmente++;
                }    
            }else{
                if(v.estaFacturado){
                    qtyEstaPagadaParcialmente++;
                }
            }
        });
        return qtyEstaPagadaParcialmente;
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
                notificar = `<button data-rel='${ JSON.stringify(detalle) }' class="btn badge bg-veris btn-notificar-llegada text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2">Activar orden</button>`
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
                elem += `<button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2 btn-link-pago" data-rel='${ JSON.stringify(detalle) }'>Paga aquí</button>`;
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
            // elem += `<button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2 btn-link-pago" data-rel='${ JSON.stringify(detalle) }'>Paga aquí</button>`;
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
                <div class="col-12 col-md-6 fw-bold fs-2 text-start text-md-end">
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
            return `Particular`;
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
                        <h6 class="text-veris">Nro. Orden: ${ value.numeroOrden }</h6>
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
    /*
    Para buscar paquetes: https://api.phantomx.com.ec/digitales/v1/comercial/detallePaquete?canalOrigen=MVE_CMV&codigoEmpresa=1&secuenciaPaquetePaciente=4680170
    */
</script>
<style>
    body{
        overflow: hidden;
    }
    .avatar-doctor{
        width: 60px !important;
        height: 60px !important;
    }
    .row-flex {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        overflow-y: auto;
    }
    .content-card {
        height: 100%;
    }
    .paciente-item i{
        visibility: hidden;
    }
    .paciente-item-selected i{
        visibility: visible;
    }
    .paciente-item-selected{
        background: var(--veris-blue-sky);
    }
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
    .box-check{
        width: 50px;
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

    #pills-tabContent .tab-pane {
        min-height: 300px;
        max-height: 450px;
        overflow-y: auto;
    }
    
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #0071ce;
    }
    .nav-pills .nav-link {
/*        background: #ebebeb;*/
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
@extends('template.app-template')
@section('content')
{{-- Modal notificar llegada --}}
<div class="modal modal-top fade" id="modalNotificarLlegada" tabindex="-1" aria-labelledby="modalNotificarLlegadaLabel" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Detalle la orden:') }}</h5>
                <div class="row gx-2 justify-content-between align-items-center">
                    <ul class="list-group border-0 p-0" id="listaPrestaciones">
                    </ul>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto btn-print-notificar-llegada fs-4" data-bs-dismiss="modal">Aceptar</button>
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
                    <img class="w-100 logo" src="{{ asset('assets/img/veris-large.png') }}" alt="">
                </div>
                <div class="col-12 col-sm-8 col-md-7 d-flex justify-content-end align-items-center d-none d-md-block text-end">
                    <div class="time-box badge bg-veris-dark text-center p-3 rounded-8">
                        <span class="fs-4">Fecha:</span><span class="ms-1 fs-4 text-veris-light" id="fecha"></span>
                        <span class="fs-4 ms-5">Hora:</span><span class="ms-1 fs-4 text-veris-light" id="hora"></span>
                    </div>
                </div>
                <div class="col-4 col-sm-2 col-md-2">
                    <a href="#" class="btn btn-salir border-veris-1 rounded-8 text-veris w-100 p-2 d-flex justify-content-center align-items-center h-100 fw-bold">
                        <img class="me-2" src="{{ asset('assets/img/exit-icon.svg') }}" alt="">Salir
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content p-3">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div id="sidebar" class="col-12 col-md-3 mb-3 mb-md-0 bg-silver sidebar-expanded h-100 overflow-auto"> <!-- Sidebar content here -->
                    <div id="toggle-sidebar" class="header-sidebar cursor-pointer w-100 d-flex justify-content-between align-items-center py-3 title-servicio position-relative">
                        <img class="me-2" src="{{ asset('assets/img/circulo-familiar.svg') }}" alt="">
                        <h4 class="mb-0 me-2 d-none d-md-block">Circulo Familiar</h4>
                        <p class="name-selected-sidebar d-block d-md-none m-0 text-veris fw-medium fs-3 mx-2"></p>
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
                            {{-- <div id="hiddenContent" class="d-none" style="width: 300px;">
                                <img class="w-50 logo my-3" src="{{ asset('assets/img/veris-large.png') }}" alt="">
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
                            </div> --}}
                            <div id="btnPrint" class="btn bg-veris d-none d-md-block text-white p-2 px-5 fs-5 fw-bold rounded-8 mt-3 mt-md-0">Generar turno</div>
                            <div id="btn-redirect-turno" url-rel="/turno/{{ $portalToken }}" class="btn d-blocl d-md-none bg-veris text-white p-2 px-5 fs-5 fw-bold rounded-8 mt-3 mt-md-0">Generar turno</div>
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
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    let dataServicios;
    let groupedData = [];

    setInterval(actualizarFechaHora, 1000);

    let local = localStorage.getItem('turno-{{ $portalToken }}');
    let dataTurno = JSON.parse(local);

    $('.btn-salir').attr('href',`/ingreso/${ dataTurno.mac }`);

    $(document).ready(async function() {

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
                    $('#toggle-sidebar h4').addClass('d-none')
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
                    $('#toggle-sidebar h4').removeClass('d-none');
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

        $('body').on('click', '#btnPrint', async function(){
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
            console.log(detalle)
            await notificarLlegada(detalle);
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

    async function mostrarPrestaciones(detalle){
        let elem = ``;
        $.each(detalle, function(key,value){
            //let class_estado_prestacion = (value.)
            elem += `<li class="list-group-item bg-white border-0 mb-1 py-0 fs-16 line-height-16 d-flex justify-content-between align-items-center">
                ${ value.nombreServicio }
                <span class="badge bg-warning badge-pill">
                    <i class="fa-solid fa-exclamation text-white"></i>
                </span>
                </li>`
        })
        $('#listaPrestaciones').html(elem);
    }

    async function notificarLlegada(detalle){
        //
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
    function isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    async function drawListFamiliares(){
        let elem = ``;
        elem += `<div data-rel='${JSON.stringify(dataTurno.paciente)}' class="item-coincidencia item-coincidencia-selected rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
            <div class="letter-name border-veris-1 mx-2 bg-white">${ dataTurno.paciente.nombreCompleto.charAt(0) }</div>
                <span class="flex-grow-1 name-familiar text-start text-md-center">${ dataTurno.paciente.nombreCompleto }</span>
        </div>`;

        $('.name-selected-sidebar').html(`${dataTurno.paciente.primerNombre} ${dataTurno.paciente.primerApellido}`);

        $.each(dataTurno.paciente.lsGrupoFamiliar, function(key, value){
            elem += `<div data-rel='${JSON.stringify(value)}' class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium d-flex justify-content-between align-items-center fs-16">
                <div class="letter-name border-veris-1 mx-2 bg-white">${ value.nombreCompleto.charAt(0) }</div>
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
        console.log(data);
        $('#list-servicios').empty();
        if(data.code == 200){
            dataServicios = data.data;
            if(data.data.length > 0){
                groupedData = [];
                await agruparDatos();
                await drawServicioAgrupado(data.data);
            }else{
                $('#list-servicios').html(`Sin servicios que mostrar`);
            }
        }else{
            $('#mensajeError').html(`${data.message}`)
            $('#modalAlerta').modal('show');
        }

        if(isMobile()){
            hideListFamiliares()
        }
    }

    function hideListFamiliares(){
        $('#list-familiares').addClass('d-none');
        $('#sidebar').addClass('sidebar-collapsed');
        $('#sidebar').removeClass('sidebar-expanded');
        $('.arrow-ico').addClass('rotate-arrow');
    }

    async function drawServicioAgrupado(){
        let elem = ``;
        $.each(groupedData, function(key, value){
            if(value.tipoServicio != "BATERIA_PRESTACIONES" && value.tipoServicio != "PAQUETES_PROMOCIONALES"){
                elem += `<h3>${ value.tipoServicio }</h3>`;
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
            }
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
                    slidesPerView: 1.1,
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
                    slidesPerView: 1.2,
                    // spaceBetween: 8,
                },
            },
        });
        iniciarCountdownDesdeAtributos();
    }

    function sectionStatusPago(detalle){
        if(!tieneTiempo(detalle.horaInicio)){
            return `<span class="badge d-flex align-items-center bg-perdida text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ asset('assets/img/icon-cita-perdida.svg') }}" alt="">
                No asistió a tiempo
            </span>`;
        }
        if(detalle.estaPagado){
            return `<span class="badge d-flex align-items-center bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ asset('assets/img/icon-pagada.svg') }}" alt="">
                Pagada
            </span>`;
        }else{
            return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ asset('assets/img/icon-pendiente.svg') }}" alt="">
                Por pagar
            </span>`;
        }
    }

    function verificarEstadoOrden(value){
        var estaPagada = false
        $.each(value.detallesOrden, function(k,v) {
            if(v.estaFacturado){
                estaPagada = true;
            }
        });
        return estaPagada;
    }

    function sectionStatusPagoOrdenes(detalle){
        let estaPagado = verificarEstadoOrden(detalle)

        if(estaPagado){
            return `<span class="badge d-flex align-items-center bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ asset('assets/img/icon-pagada.svg') }}" alt="">
                Pagada
            </span>
            <button data-rel='${ JSON.stringify(detalle.detallesOrden) }' class="btn badge bg-veris btn-notificar-llegada text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2">Notificar llegada</button>`;
        }else{
            return `<span class="badge d-flex align-items-center bg-pendiente-light text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                <img class="me-1" src="{{ asset('assets/img/icon-pendiente.svg') }}" alt="">
                Por pagar
            </span>`;
        }
    }

    function mostrarMetodosPago(detalle){
        if(detalle.estaPagado){
            return ``;
        }
        const countdownId = `countdown-${Math.random().toString(36).substring(2, 9)}`;
        return `<div class="row g-0 rounded-8 mt-2 bg-veris-sky p-3 px-2 fs-5">
            <div class="col-8 offset-2 text-center fs-5 fw-bold ">
                <div class="w-100 border-veris-1 rounded-8 mb-3 bg-white py-2">
                    <span class="text-veris fw-bold py-2 text-center">TIEMPO PARA PAGAR:</span> <span id="${countdownId}" class="countdown" data-rel='${detalle.horaInicio}'></span>
                </div>
            </div>
            <div class="col-12 d-block d-md-flex justify-content-center align-items-center gap-2">
                <span class="text-veris fw-medium -dark me-2 p-2 my-2 text-end">Método de pago</span>
                <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 me-2 my-2">Pagar en caja</button>
                <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2">Link de pago</button>
            </div>
        </div>`;
    }

    function mostrarMetodosPagoOrden(detalle){
        return `<div class="row g-0 rounded-8 mt-2 bg-veris-sky p-3 px-2 fs-5">
            <div class="col-12 d-block d-md-flex justify-content-center align-items-center gap-2">
                <span class="text-veris fw-medium -dark me-2 p-2 my-2 text-end">Método de pago</span>
                <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 me-2 my-2">Pagar en caja</button>
                <button class="btn badge bg-veris text-white px-2 px-md-4 py-3 fs-6 rounded-8 border-0 my-2">Link de pago</button>
            </div>
        </div>`;
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
                    <!--img src="{{ asset('assets/img/marker.svg') }}"-->
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

    function obtenerBeneficio(beneficio){
        if(beneficio  == null){
            return ``;
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
            console.log(99)
            classBorderPerdida = "border-perdida";
        }
        if(value.tipoServicio == "ORDEN_MEDICA"){
            var ordenPagada = verificarEstadoOrden(value);
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
                elem += `<div class="row d-flex align-items-center mb-3">
                    <div class="col-12 col-md-7">
                        <h4 class="fw-bold title-servicio text-capitalize position-relative">
                            ${value.nombreServicioNivel1.toLowerCase()}
                            <span class="text-veris fw-medium "> agendada</span>
                        </h4>
                    </div>
                    <div class="col-12 col-md-5 mt-2 mt-md-0 d-flex flex-column align-items-start align-items-md-end">
                        ${ sectionStatusPagoOrdenes(value) }
                    </div>
                </div>`;
                if(!ordenPagada){
                    elem += `${ mostrarMetodosPagoOrden(value) }`;
                }
                elem += `<div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                    <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                        <div class="avatar-doctor border-veris-1 ${classBorderPerdida}" style="background: url(${ (value.fotoMedicoApp != null) ? value.fotoMedicoApp : `https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg` }) no-repeat top center;background-size: cover;">
                        </div>
                        <div class="info-doctor ms-2 flex-grow-1">
                            <p class="mb-1">Doctor</p>
                            <p class="mb-1 fw-medium">${value.doctorAtencion}</p>
                            <p class="mb-1"><span class="text-veris fw-medium me-2">Beneficio:</span> ${obtenerBeneficio(value.beneficio)}</p>
                        </div>
                    </div>
                </div>`;
            break;
            case 'ORDENES_APOYO_PENDIENTE':
                elem += `<div class="row d-flex align-items-center">
                    <div class="col-12 col-md-7">
                        <h4 class="fw-bold title-servicio position-relative">
                            Laboratorio 
                            <span class="text-veris fw-medium ">clínico</span>
                        </h4>
                    </div>
                    <div class="col-12 col-md-5 d-flex flex-column align-items-start align-items-md-end">
                        <span class="badge bg-pagada text-veris-dark px-2 px-md-4 py-2 fs-6 rounded-8">
                            <img class="me-1" src="{{ asset('assets/img/icon-pagada.svg') }}" alt="">
                            Pagada
                        </span>
                        <button data-rel='${ JSON.stringify(value.detallesOrden) }' class="btn badge bg-veris btn-notificar-llegada text-white px-2 px-md-4 py-2 fs-6 rounded-8 border-0 d-block mt-2">Notificar llegada</button>
                    </div>
                </div>
                <div class="row d-flex justify-content-between align-items-center mt-2 p-3 px-2 fs-5">
                    <div class="col-12 col-md-6 d-flex justify-content-between align-items-center mb-3">
                        <div class="avatar-doctor border-veris-1" style="background: url(images/doctor.png) no-repeat top center;background-size: cover;">
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
                            <img class="qr-orden" src="images/qr.svg" alt="">
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
                                <img src="images/marker.svg">
                            </p>
                            <p class="mb-1"><span class="text-veris fw-medium ">Centro:</span> Veris Kennedy</p>
                        </div>
                    </div>
                </div>`;
            break;
            case 'BATERIA_PRESTACIONES':
                elem += `<div class="row d-flex align-items-center">
                    <div class="col-7">
                        <h4 class="fw-bold title-servicio position-relative">
                            ${ value.nombreServicioNivel1 }
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
                        <div class="avatar-doctor border-veris-1" style="background: url(${ (value.fotoMedicoApp != null) ? value.fotoMedicoApp : `https://dikg1979lm6fy.cloudfront.net/fotosMedicos/dummydoc.jpg` }) no-repeat top center;background-size: cover;">
                        </div>
                        <div class="info-doctor ms-2 flex-grow-1">
                            <p class="mb-1">Doctor</p>
                            <p class="mb-1">${value.doctorAtencion}</p>
                            <p class="mb-1 text-veris fw-medium">Dermatología</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="info-doctor ms-2">
                            <p class="mb-1"><span class="text-veris fw-medium ">Fecha:</span> 11:00 - 18/10/2024</p>
                            <p class="mb-1"><span class="text-veris fw-medium ">Beneficio:</span> Salud S.A. N-4-C Plan Ideal 4 Costa</p>
                        </div>
                    </div>
                </div>`;
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
        console.log(data);
        if(data.code == 200){
            
        }else{
            $('#mensajeError').html(`${data.message}`)
            $('#modalAlerta').modal('show');
        }
    }
</script>
<style>
    .name-selected-sidebar{
        line-height: 22px;
    }
    #listaPrestaciones {
        height: 300px;
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
    ::-webkit-scrollbar {
      height: 10px;
      width: 10px;
    }
    ::-webkit-scrollbar-track {
      border-radius: 5px;
      background-color: #DFE9EB;
    }

    ::-webkit-scrollbar-track:hover {
      background-color: #D5DEE0;
    }

    ::-webkit-scrollbar-track:active {
      background-color: #D5DEE0;
    }

    ::-webkit-scrollbar-thumb {
      border-radius: 5px;
      background-color: #0071CE;
    }

    ::-webkit-scrollbar-thumb:hover {
      background-color: #19408F;
    }

    ::-webkit-scrollbar-thumb:active {
      background-color: #19408F;
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
@extends('template.app-template')
@section('title')
Mi Veris - Citas - Datos de facturación
@endsection
@section('content')

<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-app.css?v=1.0.3')}}">

@include('template.header_agendamiento', ['showInfo' => true])


{{-- Modal de pago Qr --}}
<div class="modal fade mt-4" id="modalPagoQr" tabindex="-1" aria-labelledby="modalPagoQrLabel">
    <div class="modal-dialog modal modal-xxl modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="detallePago">
                <h5 class="fs--20 line-height-24 mt-3 mb-3">{{ __('Pago en línea:') }}</h5>
                <ul class="nav nav-pills justify-content-between bg-white w-100 rounded-3 mb-3" id="pills-tab" role="tablist">
                    {{-- <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 px-8 px-md-5 d-flex justify-content-center align-items-center active" id="pills-email-tab" data-bs-toggle="pill" data-bs-target="#pills-email" type="button" role="tab" aria-controls="pills-email" aria-selected="true">
                            <i class="fa-regular fa-envelope icon-tab d-none d-md-inline-block me-2"></i>
                            Email                                
                        </button>
                    </li> --}}
                    <li class="nav-item flex-fill" role="presentation">
                        <button data-rel="N" class="nav-link w-100 px-8 px-md-5 d-flex justify-content-center align-items-center active" id="pills-qr-tab" data-bs-toggle="pill" data-bs-target="#pills-qr" type="button" role="tab" aria-controls="pills-qr" aria-selected="false">
                            <i class="fa-solid fa-qrcode me-2"></i>
                            Código QR
                        </button>
                    </li>
                </ul>
                <div class="tab-content bg-transparent w-100 pt-2" id="pills-tabContent">
                    {{-- <div class="tab-pane fade mt-3 px-2 w-100 show active text-center" id="pills-email" role="tabpanel" aria-labelledby="pills-email-tab" tabindex="0">
                        <input autofocus autocomplete="off" id="email_link_pago" type="text" class="w-100 keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1" data-kioskboard-specialcharacters="true">
                        <div type="button" class="btn bg-veris-dark btn-enviar-mail text-white mx-auto mb-5 rounded-8 my-5 fs-20">
                            ENVIAR LINK DE PAGO
                            <i class="fa-regular fa-paper-plane ms-2 text-white"></i>
                        </div>
                    </div> --}}
                    <div class="tab-pane fade mt-3 px-2 w-100 show active text-center" id="pills-qr" role="tabpanel" aria-labelledby="pills-qr-tab" tabindex="0">
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

{{-- Modal Confirmar Pago --}}
<div class="modal modal-top fade" id="modalPagoRealizado" aria-labelledby="modalPagoRealizadoLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-xxl modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-start">Pago realizado</h5>
                <div class="box-info-comprobante d-flex justify-content-center align-items-center fw-bold text-dark fs-25 bg-silver-light py-2 rounded-8 my-2">
                    Comprobante: <span></span>
                </div>
                <img src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/svg/pago-realizado.svg" id="confimar-pago-icon" alt="">
                {{-- <h3 class="fw-medium text-veris-dark">¿Deseas consultar algo más?</h3> --}}
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                {{-- <a href="#" class="btn fw-normal bg-veris text-white fs--16 badge bg-veris-dark px-4 py-2 mx-2 fs-4 btn-salir">No</a> --}}
                <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white px-4 py-2 mx-2 fs-4 btn-salir text-veris border-veris-1">Salir</a>
            </div>
        </form>
    </div>
</div>

{{-- Modal de datos de facturación --}}
<div class="modal modal-top fade" id="modalDatosFacturacion" tabindex="-1" aria-labelledby="modalDatosFacturacionLabel" data-bs-backdrop="static" data-bs-keyboard="true">
    {{-- <div class="modal-dialog modal modal-lg modal-dialog-centered mx-auto"> --}}
    <div class="modal-dialog modal-lg modal-dialog-top modal-dialog-scrollable mx-auto">
        <form class="modal-content rounded-8 mt-5">
            <div class="modal-header">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center">Datos de Facturación</h5
                >
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row box-datos-factura">
                    <div class="col-6 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="codigoTipoIdentificacion">Tipo de documento</label>
                        <select class="form-select p-1 rounded-8 fs-25 text-start" name="codigoTipoIdentificacion" id="codigoTipoIdentificacion">
                            <option value="2">Cédula</option>
                            <option value="1">Ruc</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="numeroIdentificacion">Número de documento</label>
                        <input autocomplete="off" class="form-control w-100 keyboard-input virtual-keyboard-numpad p-1 rounded-8 text-start fs-25 onlyNumber" type="number" name="numeroIdentificacion" id="numeroIdentificacion" data-kioskboard-type="numpad">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="nombreCompleto">Nombre completo</label>
                        <input autocomplete="off" class="form-control w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-start fs-25 mb-2" type="text" name="nombreCompleto" id="nombreCompleto">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-20 text-silver-dark" for="email">Correo electrónico</label>
                        <input autocomplete="off" class="form-control w-100 onlyLetters text-lowercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-start fs-25 mb-2" type="email" name="email" id="email" data-kioskboard-specialcharacters="true"/>
                    </div>
                    {{-- <div class="col-12 mb-3">
                        <p class="text-center my-2 valorPago fs-40 fw-bold text-veris"></p>
                    </div> --}}
                </div>
                <div class="row box-datos-factura box-detalles-pago px-2 mb-3">
                    <h5 class="fs--20 line-height-24 mb-3 text-start">Detalles</h5>
                    <div class="px-2">
                        <table class="card-body w-100">
                            <thead>
                                <tr class="border-bottom sticky-top bg-white">
                                    <th class="fw-medium fs--2">Prestación</th>
                                    <th class="fw-medium text-center fs--2">P.V.P.</th>
                                    <th class="fw-medium text-center fs--2">Crédito/convenio</th>
                                    <th class="fw-medium text-center fs--2">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="listadoPrestacionesPago">
                            </tbody>
                        </table>
                        </div>
                </div>
                <div class="row box-datos-factura">
                    <div class="col-10 mx-auto" id="contentDetalleCita">
                        <ul class="list-group fs--1 border-0 bg-neutral rounded-8 pt-2 pb-2">
                            <li class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center py-0 px-2 fw-medium fs-25">
                                Detalle de factura
                            </li>
                            <li class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center fs-25 py-0 px-2">
                                Subtotal
                                <span class="badge text-dark fw-normal fs-25 p-0" id="subtotal"></span>
                            </li>
                            <li class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center fs-25 py-0 px-2">
                                Crédito/convenio
                                <span class="badge text-dark fw-normal fs-25 p-0" id="creditoConvenio"></span>
                            </li>
                            <li class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center fs-25 py-0 px-2">
                                Descuento aplicado
                                <span class="badge text-dark fw-normal fs-25 p-0" id="descuentoAplicado"></span>
                            </li>
                            <li class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center fs-25 py-0 px-2">
                                IVA
                                <span class="badge text-dark fw-normal fs-25 p-0" id="iva"></span>
                            </li>
                            <li class="list-group-item border-0 bg-transparent d-flex justify-content-between align-items-center fs-25 py-0 px-2 fw-medium">
                                Total
                                <span class="badge text-dark fw-bold fs-25 p-0" id="total"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row box-load-pago d-none">
                    <div class="col-12 mb-3 text-center">
                        <img class="w-75 mx-auto" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/payment.svg" alt="">
                    </div>
                    <div class="col-12 my-5 fs-40 line-height-40 text-center fw-bold text-veris-dark">
                        Inserta o desliza la tarjeta
                    </div>
                </div>
                <div class="row box-datos-factura">
                    <div class="col-12 text-center mt-4">
                        <div class="form-check d-flex justify-content-md-center align-items-center">
                            <input class="form-check-input terminos-input me-2 mb-1 width-24 shadow" type="checkbox" value="" id="checkTerminosCondicion" required>
                            <label class="form-check-label fs-20 fw-medium line-height-20" for="checkTerminosCondicion">
                                Acepto los <span data-bs-toggle="modal" data-bs-target="#modalTerminosCondiciones" class="">términos y condiciones</span> 
                                <span id="politicas" class="d-none">y <a href="https://www.veris.com.ec/politicas/" target="_blank">Política de protección de Datos Personales</a></span> 
                            </label>
                            <div class="invalid-feedback">
                                Debes aceptar antes de continuar
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row box-datos-factura">
                    <div class="col-10 mx-auto mt-3">
                        <button type="button" class="btn bg-veris fs-25 line-height-25 text-white w-100 py-3 px-32 shadow-none d-flex justify-content-between align-items-center btn-disabled btn-continuar-factura rounded-8">Continuar</button>
                        <div class="row justify-content-center align-items-center d-none">
                            <div class="col-12 col-md-6">
                                <div type="button" id="btn-ver-examenes" class="bg-veris w-100 mx-auto mt-2 cursor-pointer justify-content-center align-items-center text-white p-2 rounded-8 d-none">
                                    <div class="text-center">
                                        Ver exámenes a pagar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- Modal de datos de voucher --}}
<div class="modal modal-top fade" id="modalDatosVoucher" tabindex="-1" aria-labelledby="modalDatosVoucherLabel" data-bs-backdrop="static" data-bs-keyboard="true">
    {{-- <div class="modal-dialog modal modal-dialog-centered mx-auto"> --}}
    <div class="modal-dialog modal-lg modal-dialog-top modal-dialog-scrollable mx-auto">
        <form class="modal-content rounded-8 mt-5">
            <div class="modal-header">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center">Datos de Voucher</h5
                >
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label fs-3 text-silver-dark" for="codigoTipoIdentificacionV">Tipo de documento</label>
                        <select class="form-select p-1 rounded-8 fs-2 text-start" name="codigoTipoIdentificacionV" id="codigoTipoIdentificacionV">
                            <option value="2">Cédula</option>
                            <option value="1">Ruc</option>
                            <option value="3">Pasaporte</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-3 text-silver-dark" for="numeroIdentificacionV">Número de documento</label>
                        <input autocomplete="off" class="form-control w-100 keyboard-input virtual-keyboard-numpad p-1 rounded-8 text-start fs-2 onlyNumber" type="number" name="numeroIdentificacionV" id="numeroIdentificacionV" data-kioskboard-type="numpad">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-3 text-silver-dark" for="nombreCompletoV">Nombre completo</label>
                        <input autocomplete="off" class="form-control w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-start fs-2 mb-2" type="text" name="nombreCompletoV" id="nombreCompletoV">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fs-3 text-silver-dark" for="emailV">Correo electrónico</label>
                        <input autocomplete="off" class="form-control w-100 onlyLetters text-lowercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-start fs-2 mb-2" type="email" name="emailV" id="emailV" data-kioskboard-specialcharacters="true"/>
                    </div>
                    <div class="col-4 mb-3">
                        <label class="form-label fs-3 text-silver-dark" for="codigoPaisCelular">Código País</label>
                        <select class="form-select p-1 rounded-8 fs-2 text-start" name="codigoPaisCelular" id="codigoPaisCelular">
                        </select>
                    </div>
                    <div class="col-8 mb-3">
                        <label class="form-label fs-3 text-silver-dark" for="telefonoV">Número Teléfono móvil</label>
                        <input autocomplete="off" class="form-control w-100 keyboard-input virtual-keyboard-numpad p-1 rounded-8 text-start fs-2 onlyNumber" type="text" name="telefonoV" id="telefonoV" data-kioskboard-type="numpad" placeholder="0999999999">
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-3 mx-2 fs-4 rounded-8 btn-continuar-voucher">Pagar</button>
                {{-- <button type="button" class="btn fw-normal text-white fs--16 badge bg-veris-dark px-4 py-2 mx-2 fs-4 btn-continuar-factura" data-bs-dismiss="modal">Continuar</button> --}}
            </div>
        </form>
    </div>
</div>
<section class="p-3 px-0 mb-3">
    <div class="row mx-0">
        @include('template.back')
        <div class="col-12 col-lg-4 d-flex justify-content-between align-items-center bg-veris sticky-top overflow-hidden">
            <h5 class="ps-3 text-white my-auto py-3 fs-40 line-height-48">{{ __('Escoge el método de pago') }}</h5>
        </div>
        <div class="col-12 col-lg-8 overflow-auto pt-3">
            <div class="flex-grow-1 container-p-y pt-0">
                <div class="row g-4 justify-content-center mt-5">
                    <div class="col-12 col-md-10 mb-4 ps-3 pe-3 mb-4 tarjeta-box d-none">
                        <div class="card shadow py-4 rounded-8 cursor-pointer btn-pagar">
                            <div class="card-body fs-40 line-height-48 text-center">
                                Tarjeta de débito o crédito
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-10 mb-4 ps-3 pe-3 mb-4 qr-box d-none" data-bs-toggle="modal" data-bs-target="#modalPagoQr">
                        <div class="card shadow py-4 rounded-8 cursor-pointer">
                            <div class="card-body fs-40 line-height-48 text-center">
                                Pago en línea
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-10 mb-4 ps-3 pe-3 mb-4">
                        <div class="card shadow py-4 rounded-8 cursor-pointer box-efectivo btn-turno" data-rel="">
                            <div class="card-body fs-40 line-height-48 text-center">
                                Efectivo (Pagar en caja)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/qrcode.js"></script>

<script>

    let globalTurno = localStorage.getItem('turno-{{ $params }}');
    localStorage.setItem('flujo','agendamiento');
    let dataTurno = JSON.parse(globalTurno);

    let datosPago = {};

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let estadoPoliticas;
    let ultimaVersionPoliticas;
    let clientesAuth = [5803, 13, 68, 10996, 7656];
    let esKiosko = false;

    document.addEventListener("DOMContentLoaded", async function () {
        if (localStorage.getItem('userKiosko') !== null) {
            esKiosko = true
        }
        if(!esKiosko){
            $('.qr-box').removeClass('d-none');
            await generarLinkQr()
        }else{
            $('.tarjeta-box').removeClass('d-none');
        }

        if(dataCita.convenio.permitePago == "N"){
            $('.btn-pagar').addClass('d-none');
        }

        await parametrosGenerales("{{ $mac }}", true);

        $('body').on('change', '#checkTerminosCondicion', function(){
            if($('#checkTerminosCondicion').is(':checked')) {
                $('.btn-continuar-factura').removeClass('btn-disabled');
            } else {
                $('.btn-continuar-factura').addClass('btn-disabled');
            }
        });


        $('body').on('click', '.btn-pagar', async function(){
            let detalle = fillBoxEfectivoData();
            // Inicializar pago
            await activarPrestacionesInicializar('PRESTACION', detalle)
        })

        $('body').on('click', '.btn-continuar-factura', async function(){
            let validacion = await validarDatosFactura();
            if(validacion){
                await setearDatosFactura();
            }
        })

        $('#modalPagoQr').on('hidden.bs.modal', async function (e) {
            // reiniciarConteo()
        });

        $("#modalPagoQr").on('shown.bs.modal', function () {
            // clearInterval(temporizadorInactividad)
        });
        
        $('body').on('click', '.btn-turno', async function(){
            let detalle = [];
            let crearPtx = false;
            // if (typeof $(this).attr("data-rel") === "undefined") {
            if($(this).attr("data-rel") !== undefined){
                crearPtx = true;
                detalle = fillBoxEfectivoData();
            }
            // console.log(detalle);return;
            await generarTurno(detalle, crearPtx);
        })

        $('#modalDatosFacturacion').on('hidden.bs.modal', async function (e) {
            // await cargarCodigosPaises()
            $('.box-datos-factura').removeClass('d-none')
            $('.box-load-pago').addClass('d-none')
        });

        $('#modalDatosFacturacion').on('shown.bs.modal', async function (e) {
            // clearInterval(temporizadorInactividad)
        });

        let timeoutId;

        $('body').on('input', '#numeroIdentificacion', function() {
            clearTimeout(timeoutId); // Limpia el timeout anterior
            
            timeoutId = setTimeout(async function() {
                console.log("verifica");
                let datosF = {
                    "numeroIdentificacion": $('#numeroIdentificacion').val(),
                    "codigoTipoIdentificacion": $('#codigoTipoIdentificacion option:selected').val()
                };
                if(parseInt($('#codigoTipoIdentificacion option:selected').val()) == 2){
                    if(esValidaCedula($('#numeroIdentificacion').val())){
                        await verificarDatosFactura(datosF);
                    }else{
                        toastr.warning("Cédula incorrecta", "Atención", {
                            timeOut: 5000
                        });
                        $('#nombreCompleto').val("");
                        $('#email').val("");
                    }
                }else{
                    if($('#numeroIdentificacion').val().length == 13){
                        await verificarDatosFactura(datosF);
                    }
                }
            }, 2000);
        });
    });

    async function generarLinkQr(){
        $('#qrcode').empty();
        $('#qrcode').qrcode({
            width: 200,
            height: 200,
            color: "#000",
            bgColor: "#FFF",
            text: dataCita.reserva.linkPago.kushki+`&esLinkDigiturno=true&macAddress={{ $mac }}`
        });
    }

    async function validarDatosFactura(){
        let msg = "";

        if($('#numeroIdentificacion').val() == ""){
            msg += "Debe ingresar un número de documento \n";
        }else{
            if(parseInt($('#codigoTipoIdentificacion option:selected').val()) == 2){
                if(!esValidaCedula($('#numeroIdentificacion').val())){
                    msg += "Debe ingresar una cédula válida \n";
                }
            }else{
                if($('#numeroIdentificacion').val().length != 13){
                    msg += "Debe ingresar un RUC válido \n";
                }
            }
        }

        if($('#nombreCompleto').val() == ""){
            msg += "Debe ingresar nombres completos \n";
        }

        if(!isValidEmailAddress($('#email').val())){
            msg += "Debe ingresar un email válido \n";
        }
        
        if(msg == ""){
            return true;
        }else{
            toastr.error(msg, 'Datos de Factura incorrectos', {
                timeOut: 8000
            });
            return false;
        }
    }

    function fillBoxEfectivoData(){
        // si viene el detall desde 
        if(dataTurno.hasOwnProperty("detalles")){
            return dataTurno.detalles;
        }
        let convenio = dataCita.convenio;
        if(dataCita.convenio.codigoConvenio == null || dataCita.convenio.codigoConvenio == "" ){
            dataCita.convenio = null;
        }

        let numeroOrden = null;
        let lineaDetalleOrden = null;

        if(dataTurno.hasOwnProperty("detalles")){
            numeroOrden = dataTurno.detalles.numeroOrden;
            lineaDetalleOrden = dataTurno.detalles.lineaDetalleOrden;
        }

        let detalle = {
            // "tipoServicio": "RESERVA",
            "beneficio": {
                "convenio": dataCita.convenio,
                /*temporalmente*/
                "tarjeta": null,
                "paquete": null
            },
            "codigoReserva": dataCita.reserva.codigoReserva,
            "numeroOrden": numeroOrden,
            "lineaDetalleOrden": lineaDetalleOrden
        };

        return detalle;

    }

    async function generarTurno(detalle, crearPtx = false){
        console.log(detalle);
        let url_adicional = ``;
        
        // if(detalle != []){
        if (crearPtx) {
            let pre_trx = await activarPrestacionesInicializar('TURNO',detalle);
            url_adicional += `&idPreTransaccion=${pre_trx}`
        }

        // let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let paciente = dataCita.paciente;
        let nombreCompleto = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
        let tipoIdentificacion = (parseInt(paciente.tipoIdentificacion) == 2) ? 'CEDULA' : 'PASAPORTE';
        let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/generar_ticket?macAddress={{ $mac }}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${paciente.numeroIdentificacion}&nombreCompleto=${ nombreCompleto }${url_adicional}`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["sendHeaders"] = "true";
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
                printTurnoAPI(data.data)
                // if(dataTurno.mac == "00-22-4D-7B-2A-F5"){
                //     printTurno(data.data)
                // }else{
                //     printTurnoAPI(data.data)
                // }
            }else{
                setTimeout(async function(){
                    await generateImg()
                },500)
            }
        }else{
            $('#mensajeError').html(`${data.message}`)
            $('#modalAlerta').modal('show');
        }
    }

    async function activarPrestacionesInicializar(origen = 'CHEQUEO', detalle = null){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/inicializar?codigoEmpresa=1&tipoPreTransaccion=FACTURA`;
        let payload = {
            "secuenciaUsuario": dataParametrosGenerales.secuenciaUsuario,
            "idTurno": null,
            "caja": dataParametrosGenerales.caja,
            "nemonicoCanalFacturacion": "CAJA",
            "esFarmaciaDomicilio": false,
            "codigoSolicitudServDomicilio": null,
            "numSolicitudLabDomicilio": null,
            "esDigiturno": true
        }
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        if(data.code == 200){
            let idPreTransaccion = data.data.idPreTransaccion
            if(origen == "CHEQUEO"){
                await agregarItemChequeo(idPreTransaccion);
            }else if(origen == "PRESTACION"){
                datosPago = {};
                datosPago.detalle = detalle;
                datosPago.inicializar = data.data;
                await agregarItemTurno(idPreTransaccion, detalle, "PRESTACION");
            }else{
                await agregarItemTurno(idPreTransaccion, detalle, "TURNO");
                return idPreTransaccion;
            }
        }
    }

    let flagAutorizacion = false;
    async function agregarItemTurno(idPreTransaccion, detalle, origen = "TURNO"){
        // let dataAttr = $('.item-coincidencia-selected').attr("data-rel");
        let paciente = dataTurno.paciente;

        console.log(detalle);

        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${idPreTransaccion}/agregar_item?codigoEmpresa=1&idPreTransaccion=${idPreTransaccion}`;

        let item = [];

        let payload = {
            "idPaciente": dataCita.paciente.numeroPaciente,
        }

        payload.reservas = [{
            "_id": generateUUIDv4(),
            "beneficio": {
                "convenio": (detalle.beneficio != null && detalle.beneficio.convenio != null) ? detalle.beneficio.convenio : null,
                "secuenciaTarjetaPaciente": (detalle.beneficio != null && detalle.beneficio.tarjeta != null) ? detalle.beneficio.tarjeta.secuenciaTarjetaXPaciente : null,
                "secuenciaPaquetePaciente": (detalle.beneficio != null && detalle.beneficio.paquete != null)? detalle.beneficio.paquete.secuenciaPaquetePaciente : null
            },
            "codigoReserva": detalle.codigoReserva,
            "numeroOrden": detalle.numeroOrden,
            "lineaDetalleOrden": detalle.lineaDetalleOrden
        }]

        args["method"] = "PUT";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        if(data.code == 200){
            if(origen == "TURNO"){
                return data.data;
            }else{
                datosPago.idPreTransaccion = idPreTransaccion;
                datosPago.items = data.data;
                if(detalle.beneficio !== null && detalle.beneficio.convenio !== null){
                    if(dataCita.origen === undefined){
                        await setearDiagnostico();
                    }
                }
                if(dataCita.convenio != null){
                    if(clientesAuth.includes(dataCita.convenio.codigoCliente) && dataCita.convenio.requiereAutorizacionFacturacion){
                        await obtenerAutorizacion();
                        flagAutorizacion = true;
                    }
                }
                await consultaPreTrx(idPreTransaccion, data.data);
            }
        }
    }

    async function obtenerAutorizacion(){
        let secuenciaAfiliadoConvenio = dataCita.convenio.secuenciaAfiliado;
        console.log(secuenciaAfiliadoConvenio);
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/sync-convenios/v1/validacion_aseguradora/sync/autorizacion?canalInvocacion=CAJ&lineaNegocio=CMV&secuenciaAfiliado=${ secuenciaAfiliadoConvenio }`;
        args["method"] = "POST";    
        args["token"] = accessToken;
        args["sendHeaders"] = "true";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({

        });
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            datosPago.sync = data.data
            await setearAutorizacion();
        }else{
            toastr.error("", data.message, {
                timeOut: 5000
            });
        }
    }

    async function setearAutorizacion(){
        let idAgrupacion = await getIdAgrupacionArray();
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${ datosPago.idPreTransaccion }/setear_autorizacion_aseguradora?codigoEmpresa=1`;
        args["method"] = "PUT";
        args["token"] = accessToken;
        args["sendHeaders"] = "true";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "idAgrupacion": idAgrupacion[0],
            // "_id": "string",
            "esAutorizacionAutomatica": true,
            "secuenciaLogWs": datosPago.sync.secuenciaLogSincronizacion,
            "numeroAutorizacion": datosPago.sync.autorizacionAseguradora
        });
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            datosPago.setearAutorizacion = data.data
        }else{
            toastr.error("", data.message, {
                timeOut: 5000
            });
        }
    }

    async function consultaPreTrx(idPreTransaccion, detalle){        
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${idPreTransaccion}/consulta?codigoEmpresa=1`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(detalle);
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            datosPago.consulta = data.data;
            if(!flagAutorizacion){
                if(datosPago.consulta[0].agrupaciones[0].requiereAutorizacionEmpresa){
                    flagAutorizacion = true;
                    await obtenerAutorizacion();
                    await consultaPreTrx(idPreTransaccion, detalle);
                    return;
                }
            }
            await verificarDatosFactura();
            $('.valorPago').html(`$${parseFloat(datosPago.consulta[0].agrupaciones[0].totalAgrupacion.paciente.valorTotal).toFixed(2)}`);
            // $('.btn-continuar-factura').html(`Pagar $${parseFloat(datosPago.consulta[0].agrupaciones[0].totalAgrupacion.paciente.valorTotal).toFixed(2)}`)
            $('.btn-continuar-factura').html(`<span class="col-5 shadow-none">Continuar</span>
                            |
                <span class="col-5 mb-0 shadow-none cursor-inherit">$${parseFloat(datosPago.consulta[0].agrupaciones[0].totalAgrupacion.paciente.valorTotal).toFixed(2)}</span>`);
            // clearTimeout(temporizadorInactividad);
            // clearInterval(temporizadorInactividad)
            mostrarDetallesFactura();
            $('#modalDatosFacturacion').modal("show");
            // await validacionPrevioPago()
        }
    }

    async function mostrarDetallesFactura(){
        // $('.box-detalles-pago').addClass('d-none');
        let valor_empresa = datosPago.consulta[0].agrupaciones[0].totalAgrupacion.empresa;
        let valor_paciente = datosPago.consulta[0].agrupaciones[0].totalAgrupacion.paciente;
        let subtotal = valor_empresa.subtotal + valor_paciente.subtotal;
        let creditoConvenio = valor_empresa.valorTotal;
        let descuentoAplicado = valor_empresa.valorDescuento + valor_empresa.valorDescuento;
        let iva = valor_empresa.valorIva + valor_empresa.valorIva;
        let total = valor_paciente.valorTotal;

        $('#subtotal').html(`$${subtotal.toFixed(2)}`);
        $('#creditoConvenio').html(`-$${creditoConvenio.toFixed(2)}`);
        $('#descuentoAplicado').html(`-$${descuentoAplicado.toFixed(2)}`);
        $('#iva').html(`+$${iva.toFixed(2)}`);
        $('#total').html(`$${total.toFixed(2)}`);
        // $('#totalLabel').html(`$${dataCita.facturacion.totales.total.toFixed(2)}`);

        // if(datosPago.detalle.tipoServicio == "ORDEN_MEDICA" && datosPago.detalle.nombreServicioNivel1 == "LABORATORIO"){
        //     $('#btn-ver-examenes').removeClass('d-none');
            let elem = ``
            $.each(datosPago.consulta[0].agrupaciones[0].detallesAgrupacion, function(key, value){
                let classBorder = `border-bottom`;
                if(value.mensajeCobertura !== null && value.mensajeCobertura != ""){
                    classBorder = `border-top border-bottom-0`
                }
                elem += `<tr class="${classBorder}">
                        <td class="fs--2 text-capitalize">${value.nombrePrestacion.toLowerCase()}</td>
                        <td class="fs--2 text-center">$${value.valoresPaciente.valorTotal.toFixed(2)}</td>
                        <td class="fs--2 text-center">$${value.valoresEmpresa.valorTotal.toFixed(2)}</td>
                        <td class="fs--2 text-center">$${value.valoresVenta.valorTotal.toFixed(2)}</td>
                    </tr>`;
                if(value.mensajeCobertura !== null && value.mensajeCobertura != ""){
                    elem += `<tr class="border-bottom border-top-0"><td colspan="4" class="fs-12 line-height-14 text-danger text-start">${value.mensajeCobertura}</td></tr>`
                }
            })
            $('#listadoPrestacionesPago').html(elem);
        // }
    }

    async function verificarDatosFactura(datos = null){
        let numeroIdentificacion = datosPago.consulta[0].paciente.numeroIdentificacion;
        let codigoTipoIdentificacion = datosPago.consulta[0].paciente.codigoTipoIdentificacion;
        if(datos !== null){
            numeroIdentificacion = datos.numeroIdentificacion;
            codigoTipoIdentificacion = datos.codigoTipoIdentificacion;
        }
        let args = [];
        args["endpoint"] = `${api_url_digitales}/facturacion/v1/pacientes/verificar_datos_factura?numeroIdentificacion=${numeroIdentificacion}&codigoTipoIdentificacion=${codigoTipoIdentificacion}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";

        args["sendHeaders"] = "true";
        const data = await call(args);
        console.log(data);

        if(data.code = 200){
            datosPago.infoFactura = data.data;
            $('#codigoTipoIdentificacion').val(datosPago.infoFactura.codigoTipoIdentificacion);
            $('#numeroIdentificacion').val(datosPago.infoFactura.numeroIdentificacion);
            $('#nombreCompleto').val(datosPago.infoFactura.nombreCompleto);
            $('#email').val(datosPago.infoFactura.mail);

            $('#codigoTipoIdentificacionV').val(datosPago.infoFactura.codigoTipoIdentificacion);
            $('#numeroIdentificacionV').val(datosPago.infoFactura.numeroIdentificacion);
            $('#nombreCompletoV').val(datosPago.infoFactura.nombreCompleto);
            $('#emailV').val(datosPago.infoFactura.mail);
        }
        return;
    }

    async function setearDiagnostico(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${datosPago.idPreTransaccion}/setear_diagnosticos?codigoEmpresa=1`;

        let item = [];

        let idAgrupacion = await getIdAgrupacionArray();
        let payload = {
            "idAgrupacion": idAgrupacion[0],
            "diagnosticos": [29616]
        }

        args["method"] = "PUT";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        if(data.code == 200){
            console.log(data);
        }else{
            alert(data.message);
        }
    }

    async function getIdAgrupacionArray(){
        let arr = [];
        $.each(datosPago.items, function(key, value){
            console.log(value.idAgrupacion);
            arr.push(value.idAgrupacion);
        })
        return arr;
    }

    async function setearDatosFactura(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${datosPago.idPreTransaccion}/setear_datos_factura?codigoEmpresa=1`;

        let item = [];

        let idAgrupacion = await getIdAgrupacionArray();
        let payload = {
            "codigoTipoIdentificacion": parseInt($('#codigoTipoIdentificacion option:selected').val()),
            "numeroIdentificacion": $('#numeroIdentificacion').val(),
            "nombreCompleto": $('#nombreCompleto').val(),
            "email": $('#email').val(),
            "idAgrupacion": idAgrupacion,
            "actualizarVirTransaccionEpago": false
        }

        args["method"] = "PUT";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            await validacionPrevioPago()
        }else{
            toastr.warning("", data.message, {
                timeOut: 5000
            });
        }
    }

    async function validacionPrevioPago(){        
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${datosPago.idPreTransaccion}/validacion_previo_pago?codigoEmpresa=1`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        let idAgrupacion = await getIdAgrupacionArray();
        args["data"] = JSON.stringify({
            "idAgrupacion": idAgrupacion
        });
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            datosPago.validacion = data.data;
            // $('#modalDatosFacturacion').modal("hide");
            // $('#modalDatosVoucher').modal("show");
            if(datosPago.validacion.valorTotalAPagarPaciente == 0){
                console.log(9999)
                await solicitarPagoPinPad();
            }else{
                $('.box-datos-factura').addClass('d-none')
                $('.box-load-pago').removeClass('d-none')
                await solicitarPagoPinPad();
            }
        }else{
            toastr.warning("", data.message, {
                timeOut: 5000
            });
        }
    }

    async function solicitarPagoPinPad(){
        if(datosPago.validacion.valorTotalAPagarPaciente == 0){
            await facturarCobroPinPad();
            return;
        }
        
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pin_pad/procesar_cobro?codigoEmpresa=1`;
        // args["endpoint"] =  `https://zq3hqnfr-3000.use2.devtunnels.ms/facturacion/v1/pin_pad/procesar_cobro?codigoEmpresa=1`;

        let telefonoMovil = $('#telefonoV').val();
        if(telefonoMovil.length == 10){
            telefonoMovil = telefonoMovil.substring(1);
        }

        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        let idAgrupacion = await getIdAgrupacionArray();
        args["data"] = JSON.stringify({
            "codigoMedioPago": 1,
            "codigoPlazoTarjeta": 1,
            "secuenciaDiferido": null,
            "valor": parseFloat(datosPago.validacion.valorTotalAPagarPaciente),
            "datosPersonaTarjeta": {
                "codigoTipoIdentificacion": parseInt($('#codigoTipoIdentificacion option:selected').val()),
                "numeroIdentificacion": $('#numeroIdentificacion').val(),
                "nombreCompleto": $('#nombreCompleto').val(),
                "email": $('#email').val(),
                "telefonoCelular": null,//telefonoMovil,
                "codigoPaisCelular": null,//parseInt($('#codigoPaisCelular option:selected').val())
            },
            "flujoConPreTransaccion": {
                "idPreTransaccion": datosPago.idPreTransaccion
            }
        });
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        console.log(data);
        clearInterval(temporizadorInactividad)
        if(data.code == 200){
            datosPago.cobro = data.data;
            $('#modalDatosVoucher').modal("hide");
            // await setearPago();
            await facturarCobroPinPad();
        }else{
            console.log("FALLO PAGO");
            //reiniciarConteo();
            toastr.warning("", data.message, {
                timeOut: 5000
            });
            $('.box-datos-factura').removeClass('d-none')
            $('.box-load-pago').addClass('d-none')
        }
    }

    async function setearPago(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${datosPago.idPreTransaccion}/setear_pagos?codigoEmpresa=1&accion=NEW`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        
        let tarjeta = datosPago.cobro.datosTarjeta;

        args["data"] = JSON.stringify({
            "formaPago": {
                // "efectivo": {
                //   "idPago": null,
                //   "valorEntregado": parseFloat(datosPago.validacion.valorTotalAPagarPaciente),
                //   "valorCambio": 0.00
                // },
                "tarjeta": [{
                    "idPago": 1,
                    "valorEntregado": tarjeta.valor,
                    "nombre": tarjeta.nombre,
                    "numeroTarjeta": tarjeta.numeroTarjeta,
                    "numeroLote": tarjeta.numeroLote,
                    "mesAnioCaducidad": tarjeta.mesAnioCaducidad,
                    "numeroReferencia": tarjeta.numeroReferencia,
                    "numeroAprobacion": tarjeta.numeroAprobacion,
                    "codigoMarcaTc": tarjeta.codigoMarcaTc,
                    "codigoTipoTarjeta": tarjeta.codigoTipoTarjeta,
                    "codigoInstBancoEmisor": tarjeta.codigoInstBancoEmisor,
                    "codigoInstBancoLiquidador": tarjeta.codigoInstBancoLiquidador,
                    "codigoMedioPago": tarjeta.codigoMedioPago,
                    "codigoPlazoTarjeta": tarjeta.codigoPlazoTarjeta,
                    "aplicaInteres": tarjeta.aplicaInteres,
                    "secuenciadDocumentoVoucher": datosPago.cobro.secuenciaDocumentoVoucher,
                    "codigoMotivoManual": null,
                    "secuenciaTramaPOS": null,
                    "secuenciaDiferido": null,
                    "codigoEpago": null,
                    "fechaSolicitudEpago": "dd/mm/yyyy hh24:mi:ss",
                    "metadataEpago": {
                        "codigoIngresoVap": null,
                        "codigoSolicitudServDomicilio": null
                    }
                }]
            }
        });
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        console.log(data);
        //reiniciarConteo();
        if(data.code == 200){
            datosPago.setearPago = data.data;
            await facturarCobroPinPad();
        }else{
            toastr.warning("", data.message, {
                timeOut: 5000
            });
        }
    }

    async function facturarCobroPinPad(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pre_transacciones/${datosPago.idPreTransaccion}/facturar?codigoEmpresa=1&idPreTransaccion=${datosPago.idPreTransaccion}`;
        let idAgrupacion = await getIdAgrupacionArray();
        let payload = {
            "idAgrupacion": idAgrupacion
        }
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(payload);
        args["bodyType"] = "json";
        args["sendHeaders"] = "true";
        const data = await call(args);
        $('.box-datos-factura').removeClass('d-none')
        $('.box-load-pago').addClass('d-none')
        // reiniciarConteo();
        if(data.code == 200){
            datosPago.comprobantes = data.data;
            // Imprimir ticket
            $('#modalDatosFacturacion').modal('hide');
            // await cargarServicios();
            // alert("Pago realizado exitosamente, se imprimirá su factura...")
            
            if(datosPago.validacion.valorTotalAPagarPaciente == 0){
                $('.box-info-comprobante').html(`Transacción: <span class="ms-2"> ${datosPago.comprobantes.transacciones[0].numeroTransaccion}</span>`)
            }else{
                $('.box-info-comprobante').html(`Comprobante: <span class="ms-2"> ${datosPago.comprobantes.transacciones[0].numeroComprobante}</span>`)
            }
            $('#modalPagoRealizado').modal('show');
            await printFactura()
            /*
            {
                "code": 200,
                "success": true,
                "message": "Ok",
                "data": {
                    "transacciones": [
                        {
                            "numeroComprobante": "003-100-001641478",
                            "numeroTransaccion": 21479144,
                            "numeroOrden": 35809021,
                            "secuenciaComprobante": 25302954
                        }
                    ]
                }
            }
            */
            // $('#modalDatosPagoExitoso').modal('show');
        }else{
            reiniciarConteo();
        }
    }

    //obtener las politicas
    async function obtenerPPD(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/politicas/usuarios/${dataCita.paciente.numeroIdentificacion}/?codigoEmpresa=1&plataforma=WEB&version=7.0.1`;
        args["method"] = "GET";
        args["showLoader"] = true;

        const data = await call(args);
        console.log('data',data.code);
        if(data.code == 200){
            ultimaVersionPoliticas = data.data.ultimaVersionPoliticas;
            estadoPoliticas = data.data.estadoPoliticas;
            if(estadoPoliticas == "N"){
                $('#politicas').removeClass('d-none');
            }
        }
        return data;
    }

    //aceptar politicas
    async function aceptarPoliticas(){
        
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/politicas/usuarios/${dataCita.paciente.numeroIdentificacion}`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        args["data"] = JSON.stringify({
            
            "aceptaPoliticas": true,
            "versionPoliticas": ultimaVersionPoliticas,
            "codigoEmpresa": 1,
            "plataforma": "WEB",
            "versionPlataforma": "7.0.1",
            "identificacion": dataCita.paciente.numeroIdentificacion,
            "tipoIdentificacion": dataCita.paciente.tipoIdentificacion,
            "tipoEvento": "CR",
            "canalOrigen": _canalOrigen

        });
        const data = await call(args);
        
        return data;
    }

    async function generateImg(){
        let modalContent = document.getElementById("turnoDisplay");
        
        html2canvas(modalContent).then(function (canvas) {
            let image = canvas.toDataURL("image/png");
            let link = document.createElement("a");
            link.href = image;
            link.download = "TURNO-VERIS.png";
            link.click();
        });
    }

    async function printFactura(){
        // clearInterval(temporizadorInactividad)
        console.table(datosPago.comprobantes)
        const apiUrl = `${api_url_digitales}/reportes/v1/facturacion/comprobante_paciente?format=text_plain&codigoEmpresa=1&numeroTransaccion=${datosPago.comprobantes.transacciones[0].numeroTransaccion}&codigoSucursalImpresion=${dataParametrosGenerales.caja.codigoSucursal}&usuarioRealizaImpresion=true`;

        // Codificar la URL antes de pasarla como parámetro
        const encodedUrl = encodeURIComponent(apiUrl);
        let args = [];
        args["endpoint"] = `http://localhost:3001/printer-ticket/v1/printFile?url=${encodedUrl}`;
        args["method"] = "GET";
        args["token"] = accessToken;
        args["sendHeaders"] = "true";
        const data = await call(args);
        reiniciarConteo();
        if(data.code == 200){
            console.log(data)
        }
        return;
    }

    async function printTurnoAPI(detalle){
        let args = [];
        args["endpoint"] = `http://localhost:3002/printer-ticket/v1/turnero?turno=${detalle.turno}&sucursal=${detalle.nombreSucursalTurnero.toUpperCase()}&paciente=${detalle.nombreCompleo}&fechaTicket=${detalle.fechaEmision}&nombreMuestraTurnero=${dataParametrosGenerales.nombreMuestraTurnero}`;
        args["method"] = "GET";
        const data = await call(args);
        if(data.code == 200){
            console.log(data)
        }
        exitAfterTurno();
        return;
    }

    async function printTurno(detalle){
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
</script>
<style>
    .btn-disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    .toast-title {
        color: #fff !important;
    }
    #toast-container > .toast-warning {
        background: #f39c12 url("{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exclamation.svg") no-repeat 10px center !important;
        background-size: 40px 40px !important;
        color: white !important;
    }
    .modal,
    .modal-xxl{
        background: transparent !important;
    }
</style>
@endsection
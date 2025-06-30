@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/kioskboard-2.3.0.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/print.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/print.min.js"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-2.3.0.min.js"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/html2canvas.min.js"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="wrapper">
    <!-- Header -->
    <header class="header p-3">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-12 col-md-3 text-center text-md-start">
                    @if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
                    <img id="logo-digiturno" class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
                    @else
                    <img id="logo-digiturno" class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
                    @endif
                </div>
                <div class="col-9 col-md-9 d-md-flex justify-content-end align-items-center d-none d-md-block">
                    <div class="time-box badge bg-veris-dark text-center p-3 rounded-8" id="header-info">
                        <span class="fs-4">Fecha:</span><span class="ms-1 fs-5 text-veris-light" id="fecha"></span>
                        <span class="fs-5 ms-5 d-none">Hora:</span><span class="ms-1 fs-5 text-veris-light d-none" id="hora"></span>
                        <span class="fs-5 ms-5">Central:</span><span class="ms-1 fs-4 text-veris-light" id="central"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Content -->
    <main class="content p-2 p-md-2">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-12 h-100 px-0 rounded-t-8">
                    <ul class="nav nav-pills justify-content-between bg-white w-100 rounded-t-8 border-start-0 border-start-0" id="pills-tab-servicios" role="tablist">
                        <li class="nav-item flex-fill w-50 border-silver-light-1 rounded-8" role="presentation">
                            <button tipo-rel="AV" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-20 active" id="pills-AV-tab" data-bs-toggle="pill" data-bs-target="#pills-AV" type="button" role="tab" aria-controls="pills-AV" aria-selected="true">
                            ANULACIÓN DE VOUCHER<br>SIN FACTURA
                            </button>
                        </li>
                        <li class="nav-item flex-fill w-50 border-silver-light-1 rounded-8" role="presentation">
                            <button tipo-rel="NC" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-20" id="pills-NC-tab" data-bs-toggle="pill" data-bs-target="#pills-NC" type="button" role="tab" aria-controls="pills-NC" aria-selected="false">
                                NOTA DE CRÉDITO CON<br>REVERSO DE VOUCHER
                            </button>
                        </li>
                        <li class="nav-item flex-fill w-50 border-silver-light-1 rounded-8" role="presentation">
                            <button tipo-rel="SF" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-20" id="pills-SF-tab" data-bs-toggle="pill" data-bs-target="#pills-SF" type="button" role="tab" aria-controls="pills-SF" aria-selected="false">
                                SALDO A FAVOR<br>DEL CLIENTE
                            </button>
                        </li>
                        <li class="nav-item flex-fill w-50 border-silver-light-1 rounded-8" role="presentation">
                            <button tipo-rel="CDF" class="nav-link tipoServicio w-100 px-8 px-2 d-flex justify-content-center align-items-center text-veris-dark fs-20" id="pills-CDF-tab" data-bs-toggle="pill" data-bs-target="#pills-CDF" type="button" role="tab" aria-controls="pills-CDF" aria-selected="false">
                                CAMBIO DATOS<br>DE FACTURA
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content bg-transparent pt-2" id="pills-tabContent-servicios">
                        <div class="tab-pane fade mt-3 px-3 show active" id="pills-AV" role="tabpanel" aria-labelledby="pills-AV-tab" tabindex="0">
                            <div class="row row-flex mb-3 pb-3">
                                <div class="col-12 mt-3">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Secuencia Voucher</th>
                                                <th scope="col">N°. Tarjeta</th>
                                                <th scope="col">N°. Voucher</th>
                                                <th scope="col">Usuario Cajero</th>
                                                <th scope="col">Tarjeta Habitante</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listVouchers">
                                            {{-- <tr>
                                                <td>2520534</td>
                                                <td>54519500XXXXX343</td>
                                                <td>000020</td>
                                                <td>KDORADO1</td>
                                                <td>PAYWAVE/VISA</td>
                                                <td>$40,00</td>
                                                <td class="d-flex justify-content-center align-items-center">
                                                    <button class="bg-transparent border-0"><i class="fa-solid fa-eye mx-1 text-veris"></i></button>
                                                    <button class="bg-transparent border-0"><i class="fa-solid fa-ban mx-1 text-danger"></i></button>
                                                </td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-3 px-3" id="pills-NC" role="tabpanel" aria-labelledby="pills-NC-tab" tabindex="0">
                            <div class="row row-flex mb-3 pb-3">
                                <div class="col-12 mt-3">
                                    <p class="fs--2 fw-bold text-veris mt-3">Número de Factura</p>
                                    <div class="d-flex mt-3 align-items-center justify-content-between">
                                        <input type="text" maxlength="3" 
                                            class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" 
                                            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
                                            onkeypress="return validarNumeros(event)" 
                                            onblur="completarConCeros(this)" 
                                            required 
                                            autocomplete="off" 
                                            id="first-input">
                                        <i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
                                        <input type="text" maxlength="3" 
                                            class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" 
                                            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
                                            onkeypress="return validarNumeros(event)" 
                                            onblur="completarConCeros(this)" 
                                            required 
                                            autocomplete="off" 
                                            id="medium-input">
                                        <i class="fa-solid fa-minus txt-veris fw-bold mx-1 mx-md-3"></i>
                                        <input type="text" maxlength="9" 
                                            class="flex-grow-1 text-center rounded-3 form-control fs--1 p-2" 
                                            oninput="limitarCaracteres(this, this.getAttribute('maxlength'))" 
                                            onkeypress="return validarNumeros(event)" 
                                            onblur="completarConCeros(this)" 
                                            required 
                                            autocomplete="off" 
                                            id="last-input">
                                        <button class="m-0 mx-1 mx-md-3 bg-transparent border-0" id="btnSearch">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6 box-info-factura d-none mt-3">
                                    <p class="fs--2 fw-bold text-veris mt-3">Datos Paciente</p>
                                    <div class="box-paciente"></div>
                                </div>
                                <div class="col-6 box-info-factura d-none mt-3">
                                    <p class="fs--2 fw-bold text-veris mt-3">Datos Factura</p>
                                    <div class="box-factura"></div>
                                </div>
                                <div class="col-12 box-info-factura d-none mt-3">
                                    <table class="table">
                                        <thead>
                                            <th>Cantidad</th>
                                            <th>Prestación/Servicio</th>
                                            <th>V. Empresa</th>
                                            <th>V. Paciente</th>
                                        </thead>
                                        <tbody id="listado-prestaciones"></tbody>
                                    </table>
                                </div>
                                <div class="col-4 offset-4 box-info-factura d-none mt-5">
                                    <button class="btn bg-veris btn-action text-white mx-auto fs--20 p-3 mb-5 rounded-8 my-5">Crear Nota de Crédito</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-3 px-3" id="pills-SF" role="tabpanel" aria-labelledby="pills-SF-tab" tabindex="0">
                            <div class="row row-flex mb-3 pb-3">
                                <div class="col-12 mt-3">
                                    SF
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-3 px-3" id="pills-CDF" role="tabpanel" aria-labelledby="pills-CDF-tab" tabindex="0">
                            <div class="row row-flex mb-3 pb-3">
                                <div class="col-12 mt-3">
                                    CDF
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
    // Valida que solo se puedan ingresar números
    function validarNumeros(event) {
        return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) 
            ? null 
            : event.charCode >= 48 && event.charCode <= 57;
    }

    // Completa con ceros a la izquierda hasta el maxlength definido
    function completarConCeros(input) {
        const maxLength = parseInt(input.getAttribute('maxlength'), 10);
        if (input.value.length < maxLength) {
            input.value = input.value.padStart(maxLength, '0');
        }
    }

    // Adicional: Limita caracteres a `maxlength` manualmente si es necesario (por redundancia)
    function limitarCaracteres(input, maxLength) {
        if (input.value.length > maxLength) {
            input.value = input.value.slice(0, maxLength);
        }
    }

    document.addEventListener('DOMContentLoaded', async function () {
        await parametrosGenerales("{{ $mac }}");
        await getVouchers();

        $('body').on('click', '.btn-anular-voucher', async function(){
            let datosVoucher = JSON.parse($(this).attr('data-rel'));
            console.log(datosVoucher);
            await anularVoucher(datosVoucher);
        })

        $('body').on('click', '#btnSearch', async function(){
            let tipo = $('.tipoServicio.active').attr('tipo-rel')
            console.log(tipo)
            $('.btn-action').attr(`tipo-rel`, tipo);
            switch(tipo){
                case 'NC':
                    $('.btn-action').html(`Crear Nota de Crédito`)
                    await obtenerInfoFactura()
                break;
            }
        })

        $('body').on('click', '.btn-action', async function(){
            let tipo = $(this).attr('tipo-rel');
            switch(tipo){
                case 'NC':
                    await crearNC()
                break;
            }
        })

    })

    async function crearNC(){
        let infoFactura = JSON.parse($('.btn-action').attr('data-rel'));
        let detalles = [];
        let pagos = [];
        $.each(infoFactura.detalles, function(k, v){
            detalles.push({
                "lineaDetalleOrden": v.lineaDetalleOrden,
                "lineaDetalleComprobante": v.lineaDetalleComprobante
            })
        })
        $.each(infoFactura.pagos, function(k, v){
            pagos.push({
                "lineaDetallePago": v.lineaDetallePago,
                "valor": v.valor
            })
        })
        let obj = {
            "secuenciaUsuario": dataParametrosGenerales.secuenciaUsuario,
            "nemonicoCanalFacturacion": "KIOSKO",
            "codigoMotivo": 9,
            "caja": dataParametrosGenerales.caja,
            "numeroOrden": infoFactura.numeroOrden,
            "secuenciaComprobante": infoFactura.secuenciaComprobante,
            "detalles": detalles,
            "observacionMotivo": "SERVICIOS FACTURADOS NO BRINDADOS",
            "permitirAnularPago": false,
            "pagos": pagos,
            "secuenciaUsuarioAutorizacion": dataParametrosGenerales.secuenciaUsuario
        }
        await anularFactura(obj);
    }

    async function anularFactura(obj){
        let args = [];

        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/comprobantes/anulacion_paciente?codigoEmpresa=1&tipoAnulacion=AUTOMATICA`;
        args["method"] = "POST";
        args["dismissAlert"] = true;
        args["showLoader"] = true;
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify(obj);
        args["bodyType"] = "json";
        const data = await call(args);
        if(data.code == 200){
            if(infoFactura.permiteAnularVoucher){
                let datosVoucher = {
                    "secuenciaDocumentoVoucher": infoFactura.pagos[0].secuenciaDocumentoVoucher
                }
                await anularVoucher(datosVoucher);
            }
            if(infoFactura.permiteAnularValExt){
                await anularAutorizacion(infoFactura);
            }
        }
    }

    async function anularAutorizacion(infoFactura){
        let transacciones = [];
        transacciones.push(infoFactura.secuenciaTransaccionValExt);
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/sync-convenios/v1/valorizacion_externa/anulacion_autorizacion?idCliente=${infoFactura.idCliente}&canalInvocacion=KIO`;
        args["method"] = "DELETE";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "transacciones": transacciones
        });
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
    }

    async function obtenerInfoFactura(){
        $('.box-info-factura').addClass('d-none');
        let numeroFactura = `${getInput('first-input')}${getInput('medium-input')}${getInput('last-input')}`
        let args = [];

        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/comprobantes/factura_paciente/kiosko/consulta_por_anulacion?codigoEmpresa=1&macAddress={{ $mac }}&criterioBusqueda=COMPROBANTE_CON_FACTURA&valorBusqueda=${numeroFactura}`;
        args["method"] = "GET";
        args["dismissAlert"] = true;
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        let info = data.data;
        if(data.code == 200){
            console.log(data);
            $('.box-info-factura').removeClass('d-none');
            
            let elemPaciente = `
                <p class="mb-1 fs-20 line-height-25">Nombre: <b>${info.nombrePaciente}</b></p>
                <p class="mb-1 fs-20 line-height-25">Nro. Identificación: <b>${info.numeroIdentificacionPaciente}</b></p>
            `;
            let elemFactura = `
                <p class="mb-1 fs-20 line-height-25">Nombre: <b>${info.nombrePersonaFactura}</b></p>
                <p class="mb-1 fs-20 line-height-25">Nro. Identificación: <b>${info.numeroIdentificacionPersonaFactura}</b></p>
            `;
            let elemPrestaciones = ``;

            $.each(info.detalles, function(key, value){
                elemPrestaciones += `<tr>
                    <td>${value.cantidad}</td>
                    <td>${value.nombrePrestacion}</td>
                    <td>$${value.valoresEmpresa.valorTotal.toFixed(2)}</td>
                    <td>$${value.valoresPaciente.valorTotal.toFixed(2)}</td>
                </tr>`;
            })

            $('#listado-prestaciones').html(elemPrestaciones);

            $('.btn-action').attr('data-rel',JSON.stringify(info));

            $('.box-paciente').html(elemPaciente);
            $('.box-factura').html(elemFactura);

        }else{
            showMessage('error','Atención',data.message);
        }
    }

    async function getVouchers(){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pin_pad/consulta/vouchers_por_anular?usuarioIngreso=KKENNEDY1&codigoEmpresa=1`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        const data = await call(args);
        console.log(data);

        if(data.code == 200){
            let elem = ``;

            $.each(data.data, function(key, value){
                elem += `<tr>
                    <td>${value.secuenciaDocumentoVoucher}</td>
                    <td>${value.numeroTarjeta}</td>
                    <td>${value.numeroVoucher}</td>
                    <td>${value.usuarioIngreso}</td>
                    <td>${value.nombreMarcaTc}</td>
                    <td>$${value.valorTotal}</td>
                    <td class="d-flex justify-content-center align-items-center">
                        <button data-rel='${JSON.stringify(value)}' class="bg-transparent border-0"><i class="fa-solid fa-eye mx-1 text-veris"></i></button>
                        <button data-rel='${JSON.stringify(value)}' class="bg-transparent border-0 btn-anular-voucher"><i class="fa-solid fa-ban mx-1 text-danger"></i></button>
                    </td>
                </tr>`;
            })

            $('#listVouchers').html(elem)

        }
    }

    async function anularVoucher(datosVoucher){
        let args = [];
        args["endpoint"] =  `${api_url_digitales}/facturacion/v1/pin_pad/anular_cobro/${datosVoucher.secuenciaDocumentoVoucher}?codigoEmpresa=1&codigoUsuario=KKENNEDY1&macAddress={{ $mac }}`;
        args["method"] = "DELETE";
        args["token"] = accessToken;
        args["showLoader"] = true;
        args["data"] = JSON.stringify({});
        args["bodyType"] = "json";
        const data = await call(args);
        console.log(data);
    }
</script>
<style>
    .toast-title {
        color: #fff !important;
    }
    #toast-container > .toast-warning{
        background-image: url("{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exclamation.svg") !important;
    }
</style>
@endsection
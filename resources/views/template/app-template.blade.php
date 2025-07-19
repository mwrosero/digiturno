<!DOCTYPE html>
<html lang="es" translate="no">
    <head>
        <meta charset="utf-8" />
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> --}}
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


        <title>Digiturno - Veris</title>
        <meta name="description" content="" />
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.svg" />
        <link rel="icon" type="image/x-icon" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/favicon/favicon.png" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?display=swap&family=Montserrat:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/fonts/fontawesome.css" />
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/> --}}
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-digiturno.css?v=1.0.6')}}">
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/keyboard.css?v=1.0.1')}}">
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/bootstrap-icons.min.css?v=1.0')}}">

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/swiper/swiper.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
        @stack('css')
        
        <script>
            localStorage.setItem("flujo","digiturno");
            let buscarUsuarioFlag = true;
            let accessToken = "{{ $accessToken }}";
            let web_url = "{{ \App\Models\Veris::WEBURL }}";
            const url_payment = "{{ \App\Models\Veris::URLPAYMENT }}";
            const api_url = "{{ \App\Models\Veris::BASE_URL }}";
            const api_url_digitales = "{{ \App\Models\Veris::BASE_URL_DIGITALES }}";
            const api_war_seguridad = "{{ \App\Models\Veris::SEGURIDADES_WAR }}";
            const api_war_digitales = "{{ \App\Models\Veris::BASE_WAR_DIGITALES }}";
            const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
            const _application = "{{ \App\Models\Veris::APPLICATION }}";
            const _idOrganizacion = "{{ \App\Models\Veris::IDORGANIZACION }}";
            const _applicationLogin = "{{ \App\Models\Veris::APPLICATION_LOGIN }}";
            const _applicationLoginLider = "{{ \App\Models\Veris::APPLICATION_LOGIN_LIDER }}";
            const _idOrganizacionLogin = "{{ \App\Models\Veris::IDORGANIZACION_LOGIN }}";
            let trackId = '';
            let canalOrigen = 'MVE_CMV';
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script> 
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js?v=1.1.3"></script>
        {{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/jquery.idle.min.js"></script> --}}
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
        @include('template.analytics')
    </head>

    <body>
        @include('template.analytics-no-script')

        @include('template.modal-terminos-condiciones')
        @include('template.modal-terminos-resultados')
        
        <!-- Layout wrapper -->
        
        @yield('content')



        <!-- Modal alerta -->
        <div class="modal fade" id="modalAlerta" tabindex="-1" aria-labelledby="modalAlertaLabel">
            <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
                <div class="modal-content rounded-8">
                    <div class="modal-body text-center p-3 pb-2">
                        <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3">Veris</h1>
                        <p class="fs--16 fw-normal text-veris mb-3" id="mensajeError"></p>
                    </div>
                    <div class="modal-footer pt-0 pb-3 px-3 border-0">
                        <button type="button" class="btn bg-veris btn-ingresar text-white mx-auto rounded-8 mt-3" data-bs-dismiss="modal">Entiendo</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal consulta inactividad --}}
        <div class="modal modal-top fade" id="modalEstasAhi" tabindex="-1" aria-labelledby="modalEstasAhiLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
            <div class="modal-dialog modal modal-sm modal-dialog-centered mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="modal-title text-center my-2 text-uppercase">¿Estás ahí?</h5>
                    </div>
                    <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                        <a id="btnSi" href="#" class="btn fw-normal fs--16 badge bg-veris-dark text-white m-0 px-4 py-2 mx-2 fs-4 w-25 rounded-8" data-bs-dismiss="modal">Si</a>
                        <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-2 fs-4 w-25 rounded-8 btn-salir">SALIR</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal turno generado --}}
        <div class="modal fade" id="turnoModal" aria-labelledby="turnoModalLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                    </div> --}}
                    <div class="modal-body" id="turnoDisplay">
                        <h5 class="modal-title text-center my-2 text-uppercase" id="turnoModalLabel"></h5>
                        <!-- Código del turno -->
                        <div class="turno-codigo text-center p-2 w-75 rounded-8 border-veris-5 text-veris border-veris-3 mx-auto" style="font-size: 35px;"></div>
                        <!-- Información adicional -->
                        <div class="info-box my-0 mt-3 text-center">
                            
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto fs-4 btn-salir">CERRAR</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/i18n/i18n.js"></script>
        <!-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/block-ui/block-ui.js"></script> -->

        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/swiper/swiper.js"></script>
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/html2canvas.min.js"></script>

        @stack('scripts')
        <script>
            let estaAperturada = true;
            let dataParametrosGenerales;
            localStorage.removeItem('sessionTime');
            $(document).ready(async function() {
                if (localStorage.getItem('sessionTime') === null) {
                    localStorage.setItem('sessionTime', new Date().getTime());
                }
                // setInterval(checkAndUpdateToken, 15 * 60 * 1000);
                setInterval(checkAndUpdateToken, 10 * 60 * 1000);

                if(localStorage.getItem('flujo') !== null){
                    let url_salir = `/{{ $mac }}`;
                    // if(isMobile() || localStorage.getItem('userKiosko') !== null){
                    if (localStorage.getItem('userKiosko') !== null || isKiosk()) {
                        url_salir = `/kiosko/{{ $mac }}`;
                    }
                    if(isMobile()){
                        url_salir = `/ingreso/{{ $mac }}`;
                    }
                    $('.btn-salir').attr('href',url_salir);

                    console.log("========================app-template======================")
                    console.log(url_salir)
                }
            });

            function exitAfterTurno(){
                console.log("-----------------------")
                if(localStorage.getItem('flujo') !== null){
                    let url_salir = `/{{ $mac }}`;
                    if (localStorage.getItem('userKiosko') !== null || isKiosk()) {
                        url_salir = `/kiosko/{{ $mac }}`;
                    }
                    if(isMobile()){
                        url_salir = `/ingreso/{{ $mac }}`;
                    }
                    setTimeout(function(key,value){
                        location.href = url_salir;
                    }, 3000);
                }
            }

            async function parametrosGenerales(_mac, sendHeaders = false, esLogin = false){
                let isDeviceKiosko = true;
                if(!isKiosk()){
                    isDeviceKiosko = false;
                }
                if(isMobile()){
                    isDeviceKiosko = false;
                }
                let args = [];
                args["endpoint"] = `${api_url}/${api_war}/util/parametros_generales?macAddress=${ _mac }&esLogin=${ esLogin }&esKiosko=${ isDeviceKiosko }`;
                args["method"] = "GET";
                args["showLoader"] = false;
                args["dismissAlert"] = true;
                args["token"] = "{{ $accessToken }}";
                if(sendHeaders){
                    args["sendHeaders"] = "true";
                }

                const data = await call(args);
                // console.log(data);

                if(data.code == 200){
                    dataParametrosGenerales = data.data
                    $('#central').html(`${ dataParametrosGenerales.nombreSucursalTurnero }`)
                }else{
                    toastr.error(data.message, "Atención - Parámetros Generales", {
                        timeOut: 5000
                    });
                }
            }

            function checkAndUpdateToken() {
                console.log("Verificar si existe una sesión y ha transcurrido al menos 15 minutos");
                var sessionTime = localStorage.getItem('sessionTime');
                
                // Verificar si existe una sesión y ha transcurrido al menos 25 minutos
                if (sessionTime && new Date().getTime() - sessionTime >= 15 * 60 * 1000) {
                    // Actualizar el token
                    updateToken();
                    // Reiniciar la hora de sesión
                    localStorage.setItem('sessionTime', new Date().getTime());
                }
            }

            async function updateToken() {
                // Realizar una solicitud para actualizar el token
                console.log("Realizar una solicitud para actualizar el token");
                let args = [];
                args["endpoint"] = location.origin+"/refreshToken";
                args["method"] = "GET";
                args["bodyType"] = "json";
                args["showLoader"] = false;

                const data = await call(args);
                console.log(data);
                if(!data || data.code != 200){
                    console.log("ERROR DE RENOVACION DE TOKEN")
                }else{
                    accessToken = data.idToken;
                }
            }
            //update token bearer accessToken

            async function registrarTracking(type, payloadRegistro){
                let args = [];
                args["endpoint"] = `${api_url}/${api_war}/util/registrar_tracking?macAddress=${ dataTurno.mac }`;
                {{-- if() --}}
                let dataAttr = $('.paciente-item-selected').attr("data-rel");
                let idPaciente;
                if(dataAttr === undefined){
                    idPaciente = dataCita.paciente.numeroPaciente;
                    args["sendHeaders"] = "true";
                    trackId = dataTurno.trackId;
                }else{
                    let paciente = JSON.parse(dataAttr);
                    idPaciente = paciente.idPaciente;
                }
                let payload = {
                    "idProceso": type,
                    "pacPacNumero": parseInt(idPaciente),
                    "parametros": payloadRegistro
                }

                // "pacPacNumero": "",
                // "codigoOrdApoyo": "",
                // "codigoReserva": "",
                // "numeroOrden": ""

                switch(type){
                    case 'CITA_RESERVADA':
                        payload.codigoReserva = dataCita.reserva.codigoReserva;
                        if(dataCita.hasOwnProperty('tratamiento')){
                            payload.numeroOrden = dataCita.tratamiento.numeroOrden;
                        }
                    break;
                    case 'PAGO_PINPAD':
                        if(localStorage.getItem('flujo') === null || localStorage.getItem('flujo') == "digiturno"){
                            if(payloadRegistro.detalle.hasOwnProperty('codigoReserva')){
                                payload.codigoReserva = payloadRegistro.detalle.codigoReserva;
                            }
                            if(payloadRegistro.detalle.hasOwnProperty('codigoOrdApoyo')){
                                payload.codigoOrdApoyo = payloadRegistro.detalle.codigoOrdApoyo;
                            }
                            if(payloadRegistro.detalle.hasOwnProperty('numeroOrden')){
                                payload.numeroOrden = payloadRegistro.detalle.numeroOrden;
                            }
                        }else{
                            payload.codigoReserva = dataCita.reserva.codigoReserva;
                            if(dataCita.hasOwnProperty('tratamiento')){
                                payload.numeroOrden = dataCita.tratamiento.numeroOrden;
                            }
                        }
                        payload.parametros = payloadRegistro.comprobantes;
                    break;
                    case 'PAGO_CAJA':
                        payload.codigoReserva = payloadRegistro.codigoReserva;
                    break;
                    case 'AGENDAR_ORDEN_INTERNA':
                        payload.codigoReserva = payloadRegistro.codigoReserva;
                        if(payloadRegistro.hasOwnProperty('codigoOrdApoyo')){
                            payload.codigoOrdApoyo = payloadRegistro.codigoOrdApoyo;
                        }
                        if(payloadRegistro.hasOwnProperty('numeroOrden')){
                            payload.numeroOrden = payloadRegistro.numeroOrden;
                        }
                    break;
                }

                args["method"] = "POST";
                args["token"] = accessToken;
                args["showLoader"] = true;
                args["data"] = JSON.stringify(payload);
                args["bodyType"] = "json";
                const data = await call(args);
                console.log(data)
                return data;
            }
        </script>
        <style>
            html, body {
                touch-action: pan-x pan-y; /* Permite solo desplazamiento horizontal y vertical */
            }
            .btn-close {
                box-sizing: content-box;
                width: 1.5em !important;
                height: 1.5em !important;
                padding: .25em .25em;
                color: #000;
                background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e) center / 2em auto no-repeat !important;
                border: 0;
                border-radius: .25rem;
                opacity: .5;
                background-size: 1.5rem;
            }
        </style>    
    </body>
</html>
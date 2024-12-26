<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
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
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-digiturno.css?v=1.0')}}">
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/keyboard.css?v=1.0')}}">
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/bootstrap-icons.min.css?v=1.0')}}">

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/swiper/swiper.css" />
        <link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.css" />
        @stack('css')
        
        <script>
            let buscarUsuarioFlag = true;
            let accessToken = "{{ $accessToken }}";
            let web_url = "{{ \App\Models\Veris::WEBURL }}";
            const api_url = "{{ \App\Models\Veris::BASE_URL }}";
            const api_url_digitales = "{{ \App\Models\Veris::BASE_URL_DIGITALES }}";
            const api_war = "{{ \App\Models\Veris::BASE_WAR }}";
            const _application = "{{ \App\Models\Veris::APPLICATION }}";
            const _idOrganizacion = "{{ \App\Models\Veris::IDORGANIZACION }}";
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script> 
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>
        <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/libs/toastr/toastr.js"></script>
        @include('template.analytics')
    </head>

    <body>
        @include('template.analytics-no-script')
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
                        <a id="btnSi" href="#" class="btn fw-normal fs--16 badge bg-veris-dark text-white m-0 px-4 py-2 mx-2 fs-4" data-bs-dismiss="modal">Si</a>
                        <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-2 fs-4 btn-salir" data-bs-dismiss="modal">SALIR</a>
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
                        <div class="info-box my-0 text-center">
                            
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
        

        @stack('scripts')
        <script>
            localStorage.removeItem('sessionTime');
            $(document).ready(function() {
                if (localStorage.getItem('sessionTime') === null) {
                    localStorage.setItem('sessionTime', new Date().getTime());
                }
                setInterval(checkAndUpdateToken, 15 * 60 * 1000);
            });

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
        </script>
    </body>
</html>
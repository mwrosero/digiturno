@extends('template.app-template')
@section('title')
Elige Paciente
@endsection
@section('content')
@php
// $params = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-app.css?v=1.0.3')}}">

<div class="d-flex flex-column vh-100">
@include('template.header_agendamiento', ['showInfo' => true])

{{-- <div class="flex-grow-1 container-p-y pt-0"> --}}
<div class="flex-grow-1 pt-0">
    <!-- Modal -->
    <div class="modal modal-top fade" id="convenioModal" tabindex="-1" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered mx-auto">
            <form class="modal-content rounded-4">
                <div class="modal-header d-none">
                    <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Elige tu convenio:') }}</h5>
                    <div class="row gx-2 justify-content-between align-items-center">
                        <div class="list-group list-group-checkable d-grid gap-2 border-0" id="listaConvenios">
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn fw-normal fs--16 line-height-20 m-0 px-3 py-2" data-bs-dismiss="modal" style="color: #6A7D8E;">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal noPermiteReserva-->
    <div class="modal fade" id="noPermiteReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noPermiteReservaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div class="text-center">
                        <h1 class="modal-title fs-5 fw-medium mb-3" id="noPermiteReservaLabel">Veris</h1>
                        <p class="fs--2 fw-normal" id="noPermiteReservaMsg"></p>
                    </div>
                </div>
                <div class="modal-footer pt-0 pb-3 px-3">
                    <button type="button" class="btn btn-primary-veris m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Elegir paciente') }}</h5>
    </div> --}}
    <section class="px-0 h-100">
        <div class="row mx-0 h-lg-100">
            @include('template.back')
            <div class="col-12 col-lg-4 d-flex justify-content-start justify-content-lg-center align-items-center bg-veris">
                <h5 class="ps-3 text-white my-auto py-3 fs-40 line-height-48 fs-md-24">{{ __('Elegir paciente') }}</h5>
            </div>
            <div class="col-12 col-lg-8 pt-3 pt-lg-0">
                <div class="row px-3" id="listaPacientes">
                    {{-- <div class="col-6 col-md-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center px-3 py-2">
                                <a class="" href="#">
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <div class="avatar avatar-10">
                                            <span class="avatar-initial rounded-circle bg-soft-blue"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <p class="text-veris fw-medium fs--2 text-center mb-0">{{ __('Agregar nuevo paciente') }}</p>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
</div>
</div>
<script>
    // variables globales
    let familiar = [];
    // CAPTURAR PARAMETROS

    let local = localStorage.getItem('turno-{{ $params }}');
    localStorage.setItem('flujo','agendamiento');
    let dataTurno = JSON.parse(local);

    localStorage.setItem('cita-{{ $params }}','{}');
    let dataCita = {};
    let dataPaciente;
    
    // dataCita.tipoFlujo = "agenda/demanda";
    // tipoFlujo = dataCita.tipoFlujo;

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarGrupoFamiliar();
        await parametrosGenerales("{{ $mac }}", true);
        $('body').on('click','.convenio-item', function(){
            reservaNoPermitida($(this).attr("url-rel"), $(this).attr("data-rel"));
        })

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
    });

    async function generarTurno(detalle, crearPtx = false){
        console.log(detalle);
        let url_adicional = ``;
        
        // if(detalle != []){
        if (crearPtx) {
            let pre_trx = await activarPrestacionesInicializar('TURNO',detalle);
            url_adicional += `&idPreTransaccion=${pre_trx}`
        }

        let paciente = dataTurno.paciente;
        let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/generar_ticket?macAddress=${ dataTurno.mac }&tipoIdentificacion=${paciente.nombreTipoIdentificacion}&numeroIdentificacion=${paciente.numeroIdentificacion}&nombreCompleto=${ paciente.nombreCompleto }${url_adicional}`;
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

    // funciones asyncronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = dataTurno.paciente.numeroIdentificacion;
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        // args["authVeris"] = false;
        args["showLoader"] = true;
        const data = await call(args);
        
        if(data.code == 200){
            familiar = data.data;
            mostrarListaPacientes();
        }
        return data;
    }

    // consultar lista de convenios
    async function consultarConvenios(event) {
        if(typeof dataCita.paquete !== 'undefined'){
            console.log(2)
            let dataRel = $(event.currentTarget).data('rel');
            let url = '/citas-datos-facturacion/';
            dataCita.paciente = dataRel;
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            location.href = url + "{{ $params }}";
            return;
        }


        let dataRel = $(event.currentTarget).data('rel');
        dataCita.paciente = dataRel;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
        location.href = '/seleccionar-datos-cita/{{ $params }}?mac={{ $mac }}';
        return;
    }
    
    // mostrar lista de pacientes
    function mostrarListaPacientes(){

        let listaPacientes = $('#listaPacientes');
        
        let elemento = '';

        if(familiar != null){
            familiar.forEach((pacientes) => {
                let backgroundClass = pacientes.genero === "F" ? "bg-strong-magenta" : (pacientes.genero === "M" ? "bg-soft-blue" : "bg-soft-green");

                elemento += `<div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body text-center px-3 py-2">
                            
                            <div onclick="consultarConvenios(event)" data-rel='${JSON.stringify(pacientes)}'>
                               <div class="d-flex justify-content-center align-items-center mb-2">
                                    <div class="avatar avatar-18">
                                        <span class="avatar-initial rounded-circle ${backgroundClass}">${pacientes.primerNombre.charAt(0).toUpperCase()}</span>
                                    </div>
                                </div>
                                <p class="text-veris fw-medium fs-25 line-height-25 mb-1">${capitalizarElemento(pacientes.primerNombre)} <br> ${capitalizarElemento(pacientes.primerApellido)} ${capitalizarElemento(pacientes.segundoApellido)}</p>
                                <p class="text-veris fs-20 line-height-20 mb-0">${capitalizarElemento(pacientes.parentesco)}</p>
                            </div>
                        </div>
                    </div>
                </div> `;

            });
        }
        listaPacientes.append(elemento);
    }

    async function reservaNoPermitida(url, data ){
        let convenio = JSON.parse(atob(decodeURIComponent(data)));
        console.log("convenio", convenio);
        $('#noPermiteReservaMsg').html(convenio.convenio.mensajeBloqueoReserva)
        if(convenio.convenio.permiteReserva == "S"){
            // Actualizar dataCita con los datos del convenio
            dataCita.convenio = convenio.convenio;
            dataCita.paciente = dataPaciente;
            // Aquí puedes añadir cualquier otra información relevante a dataCita

            // Guardar el objeto actualizado en localStorage
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

            location.href = url;
        }else{
            $('#convenioModal').modal('hide');
            var myModal = new bootstrap.Modal(document.getElementById('noPermiteReserva'));
            setTimeout(function(){
                $('.modal-backdrop').remove();
                myModal.show();
            },250);
        }
    }

    // setear cita en localstorage cuando se escoge un convenio ninguno
    $('body').on('click', '#convenioNinguno', function() {
        let params = {}
        dataCita.online = online;
        dataCita.convenio = {
            "permitePago": "S",
            "permiteReserva": "S",
            "idCliente": null,
            "codigoConvenio": null,
        };
        dataCita.paciente = dataPaciente;
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));

    });
    async function printFactura(){
        // clearInterval(temporizadorInactividad)
        // console.table(datosPago.comprobantes)
        let args = [];
        args["endpoint"] = `http://localhost:3001/printer-ticket/v1/printFile?url=https://api-phantomx.veris.com.ec/reportes/v1/facturacion/comprobante_paciente?format=text_plain&codigoEmpresa=1&numeroTransaccion=21309115&codigoSucursalImpresion=1&usuarioRealizaImpresion=true`;
        args["method"] = "GET";
        args["token"] = accessToken;
        args["sendHeaders"] = "true";
        args["bodyType"] = "json";
        const data = await call(args);
        if(data.code == 200){
            console.log(data)
        }
        return;
    }
</script>

<style>
    .bg-soft-blue {
        background-color: #0071CE !important;
    }
</style>
@endsection
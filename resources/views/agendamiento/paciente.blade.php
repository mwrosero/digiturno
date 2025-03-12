@extends('template.app-template')
@section('title')
Elige Paciente
@endsection
@section('content')
@php
// $params = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-app.css?v=1.0.3')}}">

@include('template.header_agendamiento', ['showInfo' => true])

<div class="flex-grow-1 container-p-y pt-0">
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
    <section class="p-3 px-0 mb-3">
        <div class="row mx-0">
            <div class="col-12 col-lg-4 d-flex justify-content-between align-items-center bg-veris">
                <h5 class="ps-3 text-white my-auto py-3 fs-40 line-height-48 fs-md-24">{{ __('Elegir paciente') }}</h5>
            </div>
            <div class="col-12 col-lg-8 pt-3">
                <div class="row g-3 px-3" id="listaPacientes">
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

<script>
    // variables globales
    let familiar = [];
    // CAPTURAR PARAMETROS
    let local = localStorage.getItem('turno-{{ $params }}');
    let dataTurno = JSON.parse(local);

    localStorage.setItem('cita-{{ $params }}','{}');
    let dataCita = {};
    let dataPaciente;
    
    // dataCita.tipoFlujo = "agenda/demanda";
    // tipoFlujo = dataCita.tipoFlujo;

    // llamada al dom 
    document.addEventListener("DOMContentLoaded", async function () {
        await consultarGrupoFamiliar();
        $('body').on('click','.convenio-item', function(){
            reservaNoPermitida($(this).attr("url-rel"), $(this).attr("data-rel"));
        })
    });

    // funciones asyncronas
    // consultar grupo familiar
    async function consultarGrupoFamiliar() {
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = dataTurno.paciente.numeroIdentificacion;
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/perfil/migrupo?canalOrigen=${canalOrigen}&codigoUsuario=${codigoUsuario}&incluyeUsuarioSesion=S`
        args["method"] = "GET";
        args["authVeris"] = false;
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

                elemento += `<div class="col-12 col-md-6 col-lg-4">
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
   
    
    
</script>

<style>
    .bg-soft-blue {
        background-color: #0071CE !important;
    }
</style>
@endsection
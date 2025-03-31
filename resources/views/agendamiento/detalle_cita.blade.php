@extends('template.app-template')
@section('title')
Mi Veris - Citas - Revisa tus datos
@endsection
@section('content')

<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/theme-veris-app.css?v=1.0.3')}}">

{{-- Modal Confirmar Pago --}}
<div class="modal modal-top fade" id="modalAgendado" aria-labelledby="modalAgendadoLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-xxl modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-start">Tu cita ha sido agendada con éxito.</h5>
                {{-- <div class="box-info-comprobante d-flex justify-content-center align-items-center fw-bold text-dark fs-25 bg-silver-light py-2 rounded-8 my-2">
                    Comprobante: <span></span>
                </div> --}}
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

<!-- Modal de error -->
<div class="modal fade" id="ModalError" tabindex="-1" aria-labelledby="ModalError" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable mx-auto">
        <div class="modal-content">
            <div class="modal-body text-center p-3 pb-0">
                <h1 class="modal-title fs--20 line-height-24 my-3">Información de tu seguro</h1>
                <p class="fs--1 line-height-16 text-veris fw-normal" id="mensajeError"></p>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3">
                {{-- <a href="tel:+59346009600" id="btn-lamar" class="btn btn-primary-veris d-none m-0 w-100 px-4 py-3 mb-2"><i class="bi bi-telephone-fill me-2"></i> Llamar</a> --}}
                <button type="button" id="btn-dismiss-error" class="btn btn-action-error btn-primary-veris fw-medium fs--18 m-0 w-100 px-4 py-3" data-bs-dismiss="modal">Regresar</button>
                <a href="#" id="btn-redirect-error" class="btn btn-action-error btn-primary-veris fw-medium fs--18 m-0 w-100 px-4 py-3 btn-salir" data-bs-dismiss="modal">Volver al inicio</a>
            </div>
        </div>
    </div>
</div>

@include('template.header_agendamiento', ['showInfo' => true])

<section class="p-3 px-0 mb-3">
    <div class="row mx-0">
        @include('template.back')
        <div class="col-12 col-lg-4 d-flex justify-content-between align-items-center bg-veris sticky-top overflow-hidden">
            <h5 class="ps-3 text-white my-auto py-3 fs-40 line-height-48">{{ __('Revisa los datos') }}</h5>
        </div>
        <div class="col-12 col-lg-8 overflow-auto pt-3">
            <div class="flex-grow-1 container-p-y pt-0">
                <section class="p-3 mb-3 invisible detalles-cita-box">
                    <div class="row g-4 justify-content-center">
                        <div class="col-12 col-md-10 mb-4 ps-3 pe-3 box-card-precio">
                            <div class="card">
                                <div class="card-header bg-grayish-blue p--2">
                                    <h5 class="text-veris-many fw-medium line-height-28 fs-20 m-0">{{ __('Precio') }} </h5>
                                </div>
                                <div class="card-body py-2 px-0">
                                    <div class="row gx-0 justify-content-center align-items-center box-precio pt-1 pb-1">
                                    </div>
                                </div>
                                {{-- <div class="card-footer d-flex justify-content-between border-top p--2" id="contentLinkPago">
                                    <div class="mx-1">
                                        <p class="fs--2 line-height-16 mb-0 fw-medium">{{ __('¿Alguien más pagará esta cita?') }}</p>
                                        <p class="fs--2 line-height-16 mb-0">{{ __('Genera tu link de pago') }}</p>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-label-primary-veris fs--1 line-height-16 ms-3 px-3 py-2">{{ __('Enviar link') }}</a>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-12 col-md-10 mb-4 ps-3 pe-3">
                            <div class="card">
                                <div class="card-header bg-grayish-blue p--2">
                                    <h5 class="text-veris-many fw-medium line-height-28 fs-20 m-0">{{ __('Detalles de la cita') }}</h5>
                                </div>
                                <div class="card-body p--2">
                                    <div class="" id="contentDetalleCita">
                                        {{-- <p class="text-primary-veris fw-medium mb-0" id="nombreEspecialidad"></p>
                                        <p class="fw-medium fs--1 mb-0">{{ isset($data->central) ? $data->central->nombreSucursal : 'VIRTUAL' }}</p>
                                        <p class="fs--2 mb-0">{{ $data->horario->dia2 }} <b class="text-normal text-primary-veris fw-normal">{{ $data->horario->horaInicio }} {{ $meridiano }}</b></p>
                                        <p class="fs--2 mb-0">Dr(a) {{ $data->horario->nombreMedico }}</p>
                                        <p class="fs--2 mb-0">{{ $data->paciente->nombrePaciente }}</p>
                                        <p class="fs--2 mb-0">{{ isset($data->convenio->nombreConvenio) ? $data->convenio->nombreConvenio : '' }}</p> --}}
                                    </div>
                                </div>
                                <div class="card-footer pt-0 p--2" id="msg-cita">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 text-center mt-5">
                            {{-- <a href="#" id="btn-pagar" class="btn btn-lg btn-primary-veris d-none w-100">{{ __('Pagar') }}</a> --}}
                            <button id="btn-pagar" class="btn btn-lg btn-primary-veris d-none w-100 px-4 py-3 fs-25">{{ __('Continuar') }}</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<script>

    let globalTurno = localStorage.getItem('turno-{{ $params }}');
    localStorage.setItem('flujo','agendamiento');
    let dataTurno = JSON.parse(globalTurno);

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);
    let online = dataCita?.online;
    let nombreEspecialidad = capitalizarCadaPalabra(dataCita.especialidad.nombre);
    var tipoIdentificacion = parseInt(dataCita.paciente.tipoIdentificacion);
    if (isNaN(tipoIdentificacion)) {
        tipoIdentificacion = parseInt(dataCita.paciente.codigoTipoIdentificacion);
    }
    // let tipoIdentificacion = dataCita.paciente.tipoIdentificacion;
    let numeroIdentificacion = dataCita.paciente.numeroIdentificacion;
    let codigoEspecialidad = dataCita.especialidad.codigoEspecialidad;
    let secuenciaAfiliado = dataCita.convenio.secuenciaAfiliado || '' ;
    let codigoConvenio = dataCita.convenio.codigoConvenio || '';
    //let idIntervalo = dataCita.horario.idIntervalo || '';
    //let porcentajeDescuentos = dataCita.horario.porcentajeDescuento;
    let medPayPlan = dataCita.convenio.informacionExternaPlan;
    
    let permiteReserva = dataCita.convenio.permiteReserva;
    // let dia2 = dataCita.horario.dia2;
    let idCliente = dataCita.convenio.idCliente;
    let rutaImagenConvenio = dataCita.convenio.rutaImagenConvenio;
    // let horaInicio = dataCita.horario.horaInicio;

    let permitePago = "S";
    if(dataCita.convenio.permitePago){
        permitePago = dataCita.convenio.permitePago;
    }

    window.addEventListener("pageshow", async function(event) {
        if (event.persisted) {
            reiniciarConteo();
            $('#modalEstasAhiAgenda').modal('hide');
            hideLoader();
            if(dataCita.reserva){
                await eliminarReserva();
            }
        }
    });


    document.addEventListener("DOMContentLoaded", async function () {
        if(dataCita.reserva){
            await eliminarReserva();
        }
        if(dataCita.reservaEdit && dataCita.reservaEdit.estaPagada === "S" && dataCita.cambioModalidad && dataCita.cambioModalidad === "S"){
            let elem = `<p class="text-primary-veris fs-20 line-height-28 fw-medium mb-1 text-center">Servicio pagado<i class="fa-solid fa-circle-check text-success ms-2"></i></p>`;
            $('.box-precio').html(elem);
            $('#btn-pagar').html("Continuar").removeClass('d-none');

            let elemMsg = ``;
            elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2 mb-3">
                <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Estás modificando el canal de atención, si realizas el cambio <b class="fw-medium text-veris">tu atención será virtual.</b></p>
            </div>`;
            elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                <i class="fa-solid fa-circle-info text-warning fs-2 p-2 me-2"></i>
                <p class="fs--1 line-height-16 mb-0" id="infoMessage style="color: #0A2240;">Esta acción no puede deshacerse</p>
            </div>`;
            $('#msg-cita').append(elemMsg);

        }else{
            // Revisar con Boris
            // await 
            await obtenerPrecio();
        }

        await llenarDataDetallesCitas();

        $('body').on('click', '#btn-pagar', async function () {
            if(dataCita.cambioModalidad && dataCita.cambioModalidad === "S"){
                await cambiarModalidadCita();
            }else{
                reservarCita();
            }
        });

        $('.detalles-cita-box').removeClass('invisible')

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

    async function eliminarReserva(){
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoUsuario = dataTurno.paciente.numeroIdentificacion;
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/agenda/eliminarReserva?codigoReserva=${dataCita.reserva.codigoReserva}`
        args["method"] = "PUT";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        const data = await call(args);

        //Menos para edictar reserva 
        if(data.code == 200){
            delete dataCita.reserva;
            guardarData();
        }

    }

    // llenar los datos en contentDetalleCita con los datos de dataCita
    async function llenarDataDetallesCitas(){
        let sucursal;
        let dia;
        let horaInicio;
        let horaFin;
        if(dataCita.cambioModalidad && dataCita.cambioModalidad === "S"){
            //let datosAgenda = await obtenerDatosReserva(dataCita.reservaEdit.idCita);
            sucursal = `Veris - Virtual`;
            dia = dataCita.horario.fechaReserva;
            horaInicio = dataCita.horario.horaInicio;
            horaFin = dataCita.horario.horaFin;
        }else{
            if(dataCita.online == "S"){
                sucursal = dataCita.horario.nombreSucursal;
            }else{
                sucursal = dataCita.central.nombreSucursal;
            }
            dia = dataCita.horario.dia;
            horaInicio = dataCita.horario.horaInicio;
            horaFin = dataCita.horario.horaFin;
        }
        let elem = `<p class="text-primary-veris fs-20 line-height-28 fw-medium mb-1"  id="nombreEspecialidad">${capitalizarCadaPalabra(nombreEspecialidad)}</p>`;
        if(dataCita.online == "N"){    
            elem += `<p class="fw-medium fs-20 line-height-28 mb-1">${capitalizarCadaPalabra(sucursal)}</p>`;
        }
        let nombrePaciente;
        if(dataCita.paciente.nombrePaciente){
            nombrePaciente = dataCita.paciente.nombrePaciente;
        }else{
            nombrePaciente = `${dataCita.paciente.primerNombre} ${dataCita.paciente.primerApellido} ${dataCita.paciente.segundoApellido}`;
        }
        elem += `<p class="fs-20 line-height-28 mb-1">${capitalizarElemento(dia)} <b class="text-normal text-primary-veris fw-normal">${horaInicio} - ${horaFin} ${determinarMeridiano(horaInicio)}</b></p>
            <p class="fs-20 line-height-28 mb-1 text-capitalize">Dr(a) ${dataCita.horario.nombreMedico.toLowerCase()}</p>
            <p class="fs-20 line-height-28 mb-1 text-capitalize">${nombrePaciente.toLowerCase()}</p>`;
        if(dataCita.convenio.codigoConvenio){
            elem += `<p class="fs-20 line-height-28 mb-1 text-capitalize">${ (dataCita.convenio.nombreConvenio) ? dataCita.convenio.nombreConvenio.toLowerCase() : ''}</p>`
        }
        $('#contentDetalleCita').html(elem);

        if(dataCita.convenio.codigoConvenio){
            $('#contentLinkPago').removeClass('d-none');
        }

    }

    // determinar si es PM o AM segun horaInicio
    function determinarMeridiano(horaInicio){
        let partesHora = horaInicio.split(':');
        let hora = parseInt(partesHora[0]);
        let meridiano = "AM";
        if (hora >= 12) {
            meridiano = "PM";
        }
        return meridiano;
    }

    // consultar grupo familiar
    async function obtenerPrecio() {
        if(dataCita.origen == "paquetes"){
            $('.box-card-precio').addClass('d-none');
            $('.box-precio').html(`<div class="col-12 text-center"><h1 class="text-primary-veris fw-medium fs--36 line-height-44 mb-0" id="precioTotal">$0.00</h1>
                </div>`);
            $('#msg-cita').append(`<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Puedes <b class="fw-medium text-veris">reagendar</b> tu cita las veces que necesites.</p>
                    </div>`);
            $('#btn-pagar').html("Agendar").removeClass('d-none');
            return;
        }
        let args = [];
        let canalOrigen = _canalOrigen
        let codigoReserva = ''; 
        let numeroOrden = ''; 
        let codigoEmpOrden = '';
        let lineaDetalle = '';
        let aplicaCredito = 'N';
        let aplicaProntoPago = 'S';

        if(dataCita.horario.porcentajeDescuento > 0){
            aplicaCredito = "S";
        }

        if(dataCita.convenio.aplicaProntoPago){
            aplicaProntoPago = dataCita.convenio.aplicaProntoPago;
        }

        if(dataCita.reservaEdit){
            codigoReserva = dataCita.reservaEdit.idCita;
            numeroOrden = dataCita.reservaEdit.numeroOrden || '';
            codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden || '';
            lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden || '';
        }
        if(dataCita.tratamiento && !dataCita.sesion){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                numeroOrden = dataCita.tratamiento.numeroOrden;
                codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
            
        }

        let codigoUsuario = dataTurno.paciente.numeroIdentificacion;
        let cantidad = '';
        if(dataCita.tratamiento && dataCita.tratamiento.cantidadIntervalosReserva){
            cantidad = dataCita.tratamiento.cantidadIntervalosReserva
        }

        let argsSesion = '';
        if(dataCita.sesion){
            argsSesion = `&secuenciaPlanTto=${dataCita.sesion.secuenciaPlanTto}&numeroSesion=${dataCita.sesion.numeroSesion}`;
        }

        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/agenda/precio?canalOrigen=${canalOrigen}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&codigoEspecialidad=${dataCita.especialidad.codigoEspecialidad}&idIntervalos=${dataCita.horario.idIntervalo}&permitePago=${permitePago}&codigoConvenio=${codigoConvenio}&esOnline=${dataCita.online}&porcentajeDescuento=${dataCita.horario.porcentajeDescuento}&aplicaProntoPago=${aplicaProntoPago}&codigoPrestacion=${dataCita.especialidad.codigoPrestacion}&codigoServicio=${dataCita.especialidad.codigoServicio}&codigoReserva=${codigoReserva}&secuenciaAfiliado=${secuenciaAfiliado}&aplicaCredito=${aplicaCredito}&codigoReserva=${codigoReserva}&numeroOrden=${numeroOrden}&codEmpOrden=${codigoEmpOrden}&lineaDetalle=${lineaDetalle}&cantidad=${cantidad}${argsSesion}`;
        args["method"] = "POST";
        args["bodyType"] = "json";
        args["showLoader"] = true;
        args["data"] = JSON.stringify({
            "fechaSeleccionada": dataCita.horario.dia2,
            "idCliente": idCliente,
            "estaPagada": (dataCita.reservaEdit) ? dataCita.reservaEdit.estaPagada : 'N',
            "esEmbarazada": (dataCita.estaEmbarazada) ? dataCita.estaEmbarazada : "N",
            "medPayPlan": medPayPlan
        });
        const data = await call(args);
        
        if(data.code == 200){
            let { valor, porcentajeDescuento, valorCanalVirtual  } = data.data;
            var porcentajeDescuentoCopago = porcentajeDescuento;
            var subtotalCopago = valor;
            var valorTotalCopago = valorCanalVirtual;
            var subtotalCopagoFloat = parseFloat(valor);
            var valorTotalCopagoFloat = parseFloat(valorCanalVirtual);
            let params = {};

            let elem = ``;
            let descuentoLabel = ``;
            let classNone = 'd-none';
            if(porcentajeDescuentoCopago > 0){
                classNone = '';
                descuentoLabel = `*Se aplicó un ${porcentajeDescuentoCopago}% ${data.data.mensajeDescuento}`;
            }

            if(codigoConvenio){
                console.log('subTotal', subtotalCopagoFloat, 'valorTotal', valorTotalCopagoFloat);
                let logoConvenio = ``;
                if(rutaImagenConvenio !== undefined){
                    logoConvenio = `<div class="col-3 text-center">
                            <img src="${rutaImagenConvenio}" alt="" class="img-fluid" width="86" height="">
                        </div>`
                }
                elem += `${logoConvenio}
                        <div class="col-5 text-center">`;

                if(subtotalCopagoFloat > valorTotalCopagoFloat){
                elem +=     `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                                <del class="fs--2 line-height-16" id="precioBase">$${valor.toFixed(2)}</del>
                            </p>`;
                }
                        elem += `<h1 class="text-primary-veris fw-medium fs--36 line-height-44 mb-0" id="precioTotal" style="white-space: nowrap;">$${valorTotalCopago.toFixed(2)}</h1>
                        </div>
                        <p class="text-center text-primary-veris fw-medium fs--2 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }else{
                elem += `<div class="col-12 text-center">`
                if(porcentajeDescuentoCopago > 0){
                    elem += `<p class="text-danger fs--3 line-height-16 mb-0" id="content-precioBase">Precio normal 
                        <del class="fs--2 line-height-16" id="precioBase">$${valor.toFixed(2)}</del>
                    </p>`;
                }
                elem += `<h1 class="text-primary-veris fw-medium fs--36 line-height-44 mb-0" id="precioTotal">$${valorTotalCopago.toFixed(2)}</h1>
                </div>
                <p class="text-center text-primary-veris fw-medium fs--2 my-2 px-3 ${classNone}" id="infoDescuento">${descuentoLabel}</p>`;
            }


            $('.box-precio').html(elem);

            let elemMsg = ``;

            if(dataCita.horario.porcentajeDescuento == 0 && permiteReserva == "S" && permitePago == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Puedes <b class="fw-medium text-veris">reagendar</b> tu cita las veces que necesites.</p>
                    </div>`;
            }
            //Una vez agendada la cita, no podrás cambiarla, ni solicitar su devolución debido a este descuento.
            if(dataCita.horario.porcentajeDescuento > 0 && permitePago == "S" ){
                elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                        <i class="fa-solid fa-circle-info text-warning fs-2 p-2 me-2"></i>
                        <p class="fs--1 line-height-16 mb-0" id="infoMessage style="color: #0A2240;">${data.data.mensajeAlerta}</p>
                    </div>`;
            }
            if(online == "S"){
                if((dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") && valorTotalCopago > 0) {
                    elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                            <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                            <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;">Recuerda que para poder conectarte a tu cita <b class="fw-medium text-veris">debes pagarla en los próximos 30 minutos</b>.</p>
                        </div>`;
                }
            }
            if(permitePago == "N"){
                if((dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") && valorTotalCopago > 0){
                    elemMsg += `<div class="d-flex justify-content-start align-items-center border-top pt--2">
                            <i class="fa-solid fa-circle-info text-primary-veris fs-2 p-2 me-2"></i>
                            <p class="fs--1 line-height-16 mb-0" id="infoMessage" style="color: #0A2240;"><b class="fw-medium">Recuerda</b> llegar <b class="fw-medium text-veris">20 minutos antes</b> de la cita y acercarte a caja para realizar el pago.</p>
                        </div>`;
                }
            }
            $('#msg-cita').append(elemMsg);
            
            dataCita.precio = data.data;
            //let urlParams = btoa(JSON.stringify(params));
            if(dataCita.tratamiento && dataCita.tratamiento.esPagada && dataCita.tratamiento.esPagada =="S"){
                $('#btn-pagar').html('Continuar');
                $('#btn-pagar').attr('href','/cita-agendada/{{ $params }}');
            }
            if (dataCita.reservaEdit == null || dataCita.reservaEdit.estaPagada !== "S") {
                $('#btn-pagar').attr('href','/citas-datos-facturacion/{{ $params }}');
            }else{
                $('#btn-pagar').html('Continuar');
                $('#btn-pagar').attr('href','/cita-agendada/{{ $params }}');
            }
            $('#btn-pagar').removeClass('d-none');

            if((data.data.mensajeValidacion !== "" && data.data.mensajeValidacion !== null) || (data.data.mensajeValidacion2 !== "" && data.data.mensajeValidacion2 !== null)){
                $('#mensajeError').html(`${data.data.mensajeValidacion} <br> ${(data.data.mensajeValidacion2 !== null) ? data.data.mensajeValidacion2 : ""}`);
                $('.btn-action-error').addClass('d-none');
                if(data.data.aplicaCondicionesSeguro){
                    //redirecciona al home
                    $('#btn-redirect-error').removeClass('d-none');
                }else{
                    //dismiss modal
                    $('#btn-dismiss-error').removeClass('d-none');
                }
                if(data.data.mostraOpcionLlamar){
                    $('#btn-lamar').attr("href","tel:+593"+data.data.numeroContactCenter);
                }
                $('#ModalError').modal("show");
            }
        }
        return data;
    }

    async function cambiarModalidadCita(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/agenda/cambiarModalidadCita`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";
        let datosReserva = {
            "codigoReserva": dataCita.reservaEdit.idCita,
            "canalOrigen": _canalOrigen
        }
        args["data"] = JSON.stringify(datosReserva);
        const data = await call(args);

        if (data.code == 200){
            location.href = '/cita-agendada/{{ $params }}?mac={{ $mac }}';
        }
    }

    async function reservarCita(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/agenda/reservar?canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        let estaPagada = "N";
        if(dataCita.reservaEdit != null ) {
            estaPagada = dataCita.reservaEdit.estaPagada;
        }

        if(dataCita.origen == "paquetes"){
            estaPagada = "S";
            dataCita.precio = {
                "valorCanalVirtual": 0,
                "secuenciaTransaccion": null,
                "valorCanalVirtual": 0,
                "valorDescuento": 0,
                "valor": 0,
                "numeroAutorizacion": 0
            }
        }

        let datosReserva = {
            "numeroIdentificacion": dataCita.paciente.numeroIdentificacion,
            "tipoIdentificacion": tipoIdentificacion,
            "idIntervalos": dataCita.horario.idIntervalo,
            "codigoEmpresa": 1,
            "codigoEspecialidad": dataCita.especialidad.codigoEspecialidad,
            "codigoPrestacion": dataCita.especialidad.codigoPrestacion,
            "usuarioLogin": dataTurno.paciente.numeroIdentificacion,
            "esOnline": dataCita.online,
            "origen": 4,
            "motivoConsulta": "",
            "codigoServicio": dataCita.especialidad.codigoServicio,
            "canalOrigenAgendamiento": "MVE",
            "codigoEmpresaRegistro": 1,
            "codigoSucursalRegistro": null,
            "porcentajeDescuento": dataCita.horario.porcentajeDescuento,
            "permitePago": dataCita.convenio.permitePago,
            "secuenciaAfiliado": dataCita.convenio.secuenciaAfiliado,
            "canalOrigen": _canalOrigen,
            "enviarLinkPago": null,
            "valorizacion": dataCita.precio.valorCanalVirtual,
            /*precio o reagendamiento*/
            "secuenciaTransaccion": dataCita.precio.secuenciaTransaccion,
            "valorCita": dataCita.precio.valorCanalVirtual,
            "valorDescuento": dataCita.precio.valorDescuento,
            "valorSubtotalCita": dataCita.precio.valor,
            "numeroAutorizacion": dataCita.precio.numeroAutorizacion,
            "esEmbarazada": (dataCita.estaEmbarazada) ? dataCita.estaEmbarazada : "N",
            "fechaSeleccionada": dataCita.horario.dia2,
            /*Si estoy modificando/tratamiento o sino N*/
            "estaPagada": estaPagada
        }

        /*Para reagendamiento*/
        //"codigoReservaCambio": "string",

        if(dataCita.origen == "paquetes"){
            datosReserva.secuenciaPaquetePaciente = dataCita.secuenciaPaquetePaciente
            datosReserva.itemPaquete = dataCita.detalleItemPaquete.itemPaquete;
            // if(dataCita.tratamiento){
                /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
                datosReserva.numeroOrden = dataCita.detalleItemPaquete.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.detalleItemPaquete.codigoEmpresaOrden;
                datosReserva.lineaDetalle = dataCita.detalleItemPaquete.lineaDetalleOrden;
            // }
        }
        
        if(dataCita.online == "N"){
            datosReserva.codigoSucursal = dataCita.central.codigoSucursal;
        }    

        /*Solo si tiene convenio seleccionado*/
        if(dataCita.convenio.codigoConvenio){
            datosReserva.codigoEmpConvenio = 1;
            datosReserva.codigoConvenio = dataCita.convenio.codigoConvenio;
            datosReserva.idCliente = dataCita.convenio.idCliente;
        }

        if(dataCita.tratamiento){
            if(dataCita.origen && dataCita.origen == "Listatratamientos"){
                datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpOrden;
                datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalle;
            }else{
                datosReserva.numeroOrden = dataCita.tratamiento.numeroOrden;
                datosReserva.codigoEmpOrden = dataCita.tratamiento.codigoEmpresaOrden;
                datosReserva.lineaDetalle = dataCita.tratamiento.lineaDetalleOrden;
            }
        }

        if(dataCita.reservaEdit){
            /*se recibe desde 3 flujos: tratamiento/re-agendamiento*/
            datosReserva.numeroOrden = dataCita.reservaEdit.numeroOrden;
            datosReserva.codigoEmpOrden = dataCita.reservaEdit.codigoEmpresaOrden;
            datosReserva.lineaDetalle = dataCita.reservaEdit.lineaDetalleOrden;
            datosReserva.codigoReservaCambio = dataCita.reservaEdit.idCita;
        }

        if(dataCita.sesion){
            datosReserva.secuenciaPlanTto = dataCita.sesion.secuenciaPlanTto;
            datosReserva.numeroSesion = dataCita.sesion.numeroSesion;
            datosReserva.tipoAtencion = dataCita.detalleSesion.tipoAtencion;
            datosReserva.tiempoSesion = dataCita.detalleSesion.tiempoSesion;
            datosReserva.numeroOrden = dataCita.sesion.idOrden;
            datosReserva.lineaDetalle = dataCita.sesion.lineaDetalleOrden
        }

        args["data"] = JSON.stringify(datosReserva);
        const data = await call(args);

        if (data.code == 200){
            dataCita.reserva = data.data;
            guardarData();
            if(dataCita.tratamiento && dataCita.tratamiento.esPagada == "S"){
                // location.href = '/cita-agendada/{{ $params }}?mac={{ $mac }}';
                $('#modalAgendado').modal('show');
                return;
            }
            if(data.data.permitePago == "S"){
                /*
                https://api-phantomx.veris.com.ec/${api_war_digitales}/agenda/validarPermitePago?canalOrigen=MVE_CMV&codigoUsuario=0926178534&tipoItem=C&codigoReserva=4222668939
                */
                if(dataCita.precio.valorCanalVirtual == 0){
                    if(isMobile()){
                        location.href = dataCita.reserva.linkPago.kushki;
                    }else{
                        $('#modalAgendado').modal('show');
                    }
                }else{
                    await crearPreTransaccion()
                }
                //location.href = '/citas-datos-facturacion/{{ $params }}?mac={{ $mac }}';
            }else{
                // $('#modalAgendado').modal('show');
                showLoader();
                location.href = '/citas-datos-facturacion/{{ $params }}?mac={{ $mac }}';
                // location.href = '/cita-agendada/{{ $params }}?mac={{ $mac }}';
            }
        }else{
            //guardarData();
            //location.href = '/citas-datos-facturacion/{{ $params }}?mac={{ $mac }}';
            alert(data.message);
        }
    }

    async function crearPreTransaccion(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/facturacion/crear_pretransaccion?canalOrigen=${_canalOrigen}&plataforma=WEB&version=1.0.0&aplicaNuevoControl=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["bodyType"] = "json";

        // let idPaciente = dataTurno.paciente.numeroPaciente;
        let idPaciente = dataCita.paciente.numeroPaciente;
        let tipoServicio = "CITA";
        let tipoSolicitud = null;

        let codigoConvenio;
        let secuenciaAfiliado;
        
        if(dataCita.listadoPrestaciones && dataCita.listadoPrestaciones.length > 0){
            tipoServicio = "ORDEN";
            addPrestacionesToModal();
            $("#btn-ver-examenes").removeClass('d-none');
        }

        if(dataCita.ordenExterna){
            // addPrestacionesToModal();
            $('.modalDesglose-size').removeClass('modal-lg');
            $('.modalDesglose-size').addClass('modal-md');
            $("#btn-ver-examenes").removeClass('d-none');
            $('#modalDesglose .modal-header').hide();
            // idPaciente = dataCita.paciente.numeroPaciente;
            codigoConvenio = dataCita.ordenExterna.pacientes[0].codigoConvenio;
            if(dataCita.ordenExterna.aplicoDomicilio === 'N'){
                tipoServicio = "ORDEN";
                tipoSolicitud = "LAB";
            }else{
                //obtenerPreparacionPrevia();
                tipoServicio = "DOMICILIO";
                tipoSolicitud = "LAB";
            }
        }else{
            if(!dataCita.paquete){
                codigoConvenio = dataCita?.convenio.codigoConvenio;
                secuenciaAfiliado = dataCita?.convenio.secuenciaAfiliado;
            }
        }

        if(dataCita.paquete){
            tipoServicio = "PAQUETE";
        }

        if(dataCita.sesion){
            tipoServicio = "CITA_ODO";
        }

        //Consultar si idPaciente es del que hizo login o del beneficiario de lo que se va a pagar
        let dataPT = {
            "idPaciente":idPaciente,
            //"codigoPreTransaccion": dataCita.reserva.secuenciaTransaccion,
            "tipoServicio": tipoServicio,
            "tipoSolicitud": tipoSolicitud,
            "codigoConvenio": codigoConvenio,
            "secuenciaAfiliado": secuenciaAfiliado,
        }

        if(dataCita.dataOrdenExterna){
            dataPT.codigoPreTransaccion = dataCita.dataOrdenExterna.codigoPreTransaccion
        }

        if(dataCita.reserva){
            dataPT.listaCitas = [{
                "codigoReserva": dataCita.reserva.codigoReserva
            }]
        }

        if(dataCita.paquete){
            dataPT.paquete = {
                "codigoPaquete": dataCita.paquete.codigoPaquete
            }
        }

        if(dataCita.reservaEdit){
            dataPT.listaCitas = [{
                "codigoReserva": dataCita.reservaEdit.idCita
            }]
        }


        if(dataCita.listadoPrestaciones && dataCita.listadoPrestaciones.length > 0){
            dataPT.listaOrdenes = dataCita.listadoPrestaciones;
        }

        if(dataCita.ordenExterna){
            if(dataCita.ordenExterna.aplicoDomicilio === 'N'){
                dataPT.listaOrdenes = dataCita.ordenExterna.pacientes[0].examenes;
            }else{
                dataPT.codigoSolicitud = dataCita.ordenExterna.codigoSolicitud;
            }
        }

        args["data"] = JSON.stringify(dataPT);
        const data = await call(args);
        console.log(data);

        if (data.code == 200){
            dataCita.preTransaccion = data.data;
            guardarData();
            location.href = '/citas-datos-facturacion/{{ $params }}?mac={{ $mac }}';
            showLoader();
        }else{
            alert(data.message);
        }
    }

    function guardarData(){
        localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
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

    async function printFactura(detalle){
        // http://localhost:3001/printer-ticket/v1/printFile?url=https://api-phantomx.veris.com.ec/reportes/v1/facturacion/comprobante_paciente?format=text_plain%26codigoEmpresa=1%26numeroTransaccion=21479281%26codigoSucursalImpresion=1%26usuarioRealizaImpresion=true

        let args = [];
        args["endpoint"] = `http://localhost:3001/printer-ticket/v1/printFile?url=https://api-phantomx.veris.com.ec/reportes/v1/facturacion/comprobante_paciente?format=text_plain&codigoEmpresa=1&numeroTransaccion=${datosPago.comprobantes.transacciones[0].numeroTransaccion}&codigoSucursalImpresion=${dataParametrosGenerales.caja.codigoSucursal}&usuarioRealizaImpresion=true`;
        args["method"] = "GET";
        const data = await call(args);
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
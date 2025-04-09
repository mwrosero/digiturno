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

{{-- Modal Detalle paquete --}}
<div class="modal mt-4" id="modalDetallePaquete" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true" aria-labelledby="modalDetallePaqueteLabel">
    <div class="modal-dialog modal modal-xxl modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header">
                <h5 class="fs--20 line-height-24 mt-3 mb-3 text-center" id="tituloPaquete"></h5
                >
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 0;right: 25px;"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <div class="card shadow-none mb-4">
                    <div class="card-body p-3">
                        <p class="fs--2 mb-4" id="descripcionPaquete"></p>
                        <h6 class="text-start fs--1 fw-medium mb-4">DETALLES DE PAQUETE</h6>
                        <ul class="fs--2 mb-0 text-start" id="detallePaquete">
                        </ul>
                    </div>
                </div>
                <p class="text-veris mt-2 fs-30 line-height-30 fw-bold mb-2 d-none text-center" id="porcentajeDescuento"></p>
                <div class="d-flex justify-content-center align-items-center mx-lg-4 mb-2 lh-1" id="detalleValoresPaquete"></div>
                <input type="hidden" id="paquete">
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <div class="btn fw-normal fs--16 badge bg-veris-dark text-white m-0 px-4 py-2 mx-2 fs-4 w-25" data-bs-dismiss="modal">Cerrar</div>
                <div class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-2 fs-4 btn-comprar-paquete w-25">Comprar</div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex flex-column vh-100">
@include('template.header_agendamiento', ['showInfo' => true])


<div class="flex-grow-1 container-p-y pt-0">
    {{-- <div class="d-flex justify-content-between align-items-center bg-white">
        <h5 class="ps-3 my-auto py-3 fs-20 fs-md-24">{{ __('Comprar promociones') }}</h5>
    </div> --}}
    <section class="mb-0 p-3 pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18 mb-0">{{ __('Promociones sugeridas') }} <a href="/promociones/sugeridas" class="d-none ms-3 fs--2"> Ver todas</a></h5>
        </div>
        <div class="swiper swiper-promociones-sugeridas position-relative py-3 pt-md-2 pb-md-4">
            <div class="swiper-wrapper invisible" id="list-promociones-sugeridas">
                {{-- <div class="swiper-slide">
                    <a class="cursor-pointer">
                        <div class="card m-1">
                            <div class="card-header position-relative feature-img-promocion" style="background: url({{asset('assets/img/card/svg/bg-promo-default.svg')}}) no-repeat center;">
                                <span class="label-descuento-promocion position-absolute fs--2 fw-medium">-20%</span>
                            </div>
                            <div class="card-body p-3 pb-0">
                                <h2 class="title-promocion fs--16 mb-2">Veris Naranja: Videoconsulta de Medicina General + Vitamina C</h2>
                                <h5 class="paciente-promocion fs--2 p-2"><strong>Ideal para: </strong>Michael Washington Rosero Peralta</h5>
                            </div>
                            <div class="card-footer border-0 d-flex justify-content-between align-items-center p-3 pt-0">
                                <div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$98.00</span></div>
                                <div class="precio-venta fs-medium">$78.40</div>
                            </div>
                        </div>
                    </a>
                </div> --}}
            </div>
            <button type="button" id="prevProperties" class="d-flex d-none mt-n4 btn btn-prev rounded-circle"></button>
            <button type="button" id="nextProperties" class="d-flex d-none mt-n4 btn btn-next rounded-circle"></button>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-medium border-start-veris ps-3 fs-18">{{ __('Promociones disponibles') }}</h5>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-6 mb-3">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 p-3" id="search"><img src="{{asset('assets/img/svg/search.svg')}}" alt="veris-promociones"></span>
                    <input type="search" class="form-control bg-transparent fs--16 border-0 p-2 ps-0" name="buscarPorPromocion" id="buscarPorPromocion" placeholder="Ejemplo: Exámenes de laboratorio" aria-describedby="search" />
                </div>
            </div>
        </div>
    </section>
    <section class="mb-3 shadow-bottom d-none">
        <div class="col-auto p-2">
            <button class="btn btn-sm btn-outline-primary-veris ms-2 px-2 waves-effect" type="button" data-bs-toggle="modal" data-bs-target="#modalCategoriaPromociones">
                <p class="fs--1 line-height-16 fw-normal mb-0" id="nombreFiltro">Filtrar por categorías</p>
                <img src="{{asset('assets/img/svg/arrow-down.svg')}}" class="ms-1" alt="filtro categorías"> 
            </button>
            <div class="box-categorias-seleccionadas ms-2 mt-2 d-inline-block justify-content-start align-items-center"></div>
        </div>
    </section>
    <section class="mb-3 p-3 pt-0">
        <div class="row justify-content-center mt-0">
            <div class="col-lg-10">
                <div class="row gy-3" id="listado-paquetes">
                    {{-- <div class="col-md-6">
                        <div class="card w-100">
                            <a href="{{route('home.promocionDetalle')}}">
                                <div class="row g-0 justify-content-between align-items-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img/svg/promocion.svg') }}" class="img-fluid" alt="{{ __('promoción') }}">
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body p--2">
                                            <h6 class="text-end fw-medium text-one-line">Prevención y Cuidado Mamario Integral</h6>
                                            <div class="d-flex justify-content-end">
                                                <span class="badge bg-primary d-flex align-items-center px-3 mx-3">-20%</span>
                                                <div class="content-precio text-end">
                                                    <p class="text-secondary fs--3 mb-0">Antes <del>$98.00</del></p>
                                                    <h4 class="fw-medium lh-1 mb-0" style="color: #6E7A8C !important;">$78.40</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
</div>
</div>
<script>
    let page = 1;
    let perPage = 18;
    let cargandoContenido = false;
    let isFiltered = false;

    let globalTurno = localStorage.getItem('turno-{{ $params }}');
    localStorage.setItem('flujo','agendamiento');
    let dataTurno = JSON.parse(globalTurno);

    let local = localStorage.getItem('cita-{{ $params }}');
    let dataCita = JSON.parse(local);

    document.addEventListener("DOMContentLoaded", async function () {
        // obtenerCategorias();
        await obtenerPaquetesSugeridos();
        await obtenerPaquetesPromocionales();

        $('body').on('click', '.btnEliminarCategoria', async function(){
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').removeClass('category-selected');
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').find('.ico-unselected').removeClass('d-none')
            $('[categoria-rel="'+$(this).attr("categoria-rel")+'"]').find('.ico-selected').addClass('d-none')
            $('.btnAplicarFiltroCategorias').click();
        })

        $('body').on('click', '.btnAplicarFiltroCategorias', async function(){
            let categorias = await obtenerCategoriasSeleccionadas("texto-valor");
            let elem = ``;
            $.each(categorias, function(key, value){
                let label = value.split("-");
                elem += `<span class="badge bg-filter-promocion p-2 me-2 mb-2 fs--2 fw-medium">${label[1]} <i class="fa-solid fa-xmark ms-2 cursor-pointer btnEliminarCategoria" categoria-rel="${label[0]}"></i></span>`
            })
            $('.box-categorias-seleccionadas').html(elem);
            categorias.join(',')
            page = 1;
            $('#listado-paquetes').empty();
            cargandoContenido = false;
            isFiltered = true;
            await obtenerPaquetesPromocionales();
            isFiltered = false;
        })

        $('body').on('click', '.category-item', function(){
            // if (!$(event.target).hasClass('btn-unselect')) {
                if($(this).hasClass('category-selected')){
                    $(this).find('.ico-unselected').removeClass('d-none')
                    $(this).find('.ico-selected').addClass('d-none')
                    $(this).removeClass('category-selected');
                }else{
                    $(this).find('.ico-selected').removeClass('d-none')
                    $(this).find('.ico-unselected').addClass('d-none')
                    $(this).addClass('category-selected');
                }
            // }
        })

        // $('body').on('click', '.btn-unselect', function(){
        //     $(this).parent().removeClass('category-selected');
        // })

        var swiper = new Swiper('.swiper-promociones-sugeridas', {
            // slidesPerView: 1,
            spaceBetween: 8,
            
            navigation: {
                nextEl: '.btn-next',
                prevEl: '.btn-prev',
            },
            autoplay: false,
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
                768: {
                    slidesPerView: 2.3,
                    // centeredSlides: true,
                    // loop: true,
                    // spaceBetween: 8,
                },
                1024: {
                    slidesPerView: 3.3,
                    // spaceBetween: 8,
                },
                1240: {
                    slidesPerView: 4.3,
                    // spaceBetween: 8,
                },
            },
        });

        $('#list-promociones-sugeridas').removeClass('invisible');

        $(document.body).on('touchmove', onScroll); // for mobile
        $(window).on('scroll', onScroll); 

        async function onScroll(){
            console.log('onScroll');
            if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 100 > $(document).height()) {
                cargandoContenido = true;
                console.log("near bottom!");
                await obtenerPaquetesPromocionales();
            }
        }

        // $(window).scroll(function() {
        // $(window).on('scroll touchmove', async function() {
        //     if(!cargandoContenido && !isFiltered && $(window).scrollTop() + $(window).height() + 10 > $(document).height()) {
        //         cargandoContenido = true;
        //         // console.log("near bottom!");
        //         obtenerPaquetesPromocionales();
        //     }
        // });

        $('body').on('click','.btn-comprar-paquete', async function(){
            let paquete = JSON.parse($('#paquete').val());
            console.log(paquete)
            await asignarPaquete(paquete);
        })

        $('body').on('click','.btn-detalle', async function(){
            $('#paquete').val($(this).attr("data-rel"));
            let detalle = JSON.parse($(this).attr("data-rel"));
            $('#tituloPaquete').html(detalle.nombrePaquete)
            $('#descripcionPaquete').html(detalle.descripcionPaquete);

            let valorAnteriorElem = ``;
            if(detalle.porcentajeDescuento > 0){
                $('#porcentajeDescuento').html(`-${detalle.porcentajeDescuento}% OFF`).removeClass('d-none');
                $('#porcentajeDescuento').removeClass('d-none');
                //$('#valorAnteriorPaquete').html(`$${detalle.valorAnteriorPaquete.toFixed(2)}`);
                valorAnteriorElem += `<p class="fs--20 fw-normal mb-0 me-2" style="color: #6E7A8C !important;"><del id="valorAnteriorPaquete">$${detalle.valorAnteriorPaquete.toFixed(2)}</del></p>`;
            }

            let elemValores = `${valorAnteriorElem}
                <h5 class="text-primary-veris fs-30 fw-bold mb-0" id="valorTotalPaquete">$${detalle.valorTotalPaquete.toFixed(2)}</h5>`;

            $('#detalleValoresPaquete').html(elemValores)

            await obtenerDetallePaquetePromocional(detalle);
            $('#modalDetallePaquete').modal('show');
        })

        var typingTimer; // Timer identifier
        var doneTypingInterval = 750; // Tiempo de pausa en milisegundos (0.5 segundos)

        // Evento de escritura en el input
        $('#buscarPorPromocion').on('keyup', async function() {
            clearTimeout(typingTimer); // Limpiar el temporizador cada vez que se escribe

            var searchText = $(this).val();
            if (searchText.length >= 3) { // Solo realizar la búsqueda si hay al menos 3 caracteres
                typingTimer = setTimeout(async function() {
                    page = 1;
                    $('#listado-paquetes').empty();
                    cargandoContenido = true;
                    await obtenerPaquetesPromocionales(); // Llamar a la función de búsqueda después de la pausa
                }, doneTypingInterval);
            }else if(searchText.length == 0){
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                await obtenerPaquetesPromocionales();
            }
        });

        $('#buscarPorPromocion').on('search', function() {
            if ($(this).val().length === 0) {
                page = 1;
                $('#listado-paquetes').empty();
                cargandoContenido = false;
                obtenerPaquetesPromocionales();
            }
        });
    })
    
    let url_pago;
    async function asignarPaquete(paquete){
        let paciente = dataCita.paciente;
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/comercial/asignarpaquete?tipoIdentificacion=${paciente.tipoIdentificacion}&numeroIdentificacion=${paciente.numeroIdentificacion}&codigoEmpresa=${paquete.codigoEmpresaPaquete}&codigoPaquete=${paquete.codigoPaquete}&codigoAsesor=&canalOrigen=KIO_CMV`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        if(data.code == 200){
            dataCita.reservaPaquete = data.data;
            console.log(dataCita)
            url_pago = `/external/payment?tipoArticulo=PAQUETE&codArticulo=${dataCita.reservaPaquete.numeroOrden}&tipoIdentificacion=${ paciente.tipoIdentificacion }&numeroIdentificacion=${ paciente.numeroIdentificacion }&canalOrigen=KIO_CMV&esLinkDigiturno=true&macAddress={{ $mac }}`;
            dataCita.url_pago = url_pago;
            localStorage.setItem('cita-{{ $params }}', JSON.stringify(dataCita));
            location.href = '/citas-datos-facturacion-paquete/{{ $params }}?mac={{ $mac }}';
        }else{
            alert(data.message);
        }
    }

    async function obtenerDetallePaquetePromocional(paquete){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/comercial/detallePaquete?canalOrigen=${_canalOrigen}&codigoEmpresa=${paquete.codigoEmpresaPaquete}&codigoPaquete=${paquete.codigoPaquete}`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            $('#detallePaquete').empty();
            dataCita.detallePaquete = data.data;
            let elem = ``;
            $.each(data.data.detallePromocion, function(key, value){
                $.each(value.detalles, function(k,v){
                    elem += `<li class="mb-0" title="${value.nombreServicio}">${v.nombreComercial}</li>`;
                })
            })
            $('#detallePaquete').append(elem);
        }else{
            alert(data.message);
        }
    }

    async function obtenerCategoriasSeleccionadas(type){
        var itemsSeleccionados = [];
        $('.category-item').each(function() {
            if ($(this).hasClass('category-selected')) {
                if(type == "valor"){
                    itemsSeleccionados.push($(this).attr('categoria-rel'))
                }else{
                    itemsSeleccionados.push($(this).attr('categoria-rel')+'-'+$(this).attr('nombreCategoria-rel'))
                }
            }
        });
        return itemsSeleccionados;
    }

    async function obtenerCategorias(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/comercial/categoriasPaquete?canalOrigen=${_canalOrigen}`;
        args["method"] = "GET";
        args["showLoader"] = false;
        const data = await call(args);
        
        if(data.code == 200){
            let elem = `<h1 class="modal-title fs--20 line-height-24 my-3">Filtrar por</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute;right: 5px;top: 5px;"></button>`;
            $.each(data.data, function(key, categoria){
                elem += `<div nombreCategoria-rel="${capitalizarCadaPalabra(categoria.nombreCategoria)}" categoria-rel="${categoria.nemonicoCategoria}" class="d-flex justify-content-start align-items-center mb-2 cursor-pointer category-item">
                        <img src="${categoria.urlImagenCategoria}" class="ico-categoria me-3 ico-unselected"/>
                        <img src="${categoria.urlImagenCategoriaSel}" class="ico-categoria me-3 ico-selected d-none"/>
                        <span class="fs--16 me-3 text-veris">${capitalizarCadaPalabra(categoria.nombreCategoria)}</span>
                        <i class="fa-solid fa-xmark btn-unselect ms-auto"></i>
                    </div>`
            })
            $('#lista-categorias').html(elem)
        }
    }

    async function obtenerPaquetesSugeridos(){
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=SUGERIDOS&page=1&perPage=5&idPaciente=${dataCita.paciente.numeroPaciente}&estaPagado=false&verDetalle=false`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data)

        if(data.code == 200){
            let elem = ``;
            $.each(data.data.items, function(key, value){
                elem += `<div class="swiper-slide">
                    <div>
                        <div class="card m-1">
                            <div class="card-header position-relative feature-img-promocion" style="background: url(${value.urlImagen}) no-repeat center;">`;
                            if(value.porcentajeDescuento && value.porcentajeDescuento > 0){
                                elem += `<span class="label-descuento-promocion position-absolute fs--2 fw-medium">-${value.porcentajeDescuento}%</span>`;
                            }
                        elem += `</div>
                            <div class="card-body p-3 pb-0">
                                <h2 class="title-promocion fs--16 line-height-20 mb-2 text-capitalize">${value.nombrePaquete.toLowerCase()}</h2>
                                <h5 class="paciente-promocion fs--2 p-2 mb-2 text-nowrap overflow-hidden text-truncate text-capitalize"><strong>Ideal para: </strong>${value.nombrePaciente.toLowerCase()}</h5>
                            </div>
                            <div class="card-footer border-0 texto-end">
                                <div class="d-flex justify-content-between align-items-center p-3 pt-0">`;
                                if(value.porcentajeDescuento && value.porcentajeDescuento > 0){
                                    elem += `<div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$${value.valorAnteriorPaquete.toFixed(2)}</span>
                                    </div>`;
                                }
                                elem += `<div class="precio-venta ms-auto fs-medium">$${value.valorTotalPaquete.toFixed(2)}</div>
                                </div>
                                <button class="btn btn-primary-veris text-white p-2 fs-14 line-height-16 w-50 ms-auto fw-bold rounded-8  btn-detalle btn-detalle" data-rel='${ JSON.stringify(value) }'>Ver detalles</button>
                            </div>
                        </div>
                    </div>
                </div>`;
            })
            $('#list-promociones-sugeridas').html(elem);
        }
    }

    async function obtenerPaquetesPromocionales(){
        let categorias = await obtenerCategoriasSeleccionadas("valor");
        let args = [];
        args["endpoint"] = api_url_digitales + `/${api_war_digitales}/comercial/paquetes?canalOrigen=${_canalOrigen}&codigoEmpresa=1&tipoFiltro=POR_ASIGNAR&page=${page}&perPage=${perPage}&estaPagado=false&verDetalle=false&categoria=${ categorias.join(',') }&buscarPorPromocion=${ (getInput('buscarPorPromocion').replace(/\s/g, '+')) }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        const data = await call(args);

        if (data.code == 200){
            let elem = ``;
            if(data.data.items.length == 0){
                cargandoContenido = true;
            }else{
                cargandoContenido = false;  
            }
            if(data.data.items.length > 0){
                $.each(data.data.items, function(key, paquete){
                    elem += `<div class="col-12 col-md-6 col-xl-4">
                        <div class="card w-100" style="border: 1px solid #E7E9EC;box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.10);border-radius: 8px;">
                            <div class="row g-0 justify-content-between aling-items-center cursor-pointer">
                                <div class="col-4 position-relative feature-img-promocion-horizontal" style="background: url(${paquete.urlImagen}) no-repeat center;">`
                                if(paquete.porcentajeDescuento && paquete.porcentajeDescuento > 0){
                                    elem += `<span class="label-descuento-promocion position-absolute fs--2 fw-medium">-${paquete.porcentajeDescuento}%</span>`;
                                }
                                elem += `</div>
                                <div class="col-8 col-md-8">
                                    <div class="card-body h-100 p--2 pb-2 d-flex flex-column justify-content-center">
                                        <h6 class="title-promocion-horizontal fs--1 line-height-16 mb-2">${capitalizarElemento(paquete.nombrePaquete)}</h6>
                                        <div class="border-0 d-flex justify-content-between align-items-center">`;
                                            if(paquete.porcentajeDescuento && paquete.porcentajeDescuento > 0){
                                                elem += `<div class="precio-anterior me-2">Antes <span class="text-decoration-line-through">$${paquete.valorAnteriorPaquete.toFixed(2)}</span>
                                                </div>`;
                                            }
                                            elem += `<div class="precio-venta ms-auto fs-medium">$${paquete.valorTotalPaquete.toFixed(2)}
                                            </div>
                                        </div>
                                        <button class="btn btn-primary-veris text-white p-2 fs-14 line-height-16 w-50 ms-auto fw-bold rounded-8  btn-detalle my-2 btn-detalle" data-rel='${ JSON.stringify(paquete) }'>Ver detalles</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                })
                page++;
            }else{
                if(page == 1){
                    $('#listado-paquetes').empty();
                    elem += `<p class="fs--16 line-height-20 text-center mt-5 mb-4">No se encontraron coincidencias para tu búsqueda</p>`;
                }
            }
            $('#listado-paquetes').append(elem);
        }else{
            alert(data.message);
        }
    }
</script>

<style>
    .bg-soft-blue {
        background-color: #0071CE !important;
    }
    .modal,
    .modal-xxl{
        background: transparent !important;
    }
</style>
@endsection
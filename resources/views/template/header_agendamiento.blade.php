<!-- Header -->
<header class="header p-2 mb-3 sticky-top bg-white" style="z-index: 1030;">
	<div class="container-fluid g-0">
		<div class="row">
			@if (!empty($showInfo) && $showInfo)
			<div class="col-4 order-2 order-md-1 col-sm-10 col-md-4 d-flex justify-content-start align-items-center mt-3 mt-md-0">
				<a href="#" class="btn-salir text-decoration-none text-veris-dark fs-25 fw-medium">
					{{-- <i class="fa-solid fa-arrow-left me-1"></i> --}}
					<i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
					Salir
				</a>
			</div>
			@endif
			<div class="col-12 order-1 order-md-2 @if (!empty($showInfo) && $showInfo) col-sm-2 col-md-4 @endif text-center my-3 my-md-0">
				@if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
				<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
				@else
				<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
				@endif
			</div>
			@if (!empty($showInfo) && $showInfo)
			<div class="col-8 order-2 order-md-3 col-sm-2 col-md-4 d-flex justify-content-end align-items-center">
				<div id="btnPrint" class="btn btn-primary-veris text-white p-2 px-5 fs-40 line-height-40 fw-bold rounded-8 mt-3 mt-md-0 btn-turno">Generar turno</div>
			</div>
			@endif
		</div>
	</div>
</header>

{{-- Modal consulta inactividad --}}
<div class="modal modal-top fade" id="modalEstasAhiAgenda" tabindex="-1" aria-labelledby="modalEstasAhiAgendaLabel" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal modal-xxl modal-dialog-centered mx-auto">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title text-center my-2 text-uppercase">¿Estás ahí?</h5>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0 d-flex justify-content-center align-items-center">
                <a id="btnSi" href="#" class="btn fw-normal fs--16 badge bg-veris-dark text-white m-0 px-4 py-2 mx-2 fs-4 w-25" data-bs-dismiss="modal">Si</a>
                <a href="#" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-2 fs-4 btn-salir w-25">SALIR</a>
            </div>
        </div>
    </div>
</div>

<style>
	.toast-title {
        color: #fff !important;
    }
    #toast-container > .toast-warning{
        background-image: url("{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exclamation.svg") !important;
    }
    #modalEstasAhiAgenda{
    	z-index: 99999999999999999;
    }
</style>

<script>
	let temporizadorInactividad;
    let temporizadorRespuesta;

    const tiempoInactividad = 30; // Tiempo de inactividad en segundos
    const tiempoMaximoRespuesta = 15; // Tiempo máximo de respuesta al modal en segundos
	$(document).ready(async function() {
		$(document).on("mousemove keydown click scroll", function () {
			console.log("movio algo")
		    reiniciarConteo();
		});
		$("#btnSi").on("click", function () {
		    clearTimeout(temporizadorRespuesta);
		    $("#modalEstasAhiAgenda").fadeOut();
		    console.log("El usuario sigue presente.");
		    reiniciarConteo();
		});
		if(!isMobile()){
            console.log("Iniciando conteo")
            // Iniciar el conteo inicial
            reiniciarConteo();
        }
	})

	function mostrarModal() {
        // Mostrar el modal
        $("#modalEstasAhiAgenda").modal("show");

        // Iniciar temporizador para esperar respuesta
        temporizadorRespuesta = setTimeout(() => {
            $("#modalEstasAhiAgenda").modal("hide");
            console.log("No hubo respuesta a tiempo.");
            let url_salir = `/{{ $mac }}`;
            // if(isMobile() || localStorage.getItem('userKiosko') !== null){
            if (localStorage.getItem('userKiosko') !== null) {
                url_salir = `/kiosko/{{ $mac }}`;
            }
            if(isMobile()){
                url_salir = `/ingreso/{{ $mac }}`;
            }
            location.href = url_salir;
        }, tiempoMaximoRespuesta * 1000);
    }

    // Función para reiniciar el conteo de inactividad
    function reiniciarConteo() {
    	console.log("Conteo reiniciado")
        clearTimeout(temporizadorInactividad);
        temporizadorInactividad = setTimeout(mostrarModal, tiempoInactividad * 1000);
    }
</script>
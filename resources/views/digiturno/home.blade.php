@extends('template.app-template')
@section('content')
<div class="wrapper">
	<!-- Header -->
	@include('template.header', ['showInfo' => false])

	<!-- Content -->
	<main class="content p-2" id="qr-box-container">
		<div class="container-fluid h-100">
			<div class="row d-flex justify-content-between align-items-center h-100">
				<div class="col-6 h-100 d-flex justify-content-center align-items-center">
					<img class="w-100 label-qr" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/label-qr.png" alt="">
				</div>
				<div class="col-6 d-flex justify-content-center align-items-center h-100 text-center">
					{{-- <img src="{{ asset('assets/img/qr-inicio.png') }}" alt="" style="width: 250px"> --}}
					<div>
						<p class="mb-0 fs-70 fw-bold text-white line-height-50">ESCANEA</p>
						<p class="fs-50 mb-3 text-white text-decoration-underline text-center">EL CÓDIGO QR</p>
						<div id="qrcode"></div>
					</div>
				</div>
			</div>
			<!-- Más contenido aquí -->
		</div>
	</main>

	<!-- Footer -->
	<footer class="footer p-3">
		<div class="container-fluid text-center g-0 text-decoration-none">
			<div class="row">
				<div class="col-12 d-flex justify-content-center align-items-center text-decoration-none fw-bold text-veris-dark p-3 px-5 fs-2">
					Toca la pantalla para continuar
					{{-- <h4	 class="text-end me-3"><span class="text-veris">¡Hola!</span> también lo puedes generar<br>un turno desde aquí</h4> --}}
					{{-- <a href="/ingreso/{{ $mac }}" class="text-decoration-none fw-bold text-veris-dark p-3 px-5 fs-2 rounded-8">Toca la pantalla para continuar</a> --}}
				</div>
			</div>
		</div>
	</footer>
</div>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/qrcode.js"></script>
<style>
	.logo{
		max-width: 200px !important;
	}
	#qr-box-container{
		background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/bg-digiturno.jpg) no-repeat center center;
		background-size: cover;
	}
	#qrcode{
	    background: #fff;
	    width: 380px;
	    height: 380px;
	    margin: auto;
	    padding: 10px;
	    border-radius: 40px;
	    box-shadow: inset 0 0 0px 0px #00a6f9;
	    border: 30px solid #00A6F9;
	}
	.label-qr{
		max-width: 500px;
	}

	body{
		overflow: hidden;
	}

	@media only screen and (min-width: 1700px) {
		.label-qr{
			max-width: 700px;
		}
		#qrcode{
			width: 480px;
			height: 480px;
		}
		#qrcode canvas{
			width: 400px;
			height: 400px;
		}
	}
</style>
<script>
	setInterval(actualizarFechaHora, 1000);
	$(document).ready(async function() {
		$('#qrcode').qrcode({
			width: 300,
            height: 300,
            color: "#000",
            bgColor: "#FFF",
            text: `${web_url}/ingreso/{{ $mac }}?utm_source=PC&utm_medium=CENTRAL_&utm_campaign=lanzamiento_digiturno&utm_id={{ $mac }}`
            // text: `${web_url}/ingreso/{{ $mac }}?utm_source=HOJA&utm_medium=CENTRAL_TUMBACO&utm_campaign=lanzamiento_digiturno`
		});

		$('body').on('click touch', function(){
			location.href = `/ingreso/{{ $mac }}`;
		})

		localStorage.clear();

		await parametrosGenerales("{{ $mac }}");
	})
</script>
@endsection
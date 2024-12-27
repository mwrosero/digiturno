@extends('template.app-template')
@section('content')
<div class="wrapper">
	<!-- Header -->
	<header class="header p-3">
		<div class="container-fluid g-0">
			<div class="row">
				<div class="col-12 col-sm-2 col-md-3">
					<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
				</div>
				<div class="col-12 col-sm-10 col-md-9 d-flex justify-content-end align-items-center">
					<div class="time-box badge bg-veris-dark text-center p-3 rounded-8">
						<span class="fs-4">Fecha:</span><span class="ms-1 fs-4 text-veris-light" id="fecha"></span>
						<span class="fs-4 ms-5">Hora:</span><span class="ms-1 fs-4 text-veris-light" id="hora"></span>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Content -->
	<main class="content p-3">
		<div class="container-fluid h-100">
			<div class="row flex-row align-items-start h-100">
				<div class="col-12 bg-silver d-flex justify-content-between align-items-center">
					<div class="p-3 m-3">
						<h2 class="fw-bold">Genera <span class="text-veris">tu turno</span><br><span class="text-veris">desde el celular</span></h2>
					</div>
					<div class="p-3 m-3">
						<h5 class="fw-normal">Escanea el código QR, o también puedes <span class="fw-bold">seleccionar en<br> el botón “continuar”</span> para ingresar y genera tu turno.</h5>
					</div>
					{{-- <a href="/ingreso/{{ $mac }}" class="btn bg-veris text-white p-4 fs-2 rounded-8">Continuar</a> --}}
				</div>
				<div class="col-6 d-flex flex-column justify-content-center align-items-center">
					{{-- <img src="{{ asset('assets/img/qr-inicio.png') }}" alt="" style="width: 250px"> --}}
					<div id="qrcode"></div>
					<p class="mb-0 fs-3 fw-bold text-veris">Escanea</p>
					<span class="fs-4 text-center">para generar tu próximo turno<br>desde tu celular.</span>
				</div>
				<div class="col-1 d-flex justify-content-center align-items-center">
					<span class="fs-40 mt-5">ó</span>
				</div>
				<div class="col-5 d-flex flex-column justify-content-center align-items-center">
					<h4	 class="text-center me-3 mb-4"><span class="text-veris"></span> también lo puedes generar<br>un turno desde aquí</h4	>
					<a href="/ingreso/{{ $mac }}" class="btn bg-veris text-white p-5 px-5 fs-1 rounded-8">Continuar</a>
				</div>
			</div>
			<!-- Más contenido aquí -->
		</div>
	</main>

	<!-- Footer -->
	{{-- <footer class="footer p-3">
		<div class="container-fluid text-center g-0">
			<div class="row">
				<div class="col-12 d-flex justify-content-end align-items-center">
					<h4	 class="text-end me-3"><span class="text-veris">¡Hola!</span> también lo puedes generar<br>un turno desde aquí</h4	>
					<a href="/ingreso/{{ $mac }}" class="btn bg-veris text-white p-3 px-5 fs-4 rounded-8">Continuar</a>
				</div>
			</div>
		</div>
	</footer> --}}
</div>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/qrcode.js"></script>
<script>
	setInterval(actualizarFechaHora, 1000);
	$(document).ready(async function() {
		$('#qrcode').qrcode({
			width: 200,
            height: 200,
            color: "#000",
            bgColor: "#FFF",
            text: `${web_url}/ingreso/{{ $mac }}`
		});
	})
</script>
@endsection
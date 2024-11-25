@extends('template.app-template')
@section('content')
<div class="wrapper">
	<!-- Header -->
	<header class="header p-3">
		<div class="container-fluid g-0">
			<div class="row">
				<div class="col-12 col-sm-2 col-md-3">
					<img class="w-100 logo" src="{{ asset('assets/img/veris-large.png') }}" alt="">
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
						<h5 class="fw-normal"><span class="fw-bold">Escanea el código QR, o también puedes aplasta<br>en “continuar”</span> para ingresar y genera tu turno.</h5>
					</div>
				</div>
				<div class="col-12 d-flex flex-column justify-content-center align-items-center">
					<img src="{{ asset('assets/img/qr-inicio.png') }}" alt="" style="width: 250px">
					<p class="mb-0 fs-3 fw-bold text-veris">Escanea</p>
					<span class="fs-4 text-center">para generar tu próximo turno<br>desde tu celular.</span>
				</div>
			</div>
			<!-- Más contenido aquí -->
		</div>
	</main>

	<!-- Footer -->
	<footer class="footer p-3">
		<div class="container-fluid text-center g-0">
			<div class="row">
				<div class="col-12 d-flex justify-content-end align-items-center">
					<h4	 class="text-end me-3"><span class="text-veris">¡Hola!</span> también lo puedes generar<br>un turno desde aquí</h4	>
					<a href="/ingreso/{{ $mac }}" class="btn bg-veris text-white p-3 px-5 fs-4 rounded-8">Continuar</a>
				</div>
			</div>
		</div>
	</footer>
</div>
<script>
	setInterval(actualizarFechaHora, 1000);
</script>
@endsection
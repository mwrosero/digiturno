<!-- Header -->
<header class="header p-2">
	<div class="container-fluid g-0">
		<div class="row">
			@if (!empty($showInfo) && $showInfo)
			<div class="col-4 order-2 order-md-1 col-sm-10 col-md-4 d-flex justify-content-start align-items-center mt-3 mt-md-0">
				<a href="#" class="btn-salir text-decoration-none text-veris-dark fs-25 fw-medium">
					<i class="fa-solid fa-arrow-left me-1"></i>
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
				<div id="btnPrint" class="btn bg-veris text-white p-2 px-5 fs-40 fw-bold rounded-8 mt-3 mt-md-0 btn-turno">Generar turno</div>
			</div>
			@endif
		</div>
	</div>
</header>
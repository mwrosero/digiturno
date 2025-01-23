<!-- Header -->
<header class="header p-2">
	<div class="container-fluid g-0">
		<div class="row">
			@if (!empty($showInfo) && $showInfo)
			<div class="col-12 col-sm-10 col-md-4 d-flex justify-content-start align-items-center">
				<a href="#" class="btn-salir text-decoration-none text-veris-dark fs-20 fw-medium">
					<i class="fa-solid fa-arrow-left me-1"></i>
					Salir
				</a>
			</div>
			@endif
			<div class="col-12 @if (!empty($showInfo) && $showInfo) col-sm-2 col-md-4 @endif text-center">
				@if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
				<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
				@else
				<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
				@endif
			</div>
			@if (!empty($_showInfo) && $_showInfo)
			<div class="col-12 col-sm-10 col-md-9 d-flex justify-content-end align-items-center">
				<div class="time-box badge bg-veris-dark text-center p-3 rounded-8">
					<span class="fs-4">Fecha:</span><span class="ms-1 fs-4 text-veris-light" id="fecha"></span>
					<span class="fs-4 ms-5 d-none">Hora:</span><span class="ms-1 fs-4 text-veris-light d-none" id="hora"></span>
                    <span class="fs-4 ms-5">Central:</span><span class="ms-1 fs-4 text-veris-light" id="central"></span>
				</div>
			</div>
			@endif
		</div>
	</div>
</header>
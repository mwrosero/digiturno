@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/kioskboard-2.3.0.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-2.3.0.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="wrapper">
	<!-- Header -->
	@include('template.header', ['showInfo' => false])

	{{-- login user --}}
	<main class="content p-2 not-logged d-none">
		<div class="col-12 bg-silver mb-3">
			<div class="row d-flex align-items-center">
				<div class="col-12 col-md-5">
					<h2 class="fw-bold p-1 p-md-3 m-1 m-md-3">Datos <span class="text-veris">del empleado</span></h2>
				</div>
				<div class="col-12 col-md-7 text-end">
					<h5 class="fw-normal p-1 p-md-3 m-1 m-md-3 text-start d-inline-block"><span class="fw-bold">Ingresa tu usuario</span> para aperturar<br class="d-none d-md-block">  el Digiturno 
						@if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
						ParaMi.
						@else
						Veris.
						@endif
					</h5>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-8 offset-md-2 mb-4 text-center mt-5">
    		<input autocomplete="off" class="w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1 mb-2" id="user" type="text" placeholder="Ingresar Usuario" />
    		<input autocomplete="off" type="password" class="w-100 mt-3 onlyLetters keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1 mb-2" id="password" type="text" placeholder="Ingresar Clave" />
    		<div onclick="loginUser();" class="btn bg-veris btn-ingresar text-white mx-auto fs-1 p-3 mb-5 rounded-8 my-5">INICIALIZAR</div>
    	</div>
	</main>

	<!-- Content -->
	<main class="content p-2 logged d-none" id="qr-box-container">
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
	<footer class="footer p-3 logged d-none">
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
	let accion = "INICIALIZAR";
	$(document).ready(async function() {
		const userVeris = localStorage.getItem('userVeris');
		if (localStorage.getItem('userVeris') !== null) {
			$('.logged').removeClass('d-none')

			$('body').on('click touch', function(){
				location.href = `/ingreso/{{ $mac }}`;
			})	
		}else{
			$('.not-logged').removeClass('d-none')

			KioskBoard.init({
	        	keysJsonUrl: '{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-keys-spanish.json',
	        	// keysNumeric: true,
	            //keysArrayOfObjects: null, // Usa el teclado QWERTY predeterminado
	            language: 'es',          // Idioma (ejemplo: 'es' para español)
	            theme: 'light',          // Tema del teclado ('light' o 'dark')
	            keysSpacebarText: 'Espacio',
	            allowMobileKeyboard: false,
	            capsLockActive: false,
	            keysEnterText: '<i class="material-icons enter-key-icon">check_circle</i>',
	        });

	        KioskBoard.run('.virtual-keyboard-all', {});
		}

		$('#qrcode').qrcode({
			width: 300,
            height: 300,
            color: "#000",
            bgColor: "#FFF",
            text: `${web_url}/ingreso/{{ $mac }}?utm_source=PC&utm_medium=CENTRAL_&utm_campaign=lanzamiento_digiturno&utm_id={{ $mac }}`
            // text: `${web_url}/ingreso/{{ $mac }}?utm_source=HOJA&utm_medium=CENTRAL_TUMBACO&utm_campaign=lanzamiento_digiturno`
		});

		localStorage.clear();

		if (userVeris !== null) {
			// Reescribe usuario
		    localStorage.setItem('userVeris', userVeris);
		}


		await parametrosGenerales("{{ $mac }}");
	})


	async function loginUser(){
		let user = $('#user').val();
		let password = $('#password').val();
		if(user == "" || password == "" ){
			alert("Debe ingresar sus credenciales");
			return;
		}
		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war_seguridad}/autenticacion/login`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["esLogin"] = true;
        args["basic"] = btoa(user+":"+password);
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
      	if(data.code == 200){
      		localStorage.setItem('userVeris', JSON.stringify(data.data));
      		await inicializar();
      	}else{
      		alert(data.message)
      	}	
	}

	async function inicializar(){
		let userData = JSON.parse(localStorage.getItem('userVeris'));
		let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/session?macAddress={{ $mac }}&accion=${accion}&codigoUsuario=${ userData.secuenciaUsuario }`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;

        const data = await call(args);
        if(data.code == 200){
            console.log(data)
            location.reload();
        }else{
        	alert(data.message);
        }
        return;
	}
</script>
@endsection
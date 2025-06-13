@extends('template.app-template')
@section('content')
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/kioskboard-2.3.0.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-2.3.0.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<div class="wrapper">
	<!-- Header -->
	@include('template.header', ['showInfo' => false])
	{{-- Modal coincidencias --}}
	<div class="modal modal-top fade" id="modalConsultaUser" tabindex="-1" aria-labelledby="modalConsultaUserLabel" aria-hidden="true">
	    <div class="modal-dialog modal modal-dialog-centered mx-auto">
	        <form class="modal-content rounded-8">
	            <div class="modal-header d-none">
	                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>
	            <div class="modal-body p-3">
	                <h5 class="fs--20 line-height-24 mt-3 mb--20" id="info-user">Existe una sesión iniciada, elija</h5>
	            </div>
	            <div class="modal-footer pt-0 pb-3 px-3 border-0">
	                <button type="button" class="btn fw-normal fs--16 badge bg-veris-dark text-white m-0 px-4 py-2 mx-auto fs-4 w-100 my-2" id="btn-user-active">Continuar con: <span id="user-active"></span></button>
	                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto fs-4 w-100 my-2" id="btn-user-new">Cerrar e Iniciar con: <span id="user-new"></span></button>
	            </div>
	        </form>
	    </div>
	</div>

	{{-- login user --}}
	<main class="content p-2 not-logged-userpass d-none">
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
    		<input autocomplete="off" class="w-100 onlyLetters keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1 mb-2" id="user" type="text" placeholder="Ingresar Usuario" />
    		<div class="w-100 d-flex justify-content-between align-items-center">
    			<input autocomplete="off" type="password" class="w-100 mt-3 onlyLetters keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1 mb-2" id="password" type="text" placeholder="Ingresar Clave" data-kioskboard-specialcharacters="true"/>
    			<div class="box-ver-pass ms-3 fs-40 text-veris">
    				<i class="fa-solid fa-eye"></i>
    			</div>
    		</div>
    		<div onclick="loginUser();" class="btn bg-veris btn-ingresar text-white mx-auto fs-1 p-3 mb-5 rounded-8 my-5">INICIAR SESIÓN</div>
    	</div>
    	<div class="col-12 col-md-8 offset-md-2 mb-4 text-center mt-3 box-btn-anonimo">
    		<div onclick="loginAnonimo();" class="btn bg-veris-dark btn-anonimo text-white mx-auto fs-3 p-2 mb-5 rounded-8 my-3"><i class="fa-solid fa-user-secret me-2"></i>INGRESO ANÓNIMO</div>
    	</div>
    	<div class="col-12 col-md-8 offset-md-2 mb-4 text-center mt-3 box-btn-cerrar-caja d-none">
    		<div onclick="preguntaCerrar()" class="btn bg-success btn-cerrar-caja text-white mx-auto fs-3 p-2 mb-2 rounded-8 my-0"><i class="fa-solid fa-box me-2"></i>Cerrar Caja</div>
    	</div>
	</main>
	<main class="content p-2 not-logged d-none" style="overflow-x: hidden;">
		<div class="col-12 bg-silver mb-3">
			<div class="row d-flex align-items-center">
				<div class="col-12 col-md-5">
					<h2 class="fw-bold p-1 p-md-3 m-1 m-md-3">Datos <span class="text-veris">de la Caja</span></h2>
				</div>
				<div class="col-12 col-md-7 text-end">
					<h5 class="fw-normal p-1 p-md-3 m-1 m-md-3 text-start d-inline-block"><span class="fw-bold">Selecciona la Caja</span> para aperturar<br class="d-none d-md-block"> el Kiosko Digiturno 
						@if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
						ParaMi.
						@else
						Veris.
						@endif
					</h5>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6 offset-md-3 mb-4 text-center mt-5">
    		<div class="w-100" id="list-cajas">
    			
    		</div>
    	</div>
	</main>

	<!-- Content -->
	<main class="content p-2 logged d-none" id="qr-box-container">
		<div class="container-fluid h-100">
			<div class="row d-flex justify-content-between align-items-center h-100 d-none">
				<div class="col-8 mt-5 offset-2 d-flex justify-content-center align-items-center h-100 text-center">
					{{-- <img src="{{ asset('assets/img/qr-inicio.png') }}" alt="" style="width: 250px"> --}}
					<div class="mt-5">
						<p class="mb-0 fs-70 fw-bold text-white line-height-50">ESCANEA</p>
						<p class="fs-50 mb-3 text-white text-decoration-underline text-center">EL CÓDIGO QR</p>
						<div id="qrcode"></div>
					</div>
				</div>
				<div class="col-8 mt-3 offset-2 h-100 d-flex justify-content-center align-items-center">
					<img class="w-100 label-qr" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/label-qr.png" alt="">
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
					¡Toca la pantalla para continuar!
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
	.new-box-inicio{
		background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/bg-start.png) no-repeat center center;
		background-size: cover;
		width: 100%;
		height: 100%;
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

		let userVeris = localStorage.getItem('userVeris');
		let userAnonimo = localStorage.getItem('userAnonimo');
		console.log({estaAperturada});

		await parametrosGenerales("{{ $mac }}", false, true);
		
		if (localStorage.getItem('userVeris') !== null || localStorage.getItem('userAnonimo') !== null) {
			// await parametrosGenerales("{{ $mac }}", false, true);
			let userKiosko = localStorage.getItem('userKiosko');

			if (localStorage.getItem('userKiosko') !== null) {
				$('.logged').removeClass('d-none');
				$('body').html(`<div class="new-box-inicio" style="background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/bg-start.png) no-repeat center center;background-size: cover;width: 100%;height: 100%;"></div>`)
				

				$('body').on('click touch', function(){
					location.href = `/ingreso/{{ $mac }}`;
				})	

				localStorage.clear();
				{{-- await parametrosGenerales("{{ $mac }}"); --}}
			}else{
				{{-- await parametrosGenerales("{{ $mac }}"); --}}
				await consultarCajas();
				$('.not-logged').removeClass('d-none');
			}

			$('#qrcode').qrcode({
				width: 300,
	            height: 300,
	            color: "#000",
	            bgColor: "#FFF",
	            text: `${web_url}/ingreso/{{ $mac }}?utm_source=PC&utm_medium=CENTRAL_&utm_campaign=lanzamiento_digiturno&utm_id={{ $mac }}`
	            // text: `${web_url}/ingreso/{{ $mac }}?utm_source=HOJA&utm_medium=CENTRAL_TUMBACO&utm_campaign=lanzamiento_digiturno`
			});

			if (userKiosko !== null) {
				// Reescribe usuario
			    localStorage.setItem('userKiosko', userKiosko);
			    if(userVeris !== null){
			    	localStorage.setItem('userVeris', userVeris);
			    }
			    if(userAnonimo !== null){
			    	localStorage.setItem('userAnonimo', userAnonimo);
			    }
			}

			$('body').on('click', '.btn-aperturar', async function(){
				let caja = JSON.parse($(this).attr('data-rel'));
				console.log(caja)
				await aperturarCaja(caja);
			})
		}else{
			// mostrar login page
			
			// await parametrosGenerales("{{ $mac }}", false, true);
			if(!isMobile()){

		        KioskBoard.init({
		        	keysJsonUrl: '{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-keys-spanish.json',
		        	// keysNumeric: true,
		            //keysArrayOfObjects: null, // Usa el teclado QWERTY predeterminado
		            language: 'es',          // Idioma (ejemplo: 'es' para español)
		            theme: 'light',          // Tema del teclado ('light' o 'dark')
		            keysSpacebarText: 'Espacio',
		            allowMobileKeyboard: false,
		            capsLockActive: true,
		            keysEnterText: '<i class="material-icons enter-key-icon">check_circle</i>',
		        });

		        KioskBoard.run('.virtual-keyboard-all', {});

		        if(isKiosk()){
		        	const style = document.createElement("style");
		            style.innerHTML = `
		                #KioskBoard-VirtualKeyboard .kioskboard-wrapper {
		                    padding-bottom: 300px !important;
		                }
		            `;
		            document.head.appendChild(style);
		        }
	    	}
			console.log("LOGIN")
			await consultarCajas(true);
			
			//Eliminar el kiosko
			if(!estaAperturada){
				localStorage.removeItem("userKiosko");
				//location.reload();
			}

			$('.not-logged-userpass').removeClass('d-none')

			$('body').on('click', '#btn-user-new', async function(){
				await finalizar($(this).attr('user-rel'));
			})

			$('body').on('click', '#btn-user-active', async function(){
				localStorage.setItem('userVeris', JSON.stringify(userLogged));
	            location.reload();
			})

			$('body').on('click', '.box-ver-pass', async function(){
				console.log($('#password').attr('type'))
				if($('#password').attr('type') == "text"){
					$('#password').attr('type','password');
					$('.box-ver-pass').html(`<i class="fa-solid fa-eye"></i>`);
				}else{
					$('#password').attr('type','text');
					$('.box-ver-pass').html(`<i class="fa-solid fa-eye-slash"></i>`);
				}
			})
		}
		
	})

	async function preguntaCerrar(){
		if (confirm("Desea cerrar caja?")) {
		    await cerrarCaja();
		}
	}

	async function cerrarCaja(){
		let caja = JSON.parse(localStorage.getItem('userKiosko'));
		let args = [];
		// arqueos_caja/apertura
        args["endpoint"] = `${api_url_digitales}/facturacion/v1/arqueos_caja/cierre`;
        args["method"] = "PUT";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
			"codigoCaja": caja.codigoCaja,
			"numeroPuntoEmision": caja.numeroPuntoEmision,
			"codigoEmpresa": caja.codigoEmpresa,
			"codigoSucursal": caja.codigoSucursal,
			"fondoInicial": 0.00,
			"ipAddress": "{{ $ip }}",
			"codigoUsuario": caja.codigoUsuario,
			"hostName": caja.codigoUsuario,
			"billetes": {
				"b100": 0,
				"b50": 0,
				"b20": 0,
				"b10": 0,
				"b5": 0,
				"b2": 0,
				"b1": 0
			},
			"monedas": {
				"m1": 0,
				"m50": 0,
				"m25": 0,
				"m10": 0,
				"m5": 0,
				"m01": 0
			},
			"valorConteoFisico": 0,
			"numeroPapeleta": 0,
			"codigoInstitucion": 0,
			"ingresoComprobantesManuales": true

		})
        console.log(args["data"] )
        const data = await call(args);
        console.log(data);

        if(data.code == 200){
			await cerrarLote(data.data.secuenciaArqueo);
        	localStorage.clear();
        	let url_salir = `/kiosko/{{ $mac }}`;
            location.href = url_salir;
        }else{
        	alert(data.message);
        }
	}

	async function cerrarLote(secuenciaArqueo) {
		let args = [];
		// arqueos_caja/apertura
        args["endpoint"] = `${api_url_digitales}/facturacion/v1/pin_pad/cierre_lote?codigoEmpresa=1&esManual=false`;
        args["method"] = "POST";
        args["showLoader"] = true;
		args["dismissAlert"] = true;
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
		args["data"] = JSON.stringify({
			"caja": dataParametrosGenerales.caja,
			"secuenciaArqueo": secuenciaArqueo
		});
		const data = await call(args);
        console.log(data);
	}

	async function consultarCajas(soloConsulta = false){
		let args = [];
        args["endpoint"] = `${api_url_digitales}/facturacion/v1/cajeros/${ dataParametrosGenerales.secuenciaUsuario }/cajas?codigoEmpresa=1&codigoSucursal=${ dataParametrosGenerales.caja.codigoSucursal }`;
        args["method"] = "GET";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";

        const data = await call(args);
         console.log(data);
         console.log({soloConsulta});

        if(data.code == 200){
        	if(data.data.length == 1 && data.data[0].seEncuentraAperturada){
        		let caja = data.data[0];
        		localStorage.setItem('userKiosko', JSON.stringify(caja));
        		if(soloConsulta){
        			//Mostrar boton de cerrar caja
        			//$('.box-btn-cerrar-caja').removeClass('d-none');
        			console.log('Mostrar')
        			return;
        		}
        		console.log(data.data[0])
        		// location.reload();
        		location.href = `/kiosko/{{ $mac }}`;
        	}else{
				estaAperturada = false;
				//$('.box-btn-anonimo').addClass('d-none')
        		if(soloConsulta){
        			//Ocultar boton de cerrar caja
        			$('.box-btn-cerrar-caja').addClass('d-none');
        			return;
        		}
        		let elem = ``;
        		$.each(data.data, function(key, value){
        			elem += `<div class="p-3 mb-3 text-start d-flex justify-content-between align-items-center shadow rounded-8">
        				<div>
        					<p class="mb-0">${ value.nombreCaja }</p>
        					<span class="fs-12">${ value.nombreCompletoUsuario }</span>
        				</div>
        				<div data-rel='${JSON.stringify(value)}' class="btn bg-veris rounded-8 text-white btn-aperturar">APERTURAR</div>
        			</div>`
        		})
        		$('#list-cajas').html(elem);
        		$('.not-logged').removeClass('d-none');
        	}
        }else{
			estaAperturada = false;
        	alert(data.message);
        }
	}

	async function aperturarCaja(caja){
		let args = [];
		// arqueos_caja/apertura
        args["endpoint"] = `${api_url_digitales}/facturacion/v1/arqueos_caja/apertura`;
        args["method"] = "POST";
        args["showLoader"] = true;
        args["token"] = "{{ $accessToken }}";
        args["bodyType"] = "json";
        args["data"] = JSON.stringify({
			"codigoCaja": caja.codigoCaja,
			"numeroPuntoEmision": caja.numeroPuntoEmision,
			"codigoEmpresa": caja.codigoEmpresa,
			"codigoSucursal": caja.codigoSucursal,
			"fondoInicial": 0.00,
			"ipAddress": "{{ $ip }}",
			"codigoUsuario": caja.codigoUsuario,
			"hostName": caja.codigoUsuario
		})

        const data = await call(args);
        console.log(data);

        if(data.code == 200){
        	localStorage.setItem('userKiosko', JSON.stringify(caja));
        	// location.reload();
        	location.href = `/ingreso/{{ $mac }}`;
        }else{
        	alert(data.message);
        }
	}

	async function loginAnonimo(){
		localStorage.setItem('userAnonimo', true);
        location.reload();
	}

	function b64EncodeUnicode(str) {
	    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
	    	return String.fromCharCode(parseInt(p1,16))
	    }));
	}

	let userLogged = [];
	async function loginUser(){
		let user = $('#user').val();
		let password = $('#password').val();
		if(user == "" || password == "" ){
			alert("Debe ingresar sus credenciales");
			return;
		}
		let basicData = b64EncodeUnicode(user.toUpperCase()+":"+password);
		console.log(basicData);
		let args = [];
		args["endpoint"] = `${api_url_digitales}/${api_war_seguridad}/autenticacion/login`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["esLogin"] = true;
        args["basic"] = basicData//btoa("lzuÃ±iga:Andres34.*");//btoa(user.toUpperCase()+":"+password);
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
      	if(data.code == 200){
      		userLogged = data.data;
      		await consultar()
      	}else{
      		alert(data.message)
      	}	
	}

	let user_consulta;
	async function consultar(){
		let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/session?macAddress={{ $mac }}&accion=CONSULTAR&codigoUsuario=AKOLD`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;

        const data = await call(args);
        if(data.code == 200){
            if(data.data == null){
            	await inicializar();
            }else{
            	user_consulta = data.data;
            	$('#user-active').html(`${data.data.codigoUsuario}`).attr('user-rel',data.data.codigoUsuario);
            	$('#btn-user-active').attr('user-rel',userLogged.codigoUsuario);
				$('#user-new').html(`${userLogged.codigoUsuario}`).attr('user-rel',userLogged.codigoUsuario);
				$('#btn-user-new').attr('user-rel',data.data.codigoUsuario);
            	$('#modalConsultaUser').modal('show');
            }
        }else{
        	alert(data.message);
        }
        return;
	}

	async function inicializar(){
		// let userData = JSON.parse(localStorage.getItem('userVeris'));
		let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/session?macAddress={{ $mac }}&accion=${accion}&codigoUsuario=${ userLogged.codigoUsuario }`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;

        const data = await call(args);
        if(data.code == 200){
            console.log(data)
            localStorage.setItem('userVeris', JSON.stringify(userLogged));
            location.reload();
        }else{
        	alert(data.message);
        }
        return;
	}

	async function finalizar(user){
		let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/session?macAddress={{ $mac }}&accion=FINALIZAR&codigoUsuario=${ user }`;
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;

        const data = await call(args);
        if(data.code == 200){
            await inicializar();
        }else{
        	alert(data.message);
        }
        return;
	}
</script>
@endsection
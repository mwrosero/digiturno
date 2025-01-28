@extends('template.app-template')
@section('content')
@php
    $tokenTurno = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/kioskboard-2.3.0.min.css">
<link rel="stylesheet" href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/css/print.min.css">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/print.min.js"></script>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-2.3.0.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Modal usuario turno -->
<div class="modal fade" id="modalIngresarNombres" tabindex="-1" aria-labelledby="modalIngresarNombresLabel">
    <div class="modal-dialog modal-sm modal-dialog-top modal-dialog-scrollable mx-auto">
        <div class="modal-content rounded-8">
            <div class="modal-body text-center p-3 pb-2">
                <h1 class="modal-title fs--20 line-height-24 fw-medium mb-3">Veris</h1>
                <p class="fs--16 fw-normal text-veris mb-3" id="mensajeErrorUsuario"></p>
                <input autocomplete="off" class="w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1 mb-2" id="nombresTM" type="text" placeholder="Ingresa nombres" />
			    <input autocomplete="off" class="w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 text-center fs-1 rounded-8" id="apellidosTM" type="text" placeholder="Ingresa apellidos" />
			    <div onclick="crearTurno();" class="btn bg-veris btn-crear-turno text-white mx-auto mb-5 rounded-8 my-5">CREAR TURNO</div>
	    		{{-- <button onclick="buscarUsuario();" class="btn bg-veris text-white mt-2 mx-auto">BUSCAR</button> --}}
	    		<div class="w-100 d-none d-md-block">
			    	<div class="keyboardContainer w-100"></div>
			    </div>
            </div>
            {{-- <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <button type="button" class="btn bg-veris btn-ingresar text-white mx-auto rounded-8 mt-3" data-bs-dismiss="modal">Entiendo</button>
            </div> --}}
        </div>
    </div>
</div>
{{-- Modal coincidencias --}}
<div class="modal modal-top fade" id="modalCoincidencias" tabindex="-1" aria-labelledby="modalCoincidenciasLabel" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered mx-auto">
        <form class="modal-content rounded-8">
            <div class="modal-header d-none">
                <button type="button" class="btn-close fw-medium top-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <h5 class="fs--20 line-height-24 mt-3 mb--20">{{ __('Coincidencias') }}</h5>
                <div class="d-flex bg-light mb-3 justify-content-between align-items-center w-100 rounded-8 text-center bg-white text-veris-dark my-2">
	        		<img class="ms-2" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/info-ico.svg" alt="">
	        		<span class="ms-2 text-start flex-grow-1">Por favor verifica la información<br>correcta para continuar.</span>
	        	</div>
                <div class="row gx-2 justify-content-between align-items-center">
                    <ul class="list-group border-0 p-0 px-2" id="listaCoincidencias">
                    </ul>
                </div>
            </div>
            <div class="modal-footer pt-0 pb-3 px-3 border-0">
                <button type="button" class="btn fw-normal fs--16 badge bg-veris text-white m-0 px-4 py-2 mx-auto btn-print-notificar-llegada fs-4" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </form>
    </div>
</div>
<div class="wrapper">
	<!-- Header -->
	<header class="header p-3">
		<div class="container-fluid g-0">
			<div class="row">
				<div class="col-12 col-md-3 text-center text-md-start">
					@if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
					<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
					@else
					<img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
					@endif
				</div>
				<div class="col-9 col-md-9 d-md-flex justify-content-end align-items-center d-none d-md-block">
					<div class="time-box badge bg-veris-dark text-center p-3 rounded-8">
						<span class="fs-4">Fecha:</span><span class="ms-1 fs-4 text-veris-light" id="fecha"></span>
						<span class="fs-4 ms-5 d-none">Hora:</span><span class="ms-1 fs-4 text-veris-light d-none" id="hora"></span>
                        <span class="fs-4 ms-5">Central:</span><span class="ms-1 fs-4 text-veris-light" id="central"></span>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<!-- Content -->
	<main class="content p-3">
		<div class="container-fluid h-100">
			<div class="row flex-row align-items-start">
				<!-- <div class="col-12 bg-silver d-flex justify-content-between align-items-center">
					<div class="p-3 m-3">
						<h2 class="fw-bold">Datos <span class="text-veris">del paciente</span></h2>
					</div>
					<div class="p-3 m-3">
						<h5 class="fw-normal"><span class="fw-bold">Ingresa tu cédula o pasaporte y genera tu turno.</span><br>Además, si eres paciente Mi Veris puedes ver <br>información de tu grupo familiar en un solo lugar.</h5>
					</div>
				</div> -->
				<div class="col-12 bg-silver mb-3">
					<div class="row d-flex align-items-center">
						<div class="col-12 col-md-5">
							<h2 class="fw-bold p-1 p-md-3 m-1 m-md-3">Datos <span class="text-veris">del paciente</span></h2>
						</div>
						<div class="col-12 col-md-7 text-end">
							<h5 class="fw-normal p-1 p-md-3 m-1 m-md-3 text-start d-inline-block"><span class="fw-bold">Ingresa tu cédula o pasaporte y genera tu turno.</span> <br class="d-none d-md-block">Además, si eres paciente 
								@if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
								ParaMi 
								@else
								Mi Veris 
								@endif
							puedes ver <br class="d-none d-md-block">información de tu grupo familiar en un solo lugar.</h5>
						</div>
					</div>
				</div>
				<div class="col-12 g-0 d-flex flex-column justify-content-center align-items-center bg-silver">
					<ul class="nav nav-pills justify-content-between bg-white w-100 rounded-3 mb-3" id="pills-tab" role="tablist">
		                <li class="nav-item flex-fill" role="presentation">
		                    <button data-rel="C" class="nav-link tipoIdentificacion w-100 px-8 px-md-5 d-flex justify-content-center align-items-center active" id="pills-cedula-tab" data-bs-toggle="pill" data-bs-target="#pills-cedula" type="button" role="tab" aria-controls="pills-cedula" aria-selected="true">
		                    	<i class="bi bi-person-vcard icon-tab d-none d-md-inline-block me-2"></i>
			                    Cédula
			                </button>
		                </li>
		                <li class="nav-item flex-fill" role="presentation">
		                    <button data-rel="P" class="nav-link tipoIdentificacion w-100 px-8 px-md-5 d-flex justify-content-center align-items-center" id="pills-pasaporte-tab" data-bs-toggle="pill" data-bs-target="#pills-pasaporte" type="button" role="tab" aria-controls="pills-pasaporte" aria-selected="false">
		                    	<i class="bi bi-passport icon-tab d-none d-md-inline-block me-2"></i>
		                    	Pasaporte
		                    </button>
		                </li>
		                <li class="nav-item flex-fill" role="presentation">
		                    <button data-rel="N" class="nav-link tipoIdentificacion w-100 px-8 px-md-5 d-flex justify-content-center align-items-center" id="pills-nombres-tab" data-bs-toggle="pill" data-bs-target="#pills-nombres" type="button" role="tab" aria-controls="pills-nombres" aria-selected="false">
		                    	<i class="bi bi-person icon-tab d-none d-md-inline-block me-2"></i>
		                    	Nombres
		                    </button>
		                </li>
		            </ul>
		            <div class="tab-content bg-transparent w-100 pt-2" id="pills-tabContent">
						<div class="tab-pane fade mt-3 px-2 w-100 show active" id="pills-cedula" role="tabpanel" aria-labelledby="pills-cedula-tab" tabindex="0">
						    <div class="row">
						    	<div class="col-12 col-md-8 offset-md-2 mb-4 text-center">
						    		<input autocomplete="off" id="cedula" type="text" class="w-100 keyboard-input virtual-keyboard-numpad p-1 rounded-8 text-center fs-1 onlyNumber" maxlength="10" placeholder="Ingresar número de cédula" data-kioskboard-type="numpad" type="number">
						    		<div onclick="buscarUsuario();" class="btn bg-veris btn-ingresar text-white mx-auto fs-1 p-3 mb-5 rounded-8 my-5">CONTINUAR</div>
						    	</div>
						    </div>
						</div>
						<div class="tab-pane fade mt-3 px-2 w-100" id="pills-pasaporte" role="tabpanel" aria-labelledby="pills-pasaporte-tab" tabindex="0">
						    <div class="d-row">
						    	<div class="col-12 col-md-8 offset-md-2 mt-2 mb-4 text-center">
						    		<input autocomplete="off" id="pasaporte" type="text" class="w-100 keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1" data-kioskboard-specialcharacters="true" placeholder="Ingresar número de pasaporte">
						    		<div onclick="buscarUsuario();" class="btn bg-veris btn-ingresar text-white mx-auto fs-1 p-3 mb-5 rounded-8 my-5">CONTINUAR</div>
						    	</div>
						    </div>
						</div>
						<div class="tab-pane fade mt-3 px-2 w-100" id="pills-nombres" role="tabpanel" aria-labelledby="pills-nombres-tab" tabindex="0">
						    <div class="d-row">
						        <div class="col-12 col-md-8 offset-md-2 mt-2 mb-4 text-center">
						    		<input autocomplete="off" class="w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 rounded-8 text-center fs-1 mb-2" id="nombres" type="text" placeholder="Ingresa nombres" />
								    <input autocomplete="off" class="w-100 onlyLetters text-uppercase keyboard-input virtual-keyboard-all p-1 text-center fs-1 rounded-8" id="apellidos" type="text" placeholder="Ingresa apellidos" />
								    <div onclick="buscarUsuario();" class="btn bg-veris btn-ingresar text-white mx-auto fs-1 p-3 mb-5 rounded-8 my-5 ">BUSCAR</div>
						    		{{-- <button onclick="buscarUsuario();" class="btn bg-veris text-white mt-2 mx-auto">BUSCAR</button> --}}
						    		<div class="w-100 d-none d-md-block">
								    	<div class="keyboardContainer w-100"></div>
								    </div>
						        </div>
						        {{-- <div class="col-12 col-md-4 ">
						        	COINCIDENCIAS
						        	<div class="d-flex bg-light mb-3 justify-content-between align-items-center w-100 rounded-8 text-center bg-white text-veris-dark my-2">
						        		<img class="ms-2" src="{{ asset('assets/img/info-ico') }}.svg" alt="">
						        		<span class="ms-2 text-start flex-grow-1">Por favor verifica la información<br>correcta para continuar.</span>
						        	</div>
						        	<div class="w-100" id="listaCoincidencias">
						        		<div class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium">
						        			Michael Washington Rosero Peralta
						        		</div>
						        	</div>
						        </div> --}}
						    </div>
						</div>
					</div>
				</div>
			</div>
			<!-- Más contenido aquí -->
		</div>
	</main>
</div>
{{-- <script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/keyboard.js?v=1.0.8"></script> --}}

<script>
	async function validarCampos(tipo){
		if(tipo == "C"){
			return esValidaCedula($('#cedula').val())
		}else if(tipo == "P"){
			return ($('#pasaporte').val().length > 0 );
		}else{
			return ($('#nombres').val() != "" && $('#apellidos').val() != "")
		}
		return true;
	}
	async function buscarUsuario(){
		let tipo = $('.tipoIdentificacion.active').attr('data-rel');
		let tipoFiltro = ``;
		let valorFiltro = ``;
		let msg = ``;
		switch(tipo){
			case 'C':
				tipoFiltro = `CEDULA`;
				valorFiltro = $('#cedula').val();
				msg = `Cédula inválida`;
			break;
			case 'P':
				tipoFiltro = `PASAPORTE`;
				valorFiltro = $('#pasaporte').val().toUpperCase();
				msg = `Pasaporte inválido`;
			break;
			case 'N':
				tipoFiltro = `NOMBRES`;
				valorFiltro = `${ $('#apellidos').val().toUpperCase() } ${ $('#nombres').val().toUpperCase() }`;
				msg = `Debe ingresar al menos un Nombre y una Apellido`;
			break;
		}
		let valid = await validarCampos(tipo);
		if(!valid){
			$('#mensajeError').html(`${msg}`)
      		$('#modalAlerta').modal('show');
      		// Keyboard.open();
      		return;
		}
		let args = [];
        args["endpoint"] = `${api_url}/${api_war}/paciente/validar_datos?tipoFiltro=${ tipoFiltro }&valor=${ encodeURIComponent(valorFiltro) }&macAddress={{ $mac }}`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
      	if(data.code == 200){
      		if(data.data.length == 0){
      			if(tipo == "N"){
	      			$('#mensajeError').html(`Usuario no encontrado, verifique sus datos ingresados.`)
	      			$('#modalAlerta').modal('show');
	      			$('.keyboard').css('z-index','initial');
	      		}else{
	      			$('#mensajeErrorUsuario').html(`Usuario no encontrado, ingrese los siguientes datos para generar un turno.`)
	      			$('.keyboard').css('z-index',99999);
	      			$('#modalIngresarNombres').modal('show');
	      		}
      		}else if(data.data.length == 1 && (tipo == "C" || tipo == "P")){
      			storeData(data.data[0], data.trackId);
      			location.href = "/portal/{{ $tokenTurno }}?mac={{ $mac }}";
      		}else{
      			let elem = ``;
      			$.each(data.data, function(key, value){
      				elem += `<div data-rel='${JSON.stringify(value)}' class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium">
	        			${value.nombreCompleto}<br>
	        			<span class="fs-12 text-veris-dark">${value.nombreTipoIdentificacion}: ${value.numeroIdentificacion}</span>
	        		</div>`
      			});
      			$('#listaCoincidencias').html(elem);
      			$('#modalCoincidencias').modal("show");
      		}
      	}
	}

	async function storeData(data, trackId){
		let arr = {};
		arr.paciente = data;
		arr.trackId = trackId;
		arr.mac = "{{ $mac }}";
		console.log(arr);
		localStorage.setItem('turno-{{ $tokenTurno }}', JSON.stringify(arr));
	}

	async function validateInput(input) {
        // Eliminar cualquier carácter no numérico
        input.value = input.value.replace(/\D/g, "");
        
        // Limitar a 10 caracteres
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }else{
        	if(input.value.length == 10){
        		//location.href = "portal.php";
        		//await buscarUsuario();
        	}
        }
    }

    setInterval(actualizarFechaHora, 1000);

    async function buscarFamiliares(paciente){
    	let args = [];
        args["endpoint"] = `${api_url}/${api_war}/paciente/grupo_familiar?idPaciente=${ paciente.idPaciente }`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
      	if(data.code == 200){
      		paciente.lsGrupoFamiliar = data.data
      		storeData(paciente,data.trackId);
      		location.href = "/portal/{{ $tokenTurno }}?mac={{ $mac }}";
      	}else{
      		storeData(paciente,data.trackId);
      		location.href = "/portal/{{ $tokenTurno }}?mac={{ $mac }}";
      	}
    }

    let canSearch = true;
    document.addEventListener('DOMContentLoaded', async function () {
    	if(!isMobile()){
	        KioskBoard.init({
	        	keysJsonUrl: '{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/kioskboard-keys-spanish.json',
	        	keysNumeric: true,
	            //keysArrayOfObjects: null, // Usa el teclado QWERTY predeterminado
	            language: 'es',          // Idioma (ejemplo: 'es' para español)
	            theme: 'light',          // Tema del teclado ('light' o 'dark')
	            allowMobileKeyboard: false,
	            keysEnterText: '<i class="material-icons enter-key-icon">check_circle</i>',
	        });

	        // Activa el teclado virtual en los inputs con la clase 'virtual-keyboard'
	        KioskBoard.run('.virtual-keyboard-numpad', {});

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
    	}

		// Keyboard.open();
		$('body').on('click', '.nav-item.flex-fill', async function(){
			//Keyboard.close();
		})

		await parametrosGenerales("{{ $mac }}");
		
        $('body').on('click', '.item-coincidencia', async function(){
        	let data = JSON.parse($(this).attr("data-rel"));
        	await buscarFamiliares(data);
        });

        $(document).on("click", function (event) {
			if (!$(event.target).closest(".keyboard").length && $(".keyboard").css('bottom') == "0px" ) {
		    	//Keyboard.close()
		  	}
		})

		$('body').on('click', '.nav-link', function(){
			// Keyboard.close('none');
			if(!$(this).hasClass('active')){
				$('input').val("");
				console.log(0)
			}else{
				let tipo = $('.tipoIdentificacion.active').attr('data-rel');
				switch(tipo){
					case 'C':
						$('#pasaporte').removeAttr('autofocus');
						$('#nombres').removeAttr('autofocus');
						$('#cedula').attr('autofocus', true).focus();
						// Keyboard._simulateFocus('cedula')
					break;
					case 'P':
						$('#cedula').removeAttr('autofocus');
						$('#nombres').removeAttr('autofocus');
						$('#pasaporte').attr('autofocus', true).focus();
						// Keyboard._simulateFocus('pasaporte')
					break;
					case 'N':
						$('#cedula').removeAttr('autofocus');
						$('#pasaporte').removeAttr('autofocus');
						$('#nombres').attr('autofocus', true).focus();
						// Keyboard._simulateFocus('nombres')
					break;
				}
			}
		})

		let url_salir = `/{{ $mac }}`;
        if(isMobile()){
            url_salir = `/ingreso/{{ $mac }}`;
        }
        $('.btn-salir').attr('href',url_salir);

        const tiempoInactividad = 45; // Tiempo de inactividad en segundos
        const tiempoMaximoRespuesta = 15; // Tiempo máximo de respuesta al modal en segundos

        let temporizadorInactividad;
        let temporizadorRespuesta;

        // Función para mostrar el modal
        function mostrarModal() {
            // Mostrar el modal
            $("#modalEstasAhi").modal("show");

            // Iniciar temporizador para esperar respuesta
            temporizadorRespuesta = setTimeout(() => {
                $("#modalEstasAhi").modal("hide");
                console.log("No hubo respuesta a tiempo.");
                location.href = url_salir;
            }, tiempoMaximoRespuesta * 1000);
        }

        // Función para reiniciar el conteo de inactividad
        function reiniciarConteo() {
            clearTimeout(temporizadorInactividad);
            temporizadorInactividad = setTimeout(mostrarModal, tiempoInactividad * 1000);
        }

        // Detectar interacción del usuario
        $(document).on("mousemove keydown click scroll", function () {
            // reiniciarConteo();
        });

        // Manejar clic en el botón "Sí"
        $("#btnSi").on("click", function () {
            clearTimeout(temporizadorRespuesta);
            $("#modalEstasAhi").fadeOut();
            console.log("El usuario sigue presente.");
            // reiniciarConteo();
        });

        if(!isMobile()){
            console.log("Iniciando conteo")
            // Iniciar el conteo inicial
            // reiniciarConteo();
        }

        // Keyboard._simulateFocus('cedula')
    });

    // Simular el llamado a `open` externamente
function simulateOpen(inputId) {
  const element = document.getElementById(inputId); // Obtener el input por ID

  if (element) {
    console.log(99); // Simular el log del evento focus

    // Valores simulados que se usan en el código original
    const activeInput = element; // Guardar el input activo
    const value = element.value; // Sincronizar valor
    const cursorPosition = element.selectionStart; // Posición del cursor

    // Simular comportamiento previo de `_renderKeys` si aplica (aquí solo un log)
    console.log("Renderizando teclas...");

    // Llamar a la función `open` como se hace en el evento focus
    const openFunction = (value, callback) => {
      // Simular la lógica de `open`
      console.log(`Abriendo teclado con valor inicial: ${value}`);
      // Simular una actualización del valor desde el teclado
      setTimeout(() => {
        const newValue = `${value} Simulado`;
        callback(newValue); // Actualizar valor del input
      }, 1000); // Simulación de 1 segundo para la interacción
    };

    openFunction(value, (currentValue) => {
      element.value = currentValue; // Actualizar el valor del input
      console.log(`Nuevo valor del input: ${currentValue}`);
    });
  } else {
    console.error(`No se encontró el elemento con ID: ${inputId}`);
  }
}


    async function crearTurno(){
    	let tipo = $('.tipoIdentificacion.active').attr('data-rel');
        let paciente = `${ $('#nombresTM').val().toUpperCase() } ${ $('#apellidosTM').val().toUpperCase() }`;

		if($('#nombresTM').val() == "" || $('#apellidosTM').val() == ""){
			showMessage('warning','Debe llenar los campos solicitados');
			// Keyboard.open();
			return;
		}

        let args = [];
        let numeroIdentificacion;
        let tipoIdentificacion;
        if(tipo == "C"){
        	numeroIdentificacion = $('#cedula').val();
        	tipoIdentificacion = "CEDULA";
        }else{
        	numeroIdentificacion = $('#pasaporte').val();
        	tipoIdentificacion = "PASAPORTE";
        }
        args["endpoint"] =  `${api_url}/${api_war}/transaccion/generar_ticket?macAddress={{ $mac }}&tipoIdentificacion=${tipoIdentificacion}&numeroIdentificacion=${numeroIdentificacion}&nombreCompleto=${ paciente }`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "POST";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        // console.log(data);
        if(data.code == 200){
            $('#turnoModalLabel').html(`Turno - ${data.data.nombreSucursalTurnero}`);
            $('.turno-codigo').html(`${data.data.turno}`);
            // <p class="turno-prioridad"><strong>Priodidad:</strong> ${data.data.nemonicoPrioridad}</p>
                    
            $('.info-box').html(`<p class="text-wrap"><strong>Paciente:</strong> ${data.data.nombreCompleo}</p>`);
            $('#turnoModal').modal('show')
            // console.log("iniciar conteo para enviar a home")
            if(!isMobile()){
                printTurno(data.data)
            }
        }else{
            $('#mensajeError').html(`${data.message}`)
            $('#modalAlerta').modal('show');
        }
    }

    async function printTurno(detalle){
        // {
        //     "turno": "TG-008",
        //     "mensajeLlegada": "WOOOW!! ERES EL NUMERO 3 PRONTO TOCA TU TURNO",
        //     "nombreCompleo": "ROSENBERG MIRANDA DENISSE ALEXANDRA",
        //     "nombreMuestraTurnero": "Veris",
        //     "nombreSucursalTurnero": "Veris Kennedy",
        //     "prioridad": 0,
        //     "nemonicoPrioridad": "NORMAL"
        // }
        // var content = $('#turnoDisplay').html();
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
                <p class="fs-14 text-wrap" style="margin:0px;"><strong>Paciente: </strong>${detalle.nombreCompleo}</p>
            </body>
            </html>
        `;
        //<p class="fs-14 text-wrap" style="margin:0px;"><strong>Fecha emisión: </strong>${obtenerFechaHoraEnCurso()}</p>

        printJS({
            printable: htmlContent,
            type: 'raw-html',
            style: `
                @media print {
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
	.enter-key-icon{
		font-size: 30px !important;
	}
	.toast-title {
        color: #fff !important;
    }
    #toast-container > .toast-warning{
        background-image: url("{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/exclamation.svg") !important;
    }
	.nav-pills{
		background: #EBF6FE !important;
		border: 2px solid #0071CE;
		border-bottom-left-radius: 0px !important;
		border-bottom-right-radius: 0px !important;
	}
	.nav-pills .nav-link.active, .nav-pills .show>.nav-link{
		border-radius: 0px;
		background-color: var(--veris-blue-dark);
	}
	.icons-tabs path{
		color: var(--veris-blue-dark);
	}
	.nav-pills .nav-link.active .icons-tabs path, .nav-pills .show>.nav-link .icons-tabs path{
		fill: #fff;
	}
	.otp-input input {
		/*width: 56px;
		height: 56px;
		margin: 0 8px;*/
		text-align: center;
		font-size: 2rem;
		border: 2px solid var(--veris-blue-dark);
		border-radius: 12px;
		color: var(--veris-blue-dark);
		transition: all 0.3s ease;
	}
	.otp-input input:focus {
		border-color: var(--veris-blue);
		box-shadow: 0 0 0 2px var(--veris-blue);
		outline: none;
	}
	.otp-input input::-webkit-outer-spin-button,
	.otp-input input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	.otp-input input[type=number] {
		-moz-appearance: textfield;
	}
	.hg-theme-default.hg-layout-numeric .hg-button{
		font-size: 35px;
	}
	#listaCoincidencias {
	    max-height: 280px;
	    overflow-y: auto;
	}
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	  margin: 0;
	}

	/* Firefox */
	input[type=number] {
	  -moz-appearance: textfield;
	}

	.hg-button {
	    padding: 30px !important;!i;!;
	}

	button.keyboard-key.keyboard-dark {
	    background: #0071CE;
	}

	@media only screen and (max-width: 576px) {
		.otp-input input {
			font-size: 1.5rem;
			width: 10%;
			margin: 2px;
		}
	}
</style>
@endsection
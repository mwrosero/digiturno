@extends('template.app-template')
@section('content')
@php
    $tokenTurno = base64_encode(uniqid());
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css">
<div class="wrapper">
	<!-- Header -->
	<header class="header p-3">
		<div class="container-fluid g-0">
			<div class="row">
				<div class="col-12 col-md-3 text-center text-md-start">
					<img class="w-100 logo" src="{{ asset('assets/img/veris-large.png') }}" alt="">
				</div>
				<div class="col-9 col-md-9 d-md-flex justify-content-end align-items-center d-none d-md-block">
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
					<div class="row">
						<div class="col-12 col-md-5">
							<h2 class="fw-bold p-1 p-md-3 m-1 m-md-3">Datos <span class="text-veris">del paciente</span></h2>
						</div>
						<div class="col-12 col-md-7 text-end">
							<h5 class="fw-normal p-1 p-md-3 m-1 m-md-3 text-start d-inline-block"><span class="fw-bold">Ingresa tu cédula o pasaporte y genera tu turno.</span> <br class="d-none d-md-block">Además, si eres paciente Mi Veris puedes ver <br class="d-none d-md-block">información de tu grupo familiar en un solo lugar.</h5>
						</div>
					</div>
				</div>
				<div class="col-12 g-0 d-flex flex-column justify-content-center align-items-center bg-silver">
					<ul class="nav nav-pills justify-content-between bg-white w-100 rounded-3 mb-3" id="pills-tab" role="tablist">
		                <li class="nav-item flex-fill" role="presentation">
		                    <button data-rel="C" class="nav-link tipoIdentificacion w-100 px-8 px-md-5 active" id="pills-cedula-tab" data-bs-toggle="pill" data-bs-target="#pills-cedula" type="button" role="tab" aria-controls="pills-cedula" aria-selected="true">
		                    	<svg class="icons-tabs d-none d-md-inline-block" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.3337 15.1666C13.8064 15.1666 15.0003 13.9727 15.0003 12.4999C15.0003 11.0272 13.8064 9.83325 12.3337 9.83325C10.8609 9.83325 9.66699 11.0272 9.66699 12.4999C9.66699 13.9727 10.8609 15.1666 12.3337 15.1666Z" stroke="#0A2240" stroke-width="1.5"/><path d="M17.6667 20.4999C17.6667 21.9733 17.6667 23.1666 12.3333 23.1666C7 23.1666 7 21.9733 7 20.4999C7 19.0266 9.38667 17.8333 12.3333 17.8333C15.28 17.8333 17.6667 19.0266 17.6667 20.4999Z" stroke="#0A2240" stroke-width="1.5"/><path d="M3 16.4999C3 11.4719 3 8.95725 4.56267 7.39592C6.12533 5.83459 8.63867 5.83325 13.6667 5.83325H19C24.028 5.83325 26.5427 5.83325 28.104 7.39592C29.6653 8.95859 29.6667 11.4719 29.6667 16.4999C29.6667 21.5279 29.6667 24.0426 28.104 25.6039C26.5413 27.1653 24.028 27.1666 19 27.1666H13.6667C8.63867 27.1666 6.124 27.1666 4.56267 25.6039C3.00133 24.0413 3 21.5279 3 16.4999Z" stroke="#0A2240" stroke-width="1.5"/><path d="M25.6667 16.5H20.3333M25.6667 12.5H19M25.6667 20.5H21.6667" stroke="#0A2240" stroke-width="1.5" stroke-linecap="round"/></svg>
			                    Cédula
			                </button>
		                </li>
		                <li class="nav-item flex-fill" role="presentation">
		                    <button data-rel="P" class="nav-link tipoIdentificacion w-100 px-8 px-md-5" id="pills-pasaporte-tab" data-bs-toggle="pill" data-bs-target="#pills-pasaporte" type="button" role="tab" aria-controls="pills-pasaporte" aria-selected="false">
		                    	<svg class="icons-tabs d-none d-md-inline-block" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 12.8333C15.1739 12.8333 13.9021 13.36 12.9645 14.2977C12.0268 15.2354 11.5 16.5072 11.5 17.8333C11.5 19.1593 12.0268 20.4311 12.9645 21.3688C13.9021 22.3065 15.1739 22.8333 16.5 22.8333C17.8261 22.8333 19.0979 22.3065 20.0355 21.3688C20.9732 20.4311 21.5 19.1593 21.5 17.8333C21.5 16.5072 20.9732 15.2354 20.0355 14.2977C19.0979 13.36 17.8261 12.8333 16.5 12.8333ZM13.5 17.8333C13.5 17.0376 13.8161 16.2745 14.3787 15.7119C14.9413 15.1493 15.7044 14.8333 16.5 14.8333C17.2956 14.8333 18.0587 15.1493 18.6213 15.7119C19.1839 16.2745 19.5 17.0376 19.5 17.8333C19.5 18.6289 19.1839 19.392 18.6213 19.9546C18.0587 20.5172 17.2956 20.8333 16.5 20.8333C15.7044 20.8333 14.9413 20.5172 14.3787 19.9546C13.8161 19.392 13.5 18.6289 13.5 17.8333Z" fill="#0A2240"/><path d="M13.833 24.8333C13.5678 24.8333 13.3134 24.9386 13.1259 25.1261C12.9384 25.3137 12.833 25.568 12.833 25.8333C12.833 26.0985 12.9384 26.3528 13.1259 26.5404C13.3134 26.7279 13.5678 26.8333 13.833 26.8333H19.1663C19.4316 26.8333 19.6859 26.7279 19.8734 26.5404C20.061 26.3528 20.1663 26.0985 20.1663 25.8333C20.1663 25.568 20.061 25.3137 19.8734 25.1261C19.6859 24.9386 19.4316 24.8333 19.1663 24.8333H13.833Z" fill="#0A2240"/><path fill-rule="evenodd" clip-rule="evenodd" d="M21.3143 2.61206C21.8344 2.53776 22.3643 2.57606 22.8682 2.72436C23.3721 2.87267 23.8383 3.12752 24.2352 3.47167C24.6321 3.81582 24.9504 4.24122 25.1685 4.71908C25.3867 5.19694 25.4996 5.7161 25.4997 6.2414V8.0774C26.3046 8.5021 26.9783 9.13843 27.4482 9.91779C27.9181 10.6972 28.1664 11.59 28.1663 12.5001V25.8334C28.1663 27.1595 27.6396 28.4313 26.7019 29.3689C25.7642 30.3066 24.4924 30.8334 23.1663 30.8334H9.83301C8.50693 30.8334 7.23516 30.3066 6.29747 29.3689C5.35979 28.4313 4.83301 27.1595 4.83301 25.8334V7.16673V7.07206C4.83301 5.86406 5.72101 4.83873 6.91834 4.66806L21.3143 2.61206ZM7.26101 9.50006H6.83301V25.8334C6.83301 26.629 7.14908 27.3921 7.71169 27.9547C8.2743 28.5173 9.03736 28.8334 9.83301 28.8334H23.1663C23.962 28.8334 24.7251 28.5173 25.2877 27.9547C25.8503 27.3921 26.1663 26.629 26.1663 25.8334V12.5001C26.1663 11.7067 25.8521 10.9457 25.2924 10.3834C24.7327 9.82122 23.973 9.50359 23.1797 9.50006H7.26101ZM23.4997 7.50006H7.25567C7.14753 7.49916 7.04374 7.45734 6.96517 7.38303C6.8866 7.30871 6.83908 7.20741 6.83215 7.09949C6.82523 6.99156 6.85942 6.88502 6.92785 6.80127C6.99627 6.71753 7.09387 6.66279 7.20101 6.64807L21.597 4.5934C21.8334 4.55959 22.0742 4.57696 22.3033 4.64433C22.5324 4.71171 22.7443 4.82751 22.9247 4.98391C23.1051 5.1403 23.2498 5.33363 23.349 5.55082C23.4482 5.768 23.4996 6.00397 23.4997 6.24273V7.50006Z" fill="#0A2240"/></svg>
		                    	Pasaporte
		                    </button>
		                </li>
		                <li class="nav-item flex-fill" role="presentation">
		                    <button data-rel="N" class="nav-link tipoIdentificacion w-100 px-8 px-md-5" id="pills-nombres-tab" data-bs-toggle="pill" data-bs-target="#pills-nombres" type="button" role="tab" aria-controls="pills-nombres" aria-selected="false">
		                    	<svg class="icons-tabs d-none d-md-inline-block" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M25.499 28.1666C25.8526 28.1666 26.1918 28.0261 26.4418 27.7761C26.6919 27.526 26.8324 27.1869 26.8324 26.8333V25.1719C26.8377 21.4306 21.5337 18.4999 16.1657 18.4999C10.7977 18.4999 5.49902 21.4306 5.49902 25.1719V26.8333C5.49902 27.1869 5.6395 27.526 5.88955 27.7761C6.1396 28.0261 6.47873 28.1666 6.83236 28.1666H25.499ZM20.971 9.63859C20.971 10.2696 20.8467 10.8945 20.6052 11.4775C20.3637 12.0605 20.0098 12.5903 19.5636 13.0365C19.1174 13.4827 18.5876 13.8366 18.0046 14.0781C17.4216 14.3196 16.7967 14.4439 16.1657 14.4439C15.5346 14.4439 14.9098 14.3196 14.3268 14.0781C13.7438 13.8366 13.214 13.4827 12.7678 13.0365C12.3216 12.5903 11.9676 12.0605 11.7261 11.4775C11.4846 10.8945 11.3604 10.2696 11.3604 9.63859C11.3604 8.36413 11.8666 7.14188 12.7678 6.2407C13.669 5.33953 14.8912 4.83325 16.1657 4.83325C17.4401 4.83325 18.6624 5.33953 19.5636 6.2407C20.4647 7.14188 20.971 8.36413 20.971 9.63859Z" stroke="#0A2240" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
		                    	Nombres
		                    </button>
		                </li>
		            </ul>
		            <div class="tab-content bg-transparent w-100" id="pills-tabContent">
						<div class="tab-pane fade mt-3 px-2 w-100 show active" id="pills-cedula" role="tabpanel" aria-labelledby="pills-cedula-tab" tabindex="0">
						    <div class="row">
						        <div class="col-12 col-md-8 offset-md-2 mt-2 mb-4 text-center">	
					                <div class="otp-input d-none d-md-flex justify-content-between align-items-center mb-3">
										<input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
							            <input type="number" min="0" max="9" required style="flex-grow: 1; max-width: 40px; text-align: center;">
									</div>
									{{-- <button onclick="buscarUsuario();" class="btn bg-veris btn-ingresar text-white mt-2 mx-auto">INGRESAR</button> --}}
								</div>
								<div class="col-12 col-md-4 offset-md-4 d-block d-md-none text-center">
									<input class="input w-100 p-2 fs-5 mb-5 text-center" type="number" maxlength="10" id="ipCedula" oninput="validateInput(this)" placeholder="" />
									<div onclick="buscarUsuario();" class="btn bg-veris btn-ingresar text-white mx-auto mb-5 rounded-8">INGRESAR</div>
								</div>
								<div class="col-12 col-md-8 offset-md-2 d-none d-md-block mb-5">
									<div class="simple-keyboard"></div>
						        </div>
						    </div>
						</div>
						<div class="tab-pane fade mt-3 px-2 w-100" id="pills-pasaporte" role="tabpanel" aria-labelledby="pills-pasaporte-tab" tabindex="0">
						    <div class="d-row">
						    	<div class="col-12 col-md-6 text-center offset-md-3 mb-3">
						    		<input type="text" class="input-pasaporte w-100 input-an p-2 fs-5 mb-5 mb-md-1 text-center" placeholder="" />
						    		{{-- <div onclick="buscarUsuario();" class="btn bg-veris btn-ingresar text-white mx-auto mb-5 rounded-8">INGRESAR</div> --}}
						    	</div>
						        <div class="col-12 d-none d-md-block">
						        	{{-- col-md-10 offset-md-1 --}}
									<!-- <input class="input-pasaporte input-an" placeholder="" /> -->
									<div class="simple-keyboard-an w-100"></div>
						        </div>
						    </div>
						</div>
						<div class="tab-pane fade mt-3 px-2 w-100" id="pills-nombres" role="tabpanel" aria-labelledby="pills-nombres-tab" tabindex="0">
						    <div class="d-flex flex-column flex-md-row">
						        <div class="col-12 col-md-8 mb-3 text-center">
						    		<input class="w-100 rounded-8 text-center fs-4 mb-1 border-0 shadow-0" id="nombres" type="text" placeholder="Ingresa nombres" />
								    <input class="w-100 rounded-8 text-center fs-4 mb-1 border-0 shadow-0" id="apellidos" type="text" placeholder="Ingresa apellidos" />
						    		{{-- <button onclick="buscarUsuario();" class="btn bg-veris text-white mt-2 mx-auto">BUSCAR</button> --}}
						    		<div class="w-100 d-none d-md-block">
								    	<div class="keyboardContainer w-100"></div>
								    </div>
						        </div>
						        <div class="col-12 col-md-4 flex-grow-1 ms-2">
						        	COINCIDENCIAS
						        	<div class="d-flex bg-light mb-3 justify-content-between align-items-center w-100 rounded-8 text-center bg-white text-veris-dark my-2">
						        		<img class="ms-2" src="{{ asset('assets/img/info-ico') }}.svg" alt="">
						        		<span class="ms-2 text-start flex-grow-1">Por favor verifica la información<br>correcta para continuar.</span>
						        	</div>
						        	<div class="w-100" id="list-coincidencias">
						        		{{-- <div class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium">
						        			Michael Washington Rosero Peralta
						        		</div>
						        		<div class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium">
						        			Washington Alfonso Rosero Altamirano
						        		</div>
						        		<div class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium">
						        			Michael Julio Rosero Perez
						        		</div> --}}
						        	</div>
						        </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
			<!-- Más contenido aquí -->
		</div>
	</main>
</div>
<script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>
<script>
	let Keyboard = window.SimpleKeyboard.default;
	let KeyboardAn = window.SimpleKeyboard.default;

	async function buscarUsuario(){
		let tipo = $('.tipoIdentificacion.active').attr('data-rel');
		let tipoFiltro = ``;
		let valorFiltro = ``;
		switch(tipo){
			case 'C':
				tipoFiltro = `CEDULA`;
				valorFiltro = $('#ipCedula').val();
			break;
			case 'P':
				tipoFiltro = `PASAPORTE`;
				valorFiltro = $('#input-pasaporte').val();
			break;
			case 'N':
				tipoFiltro = `NOMBRES`;
				valorFiltro = `${ $('#apellidos').val().toUpperCase() } ${ $('#nombres').val().toUpperCase() }`;
			break;
		}
		let args = [];
        args["endpoint"] =  `${api_url}/${api_war}/paciente/validar_datos?tipoFiltro=${ tipoFiltro }&valor=${ encodeURIComponent(valorFiltro) }`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = true;
        const data = await call(args);
        console.log(data);
      	if(data.code == 200){
      		if(data.data.length == 0){
      			alert("No se encontro data");
      		}else if(data.data.length == 1 && (tipo == "C" || tipo == "P")){
      			storeData(data.data[0]);
      			location.href = "/portal/{{ $tokenTurno }}";
      		}else{
      			let elem = ``;
      			$.each(data.data, function(key, value){
      				elem += `<div data-rel='${JSON.stringify(value)}' class="item-coincidencia rounded-8 border-veris-2 p-2 text-center bg-veris-sky mb-2 text-veris fw-medium">
	        			${value.nombreCompleto}
	        		</div>`
      			});
      			$('#list-coincidencias').html(elem);
      		}
      	}
	}

	async function storeData(data){
		let arr = {};
		arr.paciente = data;
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

	/*Numerico*/
	let keyboard = new Keyboard('.simple-keyboard',{
	 	onChange: input => onChange(input),
	  	onKeyPress: button => onKeyPress(button),
	  	layout: {
	    	// default: ["1 2 3", "4 5 6", "7 8 9", " 0 {bksp}"],
	    	default: ["1 2 3 4 5 {bksp}", "6 7 8 9 0 {enter}"],
	    	//shift: ["! / #", "$ % ^", "& * (", "{shift} ) +", "{bksp}"]
	  	},
	  	inputName: "input",
		maxLength: {
			input: 10,
		},
	  	display: {
            "{bksp}": `<img src="{{ asset('assets/img/delete.svg') }}" alt="">`,
            "{space}": "Espacio",
            "{enter}": "Ingresar"
        },
	  	theme: "hg-theme-default hg-layout-numeric numeric-theme"
	});
	// $('.hg-button-bksp span').html(`<img src="{{ asset('assets/img/delete.svg') }}" alt="">`)

	function onChange(input) {
		document.querySelector(".input").value = input;
		//console.log("Input changed", input);
	}

	async function onKeyPress(button) {
		if (button === "{enter}" && $('#ipCedula').val().length == 10) {
        	await buscarUsuario();
        }
		const inputs = document.querySelectorAll(".otp-input input");

        // Contar cuántos inputs están llenos
        const filledInputs = Array.from(inputs).filter(input => input.value !== "").length;

        if (button === "{bksp}") {
            // Borrar el último campo lleno
            for (let i = inputs.length - 1; i >= 0; i--) {
                if (inputs[i].value) {
                    inputs[i].value = "";
                    break;
                }
            }
        } else if (!isNaN(button)) {
            if (filledInputs < 10) {
                // Escribir el número en el siguiente campo vacío
                for (let input of inputs) {
                    if (!input.value) {
                        input.value = button;
                        break;
                    }
                }

                // Verificar si ya se completaron los 10 dígitos
                if (filledInputs + 1 === 10) {
                    //console.log("¡Se han ingresado los 10 dígitos!");
                    console.log($('#ipCedula').val())
                    //await buscarUsuario();
                    // location.href = "portal.php";
                    // Aquí puedes ejecutar alguna acción adicional
                }
            } else {
                //console.log("Ya se alcanzaron los 10 dígitos.");
            }
        }
	}

	/*Alfanumerico*/
	let keyboardAn = new KeyboardAn('.simple-keyboard-an',{
		onChange: input => onChangeAn(input),
		onKeyPress: button => onKeyPressAn(button),
		layout: {
            default: [
                "1 2 3 4 5 6 7 8 9 0 {bksp}",
                "Q W E R T Y U I O P",
                "A S D F G H J K L Ñ",
                "Z X C V B N M",
                "{space} {enter}"
            ]
        },
        display: {
            "{bksp}": `<img src="{{ asset('assets/img/delete.svg') }}" alt="">`,
            "{space}": "Espacio",
            "{enter}": "Buscar"
        },
        theme: "hg-theme-default"
	});

	/**
	 * Update simple-keyboard when input is changed directly
	 */
	document.querySelector(".input-an").addEventListener("input", event => {
	 	keyboardAn.setInput(event.target.value);
	});

	console.log(keyboardAn);

	function onChangeAn(input) {
		document.querySelector(".input-an").value = input;
	  	console.log("Input changed", input);
	}

	async function onKeyPressAn(button) {
		if (button === "{enter}") {
        	await buscarUsuario();
        }
	  	console.log("Button pressed", button);

		/**
		* If you want to handle the shift and caps lock buttons
		*/
		if (button === "{shift}" || button === "{lock}") handleShift();
	}

	function handleShift() {
		let currentLayout = keyboardAn.options.layoutName;
		let shiftToggle = currentLayout === "default" ? "shift" : "default";

		keyboardAn.setOptions({
			layoutName: shiftToggle
		});
	}
	
    setInterval(actualizarFechaHora, 1000);

	const inputs = document.querySelectorAll('.otp-input input');
	const timerDisplay = document.getElementById('timer');

	inputs.forEach((input, index) => {
		input.addEventListener('input', (e) => {
			if (e.target.value.length > 1) {
				e.target.value = e.target.value.slice(0, 1);
			}
			if (e.target.value.length === 1) {
				if (index < inputs.length - 1) {
					inputs[index + 1].focus();
				}
			}
		});

		input.addEventListener('keydown', (e) => {
			if (e.key === 'Backspace' && !e.target.value) {
				if (index > 0) {
					inputs[index - 1].focus();
				}
			}
			if (e.key === 'e') {
				e.preventDefault();
			}
		});
	});

	document.addEventListener("DOMContentLoaded", () => {
        const Keyboard = window.SimpleKeyboard.default;
        let focusedInput = null; // Variable para rastrear el input activo

        // Configurar teclado virtual
        const keyboard = new Keyboard(".keyboardContainer", {
            layout: {
            default: [
                //"1 2 3 4 5 6 7 8 9 0 {bksp}",
                "Q W E R T Y U I O P {bksp}",
                "A S D F G H J K L Ñ",
                "Z X C V B N M",
                "{space} {enter}"
            ]
            },
            display: {
                "{bksp}": `<img src="{{ asset('assets/img/delete.svg') }}" alt="">`,
                "{space}": "Espacio",
                "{enter}": "Buscar"
            },
            onChange: input => {
                if (focusedInput) {
                    focusedInput.value = input; // Actualizar el valor del input activo
                }
            },
            onKeyPress: async button => {
            	if (button === "{enter}" && $('#nombres').val() != "" && $('#apellidos').val() != "") {
		        	await buscarUsuario();
		        }
                console.log("Tecla presionada:", button);
            }
        });

        // Detectar foco en los inputs
        const inputs = document.querySelectorAll("input");
        inputs.forEach(input => {
            input.addEventListener("focus", () => {
                focusedInput = input; // Actualizar el input activo
                keyboard.setInput(input.value); // Sincronizar teclado con el valor actual del input
            });
        });

        // Validar cambios en el teclado y sincronizarlos con el input
        document.querySelectorAll("input").forEach(input => {
            input.addEventListener("input", () => {
                keyboard.setInput(input.value);
            });
        });

        $('body').on('click', '.item-coincidencia', function(){
        	let data = JSON.parse($(this).attr("data-rel"));
        	storeData(data);
      		location.href = "/portal/{{ $tokenTurno }}";
        });

        // $('#ipCedula').on('input', function() {
	    // 	const value = $(this).val();
	    //     // Remover cualquier carácter que no sea un dígito
	    //     const digitsOnly = value.replace(/\D/g, '');
	    //     // Limitar a 10 dígitos
	    //     if (digitsOnly.length > 10) {
	    //     	$(this).val(digitsOnly.substring(0, 10));
	    //     } else {
	    //     	$(this).val(digitsOnly);
	    //     }
	    // });
    });
</script>
<style>
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
	#list-coincidencias {
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

	@media only screen and (max-width: 576px) {
		.otp-input input {
			font-size: 1.5rem;
			width: 10%;
			margin: 2px;
		}
	}
</style>
@endsection
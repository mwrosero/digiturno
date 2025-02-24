@extends('template.app-template')
@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- <link href="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/howler.min.js" rel="preload" as="script"> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.4/howler.min.js"></script>
@php
    switch($mac){
        case "70-85-C2-91-96-4E":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6pqwLjkSPi8_173NIq7jgSL&playlist=PLhHmuSWjQz6pqwLjkSPi8_173NIq7jgSL&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "C4-34-6B-57-E9-ED":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6rH7kOJEi_XeadSWxTJmU_5&playlist=PLhHmuSWjQz6rH7kOJEi_XeadSWxTJmU_5&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "E0-D5-5E-DB-42-36":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6pJgnfhIfttX2lvtrL86cRu&playlist=PLhHmuSWjQz6pJgnfhIfttX2lvtrL86cRu&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "1C-69-7A-AD-5F-C2":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6roN2VplVDH1sAJaLiqsVZ5&playlist=PLhHmuSWjQz6roN2VplVDH1sAJaLiqsVZ5&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "90-FB-A6-0A-9B-0C":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6olE6mjae4ZW5g27uZ4wc_d&playlist=PLhHmuSWjQz6olE6mjae4ZW5g27uZ4wc_d&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "C4-34-6B-5F-06-0C":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6qDNd8XHmun-5-MRjPvA-ta&playlist=PLhHmuSWjQz6qDNd8XHmun-5-MRjPvA-ta&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "90-FB-A6-0A-97-97":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6qF4Jg03AvEy_UG4JzJoDnC&playlist=PLhHmuSWjQz6qF4Jg03AvEy_UG4JzJoDnC&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "0C-9D-92-64-C3-34":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6qE4lN3s9OtRX5Bc_7s9uhv&playlist=PLhHmuSWjQz6qE4lN3s9OtRX5Bc_7s9uhv&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "24-2F-FA-07-17-3E":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6pV8vEtsjZW9zzrGXYKNfOY&playlist=PLhHmuSWjQz6pV8vEtsjZW9zzrGXYKNfOY&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "90-FB-A6-02-02-27":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6qS0Y-Zub7cX4faAovSsimp&playlist=PLhHmuSWjQz6qS0Y-Zub7cX4faAovSsimp&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "1C-69-7A-63-EF-BF":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6pWUPft54XZruCE6KFDWbY9&playlist=PLhHmuSWjQz6pWUPft54XZruCE6KFDWbY9&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "00-22-4D-7B-2A-F5":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6qYVO84L4AN0DHcIwgNhmo0&playlist=PLhHmuSWjQz6qYVO84L4AN0DHcIwgNhmo0&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "04-D4-C4-AC-8C-72":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6qmJVbRViwd3-1taZ0w-5D1&playlist=PLhHmuSWjQz6qmJVbRViwd3-1taZ0w-5D1&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "1C-69-7A-6A-CF-95":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLfkN66gdZWCyZXmE0yXWeQXWqrJWDzFEt&playlist=PLfkN66gdZWCyZXmE0yXWeQXWqrJWDzFEt&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "1C-69-7A-AE-99-3D":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLfkN66gdZWCxMliqWgBukx9XWfvXkA0jY&playlist=PLfkN66gdZWCxMliqWgBukx9XWfvXkA0jY&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "48-21-0B-2D-28-8F":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLfkN66gdZWCzEHEePlXJ9s0Bj0Dde6_VI&playlist=PLfkN66gdZWCzEHEePlXJ9s0Bj0Dde6_VI&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "48-21-0B-2D-1F-3C":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLfkN66gdZWCwN9FGIE5vn0KxFpGSJQ-42&playlist=PLfkN66gdZWCwN9FGIE5vn0KxFpGSJQ-42&autoplay=1&mute=1&controls=0&loop=1";
        break;
        case "48-21-0B-2D-2F-04":
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLfkN66gdZWCxR9jdOcaml_dkvqC4CYYGS&playlist=PLfkN66gdZWCxR9jdOcaml_dkvqC4CYYGS&autoplay=1&mute=1&controls=0&loop=1";
        break;
        default:
            $playlist = "https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6rRzJbZmaLutrK9po3379Zh&autoplay=1&mute=1&controls=0&loop=1&playlist=PLhHmuSWjQz6rRzJbZmaLutrK9po3379Zh";
    }
@endphp

<div class="wrapper">
    <!-- Content -->
    <main class="content p-3">
        <div class="container-fluid h-100">
        <div class="row flex-row align-items-start h-100">
            <div class="col-3 h-100 d-flex flex-column justify-content-between">
                @if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
                <img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/parami-large.png" alt="">
                @else
                <img class="w-100 logo" src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/veris-large.png" alt="">
                @endif
                <div class="mt-auto" id="next-turno">
                    {{-- <div class="text-veris mb-3 fs-40">Turnos en atención</div>
                    <div class="card rounded-8 bg-veris-dark mb-1">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            
                            <div class="info">
                                <span class="text-center fw-bold fs-50 line-height-50 text-white mb-0">TG-086</span>
                                <p class="text-veris-sky fs-1 mb-0">Módulo 1</p>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-8 bg-veris-dark mb-1">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            
                            <div class="info">
                                <span class="text-center fw-bold fs-50 line-height-50 text-white mb-0">TG-086</span>
                                <p class="text-veris-sky fs-1 mb-0">Módulo 1</p>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-8 bg-veris-dark mb-1">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            <img style="width: 50px;" class="mx-2 ms-4" src="http://digiturno.veris.com.ec/assets/img/MAYOR_EDAD.svg" alt="">
                            <div class="info">
                                <span class="text-center fw-bold fs-50 line-height-50 text-white mb-0">A-019</span>
                                <p class="text-veris-sky fs-1 mb-0">Módulo 3</p>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-8 bg-veris-dark mb-1">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            <img style="width: 50px;" class="mx-2 ms-4" src="http://digiturno.veris.com.ec/assets/img/MAYOR_EDAD.svg" alt="">
                            <div class="info">
                                <span class="text-center fw-bold fs-50 line-height-50 text-white mb-0">A-019</span>
                                <p class="text-veris-sky fs-1 mb-0">Módulo 3</p>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-8 bg-veris-dark mb-1">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            <img style="width: 50px;" class="mx-2 ms-4" src="http://digiturno.veris.com.ec/assets/img/MAYOR_EDAD.svg" alt="">
                            <div class="info">
                                <span class="text-center fw-bold fs-50 line-height-50 text-white mb-0">A-019</span>
                                <p class="text-veris-sky fs-1 mb-0">Módulo 3</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-9 h-100 overflow-hidden">
                @if (in_array($mac, \App\Models\Veris::MACS_PARAMI))
                {{-- <div class="w-100 h-100" style="background: url({{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/img/preview_parami.png) no-repeat center center;background-size: cover;"></div> --}}
                <video src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/video/parami.mp4" autoplay loop muted playsinline style="width:100%; height:auto;"></video>
                @else
                <div class="ratio ratio-16x9">
                    <iframe class="rounded-8" src="{{ $playlist }}" allow="autoplay; fullscreen" allowfullscreen>
                    </iframe>
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer p-3">
        <div class="container-fluid h-100 g-0">
            <div class="row h-100 d-flex align-items-center" id="wait-turno">
                <!-- <div class="col-2 h-100">
                    <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100">
                        Próximos turnos
                    </div>
                </div>
                <div class="col-2 h-75 p-3">
                    <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100 rounded-8 border-veris-1 bg-veris-sky">
                        <p class="w-100 m-0 text-center text-veris">TG 002</p>
                    </div>
                </div>
                <div class="col-2 h-75 p-3">
                    <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100 rounded-8 border-veris-1 bg-veris-sky">
                        <p class="w-100 m-0 text-center text-veris">TG 003</p>
                    </div>
                </div>
                <div class="col-2 h-75 p-3">
                    <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100 rounded-8 border-veris-1 bg-veris-sky">
                        <p class="w-100 m-0 text-center text-veris">TG 004</p>
                    </div>
                </div> -->
            </div>
        </div>
    </footer>
    <audio id="turno-sound" class="d-none">
        <source src="{{ asset('assets/sound.mp3') }}" type="audio/mpeg">
    </audio>
</div>
<style>
    .footer {
        flex: 0 0 25%;
    }
</style>
<script>
    let turnosEnAtencion = []
    setInterval(cargarTurnos, 5000);

    var sound = new Howl({
        src: ['{{ asset('assets/sound.mp3') }}'],
        volume: 1.0
    });

    async function notificarNuevo(data){
        $.each(data, async function(key,value){
            if(!turnosEnAtencion.includes(value.idorden)){
                turnosEnAtencion.push(value.idorden);
                console.log("Turno: "+value.turno)
                await playSound();
            }
        })
    }

    async function playSound(){
        // var sonido = $("#turno-sound")[0];
        // sonido.play();
        sound.play();
    } 

    async function cargarTurnos(){
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TURNO_ASIGNADO`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = false;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            notificarNuevo(data.data);
            let elem = `<div class="text-veris mb-3 fs-40">Turnos en atención</div>`;
            $.each(data.data, function(key, value){
                if(key < 5){
                    let modulo = ``;
                        modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;

                    let modulo_wait = ``;
                    if(value.cajaatiende != null){
                        modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;
                        modulo_wait = `<p class="text-veris fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;
                    }
                    let icon = ``;
                    if(value.nemonicoPrioridad != "NORMAL"){
                        if(value.nemonicoPrioridad != null){
                            icon = `<img style="width: 50px;" class="mx-2 ms-4" src="{{ asset('assets/img/${value.nemonicoPrioridad}.svg') }}" alt="">`;
                        }
                    }
                    elem += `<div class="card rounded-8 bg-veris-dark mb-1">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            ${icon}
                            <div class="info">
                                <span class="text-center fw-bold fs-50 line-height-50 text-white mb-0">${value.turno}</span>
                                ${modulo}
                            </div>
                        </div>
                    </div>`;
                }
            })
            $('#next-turno').html(elem)
        }

        args["endpoint"] = `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TURNO_NO_ASIGNADO`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = false;
        const dataWait = await call(args);
        console.log(dataWait);
        if(dataWait.code == 200){
            let elem = `<div class="col-12">
                <div class="d-flex justify-content-start align-items-center text-start fs-40 line-height-50 h-100 fs-20 text-veris">
                    Próximos turnos
                </div>
            </div>`;
            $.each(dataWait.data, function(key, value){
                if(key < 6){
                    let modulo = ``;
                    let modulo_wait = ``;
                    if(value.cajaatiende != null){
                        modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;
                        modulo_wait = `<p class="text-veris fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;
                    }
                    let icon = ``;
                    if(value.nemonicoPrioridad != "NORMAL"){
                        if(value.nemonicoPrioridad != null){
                            icon = `<img style="width: 50px;" class="mx-2 ms-4" src="{{ asset('assets/img/${value.nemonicoPrioridad}.svg') }}" alt="">`;
                        }
                    }
                    elem += `<div class="col-2 h-75 p-3">
                            <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100 rounded-8 border-veris-1 bg-veris-sky">
                                ${icon}
                                <div class="text-center flex-grow-1">
                                    <p class="w-100 m-0 text-center text-veris">${value.turno}</p>
                                    ${modulo_wait}
                                </div>
                            </div>
                        </div>`;
                    }
            })
            $('#wait-turno').html(elem)
        }
    }

    async function _cargarTurnos(){
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TODOS`;
        //dataCita.paciente.numeroPaciente
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = false;
        const data = await call(args);
        console.log(data);
        if(data.code == 200){
            let maxIterations = 6;
            let elem = `<div class="col-2 h-100">
                <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100">
                    Próximos turnos
                </div>
            </div>`;
            $.each(data.data, function(key, value){
                if (key >= maxIterations) {
                    return false; // Detiene el bucle
                }
                let modulo = ``;
                let modulo_wait = ``;
                if(value.cajaatiende != null){
                    modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;
                    modulo_wait = `<p class="text-veris fs-1 mb-0">Módulo ${value.cajaatiende}</p>`;
                }
                if(key == 0){
                    let elem_0 = `<h1 class="text-veris mb-3">Siguiente turno</h1>
                        <div class="card rounded-8 bg-veris-dark">
                            <div class="card-content text-center p-4 px-2 d-flex justify-content-around align-items-center">
                                <img style="width: 75px;" src="{{ asset('assets/img/${value.nemonicoPrioridad}.svg') }}" alt="">
                                <div class="info">
                                    <span class="text-center fw-bold fs-70 text-white mb-2">${value.turno}</span>
                                    ${modulo}
                                </div>
                            </div>
                        </div>`;
                    $('#next-turno').html(elem_0);
                }else{
                    elem += `<div class="col-2 h-75 p-3">
                        <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100 rounded-8 border-veris-1 bg-veris-sky">
                            <img style="width: 50px;" class="mx-2" src="{{ asset('assets/img/${value.nemonicoPrioridad}.svg') }}" alt="">
                            <div class="text-center flex-grow-1">
                                <p class="w-100 m-0 text-center text-veris">${value.turno}</p>
                                ${modulo_wait}
                            </div>
                        </div>
                    </div>`;
                }
            })
            $('#wait-turno').html(elem)
        }else{
            alert(data.message)
        }
    }

    document.addEventListener("DOMContentLoaded", async () => {
        await cargarTurnos();
    })
</script>
<style>
    .fs-50{
        font-size: 50px;
    }
    .line-height-50{
        line-height: 50px;
    }
</style>
@endsection
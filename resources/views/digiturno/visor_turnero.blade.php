@extends('template.app-template')
@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="wrapper">
    <!-- Content -->
    <main class="content p-3">
        <div class="container-fluid h-100">
        <div class="row flex-row align-items-start h-100">
            <div class="col-3 h-100 d-flex flex-column justify-content-between">
                <img class="w-75 mb-3" src="{{ asset('assets/img/veris-large.png') }}" alt="">
                <div class="mt-auto" id="next-turno">
                    <!-- <h1 class="text-veris mb-3">Siguiente turno</h1>
                    <div class="card rounded-8 bg-veris-dark">
                        <div class="card-content text-center p-4 px-2 d-flex justify-content-around align-items-center">
                            <img style="width: 75px;" src="{{ asset('assets/img/NORMAL.svg') }}" alt="">
                            <div class="info">
                                <span class="text-center fw-bold fs-70 text-white mb-2">TG 001</span>
                                <p class="text-veris-sky fs-1 mb-0">Módulo 1</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-9 h-100 overflow-hidden">
                <div class="ratio ratio-16x9">
                    <!-- <iframe class="rounded-8" 
                        src="https://www.youtube.com/embed/xyq36cCP92E?list=PLhHmuSWjQz6q_SgoAIqeRjfuwGXGsb8Vz&autoplay=1&mute=1" 
                        title="YouTube playlist" 
                        allowfullscreen>
                    </iframe> -->
                    <iframe class="rounded-8" src="https://www.youtube.com/embed/videoseries?list=PLhHmuSWjQz6q_SgoAIqeRjfuwGXGsb8Vz&autoplay=1&mute=1&controls=0&loop=1&playlist=PLhHmuSWjQz6q_SgoAIqeRjfuwGXGsb8Vz" allow="autoplay; fullscreen" allowfullscreen>
                    </iframe>
                </div>
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
</div>
<style>
    .footer {
        flex: 0 0 25%;
    }
</style>
<script>
    setInterval(cargarTurnos, 5000);
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
            let maxIterations = 6;
            let elem = `<div class="text-veris mb-3 fs-40">Siguiente turno</div>`;
            $.each(data.data, function(key, value){
                if(key < 3){
                    let modulo = ``;
                        modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.idcaja}</p>`;

                    let modulo_wait = ``;
                    if(value.idcaja != null){
                        modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.idcaja}</p>`;
                        modulo_wait = `<p class="text-veris fs-1 mb-0">Módulo ${value.idcaja}</p>`;
                    }
                    let icon = ``;
                    if(value.nemonicoPrioridad != "NORMAL"){
                        icon = `<img style="width: 50px;" class="mx-2 ms-4" src="{{ asset('assets/img/${value.nemonicoPrioridad}.svg') }}" alt="">`;
                    }
                    elem += `<div class="card rounded-8 bg-veris-dark">
                        <div class="card-content text-center p-2 d-flex justify-content-around align-items-center">
                            ${icon}
                            <div class="info">
                                <span class="text-center fw-bold fs-70 text-white mb-0">${value.turno}</span>
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
                    if(value.idcaja != null){
                        modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.idcaja}</p>`;
                        modulo_wait = `<p class="text-veris fs-1 mb-0">Módulo ${value.idcaja}</p>`;
                    }
                    let icon = ``;
                    if(value.nemonicoPrioridad != "NORMAL"){
                        icon = `<img style="width: 50px;" class="mx-2 ms-4" src="{{ asset('assets/img/${value.nemonicoPrioridad}.svg') }}" alt="">`;
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
                if(value.idcaja != null){
                    modulo = `<p class="text-veris-sky fs-1 mb-0">Módulo ${value.idcaja}</p>`;
                    modulo_wait = `<p class="text-veris fs-1 mb-0">Módulo ${value.idcaja}</p>`;
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
@endsection
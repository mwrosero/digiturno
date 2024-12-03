@extends('template.app-template')
@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="wrapper">
    <!-- Content -->
    <main class="content p-3">
        <div class="container-fluid h-100">
        <div class="row flex-row align-items-start h-100">
            <div class="col-3 h-100 d-flex flex-column justify-content-between">
                <img class="w-75 mb-5" src="{{ asset('assets/img/veris-large.png') }}" alt="">
                <div class="mt-auto">
                    <h1 class="text-veris mb-3">Siguiente turno</h1>
                    <div class="card rounded-8 bg-veris-dark">
                        <div class="card-content text-center p-5">
                            <span class="text-center fw-bold fs-70 text-white mb-2">TG 001</span>
                            <p class="text-veris-sky fs-1 mb-0">Módulo 1</p>
                        </div>
                    </div>
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
            <div class="row h-100 d-flex align-items-center">
                <div class="col-2 h-100">
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
                </div>
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
    //setInterval(actualizarFechaHora, 1000);
    async function cargarTurnos(){
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
      }else{
          alert(data.message)
      }
  }

  document.addEventListener("DOMContentLoaded", () => {

  })
</script>  
@endsection
@extends('template.app-template')
@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="wrapper">
    <!-- Content -->
    <main class="content p-3">
        <div class="container-fluid h-100">
        <div class="row flex-row align-items-start h-100">
            <div class="col-3 h-100 d-flex flex-column justify-content-between">
                <img class="w-75 mb-5" src="{{ asset('assets/img/veris-laboratorio.svg') }}" alt="">
                <div class="mt-auto">
                    <h1 class="text-veris-dark fw-normal mb-3">Paciente en proceso</h1>
                    <div class="card rounded-8 bg-green-dark shadow-green border-green-2">
                        <div class="card-content text-center p-5">
                            <span class="text-center fw-bold fs-40 line-height-40 text-white mb-2">Amira Rosero</span>
                        </div>
                    </div>
                    <div class="card rounded-8 bg-green-dark shadow-green border-green-2">
                        <div class="card-content text-center p-5">
                            <span class="text-center fw-bold fs-40 line-height-40 text-white mb-2">Martina Castro</span>
                        </div>
                    </div>
                    <div class="card rounded-8 bg-green-dark shadow-green border-green-2">
                        <div class="card-content text-center p-5">
                            <span class="text-center fw-bold fs-40 line-height-40 text-white mb-2">Patricio Valarezo</span>
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
                    <div class="d-flex justify-content-start align-items-center text-start fs-50 line-height-50 h-100 text-veris-dark fw-normal">
                        Próximos pacientes
                    </div>
                </div>
                <div class="col-2 h-75 p-3">
                    <div class="d-flex justify-content-start align-items-center text-start fs-40 line-height-40 h-100 rounded-8 border-veris-1 bg-green border-green-2 shadow-green">
                        <p class="w-100 m-0 fw-medium text-center text-green">Michael Rosero</p>
                    </div>
                </div>
                <div class="col-2 h-75 p-3">
                    <div class="d-flex justify-content-start align-items-center text-start fs-40 line-height-40 h-100 rounded-8 border-veris-1 bg-green border-green-2 shadow-green">
                        <p class="w-100 m-0 fw-medium text-center text-green">Jennifer Rivera</p>
                    </div>
                </div>
                <div class="col-2 h-75 p-3">
                    <div class="d-flex justify-content-start align-items-center text-start fs-40 line-height-40 h-100 rounded-8 border-veris-1 bg-green border-green-2 shadow-green">
                        <p class="w-100 m-0 fw-medium text-center text-green">Maria<br>Arreola</p>
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
    .bg-green{
        background: #B3D766;
    }
    .bg-green-dark{
        background: #4D7100;
    }
    .border-green-2{
        border: 2px solid #4D7100;
    }
    .shadow-green{
        box-shadow: 0px -9px 24px 0px #00000040;
    }
    .text-green{
        color: #4D7100;
    }
    .fs-40{
        font-size: 40px;
    }
    .line-height-40{
        line-height: 40px;
    }
</style>
<script>
    //setInterval(actualizarFechaHora, 1000);
    async function cargarTurnos(){
      let args = [];
      //curl -X GET "https://api-phantomx.veris.com.ec/apoyosdx/v1/monitor/monitor_turnos_laboratorio?codigoSucursal=14" -H "accept: application/json" -H "Application: wqeqwe" -H "IdOrganizacion: asdasd"
      args["endpoint"] = `${api_url_digitales}/apoyosdx/v1/monitor/monitor_turnos_laboratorio?codigoSucursal={{ $mac }}&codigoEmpresa=1`;
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

  document.addEventListener("DOMContentLoaded", async () => {
    await cargarTurnos();
  })
</script>  
@endsection
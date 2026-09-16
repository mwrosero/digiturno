@extends('template.app-template')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.4/howler.min.js"></script>

@php
    if($lineaNegocio == "veris"){
        $playlist = "https://www.youtube.com/embed?listType=playlist&list=PLhHmuSWjQz6qmJVbRViwd3-1taZ0w-5D1&autoplay=1&mute=1&controls=0&loop=1&enablejsapi=1&rel=0&modestbranding=1";
    }else{
        $playlist = "https://www.youtube.com/embed?listType=playlist&list=PLfkN66gdZWCxJGayEZqbztdldfI42NyvX&autoplay=1&mute=1&controls=0&loop=1&enablejsapi=1&rel=0&modestbranding=1";
    }
    $assetUrl = request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/');
@endphp

<style>
  :root {
    --header-dark: #0071bc;
    --row-light: #cfe0f0;
    --row-lighter: #dfeaf5;
  }

  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
    background: #04264a;
  }

  .stage {
    position: relative;
    width: 100vw;
    height: 100vh;
    background-image: url('{{ $assetUrl }}/assets/img/bg-turnero-{{$lineaNegocio}}.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    /* Flexbox para centrar verticalmente el contenido dentro de la pantalla */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 5vw;
    box-sizing: border-box;
  }

  .iniciador {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    background: rgba(4, 38, 74, 0.95);
  }

  .logo-wrap {
    position: absolute;
    top: 10vh;
    right: 5vw;
    width: 35vw;
    @if($lineaNegocio == "parami")
    max-width: 440px;
    @endif
    text-align: right;
  }
  .logo-wrap img {
    width: 100%;
    height: auto;
    display: block;
    margin-left: auto;
  }

  /* Contenedor principal ajustado para centrado flex */
  .main-container {
    width: 100%;
    display: flex;
    gap: 2.5vw;
    align-items: stretch;
    margin-top: 4vh; /* Desplazamiento ligero opcional si la marca del logo ocupa la parte superior */
  }

  .turnos-card {
    flex: 1;
    background: rgba(255, 255, 255, 0.88);
    border-radius: 1.4vw;
    box-shadow: 0 1.5vw 3vw rgba(0, 0, 0, 0.28);
    overflow: hidden;
    padding: 0.9vw;
    display: flex;
    flex-direction: column;
    max-height: 100%;
  }

  .turnos-header {
    background: var(--header-dark);
    color: #fff;
    font-weight: 700;
    font-size: 1.8vw;
    padding: 0.7vw 1.2vw;
    border-radius: 0.9vw;
    margin-bottom: 0.5vw;
    letter-spacing: 0.02em;
    flex: 0 0 auto;
  }

  #next-turno {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    gap: 0.5vw;
    overflow: hidden;
  }

  /* Filas con altura fija uniforme y compacta */
  .turno-row {
    height: 5.5vh;
    min-height: 5.5vh;
    display: flex;
    align-items: center;
    border-radius: 0.5vw;
    overflow: hidden;
    color: #123a5e;
    flex: 0 0 auto;
    background: transparent !important;
  }

  /* Columna 1: Código */
  .turno-codigo {
    flex: 0 0 22%;
    height: 100%;
    padding: 0.3vw 0.8vw;
    font-weight: 700;
    font-size: 1.5vw;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4vw;
    background: rgba(0, 113, 188, 0.29);
    @if($lineaNegocio == "parami")
    background: #2e3192;
    color: #fff !important;
    @endif
  }

  /* Columna 2: Nombre (Centro) */
  .turno-nombre {
    flex: 1 1 auto;
    height: 100%;
    padding: 0.3vw 0.8vw;
    font-weight: 600;
    font-size: 1vw;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    display: flex;
    align-items: center;
    border-left: none;
    border-right: none;
    background: rgba(41, 171, 226, 0.29);
  }

  /* Columna 3: Caja / Módulo */
  .turno-caja {
    flex: 0 0 22%;
    height: 100%;
    padding: 0.3vw 0.8vw;
    font-weight: 700;
    font-size: 1.5vw;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 113, 188, 0.29);
  }

  .video-card {
    flex: 1;
    aspect-ratio: 16 / 9;
    border-radius: 1.4vw;
    overflow: hidden;
    box-shadow: 0 1.5vw 3vw rgba(0, 0, 0, 0.28);
    background: #000;
  }
  .video-card iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
  }

  .prioridad-icon {
    width: 1.3vw;
    height: auto;
  }
</style>

<div class="iniciador d-flex justify-content-center align-items-center d-none">
    <button class="btn btn-primary btn-lg p-4 fs-2 fw-bold" onclick="iniciarTurnero()">INICIAR TURNERO</button>
</div>

<div class="stage turnero">
    <div class="logo-wrap">
        <img src="{{ $assetUrl }}/assets/img/logo-turnero-{{$lineaNegocio}}.png">
    </div>

    <div class="main-container">
        <div class="turnos-card">
            <div class="turnos-header">Turnos de atención</div>
            <div id="next-turno"></div>
        </div>

        <div class="video-card">
            <iframe
              src="{{ $playlist }}"
              title="Veris video"
              allow="autoplay; fullscreen; encrypted-media"
              allowfullscreen>
            </iframe>
        </div>
    </div>
</div>

<script>
    let turnosEnAtencion = [];

    var sound = new Howl({
        src: ['{{ $assetUrl }}/assets/sound.mp3'],
        volume: 1.0
    });

    function iniciarTurnero() {
        cargarTurnos();
        $('.iniciador').addClass('d-none');
        $('.turnero').removeClass('d-none');
        setInterval(cargarTurnos, 2000);
    }

    async function notificarNuevo(data) {
        $.each(data, async function(key, value) {
            if (!turnosEnAtencion.includes(value.idorden)) {
                turnosEnAtencion.push(value.idorden);
                await playSound();
            }
        });
    }

    async function playSound() {
        sound.muted = false;
        sound.play();
    }

    async function cargarTurnos() {
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TURNO_ASIGNADO`;
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = false;

        const data = await call(args);

        if (data && data.code == 200) {
            notificarNuevo(data.data);
            let elem = '';
            
            // Set para almacenar las combinaciones únicas
            const procesados = new Set();
            let mostrados = 0;

            $.each(data.data, function(key, value) {
                // Creamos un identificador único por cada combinación de turno y caja
                const identificador = `${value.turno}_${value.cajaatiende}`;

                // Si la combinación ya existe en el Set, omitimos este elemento
                if (procesados.has(identificador)) {
                    return true; // continue en $.each de jQuery
                }

                // Si ya mostramos 6 elementos únicos, detenemos la iteración
                if (mostrados >= 6) {
                    return false; // break en $.each de jQuery
                }

                // Registramos el elemento como procesado e incrementamos el contador
                procesados.add(identificador);
                mostrados++;

                let modulo = value.cajaatiende ? `Módulo ${value.cajaatiende}` : '';
                let nombrePaciente = value.paciente || value.nombre || '';
                
                let icon = '';
                if (value.nemonicoPrioridad && value.nemonicoPrioridad !== "NORMAL") {
                    icon = `<img class="prioridad-icon" src="{{ $assetUrl }}/assets/img/${value.nemonicoPrioridad}.svg" alt="">`;
                }

                elem += `
                <div class="turno-row">
                  <div class="turno-codigo">
                    ${icon}
                    <span>${value.turno}</span>
                  </div>
                  <div class="turno-nombre">${nombrePaciente}</div>
                  <div class="turno-caja">${modulo}</div>
                </div>`;
            });

            // Verificamos si no se generó ningún elemento visual
            if (mostrados === 0) {
                elem = `<div class="d-flex align-items-center justify-content-center h-100 text-muted fs-2 fw-medium">
                    <img src="{{ $assetUrl }}/assets/img/empty-turno-{{$lineaNegocio}}.png" style="height: 300px">
                </div>`;
            }

            $('#next-turno').html(elem);
        }
    }

    async function BKcargarTurnos() {
        let args = [];
        args["endpoint"] = `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TURNO_ASIGNADO`;
        args["method"] = "GET";
        args["token"] = accessToken;
        args["showLoader"] = false;

        const data = await call(args);

        if (data && data.code == 200) {
            notificarNuevo(data.data);
            let elem = '';

            $.each(data.data, function(key, value) {
                if (key < 6) {
                    let modulo = value.cajaatiende ? `Módulo ${value.cajaatiende}` : '';
                    let nombrePaciente = value.paciente || value.nombre || '';
                    
                    let icon = '';
                    if (value.nemonicoPrioridad && value.nemonicoPrioridad !== "NORMAL") {
                        icon = `<img class="prioridad-icon" src="{{ $assetUrl }}/assets/img/${value.nemonicoPrioridad}.svg" alt="">`;
                    }

                    elem += `
                    <div class="turno-row">
                      <div class="turno-codigo">
                        ${icon}
                        <span>${value.turno}</span>
                      </div>
                      <div class="turno-nombre">${nombrePaciente}</div>
                      <div class="turno-caja">${modulo}</div>
                    </div>`;
                }
            });

            if (data.data.length === 0) {
                elem = `<div class="d-flex align-items-center justify-content-center h-100 text-muted fs-2 fw-medium">
                    <img src="{{ $assetUrl }}/assets/img/empty-turno-{{$lineaNegocio}}.png" style="height: 300px">
                    {{-- Sin turnos en atención --}}
                </div>`;
            }

            $('#next-turno').html(elem);
        }
    }

    const worker = new Worker(URL.createObjectURL(new Blob([`
        setInterval(() => postMessage("keepAlive"), 30000);
    `], { type: "text/javascript" })));
    worker.onmessage = (event) => console.log(event.data);

    setInterval(() => {
        document.dispatchEvent(new Event("visibilitychange"));
        document.title = document.title === "Turnos" ? "Turnos Activos" : "Turnos";
    }, 60000);

    document.addEventListener("DOMContentLoaded", async () => {
        await cargarTurnos();
        setInterval(cargarTurnos, 2000);
        reiniciarCadaHora();
    });

    function reiniciarCadaHora() {
        setInterval(function () {
            location.reload();
        }, 3600000);
    }
</script>
@endsection
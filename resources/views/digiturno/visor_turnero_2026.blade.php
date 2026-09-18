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
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2vw;
    padding: 0 2vw;
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
    top: 2vh;
    right: 2vw;
    width: 30vw;
    @if($lineaNegocio == "parami")
    top: 2vh;
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

  .main-container {
    width: 100%;
    display: flex;
    gap: 2.5vw;
    align-items: stretch;
    margin-top: 8vh;
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
    font-size: 2.2vw;
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

  .turno-row {
    height: 8vh;
    min-height: 8vh;
    display: flex;
    align-items: center;
    border-radius: 0.5vw;
    overflow: hidden;
    color: #123a5e;
    flex: 0 0 auto;
    background: transparent !important;
  }

  .turno-codigo {
    flex: 0 0 40%;
    height: 100%;
    padding: 0.3vw 0.8vw;
    font-weight: 700;
    font-size: 3.5vw;
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

  .turno-caja {
    flex: 1 1 auto;
    height: 100%;
    padding: 0.3vw 0.8vw;
    font-weight: 700;
    font-size: 3.5vw;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 113, 188, 1);
    color: #fff;
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

  /* --- CAJA INFERIOR --- */
  .bottom-card {
    width: 100%;
    height: 10vw;
    background: rgba(255, 255, 255, 0.88);
    border-radius: 0.8vw;
    box-shadow: 0 1vw 2vw rgba(0, 0, 0, 0.28);
    display: flex;
    align-items: center;
    padding: 0.9vw;
    gap: 0.5vw;
    overflow: hidden;
    box-sizing: border-box;
  }

  .bottom-card-icon {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 0.5vw;
  }

  .bottom-card-icon img {
    height: 80%;
    width: auto;
  }

  .bottom-card-items {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    flex: 1;
    height: 100%;
  }

  .bottom-item-box {
    height: 100%;
    padding: 0 1vw;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 4vw;
    color: #123a5e;
    border-radius: 0.4vw;
    white-space: nowrap;
  }

  .bottom-item-box.bg-light-blue {
    background: rgba(0, 113, 188, 0.29);
  }

  .bottom-item-box.bg-dark-blue {
    background: rgba(0, 113, 188, 1);
    color: #fff;
  }

  /* --- NOTIFICACIÓN POP-UP FLOTANTE --- */
  .turno-alert-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.7);
    background: rgba(4, 38, 74, 0.96);
    border: 0.4vw solid #29abe2;
    border-radius: 2vw;
    padding: 2.5vw 4vw;
    box-shadow: 0 2vw 5vw rgba(0, 0, 0, 0.6);
    z-index: 9999;
    text-align: center;
    color: #fff;
    opacity: 0;
    pointer-events: none;
    transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.25s ease-out;
    min-width: 40vw;
  }

  .turno-alert-overlay.show {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }

  .alert-title {
    font-size: 2.2vw;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #29abe2;
    margin-bottom: 0.8vw;
    font-weight: 600;
  }

  .alert-codigo {
    font-size: 6.5vw;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 1.2vw;
    color: #ffffff;
    text-shadow: 0 0.5vw 1vw rgba(0,0,0,0.5);
  }

  .alert-modulo {
    font-size: 3.5vw;
    font-weight: 700;
    background: #0071bc;
    color: #fff;
    padding: 0.6vw 2.5vw;
    border-radius: 1vw;
    display: inline-block;
    box-shadow: 0 0.8vw 1.5vw rgba(0,0,0,0.3);
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

    <!-- CAJA INFERIOR ANCHO COMPLETO -->
    <div class="bottom-card d-none">
        <div class="bottom-card-icon mx-3">
            <i class="fa-solid fa-clock-rotate-left" style="color: #0071bc; font-size: 80px;"></i>
        </div>
        <div class="bottom-card-items" id="bottom-turnos-list">
            <!-- Se llena dinámicamente con JS -->
        </div>
    </div>

    <!-- POP-UP NOTIFICACIÓN DE NUEVO TURNO -->
    <div id="turno-pop-alert" class="turno-alert-overlay">
        <div class="alert-title">Siguiente Turno</div>
        <div class="alert-codigo" id="pop-turno-codigo">--</div>
        <div class="alert-modulo" id="pop-turno-modulo">--</div>
    </div>
</div>

<script>
    let turnosEnAtencion = [];
    let colaNotificaciones = [];
    let mostrandoNotificacion = false;

    // Web Audio API para reproducir desde RAM al instante
    const AudioCtx = window.AudioContext || window.webkitAudioContext;
    let audioCtx = null;
    let soundBuffer = null;

    function getAudioContext() {
        if (!audioCtx) {
            audioCtx = new AudioCtx();
        }
        if (audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
        return audioCtx;
    }

    // Precargar el MP3 original como buffer en RAM
    async function precargarAudio() {
        try {
            const ctx = getAudioContext();
            const url = '{{ request()->getHost() === "127.0.0.1" ? url("/") : secure_url("/") }}/assets/sound.mp3';
            const response = await fetch(url);
            const arrayBuffer = await response.arrayBuffer();
            soundBuffer = await ctx.decodeAudioData(arrayBuffer);
        } catch (e) {
            console.error("Error al precargar el audio:", e);
        }
    }

    // Reproducción pura e instantánea sin retardo de red
    function playSound() {
        if (!soundBuffer) return;

        try {
            const ctx = getAudioContext();
            const source = ctx.createBufferSource();
            source.buffer = soundBuffer;
            source.connect(ctx.destination);
            source.start(0);
        } catch (e) {
            console.error("Error al reproducir audio:", e);
        }
    }

    async function notificarNuevo(data) {
        let hayNuevos = false;

        // Procesamiento síncrono correcto de la lista de turnos
        $.each(data, function(key, value) {
            if (!turnosEnAtencion.includes(value.idorden)) {
                turnosEnAtencion.push(value.idorden);
                
                colaNotificaciones.push({
                    turno: value.turno,
                    caja: value.cajaatiende
                });

                hayNuevos = true;
            }
        });

        if (hayNuevos && !mostrandoNotificacion) {
            procesarColaNotificaciones();
        }
    }

    function procesarColaNotificaciones() {
        if (colaNotificaciones.length === 0) {
            mostrandoNotificacion = false;
            return;
        }

        mostrandoNotificacion = true;

        const item = colaNotificaciones.shift();
        const modulo = item.caja ? `Módulo ${item.caja}` : '';

        $('#pop-turno-codigo').text(item.turno);
        $('#pop-turno-modulo').text(modulo);

        // Disparo en paralelo exacto: Sonido RAM (0ms) + Modal CSS
        playSound();
        $('#turno-pop-alert').addClass('show');

        setTimeout(() => {
            $('#turno-pop-alert').removeClass('show');

            setTimeout(() => {
                procesarColaNotificaciones();
            }, 400);

        }, 4000);
    }

    async function cargarTurnos() {
        let argsAsignados = {
            endpoint: `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TURNO_ASIGNADO`,
            method: "GET",
            token: accessToken,
            showLoader: false
        };

        let argsEnEspera = {
            endpoint: `${api_url}/${api_war}/transaccion/turnos_asignados_caja?macAddress={{ $mac }}&estado=TURNO_NO_ASIGNADO`,
            method: "GET",
            token: accessToken,
            showLoader: false
        };

        const [data, dataWait] = await Promise.all([
            call(argsAsignados),
            call(argsEnEspera)
        ]);

        if (data && data.code == 200) {
            notificarNuevo(data.data);
            let elem = '';
            
            const procesados = new Set();
            let mostrados = 0;

            $.each(data.data, function(key, value) {
                const identificador = `${value.turno}_${value.cajaatiende}`;

                if (procesados.has(identificador)) {
                    return true;
                }

                if (mostrados >= 6) {
                    return false;
                }

                procesados.add(identificador);
                mostrados++;

                let modulo = value.cajaatiende ? `Módulo ${value.cajaatiende}` : '';
                
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
                  <div class="turno-caja">${modulo}</div>
                </div>`;
            });

            if (mostrados === 0) {
                elem = `<div class="d-flex align-items-center justify-content-center h-100 text-muted fs-2 fw-medium">
                    <img src="{{ $assetUrl }}/assets/img/empty-turno-{{$lineaNegocio}}.png" style="height: 300px">
                </div>`;
            }

            $('#next-turno').html(elem);
        }

        let elemBottom = '';
        let contadorEspera = 0;

        if (dataWait && dataWait.code == 200 && Array.isArray(dataWait.data)) {
            const procesadosEspera = new Set();

            $.each(dataWait.data, function(key, value) {
                const identificador = `${value.turno}`;

                if (procesadosEspera.has(identificador)) {
                    return true;
                }

                procesadosEspera.add(identificador);
                contadorEspera++;

                const bgClass = (contadorEspera % 2 === 1) ? 'bg-light-blue' : 'bg-dark-blue';
                
                elemBottom += `
                <div class="bottom-item-box ${bgClass}">
                    ${value.turno}
                </div>`;
            });
        }

        $('.bottom-card').toggleClass('d-none', contadorEspera === 0);$('#bottom-turnos-list').html(elemBottom);
    }

    // PREVENCION DE SUSPENSION DEL NAVEGADOR (Tu Web Worker + Reactivación de Audio)
    const worker = new Worker(URL.createObjectURL(new Blob([`
        setInterval(() => postMessage("keepAlive"), 30000);
    `], { type: "text/javascript" })));

    worker.onmessage = () => {
        // Al recibir el keepAlive reactivamos el AudioContext si el navegador intentó suspenderlo
        if (audioCtx && audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
    };

    setInterval(() => {
        document.dispatchEvent(new Event("visibilitychange"));
        document.title = document.title === "Turnos" ? "Turnos Activos" : "Turnos";
    }, 60000);

    // INICIALIZACIÓN AUTOMÁTICA PARA PANTALLA DESATENDIDA
    document.addEventListener("DOMContentLoaded", async () => {
        await precargarAudio();
        await cargarTurnos();
        //setInterval(cargarTurnos, 2000);
        
        // Reinicio automático cada 1 hora
        setInterval(() => {
            location.reload();
        }, 3600000);
    });
</script>
@endsection
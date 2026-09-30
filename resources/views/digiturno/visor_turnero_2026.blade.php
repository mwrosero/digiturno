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
    width: 3vw;
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

  .bottom-card .prioridad-icon{
    width: 5vw;
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
    font-size: 3.75vw;
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

  .alert-codigo .prioridad-icon{
    width: 5vw;
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
            <i class="fa-solid fa-clock-rotate-left" style="color: #0071bc; font-size: 60px;"></i>
        </div>
        <div class="bottom-card-items" id="bottom-turnos-list">
            <!-- Se llena dinámicamente con JS -->
        </div>
    </div>

    <!-- POP-UP NOTIFICACIÓN DE NUEVO TURNO -->
    <div id="turno-pop-alert" class="turno-alert-overlay">
        <div class="alert-title">Siguiente Turno</div>
        <div class="text-center mx-auto" id="box-nemonico-turno"></div>
        <div class="alert-codigo d-flex justify-content-center align-items-center" id="pop-turno-codigo">--</div>
        <div class="alert-modulo" id="pop-turno-modulo">--</div>
    </div>
</div>

<script>
    let turnosEnAtencion = [];
    let colaNotificaciones = [];
    let mostrandoNotificacion = false;
    let cargandoTurnos = false; // Prevención de llamadas traslapadas

    let speech = new SpeechSynthesisUtterance();

    function cargarVoces() {
        voices = window.speechSynthesis.getVoices();
    }
    window.speechSynthesis.onvoiceschanged = cargarVoces;
    cargarVoces();

    // ===== AUDIO ROBUSTO PARA PANTALLA DESATENDIDA =====
    const AudioCtx = window.AudioContext || window.webkitAudioContext;
    const SOUND_URL = '{{ $assetUrl }}/assets/sound.mp3';
    const AUDIO_IDLE_RECREAR_MS = 5 * 60 * 1000;

    let audioCtx = null;
    let soundBuffer = null;
    let cargandoAudio = false;
    let ultimoUsoAudio = 0;
    let htmlAudio = null;

    function crearAudioContext() {
        if (audioCtx && audioCtx.state !== 'closed') {
            try { audioCtx.close().catch(() => {}); } catch (e) {}
        }
        audioCtx = new AudioCtx({ latencyHint: 'interactive' });
        audioCtx.onstatechange = () => {
            if (audioCtx && audioCtx.state !== 'running' && audioCtx.state !== 'closed') {
                audioCtx.resume().catch(() => {});
            }
        };
        return audioCtx;
    }

    function getAudioContext() {
        if (!audioCtx || audioCtx.state === 'closed') {
            crearAudioContext();
        }
        if (audioCtx.state !== 'running') {
            audioCtx.resume().catch(() => {});
        }
        return audioCtx;
    }

    async function precargarAudio() {
        if (soundBuffer || cargandoAudio) return;
        cargandoAudio = true;
        try {
            const ctx = getAudioContext();
            const response = await fetch(SOUND_URL, { cache: 'force-cache' });
            if (!response.ok) throw new Error('HTTP ' + response.status);
            const arrayBuffer = await response.arrayBuffer();
            soundBuffer = await ctx.decodeAudioData(arrayBuffer);
        } catch (e) {
            console.error("Error al precargar el audio:", e);
        } finally {
            cargandoAudio = false;
        }
    }

    function esperar(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function reproducirRespaldo() {
        try {
            if (!htmlAudio) {
                htmlAudio = new Audio(SOUND_URL);
                htmlAudio.preload = 'auto';
            }
            htmlAudio.currentTime = 0;
            const p = htmlAudio.play();
            if (p && p.catch) p.catch(e => console.error("Respaldo de audio falló:", e));
        } catch (e) {
            console.error("Respaldo de audio falló:", e);
        }
    }

    async function playSound() {
        try {
            if (audioCtx && ultimoUsoAudio && (Date.now() - ultimoUsoAudio) > AUDIO_IDLE_RECREAR_MS) {
                crearAudioContext();
            }

            let ctx = getAudioContext();
            if (ctx.state !== 'running') {
                await Promise.race([ctx.resume(), esperar(300)]);
            }
            if (ctx.state !== 'running') {
                ctx = crearAudioContext();
                await Promise.race([ctx.resume(), esperar(300)]);
            }

            if (!soundBuffer) throw new Error('El buffer de audio aún no está cargado');

            const source = ctx.createBufferSource();
            source.buffer = soundBuffer;
            source.connect(ctx.destination);
            source.start(0);
            ultimoUsoAudio = Date.now();
        } catch (e) {
            console.error("Error al reproducir audio (se usa respaldo):", e);
            reproducirRespaldo();
            precargarAudio();
        }
    }

    if (navigator.mediaDevices && navigator.mediaDevices.addEventListener) {
        navigator.mediaDevices.addEventListener('devicechange', () => {
            crearAudioContext();
            if (!soundBuffer) precargarAudio();
        });
    }

    async function notificarNuevo(data) {
        let hayNuevos = false;

        $.each(data, function(key, value) {
            // Verificar que no se haya procesado ni esté actualmente en la cola
            const yaEnCola = colaNotificaciones.some(item => item.idorden === value.idorden);

            if (!turnosEnAtencion.includes(value.idorden) && !yaEnCola) {
                turnosEnAtencion.push(value.idorden);
                
                colaNotificaciones.push({
                    idorden: value.idorden,
                    turno: value.turno,
                    caja: value.cajaatiende,
                    nemonicoPrioridad: value.nemonicoPrioridad
                });

                hayNuevos = true;
            }
        });

        if (hayNuevos && !mostrandoNotificacion) {
            procesarColaNotificaciones();
        }
    }

    const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

    async function procesarColaNotificaciones() {
        if (colaNotificaciones.length === 0) {
            mostrandoNotificacion = false;
            return;
        }

        mostrandoNotificacion = true;

        const item = colaNotificaciones.shift();
        const modulo = item.caja ? `Módulo ${item.caja}` : '';
        
        let icon = ``;
        if (item.nemonicoPrioridad && item.nemonicoPrioridad !== "NORMAL") {
            icon = `<img class="prioridad-icon me-2" src="{{ $assetUrl }}/assets/img/${item.nemonicoPrioridad}.svg" alt="">`;
        }

        $('#pop-turno-codigo').html(`${icon} ${item.turno}`);
        $('#pop-turno-modulo').text(modulo);

        await playSound();
        await delay(1000);
        await llamarPaciente(item);

        $('#turno-pop-alert').addClass('show');

        setTimeout(() => {
            $('#turno-pop-alert').removeClass('show');

            setTimeout(() => {
                procesarColaNotificaciones();
            }, 1500);

        }, 4000);
    }

    async function llamarPaciente(item){
        console.log(item.turno);
        let letraTurno = (item.turno.split('-'))[0];
        let turnoTexto = await numberToWords(item.turno);
        const textToSpeak = `Turno ${letraTurno} ${turnoTexto}, Módulo ${item.caja}`;

        const voices = window.speechSynthesis.getVoices();
        const vozPaloma = voices.find(v => v.name.includes('Paloma') && v.lang === 'es-US') 
                       || voices.find(v => v.name.includes('Paloma'))
                       || voices.find(v => v.lang === 'es-US');

        const speech = new SpeechSynthesisUtterance(textToSpeak);
        speech.text = textToSpeak;
        speech.lang = 'es-US';
        speech.volume = 1;
        speech.rate = 1;

        if (vozPaloma) {
            speech.voice = vozPaloma;
        }

        speech.onend = () => resolve();
        speech.onerror = () => resolve();

        window.speechSynthesis.cancel();
        window.speechSynthesis.speak(speech);
    }

    function obtenerMejorVozLatina() {
        const voices = window.speechSynthesis.getVoices();

        // 1. Prioridad: Voz 'Natural' o 'Online' en español de Latinoamérica (es-MX, es-US, es-CO, es-AR, etc.)
        let vozElegida = voices.find(v => 
            v.lang.startsWith('es') && 
            !v.lang.includes('ES') && // Excluye España
            (v.name.includes('Natural') || v.name.includes('Online'))
        );

        // 2. Segunda opción: Cualquier voz 'Natural' en español (incluso si es es-ES)
        if (!vozElegida) {
            vozElegida = voices.find(v => 
                v.lang.startsWith('es') && 
                (v.name.includes('Natural') || v.name.includes('Online'))
            );
        }

        // 3. Tercera opción: Cualquier voz en español latino no-España
        if (!vozElegida) {
            vozElegida = voices.find(v => v.lang.startsWith('es') && !v.lang.includes('ES'));
        }

        // 4. Último recurso: Primera voz que empiece por 'es'
        if (!vozElegida) {
            vozElegida = voices.find(v => v.lang.startsWith('es'));
        }

        return vozElegida;
    }

    async function numberToWords(str) {
        if (!str) return '';
        let turno = str.split('-');
        let num = turno[1] || str;
        const units = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        const tens = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        const teens = ['diez', 'once', 'doce', 'trece', 'caturce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
        const twenties = ['veinte', 'veintiuno', 'veintidós', 'veintitrés', 'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve'];
        const hundreds = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecentos'];

        let n = parseInt(num, 10);
        if (isNaN(n)) return str;
        if (n === 0) return 'cero';
        if (n === 100) return 'cien';

        let parts = [];

        if (n >= 100) {
            parts.push(hundreds[Math.floor(n / 100)]);
            n %= 100;
        }

        if (n >= 20) {
            if (n < 30) {
                parts.push(twenties[n - 20]);
            } else {
                let ten = Math.floor(n / 10);
                let unit = n % 10;
                parts.push(unit > 0 ? `${tens[ten]} y ${units[unit]}` : tens[ten]);
            }
        } else if (n >= 10) {
            parts.push(teens[n - 10]);
        } else if (n > 0) {
            parts.push(units[n]);
        }

        return parts.join(' ');
    }

    function formatTextForSpeech(text) {
        let cleanText = text.replace(/([a-záéíóúñ]+)-(\d+)/gi, '$1 $2');
        return cleanText.replace(/\b(0*)(\d+)\b/g, (match, zeros, number) => {
            const word = numberToWords(number);
            const prefix = zeros.length > 0 ? 'cero '.repeat(zeros.length) : '';
            return prefix + word;
        });
    }

    async function cargarTurnos() {
        if (cargandoTurnos) return; // Evita llamadas colisionadas si la red tarda
        cargandoTurnos = true;

        try {
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

                const turnosOrdenados = Array.isArray(data.data) ? [...data.data].reverse() : [];
                
                $.each(turnosOrdenados, function(key, value) {
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
                        icon = `<img class="prioridad-icon me-2" src="{{ $assetUrl }}/assets/img/${value.nemonicoPrioridad}.svg" alt="">`;
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
                let mostrados = 0;
                $.each(dataWait.data, function(key, value) {
                    const identificador = `${value.turno}`;

                    if (procesadosEspera.has(identificador)) {
                        return true;
                    }

                    procesadosEspera.add(identificador);
                    contadorEspera++;

                    let icon = '';
                    if (value.nemonicoPrioridad && value.nemonicoPrioridad !== "NORMAL") {
                        icon = `<img class="prioridad-icon me-2" src="{{ $assetUrl }}/assets/img/${value.nemonicoPrioridad}.svg" alt="">`;
                    }

                    const bgClass = (contadorEspera % 2 === 1) ? 'bg-light-blue' : 'bg-dark-blue';

                    if (mostrados >= 6) {
                        return false;
                    }

                    mostrados++;                
                    elemBottom += `
                    <div class="bottom-item-box ${bgClass}">
                        ${value.turno}
                    </div>`;
                });
            }

            $('.bottom-card').toggleClass('d-none', contadorEspera === 0);$('#bottom-turnos-list').html(elemBottom);
        } catch (e) {
            console.error("Error al cargar turnos:", e);
        } finally {
            cargandoTurnos = false;
        }
    }

    // PREVENCION DE SUSPENSION DEL NAVEGADOR
    const worker = new Worker(URL.createObjectURL(new Blob([`
        setInterval(() => postMessage("keepAlive"), 30000);
    `], { type: "text/javascript" })));

    worker.onmessage = () => {
        if (audioCtx && audioCtx.state !== 'running' && audioCtx.state !== 'closed') {
            audioCtx.resume().catch(() => {});
        }
        if (!soundBuffer) {
            precargarAudio();
        }
    };

    setInterval(() => {
        document.dispatchEvent(new Event("visibilitychange"));
        document.title = document.title === "Turnos" ? "Turnos Activos" : "Turnos";
    }, 60000);

    // INICIALIZACIÓN AUTOMÁTICA
    document.addEventListener("DOMContentLoaded", async () => {
        await precargarAudio();
        await cargarTurnos();
        setInterval(cargarTurnos, 2000);
        
        setInterval(() => {
            location.reload();
        }, 3600000);
    });
</script>
@endsection
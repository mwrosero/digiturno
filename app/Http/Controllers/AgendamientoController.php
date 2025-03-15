<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class AgendamientoController extends Controller
{
    public function paciente($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('agendamiento.paciente')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

    public function datosCita($portalToken, Request $request){
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('agendamiento.seleccionar_datos_cita')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

    public function fechaCita($portalToken, Request $request){
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('agendamiento.fecha_doctor')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

    public function detalleCita($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        // return view('agendamiento.detalle_cita')
        //         ->with('mac',$mac)
        //         ->with('accessToken',$token)
        //         ->with('params',$portalToken);
        return response()
            ->view('agendamiento.detalle_cita', [
                'mac' => $mac,
                'accessToken' => $token,
                'params' => $portalToken
            ])
            ->header("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0")
            ->header("Pragma", "no-cache")
            ->header("Expires", "Sat, 01 Jan 2000 00:00:00 GMT");

    }

    public function datosFacturacion($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('agendamiento.datos_facturacion')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

}
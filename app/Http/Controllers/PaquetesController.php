<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class PaquetesController extends Controller
{
    public function pacientePaquete($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('paquetes.paciente')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

    public function listadoPaquetes($portalToken, Request $request){
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('paquetes.listado_paquetes')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

    public function datosFacturacionPaquetes($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        
        return view('paquetes.datos_facturacion_paquetes')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('params',$portalToken);
    }

}
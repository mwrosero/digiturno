<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

use App\Models\Veris;

class DigiturnoController extends Controller
{
    public function index($mac) {
        $token = Veris::getToken();
        // dd($token);
        if($mac == "70-85-C2-91-96-4E"){
            return view('digiturno.portalerror')
                    ->with('accessToken',$token)
                    ->with('mac',$mac)
                    ->with('portalToken',$portalToken);
        }else{
        return view('digiturno.home')
                ->with('accessToken',$token)
                ->with('mac',$mac);
            }
    }

    public function ingreso($mac, Request $request) {
        $data = $request->all();
        if(isset($data['utm_medium']) && $data['utm_medium'] == 'CENTRAL'){
            $mac = 'E0-D5-5E-DB-42-36';
            return redirect()->route('ingreso', ['mac' => $mac, 'utm_source' => 'HOJA', 'utm_medium' => 'DORADO']);
        }

        $token = Veris::getToken();
        //dd($token);
        return view('digiturno.ingreso_kiosk')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function portal($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];

        return view('digiturno.portal2')
                    ->with('accessToken',$token)
                    ->with('mac',$mac)
                    ->with('portalToken',$portalToken);

        /*if($mac == "24-2F-FA-07-17-3E" || $mac == "90-FB-A6-02-01-F7" || $mac == "0C-9D-92-64-C3-34" || $mac == "E0-D5-5E-DB-42-36" || $mac == "90-FB-A6-02-02-27"){
            return view('digiturno.portal2')
                    ->with('accessToken',$token)
                    ->with('mac',$mac)
                    ->with('portalToken',$portalToken);
        }else{
            return view('digiturno.portal')
                    ->with('accessToken',$token)
                    ->with('mac',$mac)
                    ->with('portalToken',$portalToken);
        }*/
    }

    public function portal2($portalToken, Request $request) {
        $token = Veris::getToken();
        $data = $request->all();
        $mac = $data['mac'];
        return view('digiturno.portal2')
                ->with('mac',$mac)
                ->with('accessToken',$token)
                ->with('portalToken',$portalToken);
    }

    public function turno($portalToken) {
        $token = Veris::getToken();
        //dd($token);
        return view('digiturno.turno')
                ->with('accessToken',$token)
                ->with('portalToken',$portalToken);
    }

    public function turnero($mac){
        $token = Veris::getToken();
        return view('digiturno.visor_turnero')
               ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function turneroLaboratorio($mac){
        $token = Veris::getToken();
        return view('laboratorio.visor_turnero_laboratorio')
               ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function refreshToken(){
        $token = Veris::getToken();
        if($token != ""){
            $msg = [
                "code" => 200,
                "message" => "",
                "idToken" => $token
            ];
        }else{
            $msg = [
                "code" => 400,
                "message" => "No se pudo generar el token"
            ];
        }

        return response()->json($msg);
    }

    public function testIngreso($mac) {
        $token = Veris::getToken();
        //dd($token);
        return view('digiturno.ingreso_kiosk')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }
}
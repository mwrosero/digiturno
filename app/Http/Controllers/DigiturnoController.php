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
        return view('digiturno.home')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function ingreso($mac) {
        $token = Veris::getToken();
        //dd($token);
        return view('digiturno.ingreso')
                ->with('accessToken',$token)
                ->with('mac',$mac);
    }

    public function portal($portalToken) {
        $token = Veris::getToken();
        return view('digiturno.portal')
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
}
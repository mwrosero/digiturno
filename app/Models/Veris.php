<?php

namespace App\Models;

use session;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veris extends Model
{
    use HasFactory;
    //DEV
    // public const BASE_URL = 'https://desa-turnero.phantomx.com.ec';
    // public const BASE_URL_DIGITALES = 'https://api-phantomx.veris.com.ec';
    // public const BASE_WAR = 'turnero/v2';
    // public const SEGURIDADES_WAR = 'seguridadtest/v1';
    // public const CANAL_ORIGEN = 'MVE_CMV';
    // public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';//UEhBTlRPTVhfRU1QUkVTQVJJQUw=
    // public const IDORGANIZACION = 'adf4e264-cd20-4653-9a44-025b13050992';
    // public const AMPLITUDE = "1cbd8baed97a6c8abf6b8e398b77cf6f";
    // public const BASICAUTHDIGITALES = 'QkFDS0VORFBIQU5UT006Q2xAdmUxMjM0';

    //PROD
    public const BASE_URL = 'https://turnero.phantomx.com.ec';
    public const BASE_URL_DIGITALES = 'https://api.phantomx.com.ec';
    public const BASE_WAR = 'turnero/v2';
    public const SEGURIDADES_WAR = 'seguridad/v1';
    public const CANAL_ORIGEN = 'MVE_CMV';
    public const APPLICATION = 'UEhBTlRPTVhfQkFDS0VORA==';
    public const IDORGANIZACION = '365509c8-9596-4506-a5b3-487782d5876e';
    public const AMPLITUDE = "93127ac840f734cdcc8bf469f8bc95d5";
    public const BASICAUTHDIGITALES = 'YmFja2VuZHBoYW50b206QmFja1BAbnRoMG1QQHNzMjAyMQ==';

    static function call(Array $config)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $config['endpoint']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // METHOD
        if( $config['method'] == 'POST' ){
            curl_setopt($ch, CURLOPT_POST, 1);
        }else if( $config['method'] == 'GET' || $config['method'] == 'PUT' ){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $config['method']);
        }

        $header = [];
        $header[] = 'application: ' . self::APPLICATION;
        $header[] = 'idorganizacion: ' . self::IDORGANIZACION;

        // AUTH
        if( isset($config['token']) && !isset($config['data'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $config['token'] ));
            $header[] = 'Authorization: Bearer ' . $config['token'];
        }

        // POST DATA
        if( isset($config['data']) && ($config['method'] == 'POST' || $config['method'] == 'PUT' ) ){
            $data_serialized = json_encode($config['data']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_serialized);
            
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: ' . strlen($data_serialized);
            $header[] = 'content-language: es';
            
            if( isset($config['token']) ){
                $header[] = 'Authorization: Bearer ' . $config['token'];
            }
        }

        if( isset($config['basic']) ){
            $header[] = 'Authorization: Basic ' . $config['basic'];
            $header[] = 'Content-Type: application/json';
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // LOGIN
        if( isset($config['username']) && isset($config['password'])){
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
        }

        // dd($header);
        
        // API CALL
        try{
            $result = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
        }
        catch(\Exception $e){
            $result = [ 'error' => 'Falla en la llamada', ];
        }

        // RETURN DATA
        if( gettype($result) === 'string' )
            return json_decode($result);

        return $result;
    }

    /*
    * getToken
    * ----------------------------------------------
    * Peticion al webservice de ISM para obtener el token
    * de acceso para las peticiones CURL. Esto se debe
    * ejecutar una sola vez por sessión.
    * ----------------------------------------------
    */
    static function getToken()
    {
        $token = session('accessToken', null);

        /*if( $token !== null ){
            return $token;
        }*/
        
        $method = '/autenticacion/login';
        $response = Veris::call([
            'endpoint' => self::BASE_URL_DIGITALES.'/'.self::SEGURIDADES_WAR.$method,
            'basic' => self::BASICAUTHDIGITALES,
            'method'   => 'POST'
        ]);

        // echo self::BASE_URL_DIGITALES.'/'.self::SEGURIDADES_WAR.$method;
        // dd($response);
        
        session(['accessToken' => $response->data->idToken]);
        return $response->data->idToken;
    }

}
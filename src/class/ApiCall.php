<?php

namespace SgiSoftware\ApiRuc\class;

use SgiSoftware\ApiRuc\helpers\Response;
use SgiSoftware\ApiRuc\helpers\SET;
use stdClass;

class ApiCall
{
    const TIPO_IDENTIFICACION_RUC = "11";

    const TIPO_IDENTIFICACION_CEDULA_IDENTIDAD = "12";

    const TIPO_IDENTIFICACION_SIN_NOMBRE = "15";

    public String $APIKEY;

    public String $API_BASE_PATH;

    public String $API_BASE_PATH_ENDPOINT;

    public String $API_ENDPOINT_OBTENER;

    public String $API_ENDPOINT_BUSCAR;

    public function __construct()
    {
        $this->APIKEY = config('api-config.ruc_apikey');
        $this->API_BASE_PATH = config('api-config.ruc_base_path');
        $this->API_BASE_PATH_ENDPOINT = config('api-config.ruc_api_base_path_endpoint');
        $this->API_ENDPOINT_OBTENER = config('api-config.ruc_api_endpoint_obtener');
        $this->API_ENDPOINT_BUSCAR = config('api-config.ruc_api_endpoint_buscar');
    }

    public function obtenerContribuyente($rucn)
    {
        $url = $this->API_BASE_PATH . $this->API_BASE_PATH_ENDPOINT . $this->API_ENDPOINT_OBTENER . $rucn;

        $additional_headers = array(
            'Content-Type: application/json',
            'apikey: ' . $this->APIKEY
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $server_output = curl_exec($ch);
        $response = json_decode($server_output);

        if ($response->code == Response::STATUS_OK) {
            return $response;
        } else {
            $cliente = new stdClass();
            $response = new \stdClass();
            $response->content = $cliente;
            $response->code = Response::STATUS_NOT_FOUND;
            return $response;
        }
    }

    public function buscarContribuyente($rucn)
    {
        $url = $this->API_BASE_PATH . $this->API_BASE_PATH_ENDPOINT . $this->API_ENDPOINT_BUSCAR . $rucn;

        $additional_headers = array(
            'Content-Type: application/json',
            'apikey: ' . $this->APIKEY
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $server_output = curl_exec($ch);
        $response = json_decode($server_output);

        if ($response->code == Response::STATUS_OK) {
            return $response;
        } else {
            $cliente = new stdClass();
            $response = new \stdClass();
            $response->content = $cliente;
            $response->code = Response::STATUS_NOT_FOUND;
            return $response;
        }
    }

    public static function obtenerSiExiste($rucn)
    {
        $callApi = (new ApiCall)->obtenerContribuyente($rucn);

        /** Status 200 significa que esta en los registros de la SET
         * por lo tanto su tipo de identificación es RUC = 11
         */
        $cliente = new stdClass();

        if ($callApi->code == 200) {

            $reponseContent = $callApi->response->content;

            switch ($reponseContent->ESTADO) {
                case SET::ESTADO_CONTRIBUYENTE_ACTIVO:
                    $activo = true;
                    break;
                case SET::ESTADO_CONTRIBUYENTE_SUSPENSION_TEMPORAL:
                case SET::ESTADO_CONTRIBUYENTE_CANCELADO:
                case SET::ESTADO_CONTRIBUYENTE_CANCELADO_DEFINITIVO:
                case SET::ESTADO_CONTRIBUYENTE_BLOQUEADO:
                    $activo = false;
                    break;
                default;
                    $activo = false;
                    break;
            }

            $nombreContribuyente = ($reponseContent->NOMBRE != '' ? ($reponseContent->APELLIDO . ',' . $reponseContent->NOMBRE) : $reponseContent->APELLIDO);
            $cliente->DESCRIPC = $nombreContribuyente;
            $cliente->FACT_NOMB = $nombreContribuyente;
            $cliente->FACT_RUC = $activo ? ($reponseContent->RUCN . '-' . $reponseContent->DVN) : $reponseContent->RUCN;
            $cliente->RUCN = $reponseContent->RUCN;
            $cliente->DVN = $reponseContent->DVN;
            $cliente->TIPOID = $activo ? self::TIPO_IDENTIFICACION_RUC : self::TIPO_IDENTIFICACION_CEDULA_IDENTIDAD;
        }

        $res = new \stdClass();
        $res->content = $cliente;
        $res->code = $callApi->code;

        return $res;
    }
}

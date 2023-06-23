<?php

namespace SgiSoftware\class;

use SgiSoftware\configs\configsApi;
use SgiSoftware\helpers\Response;
use SgiSoftware\helpers\SET;
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

    /**
     * Comsume api call
     * @return false|\Illuminate\Support\Collection|string
     */
    public function __construct()
    {
        $config =  configsApi::get();

        $this->APIKEY = $config['sgi_ruc_apikey'];
        $this->API_BASE_PATH = $config['sgi_ruc_base_path'];
        $this->API_BASE_PATH_ENDPOINT = $config['sgi_ruc_api_base_path_endpoint'];
        $this->API_ENDPOINT_OBTENER = $config['sgi_ruc_api_endpoint_obtener'];
        $this->API_ENDPOINT_BUSCAR = $config['sgi_ruc_api_endpoint_buscar'];
    }

    public function obtenerContribuyente($rucn)
    {
        $url = $this->API_BASE_PATH . $this->API_BASE_PATH_ENDPOINT . $this->API_ENDPOINT_OBTENER . $this->APIKEY . '/' . $rucn;

        $additional_headers = array(
            'Content-Type: application/json',
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $server_output = curl_exec($ch);
        $response = json_decode($server_output);

        if ($response->status == Response::STATUS_OK) {
            return $response;
        } else {
            $cliente = new stdClass();
            $response = new \stdClass();
            $response->datos = $cliente;
            $response->status = Response::STATUS_NOT_FOUND;
            return $response;
        }
    }

    public function buscarContribuyente($rucn)
    {
        $url = $this->API_BASE_PATH . $this->API_BASE_PATH_ENDPOINT . $this->API_ENDPOINT_BUSCAR . $this->APIKEY . '/' . $rucn;

        $additional_headers = array(
            'Content-Type: application/json',
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $additional_headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $server_output = curl_exec($ch);
        $response = json_decode($server_output);

        if ($response->status == Response::STATUS_OK) {
            return $response;
        } else {
            $cliente = new stdClass();
            $response = new \stdClass();
            $response->datos = $cliente;
            $response->status = Response::STATUS_NOT_FOUND;
            return $response;
        }
    }

    public static function obtenerSiExiste($rucn)
    {
        $callApi = self::obtenerContribuyente($rucn);

        /** Status 200 significa que esta en los registros de la SET
         * por lo tanto su tipo de identificación es RUC = 11
         */
        $cliente = new stdClass();

        if ($callApi->status == 200) {

            switch ($callApi->response->ESTADO) {
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

            $nombreContribuyente = ($callApi->response->NOMBRE != '' ? ($callApi->response->APELLIDO . ',' . $callApi->response->NOMBRE) : $callApi->response->APELLIDO);
            $cliente->DESCRIPC = $nombreContribuyente;
            $cliente->FACT_NOMB = $nombreContribuyente;
            $cliente->FACT_RUC = $activo ? ($callApi->response->RUCN . '-' . $callApi->response->DVN) : $callApi->response->RUCN;
            $cliente->RUCN = $callApi->response->RUCN;
            $cliente->DVN = $callApi->response->DVN;
            $cliente->TIPOID = $activo ? self::TIPO_IDENTIFICACION_RUC : self::TIPO_IDENTIFICACION_CEDULA_IDENTIDAD;
        }

        $res = new \stdClass();
        $res->datos = $cliente;
        $res->status = $callApi->status;

        return $res;
    }
}

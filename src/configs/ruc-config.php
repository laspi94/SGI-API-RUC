<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DATOS_SET*
    |--------------------------------------------------------------------------
    |
    | Estas variables corresponde a la conexión con el API para la obtención de 
    | datos de contribuyentes de la SET, el BASE PATH depende del entorno el cual
    | se esté ejecutando.
    |
    */
    
    'ruc_apikey' => env('RUC_APIKEY', ''),
    'ruc_base_path' => env('RUC_API_BASE_PATH', ''),
    'ruc_api_base_path_endpoint' => env('RUC_API_BASE_PATH_ENDPOINT', ''),
    'ruc_api_endpoint_obtener' => env('RUC_API_ENDPOINT_OBTENER', ''),
    'ruc_api_endpoint_buscar' => env('RUC_API_ENDPOINT_BUSCAR', ''),

];

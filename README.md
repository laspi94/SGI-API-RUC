# SGI-API-RUC
package para realizar llamada al api de SGI Software y Dominios para obtener los contribuyentes registrados en la Secretaría de Estado de Tributación/Paraguay

# Ejemplo de uso para el método "obtenerSiExiste"
```php
<?php
class RucController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Devuelve los datos del contribuyente si este se encuentra registrado en la SET.
     * @return mixed
     */
    public function get($rucn)
    {
        return (new ApiCall)->obtenerSiExiste($rucn);
    }
}
```
# Respuesta servidor
```json
{
 "code": 200,
  "content":
  {
    "DESCRIPC": "LASPINA VILLALBA, CARLOS FABIAN",
    "FACT_NOMB": "LASPINA VILLALBA, CARLOS FABIAN",
    "FACT_RUC": 4199210,
    "RUCN": 4199210,
    "DVN": 5, 
    "TIPOID": "12"
}
```
# Ejemplo de uso para obtener el rawData "obtenerContribuyente"

```php
<?php
  (new ApiCall)->obtenerContribuyente($rucn);
```

```json
{
    "code": 200,
    "status": "OK",
    "response": {
        "content": {
            "RUCN": 4199210,
            "NOMBRE": " CARLOS FABIAN",
            "APELLIDO": "LASPINA VILLALBA",
            "RUCN_ANTERIOR": "LAVC921920E",
            "DVN": 5,
            "ESTADO": "SUSPENSION TEMPORAL",
            "ARCHIVO": "ruc0.zip"
        }
    },
    "message": "Contribuyente encontrado!"
}
```

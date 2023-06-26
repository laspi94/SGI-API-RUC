# api-ruc

package para realizar llamada al api de SGI Software y Dominios para obtener los contribuyentes registrados en la Secretaría de Estado de Tributación/Paraguay

## API Referencia

#### Obtener datos del contribuyente.

```http
  GET /api/v2/tributario/${rucn}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `rucn` | `string` | **Required**. RUC |

#### ${rucn}

Sin digito verificador.

#### Obtener listado de contribuyentes con 

```http
  GET /api/v2/buscar/tributario/${referencia}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `referencia` | `string` | **Required**. RUC |

#### ${referencia}

Puede usar la referencia del nombre, apellido, denominación o ruc(parcial sin digito verificador).


## Environment Variables

Para ejecutar este proyecto, deberá agregar las siguientes variables de entorno a su archivo .env

`RUC_APIKEY` = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'


## Installation

Instalar mi proyecto con composer

```bash
  composer require sgi-software/api-ruc
```
    
## Uso/Ejemplos

=======
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
## Usado por

Este proyecto es utilizado por las siguientes empresas:

- SGI Software y Dominios

## FAQ

#### ¿Cada cuanto se actualizan los registros?

Los registros son actualizados día a día, con los datos emitidos por el estado.

## License

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
## Authors

- [@laspi94](https://www.github.com/laspi94)
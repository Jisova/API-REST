<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Generators extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Vistas de los comandos del generador
     * ------------------------------------------------- -------------------------
     *
     * Esta matriz define la asignacion de comandos del generador a los archivos de vista
     * ellos estan usando. Si necesita personalizarlos usted mismo, copielos
     * ver archivos en su propia carpeta e indicar la ubicacion aqui.
     *
     * Notaras que las vistas tienen marcadores de posicion especiales encerrados entre
     * llaves `{...}`. Estos marcadores de posicion son utilizados internamente por el
     * comandos del generador en el procesamiento de reemplazos, por lo que se le advierte
     * no eliminarlos ni modificar los nombres. Si lo haces, puedes
     * terminar interrumpiendo el proceso de andamiaje y arrojar errores.
     *
     * USTED HA SIDO ADVERTIDO!
     *
     * @var array<string, string>
     */
    public $views = [
        'make:command'      => 'CodeIgniter\Commands\Generators\Views\command.tpl.php',
        'make:config'       => 'CodeIgniter\Commands\Generators\Views\config.tpl.php',
        'make:controller'   => 'CodeIgniter\Commands\Generators\Views\controller.tpl.php',
        'make:entity'       => 'CodeIgniter\Commands\Generators\Views\entity.tpl.php',
        'make:filter'       => 'CodeIgniter\Commands\Generators\Views\filter.tpl.php',
        'make:migration'    => 'CodeIgniter\Commands\Generators\Views\migration.tpl.php',
        'make:model'        => 'CodeIgniter\Commands\Generators\Views\model.tpl.php',
        'make:seeder'       => 'CodeIgniter\Commands\Generators\Views\seeder.tpl.php',
        'make:validation'   => 'CodeIgniter\Commands\Generators\Views\validation.tpl.php',
        'session:migration' => 'CodeIgniter\Commands\Generators\Views\migration.tpl.php',
    ];
}

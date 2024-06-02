<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * CONFIGURACION DEL CARGADOR AUTOMATICO
 * ------------------------------------------------- ------------------
 *
 * Este archivo define los espacios de nombres y mapas de clases para que el Autoloader
 * puede encontrar los archivos segun sea necesario.
 *
 * NOTA: Si usa una clave identica en $psr4 o $classmap, entonces
 * los valores en este archivo sobrescribiran los valores del marco.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Espacios de nombres
     * ------------------------------------------------- ------------------
     * Esto asigna las ubicaciones de cualquier espacio de nombres en su aplicacion a
     * su ubicacion en el sistema de archivos. Estos son utilizados por el cargador automatico.
     * para localizar archivos la primera vez que se crean instancias.

     *
     * Los directorios '/app' y '/system' ya estan asignados.
     * puedes cambiar el nombre del espacio de nombres de la 'Aplicacion' si lo deseas,
     * pero esto debe hacerse antes de crear clases con espacios de nombres,
     * de lo contrario, necesitaras modificar todas esas clases para que esto funcione.
     *
     * Prototipo:
     *```
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // Para espacio de nombres de aplicacion personalizado
        'Config'      => APPPATH . 'Config',
    ];

    /**
     * -------------------------------------------------------------------
     * Mapa de clase
     * ------------------------------------------------- ------------------
     * El mapa de clases proporciona un mapa de los nombres de las clases y sus nombres exactos.
     * ubicacion en el camino. Las clases cargadas de esta manera tendran
     * rendimiento ligeramente mas rapido porque no tendran que ser
     * buscado dentro de uno o mas directorios como lo harian si
     * se estaban cargando automaticamente a traves de un espacio de nombres.
     *
     * Prototipo:
     *```
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * -------------------------------------------------------------------
     * Archivos
     * ------------------------------------------------- ------------------
     * La matriz de archivos proporciona una lista de rutas a archivos __sin clase__
     * que se cargara automaticamente. Esto puede ser util para operaciones de arranque.
     * o para funciones de carga.
     *
     * Prototipo:
     * ```
     *	  $files = [
     *	 	   '/path/to/my/file.php',
     *    ];
     * ```
     *
     * @var array<int, string>
     */
    public $files = [];
}

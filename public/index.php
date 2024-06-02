<?php

//Ruta al controlador frontal(este archivo)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

/*
 *---------------------------------------------------------------
 * ARRANQUE LA APLICACION
 *---------------------------------------------------------------
 * Este proceso configura las constantes de ruta, cargas y registros.
 * nuestro cargador automatico, junto con el de Composer, carga nuestra constantes
 * y activa un arranque especifico del entorno.
 */

// Asegurese de que el directorio actual apunte al control frontal
chdir(__DIR__);

// Carga archivo de configuracion de rutas
// Esta es la linea que podria necesitar ser cambiada, dependiendo de
$pathsConfig = FCPATH . '../app/Config/Paths.php';
// ^^^ Change this if you move your application folder
require realpath($pathsConfig) ?: $pathsConfig;

$paths = new Config\Paths();

// Ubicacion del archivo de arranque del marco
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app       = require realpath($bootstrap) ?: $bootstrap;

/*
 *---------------------------------------------------------------
 * INICIAR LA APLICACION 
 *---------------------------------------------------------------
 * Ahora que todo esta configurado, es hora de encender
 * los motores y hacer que esta aplicacion funcione.
 */
$app->run();

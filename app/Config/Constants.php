<?php

/*
 | --------------------------------------------------------------------
 | Espacio de nombres de la aplicacion
 | -------------------------------------------------- ------------------
 |
 | Esto define el espacio de nombres predeterminado que se utiliza en todo
 | CodeIgniter para hacer referencia al directorio de la aplicacion. Cambiar
 | esta constante para cambiar el espacio de nombres que todas las aplicaciones
 | las clases deben utilizar.
 |
 | NOTA: cambiar esto requerira modificar manualmente el
 | espacios de nombres existentes de App\* clases con espacio de nombres.

 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Ruta del compositor
 | -------------------------------------------------- ------------------------
 |
 | La ruta en la que se espera que este el archivo de carga automatica de Composer. Por defecto,
 | La carpeta del proveedor este en el directorio raiz, pero puede personalizarla aqui.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Constantes de tiempo
 |------------------------------------------------- -------------------------
 |
 | Proporcionar formas sencillas de trabajar con la gran cantidad de funciones PHP que
 | requieren que la informacion este en segundos.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Codigos de estado de salida
 | -------------------------------------------------- ------------------------
 |
 | Se utiliza para indicar las condiciones bajo las cuales el script sale ().
 | Si bien no existe un estandar universal para los codigos de error, existen algunos
 | convenciones amplias.  A o se mencionan tres de estos convenios, por
 | aquellos que deseen hacer uso de ellos.  Los valores predeterminados de CodeIgniter eran
 | elegidos para la menor superposicion con estas convenciones, sin dejar de
 | dejando espacio para que otros se definan en futuras versiones y usuarios
 | aplicaciones.
 |
 | Las tres convenciones principales utilizadas para determinar los codigos de estado de salida
 | son como sigue:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

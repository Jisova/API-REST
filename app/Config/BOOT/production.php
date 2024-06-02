<?php

/*
 |--------------------------------------------------------------------------
 | PANTALLA DE ERRORES
 |--------------------------------------------------------------------------
 | No muestre NINGUNO en entornos de produccion. En su lugar, deje que el sistema
 | detecte y muestre un mensaje de error generico.
 */
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

/*
 |--------------------------------------------------------------------------
 | MODO DE DEPURACION
 |--------------------------------------------------------------------------
 | El modo de depuracion es un indicador experimental que puede permitir cambios en todo
 | momento el sistema. Actualmente no se utiliza mucho y es posible que no sobrviva.
 | liberacion del marco.
 */
defined('CI_DEBUG') || define('CI_DEBUG', false);

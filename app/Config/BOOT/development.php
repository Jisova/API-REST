<?php

/*
 |--------------------------------------------------------------------------
 | PANTALLA DE ERRORES
 |--------------------------------------------------------------------------
 | En desarrollo, queremos mostrar tantos errores como sea posible para 
 |ayudar a garantizar que no lleguen a produccion. Y ahorraremos horas de 
 | depuraciones dolorosas.
 */
error_reporting(-1);
ini_set('display_errors', '1');

/*
 |--------------------------------------------------------------------------
 | DEPURAR RASTROS DE PROCESOS
 |--------------------------------------------------------------------------
 | Si es verdadero, esta constante indicara a las pantallas de error que
 | muestren depuraciones | seguimientos junto con la otra información de error. Si
 | prefiere no ver esto , establezca este valor en falso
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

/*
 |--------------------------------------------------------------------------
 | MODO DE DEPURACION
 |--------------------------------------------------------------------------
 | El modo de depuracion es un indicador experimental que puede permitir cambios en 
 | todo momento el sistema. Esto controlara si Kint esta cargado y algunos otros
 | elementos. Tambien se puede utilizar siempre dentro de su propia aplicacion.
 */
defined('CI_DEBUG') || define('CI_DEBUG', true);

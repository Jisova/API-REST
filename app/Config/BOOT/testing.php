<?php

/*
 |--------------------------------------------------------------------------
 | PANTALLA DE ERRORES
 |--------------------------------------------------------------------------
 | En desarrollo, queremos mostrar tantos errores como sea posible para
 | ayudar a garantizar que no lleguen a produccion. Y ahorraremos horas de
 | depuracion dolorosa.
 */
error_reporting(-1);
ini_set('display_errors', '1');

/*
 |--------------------------------------------------------------------------
 | DEPURAR RASTROS DE RETROCESOS
 |--------------------------------------------------------------------------
 | Si es verdadero, esta constante indicara a las pantallas de error que muestren
 | seguimientos de depuracion junto con otra informacion de error. Si
 | prefiere no ver esto, establezaca este valor en falso.
 */
defined('SHOW_DEBUG_BACKTRACE') || define('SHOW_DEBUG_BACKTRACE', true);

/*
 |--------------------------------------------------------------------------
 | MODO DE DEPURACION 
 |--------------------------------------------------------------------------
 | Depuracion es un indicador experimental que puede permitir cambios
 | en el sistema. Actualmente no se usa ampliamente y es posible que no sobreviva
 | al lanzamiento del marco.
 */
defined('CI_DEBUG') || define('CI_DEBUG', true);

<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CURLRequest extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * CURLSolicitar opciones para compartir
     * ------------------------------------------------- -------------------------
     *
     * Ya sea para compartir opciones entre solicitudes o no.
     *
     * Si es verdadero, no se restableceran todas las opciones entre solicitudes.
     * Puede causar una solicitud de error con encabezados innecesarios.
     *
     * @var bool
     */
    public $shareOptions = true;
}

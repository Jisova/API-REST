<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuracion de cifrado.
 *
 * Estas son las configuraciones utilizadas para el cifrado, si no pasas un parametro
 * matriz al cifrador para creacion/inicializacion.
 */
class Encryption extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Iniciador de clave de cifrado
     * ------------------------------------------------- -------------------------
     *
     * Si utiliza la clase Encryption, debe establecer una clave de cifrado (semilla).
     * Debe asegurarse de que sea lo suficientemente largo para el cifrado y el modo que planea utilizar.
     * Consulte la guia del usuario para obtener mas informacion.
     *
     * @var string
     */
    public $key = '';

    /**
     * --------------------------------------------------------------------------
     * Controlador de cifrado a utilizar
     * ------------------------------------------------- -------------------------
     *
     * Uno de los controladores de cifrado compatibles.
     *
     * Controladores disponibles:
     * - OpenSSL
     * - Sodium
     *
     * @var string
     */
    public $driver = 'OpenSSL';

    /**
     * --------------------------------------------------------------------------
     * Longitud del relleno de SodiumHandler en bytes
     * ------------------------------------------------- -------------------------
     *
     * Este es el numero de bytes que se completaran con el mensaje de texto sin formato.
     * antes de que se cifre. Este valor debe ser mayor que cero.
     *
     * Consulte la guia del usuario para obtener mas informacion sobre el relleno.
     *
     * @var int
     */
    public $blockSize = 16;

    /**
     * --------------------------------------------------------------------------
     * Resumen de cifrado
     * ------------------------------------------------- -------------------------
     *
     * HMAC digest to use, e.g. 'SHA512' or 'SHA256'. Default value is 'SHA512'.
     *
     * @var string
     */
    public $digest = 'SHA512';
}

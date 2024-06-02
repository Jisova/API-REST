<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use DateTimeInterface;

class Cookie extends BaseConfig
{
    /**
     * ------------------------------------------------- -------------------------
     * Prefijo de cookies
     * ------------------------------------------------- -------------------------
     *
     * Establezca un prefijo de nombre de cookie si necesita evitar colisiones.
     *
     * @var string
     */
    public $prefix = '';

    /**
     * --------------------------------------------------------------------------
     *La cookie expira la marca de tiempo
     * ------------------------------------------------- -------------------------
     *
     * La marca de tiempo predeterminada vence para las cookies. Establecer esto en `0` significara que
     * la cookie no tendra el atributo `Expires` y se comportara como una sesion
     * Cookie.
     *
     * @var DateTimeInterface|int|string
     */
    public $expires = 0;

    /**
     * -------------------------------------------------- ------------------------
     * Ruta de cookies
     * ------------------------------------------------- -------------------------
     *
     * Normalmente sera una barra diagonal.

     *
     * @var string
     */
    public $path = '/';

    /**
     * --------------------------------------------------------------------------
     * Dominio de cookies
     * ------------------------------------------------- -------------------------
     *
     * Establezca en `.su-dominio.com` para cookies de todo el sitio.
     * 
     * @var string
     */
    public $domain = '';

    /**
     * --------------------------------------------------------------------------
     *Cookie segura
     * ------------------------------------------------- -------------------------
     *
     * La cookie solo se establecera si existe una conexion HTTPS segura.
     *
     * @var bool
     */
    public $secure = false;

    /**
     * --------------------------------------------------------------------------
     * Cookie HTTPSolo
     * ------------------------------------------------- -------------------------
     *
     * Solo se podra acceder a las cookies a traves de HTTP(S) (no JavaScript).
     *
     * @var bool
     */
    public $httponly = true;

    /**
     * --------------------------------------------------------------------------
     * Cookie Mismo Sitio
     * ------------------------------------------------- -------------------------
     *
     * Configurar la configuracion de cookies SameSite. Los valores permitidos son:
     * - None
     * - Lax
     * - Strict
     * - ''
     *
     * Alternativamente, puede utilizar los nombres de constantes:
     * - `Cookie::SAMESITE_NONE`
     * - `Cookie::SAMESITE_LAX`
     * - `Cookie::SAMESITE_STRICT`
     *
     * El valor predeterminado es `Lax` para compatibilidad con los navegadores modernos. Configuracion `''`
     * (cadena vacia) significa atributo SameSite predeterminado establecido por los navegadores (`Lax`)
     * se configurara en las cookies. Si se establece en `Ninguno`, tambien se debe configurar `$secure`.
     *
     * @var string
     */
    public $samesite = 'Lax';

    /**
     * --------------------------------------------------------------------------
     * Cookie Raw
     * --------------------------------------------------------------------------
     *
     * Esta bandera permite configurar una cookie "sin procesar", es decir, su nombre y valor son
     * no URL codificada usando `rawurlencode()`.
     *
     * Si esto se establece en "verdadero", los nombres de las cookies deben cumplir con RFC 2616.
     * lista de caracteres permitidos.

     *
     * @var bool
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#attributes
     * @see https://tools.ietf.org/html/rfc2616#section-2.2
     */
    public $raw = false;
}

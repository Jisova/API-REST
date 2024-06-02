<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * URL DEL SITIO BASE
     * --------------------------------------------------------------------------
     *
     * URL a su raiz CodeIgniter. Normalmente esta sera tu URL base,
     * con una barra diagonal:
     *
     *    http://example.com/
     *
     * Si esto no esta configurado. CodeIgniter intentara adivinar el protocolo, el 
     * dominio y la ruta a su instalacion. Sin embargo, siempre debes configurar esto
     * explicitamente y nunca confiar en la autoconjetura, especialmente en entornos
     * de produccion.
     *
     * @var string
     */
    public $baseURL = 'http://localhost:8080/';

    /**
     * --------------------------------------------------------------------------
     * Archivo de indice
     * --------------------------------------------------------------------------
     *
     * Normalmente, este sera su archivo index.php, a menos que le haya cambiado el 
     * nombre por otro. Si esta utilizando mod_rewrite para eliminar la pagina, configurar esta
     * variable.
     *
     * @var string
     */
    public $indexPage = 'index.php';

    /**
     * --------------------------------------------------------------------------
     * PROTOCOLO URI 
     * --------------------------------------------------------------------------
     *
     * Este elemento determina que getServer global debe usarse para recuperar la cadena URI.
     * La configuracion predeterminada de 'REQUEST_URI' funciona para la mayoria de los servidores.
     * Si tus enlaces no aparecen funcionar, prueba uno de los otros:
     *
     * 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
     * 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
     * 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
     *
     * ADVERTENCIA: Si configura esto en 'PATH_INFO!,URIS siempre estara decodificado en URL!
     *
     * @var string
     */
    public $uriProtocol = 'REQUEST_URI';

    /**
     * --------------------------------------------------------------------------
     * Configuracion regional predeterminada
     * --------------------------------------------------------------------------
     *
     * LA configuracion regional representa aproximadamente el idioma y la ubicacion 
     * desde donde el visitante ve el sitio. Afecta las cadenas de idioma y otras
     * cadenas (como marcadores de moneda, numeros, etc.) con las que su programa
     * debe ejecutarse para esta solicitud.
     *
     * @var string
     */
    public $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * Negociar la localidad
     * --------------------------------------------------------------------------
     *
     * Si es verdadero, el objeto Solicitud actual determinara automaticamente el
     * idioma a utilizar segun el valor del encabezado Accept-Language.
     *
     * Si es falso, no se realizara ninguna deteccion automatica.
     *
     * @var bool
     */
    public $negotiateLocale = false;

    /**
     * --------------------------------------------------------------------------
     * Configuraciones regionales admitidas
     * --------------------------------------------------------------------------
     *
     * Si $negotiateLocale es verdadero, esta matriz enumera las configuraciones regionales admitidas
     * por la aplicacion en orden de prioridad descendente. Si no hay coincidencia
     * encontrado, se utilizara la primera configuracion regional.
     *
     * @var string[]
     */
    public $supportedLocales = ['en'];

    /**
     * --------------------------------------------------------------------------
     * Zona horaria de la aplicacion
     * --------------------------------------------------------------------------
     *
     * La zona horaria predeterminada que se utilizara en su aplicacion para mostrar
     * fechas con el asistente de fechas y se pueden recuperar a traves de app_timezone()
     *
     * @var string
     */
    public $appTimezone = 'America/Chicago';

    /**
     * --------------------------------------------------------------------------
     * Conjunto de caracteres predeterminado
     * --------------------------------------------------------------------------
     *
     * Esto determina que juego de caracteres se utiliza de forma predeterminada en varios metodos.
     * que requieren que se proporcione un juego de caracteres.
     *
     * @see http://php.net/htmlspecialchars para obtener una lista de juegos de caracteres compatibles.
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * PROTOCOLO URI
     * --------------------------------------------------------------------------
     *
     * Si es verdadero, esto obligara a que todas las solicitudes realizadas a esta aplicacion sean
     * realizado a traves de una conexion segura (HTTPS). Si la solicitud entrante no es
     * seguro, el usuario sera redirigido a una version segura de la pagina
     * y se establecerá el encabezado HTTP Strict Transport Security.
     *
     * @var bool
     */
    public $forceGlobalSecureRequests = false;

    /**
     * --------------------------------------------------------------------------
     * Controlador de sesion
     * --------------------------------------------------------------------------
     *
     * El controlador de almacenamiento de sesion a utilizar:
     * - `CodeIgniter\Session\Handlers\FileHandler`
     * - `CodeIgniter\Session\Handlers\DatabaseHandler`
     * - `CodeIgniter\Session\Handlers\MemcachedHandler`
     * - `CodeIgniter\Session\Handlers\RedisHandler`
     *
     * @var string
     */
    public $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';

    /**
     * --------------------------------------------------------------------------
     * Nombre de la cookie de sesion
     * --------------------------------------------------------------------------
     *
     * El nombre de la cookie de sesion, must contain only [0-9a-z_-] caracteres
     *
     * @var string
     */
    public $sessionCookieName = 'ci_session';

    /**
     * --------------------------------------------------------------------------
     * Caducidad de la sesion
     * --------------------------------------------------------------------------
     *
     * El numero de SEGUNDOS que quieres que dure la sesion.
     * Establecer en 0 (cero) significa que caducara cuando se cierre el navegador.
     *
     * @var int
     */
    public $sessionExpiration = 7200;

    /**
     * --------------------------------------------------------------------------
     * Ruta para guardar sesion
     * --------------------------------------------------------------------------
     *
     * La ubicacion para guardar sesiones depende del controlador.
     *
     * Para rl coontrolador 'files' driver, it's a path es una ruta a directorio grabable.
     * ADVERTENCIA: Solo se admiten rutas absolutas!
     *
     * Para el controlador de 'database' driver,  es el nombre de una tabla.
     * Lea el manual for the format con otros controladores de sesion.
     *
     * MPORTANTE: DEBE establecer una ruta de guardado valida!
     *
     * @var string
     */
    public $sessionSavePath = WRITEPATH . 'session';

    /**
     * --------------------------------------------------------------------------
     * IP de coincidencia de sesion

     * --------------------------------------------------------------------------
     *
     * Si debe coincidir con la direccion IP del usuario al leer los datos de la sesion
     *
     * ADVERTENCIA: Si esta utilizando el controlador de la base de datos, no olvide actualizar
     *         la CLAVE PRIMARIA de su tabla de sesion al cambiar esta configuracion.
     *
     * @var bool
     */
    public $sessionMatchIP = false;

    /**
     * --------------------------------------------------------------------------
     * Tiempo de sesion para actualizar
     * --------------------------------------------------------------------------
     *
     * Cuantos segundos transcurren entre CI y la regeneracion del ID de sesion.
     *
     * @var int
     */
    public $sessionTimeToUpdate = 300;

    /**
     * --------------------------------------------------------------------------
     * Sesion Regenerar Destruir
     * --------------------------------------------------------------------------
     *
     * Si se deben destruir los datos de la sesion asociados con la ID de la sesion anterior
     * al regenerar automaticamente el ID de sesion. Cuando se establece en FALSO, los datos
     * sera posteriormente eliminado por el recolector de basura.
     *
     * @var bool
     */
    public $sessionRegenerateDestroy = false;

    /**
     * --------------------------------------------------------------------------
     * Prefijo de galleta
     * ------------------------------------------------- -------------------------
     *
     * Establezca un prefijo de nombre de cookie si necesita evitar colisiones.
     *
     * @var string
     *
     * @deprecated use Config\Cookie::$prefix propiedad en su lugar.
     */
    public $cookiePrefix = '';

    /**
     * --------------------------------------------------------------------------
     * Dominio de cookies
     * ------------------------------------------------- -------------------------
     *
     * Establezca en `.your-domain.com` para cookies de todo el sitio.
     *
     * @var string
     *
     * @deprecated use Config\Cookie::$domain propiedad en su lugar.
     */
    public $cookieDomain = '';

    /**
     * --------------------------------------------------------------------------
     *Ruta de cookies
     * ------------------------------------------------- -------------------------
     *
     * Normalmente sera una barra diagonal.
     *
     * @var string
     *
     * @deprecated use Config\Cookie::$path propiedad en su lugar.
     */
    public $cookiePath = '/';

    /**
     * --------------------------------------------------------------------------
     * Cookie segura
     * ------------------------------------------------- -------------------------
     *
     * La cookie solo se establecera si existe una conexion HTTPS segura.
     *
     * @var bool
     *
     * @deprecated use Config\Cookie::$secure propiedad en su lugar.
     */
    public $cookieSecure = false;

    /**
     * --------------------------------------------------------------------------
     * Cookie HttpOnly
     * --------------------------------------------------------------------------
     *
     * Cookie will only be accessible via HTTP(S) (no JavaScript).
     *
     * @var bool
     *
     * @deprecated use Config\Cookie::$httponly propiedad en su lugar.
     */
    public $cookieHTTPOnly = true;

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
     * se configurara en las cookies. Si se establece en `Ninguno`, tambien se debe configurar `$cookieSecure`.
     * @var string
     *
     * @deprecated use Config\Cookie::$samesite propiedad en su lugar.
     */
    public $cookieSameSite = 'Lax';

    /**
     * --------------------------------------------------------------------------
     * IP de proxy inverso
     * ------------------------------------------------- -------------------------
     *
     * Si su servidor esta detras de un proxy inverso, debe incluir el proxy en la lista blanca
     * Direcciones IP desde las cuales CodeIgniter deberia confiar en encabezados como
     * HTTP_X_FORWARDED_FOR y HTTP_CLIENT_IP para identificar correctamente
     * la direccion IP del visitante.
     *
     * Puede utilizar tanto una matriz como una lista de direcciones proxy separadas por comas,
     * ademas de especificar subredes completas. Aqui estan algunos ejemplos:

     *
     * Comma-separated:	'10.0.1.200,192.168.5.0/24'
     * Array: ['10.0.1.200', '192.168.5.0/24']
     *
     * @var string|string[]
     */
    public $proxyIPs = '';

    /**
     * --------------------------------------------------------------------------
     * Nombre del token CSRF
     * ------------------------------------------------- -------------------------
     *
     * El nombre del token.
     *
     * @deprecated Use `Config\Security` $tokenName propiedad en lugar de utilizar esta propiedad.
     *
     * @var string
     */
    public $CSRFTokenName = 'csrf_test_name';

    /**
     * --------------------------------------------------------------------------
     * Nombre del encabezado CSRF
     * ------------------------------------------------- -------------------------
     *
     * El nombre del encabezado.
     *
     * @deprecated Use `Config\Security` $headerName propiedad en lugar de utilizar esta propiedad.
     *
     * @var string
     */
    public $CSRFHeaderName = 'X-CSRF-TOKEN';

    /**
     * --------------------------------------------------------------------------
     * Nombre de la cookie CSRF
     * ------------------------------------------------- -------------------------
     *
     * El nombre de la cookie.
     *
     * @deprecated Use `Config\Security` $cookieName propiedad en lugar de utilizar esta propiedad.
     *
     * @var string
     */
    public $CSRFCookieName = 'csrf_cookie_name';

    /**
     * --------------------------------------------------------------------------
     * CSRF caducar
     * ------------------------------------------------- -------------------------
     *
     * El numero en segundos que el token deberia caducar.
     *
     * @deprecated Use `Config\Security` $expire propiedad en lugar de utilizar esta propiedad.
     *
     * @var int
     */
    public $CSRFExpire = 7200;

    /**
     * --------------------------------------------------------------------------
     * CSRF regenerar
     * ------------------------------------------------- -------------------------
     *
     * Regenerar token en cada envio?
     *
     * @deprecated Use `Config\Security` $regenerate propiedad en lugar de utilizar esta propiedad.
     *
     * @var bool
     */
    public $CSRFRegenerate = true;

    /**
     * --------------------------------------------------------------------------
     * Redireccionamiento CSRF
     * ------------------------------------------------- -------------------------
     *
     * Redirigir a la pagina anterior con error en caso de falla?
     * 
     * @deprecated Use `Config\Security` $redirect propiedad en lugar de utilizar esta propiedad.
     *
     * @var bool
     */
    public $CSRFRedirect = true;

    /**
     * --------------------------------------------------------------------------
     *CSRF Mismo sitio
     * ------------------------------------------------- -------------------------
     *
     * Configuracion para el token de cookie CSRF SameSite. Los valores permitidos son:
     * - None
     * - Lax
     * - Strict
     * - ''
     *
     * El valor predeterminado es `Lax` como se recomienda en este enlace:
     *
     * @see https://portswigger.net/web-security/csrf/samesite-cookies
     * @deprecated Use `Config\Security` $samesite propiedad en lugar de utilizar esta propiedad.
     *
     * @var string
     */
    public $CSRFSameSite = 'Lax';

    /**
     * --------------------------------------------------------------------------
     * Politica de seguridad de contenidos
     * ------------------------------------------------- -------------------------
     *
     * Permite que la Politica de seguridad de contenido de Response restrinja las fuentes que
     * se puede utilizar para imagenes, scripts, archivos CSS, audio, video, etc. Si esta habilitado,
     * el objeto Respuesta completara los valores predeterminados para la politica desde el
     * Archivo `ContentSecurityPolicy.php`. Los controladores siempre pueden agregar a esos
     * restricciones en tiempo de ejecucion.
     *
     * Para una mejor comprension de CSP, consulte estos documentos:
     *
     * @see http://www.html5rocks.com/en/tutorials/security/content-security-policy/
     * @see http://www.w3.org/TR/CSP/
     *
     * @var bool
     */
    public $CSPEnabled = false;
}

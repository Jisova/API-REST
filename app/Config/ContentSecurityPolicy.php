<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Almacena la configuracion predeterminada para ContentSecurityPolicy, si
 * elige usarlo. Los valores aqui se leeran y estableceran como predeterminados.
 * para el sitio. Si es necesario, se pueden anular pagina por pagina.
 *
 * Referencia sugerida para explicaciones:

 *
 * @see https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 */
class ContentSecurityPolicy extends BaseConfig
{
    //-------------------------------------------------------------------------
    // Gestion general de CSP
    //-------------------------------------------------------------------------

    /**
     * Default CSP report context
     *
     * @var bool
     */
    public $reportOnly = false;

    /**
     * Specifies a URL where a browser will send reports
     * when a content security policy is violated.
     *
     * @var string|null
     */
    public $reportURI;

    /**Instruye a los agentes de usuario a reescribir esquemas de URL, cambiando
     * HTTP y HTTPS. Esta directiva es para sitios web con
     * una gran cantidad de URL antiguas que deben reescribirse.
     *
     * @var bool
     */
    public $upgradeInsecureRequests = false;

    //-------------------------------------------------------------------------
    // Fuentes permitidas
    // Nota: una vez que estableces una politica en 'ninguna', no se puede restringir mas
    //-------------------------------------------------------------------------

    /**
     * Se predeterminara a si mismo si no se anula
     *
     * @var string|string[]|null
     */
    public $defaultSrc;

    /**
     * Lists allowed scripts' URLs.
     *
     * @var string|string[]
     */
    public $scriptSrc = 'self';

    /**
     * Lists allowed stylesheets' URLs.
     *
     * @var string|string[]
     */
    public $styleSrc = 'self';

    /**
     * Defines the origins from which images can be loaded.
     *
     * @var string|string[]
     */
    public $imageSrc = 'self';

    /**
     * Restricts the URLs that can appear in a page's `<base>` element.
     *
     * Will default to self if not overridden
     *
     * @var string|string[]|null
     */
    public $baseURI;

    /**
     * Lists the URLs for workers and embedded frame contents
     *
     * @var string|string[]
     */
    public $childSrc = 'self';

    /**
     * Limits the origins that you can connect to (via XHR,
     * WebSockets, and EventSource).
     *
     * @var string|string[]
     */
    public $connectSrc = 'self';

    /**
     * Specifies the origins that can serve web fonts.
     *
     * @var string|string[]
     */
    public $fontSrc;

    /**
     * Lists valid endpoints for submission from `<form>` tags.
     *
     * @var string|string[]
     */
    public $formAction = 'self';

    /**
     * Especifica las fuentes que pueden incrustar la pagina actual.
     * Esta directiva se aplica a `<frame>`, `<iframe>`, `<embed>`,
     etiquetas * y `<applet>`. Esta directiva no se puede utilizar en
     * Etiquetas `<meta>` y se aplica solo a recursos que no son HTML.
     *
     * @var string|string[]|null
     */
    public $frameAncestors;

    /**
     * The frame-src directive restricts the URLs which may
     * be loaded into nested browsing contexts.
     *
     * @var array|string|null
     */
    public $frameSrc;

    /**
     * Restricts the origins allowed to deliver video and audio.
     *
     * @var string|string[]|null
     */
    public $mediaSrc;

    /**
     * Allows control over Flash and other plugins.
     *
     * @var string|string[]
     */
    public $objectSrc = 'self';

    /**
     * @var string|string[]|null
     */
    public $manifestSrc;

    /**
     * Limits the kinds of plugins a page may invoke.
     *
     * @var string|string[]|null
     */
    public $pluginTypes;

    /**
     * List of actions allowed.
     *
     * @var string|string[]|null
     */
    public $sandbox;
}

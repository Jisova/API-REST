<?php

/**
 *Este archivo es parte del marco CodeIgniter 4.
 *
 * (c) Fundacion CodeIgniter <admin@codeigniter.com>
 *
 * Para obtener informacion completa sobre derechos de autor y licencia, consulte
 * el archivo de LICENCIA que se distribuyo con este codigo fuente.
 */

namespace CodeIgniter\API;

use CodeIgniter\Format\FormatterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use Config\Services;

/**
 * Proporciona metodos comunes y mas legibles para proporcionar
 * respuestas HTTP consistentes bajo una variedad de comunes
 * situaciones al trabajar como API.

 *
 * @property IncomingRequest $request
 * @property Response        $response
 */
trait ResponseTrait
{
    /**
     *Permite que las clases secundarias anulen el
     * codigo de estado que se utiliza en su API.
     *
     * @var array<string, int>
     */
    protected $codes = [
        'created'                   => 201,
        'deleted'                   => 200,
        'updated'                   => 200,
        'no_content'                => 204,
        'invalid_request'           => 400,
        'unsupported_response_type' => 400,
        'invalid_scope'             => 400,
        'temporarily_unavailable'   => 400,
        'invalid_grant'             => 400,
        'invalid_credentials'       => 400,
        'invalid_refresh'           => 400,
        'no_data'                   => 400,
        'invalid_data'              => 400,
        'access_denied'             => 401,
        'unauthorized'              => 401,
        'invalid_client'            => 401,
        'forbidden'                 => 403,
        'resource_not_found'        => 404,
        'not_acceptable'            => 406,
        'resource_exists'           => 409,
        'conflict'                  => 409,
        'resource_gone'             => 410,
        'payload_too_large'         => 413,
        'unsupported_media_type'    => 415,
        'too_many_requests'         => 429,
        'server_error'              => 500,
        'unsupported_grant_type'    => 501,
        'not_implemented'           => 501,
    ];

    /**
     * Como formatear los datos de respuesta.
     * Ya sea 'json' o 'xml'. Si estara en blanco
     * determinar a traves de la negociacion de contenidos.
     *
     * @var string
     */
    protected $format = 'json';

    /**
     * Instancia actual del formateador. Esto generalmente lo establece ResponseTrait::format
     *
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * Proporciona un metodo unico y sencillo para devolver una respuesta API, formateada
     * para que coincida con el formato solicitado, con el tipo de contenido y el codigo de estado adecuados.
     *
     * @param array|string|null $data
     *
     * @return Response
     */
    protected function respond($data = null, ?int $status = null, string $message = '')
    {
        if ($data === null && $status === null) {
            $status = 404;
            $output = null;
        } elseif ($data === null && is_numeric($status)) {
            $output = null;
        } else {
            $status = empty($status) ? 200 : $status;
            $output = $this->format($data);
        }

        if ($output !== null) {
            if ($this->format === 'json') {
                return $this->response->setJSON($output)->setStatusCode($status, $message);
            }

            if ($this->format === 'xml') {
                return $this->response->setXML($output)->setStatusCode($status, $message);
            }
        }

        return $this->response->setBody($output)->setStatusCode($status, $message);
    }

    /**
     *Se utiliza para errores genericos para los que no existen metodos personalizados.
     *
     * @param array|string $messages
     * @param int          $status   HTTP status code
     * @param string|null  $code     Custom, API-specific, error code
     *
     * @return Response
     */
    protected function fail($messages, int $status = 400, ?string $code = null, string $customMessage = '')
    {
        if (! is_array($messages)) {
            $messages = ['error' => $messages];
        }

        $response = [
            'status'   => $status,
            'error'    => $code ?? $status,
            'messages' => $messages,
        ];

        return $this->respond($response, $status, $customMessage);
    }

    //--------------------------------------------------------------------
    // Ayudantes de respuesta
    //------------------------------------------------ --------------------

    /**
     * Se utiliza despues de crear con exito un nuevo recurso.
     *
     * @param mixed $data
     *
     * @return Response
     */
    protected function respondCreated($data = null, string $message = '')
    {
        return $this->respond($data, $this->codes['created'], $message);
    }

    /**
     * Se utiliza despues de que un recurso se haya eliminado exitosamente.
     *
     * @param mixed $data
     *
     * @return Response
     */
    protected function respondDeleted($data = null, string $message = '')
    {
        return $this->respond($data, $this->codes['deleted'], $message);
    }

    /**
     * Se utiliza despues de que un recurso se haya actualizado correctamente.
     *
     * @param mixed $data
     *
     * @return Response
     */
    protected function respondUpdated($data = null, string $message = '')
    {
        return $this->respond($data, $this->codes['updated'], $message);
    }

    /**
     * Se utiliza despues de que un comando se ha ejecutado con exito pero no hay
     * respuesta significativa para enviar de vuelta al cliente
     *
     * @return Response
     */
    protected function respondNoContent(string $message = 'No Content')
    {
        return $this->respond(null, $this->codes['no_content'], $message);
    }

    /**
     *Se utiliza cuando el cliente no envio informacion de autorizacion,
     * o tenia malas credenciales de autorizacion. Se anima al usuario a intentarlo de nuevo.
     *con la informacion adecuada.
     *
     * @return Response
     */
    protected function failUnauthorized(string $description = 'Unauthorized', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['unauthorized'], $code, $message);
    }

    /**
     *Se utiliza cuando siempre se deniega el acceso a este recurso y sin importe
     * de volver a intentarlo ayudara.
     *
     * @return Response
     */
    protected function failForbidden(string $description = 'Forbidden', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['forbidden'], $code, $message);
    }

    /**
     * Se utiliza cuando no se puede encontrar un recurso especifico.
     *
     * @return Response
     */
    protected function failNotFound(string $description = 'Not Found', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['resource_not_found'], $code, $message);
    }

    /**
     *Se utiliza cuando los datos proporcionados por el cliente no pueden ser validados.
     *
     * @return Response
     *
     * @deprecated Use failValidationErrors instead
     */
    protected function failValidationError(string $description = 'Bad Request', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['invalid_data'], $code, $message);
    }

    /**
     * Se utiliza cuando los datos proporcionados por el cliente no pueden ser validados en uno o mas campos.
     *
     * @param string|string[] $errors
     *
     * @return Response
     */
    protected function failValidationErrors($errors, ?string $code = null, string $message = '')
    {
        return $this->fail($errors, $this->codes['invalid_data'], $code, $message);
    }

    /**
     * Uselo cuando intente crear un nuevo recurso y ya exista.
     *
     * @return Response
     */
    protected function failResourceExists(string $description = 'Conflict', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['resource_exists'], $code, $message);
    }

    /**
     * Uselo cuando un recurso fue eliminado previamente. Esto es diferente a
     * No encontrado, porque aqui sabemos que los datos existian anteriormente, pero ya no estan.
     * donde No encontrado significa que simplemente no podemos encontrar ninguna informacion al respecto.
     *
     * @return Response
     */
    protected function failResourceGone(string $description = 'Gone', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['resource_gone'], $code, $message);
    }

    /**
     * Se utiliza cuando el usuario ha realizado demasiadas solicitudes del recurso recientemente.
     *
     * @return Response
     */
    protected function failTooManyRequests(string $description = 'Too Many Requests', ?string $code = null, string $message = '')
    {
        return $this->fail($description, $this->codes['too_many_requests'], $code, $message);
    }

    /**
     * Se utiliza cuando hay un error del servidor.
     *
     * @param string      $descripcion   El mensaje de error que se mostrara al usuario.
     * @param string|null $codigo        Un codigo de error personalizado, especifico de API.
     * @param string      $mensaje       Un mensaje personalizado de "motivo" para devolver.
     *
     * @return Response The value of the Response's send() method.
     */
    protected function failServerError(string $description = 'Internal Server Error', ?string $code = null, string $message = ''): Response
    {
        return $this->fail($description, $this->codes['server_error'], $code, $message);
    }

    //--------------------------------------------------------------------
    //Metodos de utilidad
    //------------------------------------------------ --------------------

    /**
     * Maneja el formato de una respuesta. Actualmente hace algunas suposiciones importantes.
     * y necesita actualizacion! :)
     *
     * @param array|string|null $data
     *
     * @return string|null
     */
    protected function format($data = null)
    {
        // Si los datos son una cadena, no hay mucho que podamos hacer con ellos...
        if (is_string($data)) {
            // El tipo de contenido debe ser texto/... y no aplicacion/...
            $contentType = $this->response->getHeaderLine('Content-Type');
            $contentType = str_replace('application/json', 'text/html', $contentType);
            $contentType = str_replace('application/', 'text/', $contentType);
            $this->response->setContentType($contentType);
            $this->format = 'html';

            return $data;
        }

        $format = Services::format();
        $mime   = "application/{$this->format}";

        //Determinar el tipo de respuesta correcto mediante la negociacion de contenido si no se declara explicitamente
        if (empty($this->format) || ! in_array($this->format, ['json', 'xml'], true)) {
            $mime = $this->request->negotiate('media', $format->getConfig()->supportedResponseFormats, false);
        }

        $this->response->setContentType($mime);

        // Si no tenemos un formateador, crea uno.
        if (! isset($this->formatter)) {
            // si no hay formateador, use el predeterminado
            $this->formatter = $format->getFormatter($mime);
        }

        if ($mime !== 'application/json') {
            // Convertir objetos de forma recursiva en matrices asociativas
            // No se requiere conversion para JSONFormatter
            $data = json_decode(json_encode($data), true);
        }

        return $this->formatter->format($data);
    }

    /**
     * Establece el formato en el que debe estar la respuesta.
     *
     * @return $this
     */
    protected function setResponseFormat(?string $format = null)
    {
        $this->format = strtolower($format);

        return $this;
    }
}

<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Format\FormatterInterface;

class Format extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     *Formatos de respuesta disponibles
     * ------------------------------------------------- -------------------------
     *
     * Cuando realizas la negociacion de contenido con la solicitud, estos son los
     * formatos disponibles que admite su aplicacion. Esto es actualmente
     * solo se usa con API\ResponseTrait. Debe existir un formateador valido
     * para el formato especificado.
     *
     * Estos formatos solo se verifican cuando los datos se pasan a responder()
     * el metodo es una matriz.
     *
     * @var string[]
     */
    public $supportedResponseFormats = [
        'application/json',
        'application/xml', // machine-readable XML
        'text/xml', // human-readable XML
    ];

    /**
     * --------------------------------------------------------------------------
     * Formateadores
     * ------------------------------------------------- -------------------------
     *
     * Enumera la clase que se utilizara para formatear respuestas de un tipo particular.
     * Para cada tipo de mime, indique la clase que se debe utilizar. Formateadores
     * se puede recuperar mediante el metodo getFormatter().
     *
     * @var array<string, string>
     */
    public $formatters = [
        'application/json' => 'CodeIgniter\Format\JSONFormatter',
        'application/xml'  => 'CodeIgniter\Format\XMLFormatter',
        'text/xml'         => 'CodeIgniter\Format\XMLFormatter',
    ];

    /**
     * --------------------------------------------------------------------------
     * Formatters Options
     * ----------------------------------------------------- ---------------------
     *
     * Opciones adicionales para ajustar el comportamiento predeterminado de los formateadores.
     * Para cada tipo de mime, enumere las opciones adicionales que se deben utilizar.

     *
     * @var array<string, int>
     */
    public $formatterOptions = [
        'application/json' => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        'application/xml'  => 0,
        'text/xml'         => 0,
    ];

    /**
     *Un metodo Factory para devolver el formateador apropiado para el tipo mime dado.
     *
     * @return FormatterInterface
     *
     * @deprecated Este es un alias de `\CodeIgniter\Format\Format::getFormatter`. Usa eso en su lugar.
     */
    public function getFormatter(string $mime)
    {
        return Services::format()->getFormatter($mime);
    }
}

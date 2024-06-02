<?php

/**
 *Este archivo es parte del marco CodeIgniter 4.
 *
 * (c) Fundacion CodeIgniter <admin@codeigniter.com>
 *
 * Para obtener informacion completa sobre derechos de autor y licencia, consulte
 * el archivo de LICENCIA que se distribuyo con este codigo fuente.
 */

namespace CodeIgniter\Database;

use CodeIgniter\Config\Factories;

/**
 * Returns new or shared Model instances
 *
 * @deprecated Use CodeIgniter\Config\Factories::models()
 *
 * @codeCoverageIgnore
 */
class ModelFactory
{
    /**
     * Creates new Model instances or returns a shared instance
     *
     * @return mixed
     */
    public static function get(string $name, bool $getShared = true, ?ConnectionInterface $connection = null)
    {
        return Factories::models($name, ['getShared' => $getShared], $connection);
    }

    /**
     * Helper method for injecting mock instances while testing.
     *
     * @param object $instance
     */
    public static function injectMock(string $name, $instance)
    {
        Factories::injectMock('models', $name, $instance);
    }

    /**
     * Resets the static arrays
     */
    public static function reset()
    {
        Factories::reset('models');
    }
}

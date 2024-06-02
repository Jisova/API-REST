<?php

namespace Config;

use CodeIgniter\Config\View as BaseView;

class View extends BaseView
{
    /**
     * Cuando es falso, el metodo de visualizacion borrara los datos entre cada
     * llamar. Esto mantiene sus datos seguros y garantiza que no se produzcan errores accidentales.
     * fugas entre llamadas, por lo que necesitaria pasar los datos explicitamente
     * a cada vista. Es posible que prefiera que los datos permanezcan entre
     * Llama para que este disponible para todas las vistas. Si ese es el caso,
     * establecer $saveData en verdadero.

     *
     * @var bool
     */
    public $saveData = true;

    /**
     * Los filtros del analizador asignan un nombre de filtro con cualquier PHP invocable. Cuando el
     * El analizador prepara una variable para mostrarla, la encadenara
     * a traves de los filtros en el orden definido, insertando cualquier parametro.
     * Para evitar posibles abusos, todos los filtros DEBEN definirse aqui
     * para que esten disponibles para su uso dentro del analizador.
     *
     * Ejemplos:
     *  { title|esc(js) }
     *  { created_on|date(Y-m-d)|esc(attr) }
     *
     * @var array
     */
    public $filters = [];

    /**
     * Los complementos del analizador proporcionan una forma de ampliar la funcionalidad proporcionada
     * por el analizador central creando alias que seran reemplazados por
     * cualquier invocable. Puede ser unico o par de etiquetas.
     *
     * @var array
     */
    public $plugins = [];
}

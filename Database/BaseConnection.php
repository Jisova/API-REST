<?php

/**
 * Este archivo es parte del marco CodeIgniter 4.
 *
 * (c) Fundacion CodeIgniter <admin@codeigniter.com>
 *
 * Para obtener informacion completa sobre derechos de autor y licencia, consulte
 * el archivo de LICENCIA que se distribuyo con este codigo fuente.
 */

namespace CodeIgniter\Database;

use Closure;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Events\Events;
use Throwable;

/**
 * @property array      $aliasedTables
 * @property string     $charset
 * @property bool       $compress
 * @property float      $connectDuration
 * @property float      $connectTime
 * @property string     $database
 * @property string     $DBCollat
 * @property bool       $DBDebug
 * @property string     $DBDriver
 * @property string     $DBPrefix
 * @property string     $DSN
 * @property mixed      $encrypt
 * @property array      $failover
 * @property string     $hostname
 * @property mixed      $lastQuery
 * @property string     $password
 * @property bool       $pConnect
 * @property int|string $port
 * @property bool       $pretend
 * @property string     $queryClass
 * @property array      $reservedIdentifiers
 * @property bool       $strictOn
 * @property string     $subdriver
 * @property string     $swapPre
 * @property int        $transDepth
 * @property bool       $transFailure
 * @property bool       $transStatus
 */
abstract class BaseConnection implements ConnectionInterface
{
    /**
     * Nombre de fuente de datos/cadena de conexion
     *
     * @var string
     */
    protected $DSN;

    /**
     * Puerto de base de datos
     *
     * @var int|string
     */
    protected $port = '';

    /**
     * Hostname
     *
     * @var string
     */
    protected $hostname;

    /**
     * Username
     *
     * @var string
     */
    protected $username;

    /**
     * Password
     *
     * @var string
     */
    protected $password;

    /**
     * Database name
     *
     * @var string
     */
    protected $database;

    /**
     * Database driver
     *
     * @var string
     */
    protected $DBDriver = 'MySQLi';

    /**
     * Sub-driver
     *
     * @used-by CI_DB_pdo_driver
     *
     * @var string
     */
    protected $subdriver;

    /**
     * Table prefix
     *
     * @var string
     */
    protected $DBPrefix = '';

    /**
     * Persistent connection flag
     *
     * @var bool
     */
    protected $pConnect = false;

    /**
     * Debug flag
     *
     * Whether to display error messages.
     *
     * @var bool
     */
    protected $DBDebug = false;

    /**
     * Character set
     *
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * Collation
     *
     * @var string
     */
    protected $DBCollat = 'utf8_general_ci';

    /**
     * Swap Prefix
     *
     * @var string
     */
    protected $swapPre = '';

    /**
     * Encryption flag/data
     *
     * @var mixed
     */
    protected $encrypt = false;

    /**
     * Compression flag
     *
     * @var bool
     */
    protected $compress = false;

    /**
     * Strict ON flag
     *
     * Whether we're running in strict SQL mode.
     *
     * @var bool
     */
    protected $strictOn;

    /**
     * Settings for a failover connection.
     *
     * @var array
     */
    protected $failover = [];

    /**
     * The last query object that was executed
     * on this connection.
     *
     * @var mixed
     */
    protected $lastQuery;

    /**
     * Connection ID
     *
     * @var bool|object|resource
     */
    public $connID = false;

    /**
     * Result ID
     *
     * @var bool|object|resource
     */
    public $resultID = false;

    /**
     * Protect identifiers flag
     *
     * @var bool
     */
    public $protectIdentifiers = true;

    /**
     * List of reserved identifiers
     *
     * Identifiers that must NOT be escaped.
     *
     * @var array
     */
    protected $reservedIdentifiers = ['*'];

    /**
     * Identifier escape character
     *
     * @var array|string
     */
    public $escapeChar = '"';

    /**
     * ESCAPE statement string
     *
     * @var string
     */
    public $likeEscapeStr = " ESCAPE '%s' ";

    /**
     * ESCAPE character
     *
     * @var string
     */
    public $likeEscapeChar = '!';

    /**
     * RegExp used to escape identifiers
     *
     * @var array
     */
    protected $pregEscapeChar = [];

    /**
     * Holds previously looked up data
     * for performance reasons.
     *
     * @var array
     */
    public $dataCache = [];

    /**
     * Microtime when connection was made
     *
     * @var float
     */
    protected $connectTime = 0.0;

    /**
     * How long it took to establish connection.
     *
     * @var float
     */
    protected $connectDuration = 0.0;

    /**
     * If true, no queries will actually be
     * ran against the database.
     *
     * @var bool
     */
    protected $pretend = false;

    /**
     * Transaction enabled flag
     *
     * @var bool
     */
    public $transEnabled = true;

    /**
     * Strict transaction mode flag
     *
     * @var bool
     */
    public $transStrict = true;

    /**
     * Transaction depth level
     *
     * @var int
     */
    protected $transDepth = 0;

    /**
     * Transaction status flag
     *
     * Used with transactions to determine if a rollback should occur.
     *
     * @var bool
     */
    protected $transStatus = true;

    /**
     * Transaction failure flag
     *
     * Used with transactions to determine if a transaction has failed.
     *
     * @var bool
     */
    protected $transFailure = false;

    /**
     * Array of table aliases.
     *
     * @var array
     */
    protected $aliasedTables = [];

    /**
     * Query Class
     *
     * @var string
     */
    protected $queryClass = 'CodeIgniter\\Database\\Query';

    /**
     * Saves our connection settings.
     */
    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        $queryClass = str_replace('Connection', 'Query', static::class);

        if (class_exists($queryClass)) {
            $this->queryClass = $queryClass;
        }
    }

    /**
     * Initializes the database connection/settings.
     *
     * @throws DatabaseException
     *
     * @return mixed
     */
    public function initialize()
    {
        /* Si hay una conexion establecida disponible, entonces hay
         * no es necesario conectarse y seleccionar la base de datos.
         *
         * Dependiendo del controlador de la base de datos, conn_id puede ser
         * booleano VERDADERO, un recurso o un objeto.
         */
        if ($this->connID) {
            return;
        }

        $this->connectTime = microtime(true);
        $connectionErrors  = [];

        try {
            // Connect to the database and set the connection ID
            $this->connID = $this->connect($this->pConnect);
        } catch (Throwable $e) {
            $connectionErrors[] = sprintf('Main connection [%s]: %s', $this->DBDriver, $e->getMessage());
            log_message('error', 'Error connecting to the database: ' . $e->getMessage());
        }

        // No connection resource? Check if there is a failover else throw an error
        if (! $this->connID) {
            // Check if there is a failover set
            if (! empty($this->failover) && is_array($this->failover)) {
                // Go over all the failovers
                foreach ($this->failover as $index => $failover) {
                    // Replace the current settings with those of the failover
                    foreach ($failover as $key => $val) {
                        if (property_exists($this, $key)) {
                            $this->{$key} = $val;
                        }
                    }

                    try {
                        // Try to connect
                        $this->connID = $this->connect($this->pConnect);
                    } catch (Throwable $e) {
                        $connectionErrors[] = sprintf('Failover #%d [%s]: %s', ++$index, $this->DBDriver, $e->getMessage());
                        log_message('error', 'Error connecting to the database: ' . $e->getMessage());
                    }

                    // If a connection is made break the foreach loop
                    if ($this->connID) {
                        break;
                    }
                }
            }

            // We still don't have a connection?
            if (! $this->connID) {
                throw new DatabaseException(sprintf(
                    'Unable to connect to the database.%s%s',
                    PHP_EOL,
                    implode(PHP_EOL, $connectionErrors)
                ));
            }
        }

        $this->connectDuration = microtime(true) - $this->connectTime;
    }

    /**
     * Connect to the database.
     *
     * @return mixed
     */
    abstract public function connect(bool $persistent = false);

    /**
     * Close the database connection.
     */
    public function close()
    {
        if ($this->connID) {
            $this->_close();
            $this->connID = false;
        }
    }

    /**
     * Platform dependent way method for closing the connection.
     *
     * @return mixed
     */
    abstract protected function _close();

    /**
     * Create a persistent database connection.
     *
     * @return mixed
     */
    public function persistentConnect()
    {
        return $this->connect(true);
    }

    /**
     * Keep or establish the connection if no queries have been sent for
     * a length of time exceeding the server's idle timeout.
     *
     * @return mixed
     */
    abstract public function reconnect();

    /**
     *Devuelve el objeto de conexion real. Si tanto una 'lectura' como una 'escritura'
     * se ha especificado la conexion, puede pasar cualquiera de los terminos a
     * obtener esa conexion. Si pasa cualquiera de los alias y solo un
     * la conexion esta presente, debe devolver la unica conexion.
     *
     * @return mixed
     */
    public function getConnection(?string $alias = null)
    {
        // @todo work with read/write connections
        return $this->connID;
    }

    /**
     * Select a specific database table to use.
     *
     * @return mixed
     */
    abstract public function setDatabase(string $databaseName);

    /**
     * Returns the name of the current database being used.
     */
    public function getDatabase(): string
    {
        return empty($this->database) ? '' : $this->database;
    }

    /**
     * Set DB Prefix
     *
     * Set's the DB Prefix to something new without needing to reconnect
     *
     * @param string $prefix The prefix
     */
    public function setPrefix(string $prefix = ''): string
    {
        return $this->DBPrefix = $prefix;
    }

    /**
     * Returns the database prefix.
     */
    public function getPrefix(): string
    {
        return $this->DBPrefix;
    }

    /**
     * The name of the platform in use (MySQLi, mssql, etc)
     */
    public function getPlatform(): string
    {
        return $this->DBDriver;
    }

    /**
     * Returns a string containing the version of the database being used.
     */
    abstract public function getVersion(): string;

    /**
     * Establece los alias de tabla que se utilizaran. Estos son tipicamente
     * recopilados durante el uso del Builder y configurados aqui
     * para que las consultas se generen correctamente.
     *
     * @return $this
     */
    public function setAliasedTables(array $aliases)
    {
        $this->aliasedTables = $aliases;

        return $this;
    }

    /**
     * Add a table alias to our list.
     *
     * @return $this
     */
    public function addTableAlias(string $table)
    {
        if (! in_array($table, $this->aliasedTables, true)) {
            $this->aliasedTables[] = $table;
        }

        return $this;
    }

    /**
     * Executes the query against the database.
     *
     * @return mixed
     */
    abstract protected function execute(string $sql);

    /**
     *Orquesta una consulta contra la base de datos. Las consultas deben utilizar
     * Objetos Database\Statement para almacenar la consulta y construirla.
     * Este metodo funciona con el cache.
     *
     * Deberia manejar automaticamente diferentes conexiones para lectura/escritura
     * consultas si es necesario.
     *
     * @param mixed ...$binds
     *
     * @return BaseResult|bool|Query BaseResult when “read” type query, bool when “write” type query, Query when prepared query
     *
     * @todo BC set $queryClass default as null in 4.1
     */
    public function query(string $sql, $binds = null, bool $setEscapeFlags = true, string $queryClass = '')
    {
        $queryClass = $queryClass ?: $this->queryClass;

        if (empty($this->connID)) {
            $this->initialize();
        }

        /**
         * @var Query $query
         */
        $query = new $queryClass($this);

        $query->setQuery($sql, $binds, $setEscapeFlags);

        if (! empty($this->swapPre) && ! empty($this->DBPrefix)) {
            $query->swapPrefix($this->DBPrefix, $this->swapPre);
        }

        $startTime = microtime(true);

        // Always save the last query so we can use
        // the getLastQuery() method.
        $this->lastQuery = $query;

        // Run the query for real
        if (! $this->pretend && false === ($this->resultID = $this->simpleQuery($query->getQuery()))) {
            $query->setDuration($startTime, $startTime);

            // This will trigger a rollback if transactions are being used
            if ($this->transDepth !== 0) {
                $this->transStatus = false;
            }

            if ($this->DBDebug) {
                // We call this function in order to roll-back queries
                // if transactions are enabled. If we don't call this here
                // the error message will trigger an exit, causing the
                // transactions to remain in limbo.
                while ($this->transDepth !== 0) {
                    $transDepth = $this->transDepth;
                    $this->transComplete();

                    if ($transDepth === $this->transDepth) {
                        log_message('error', 'Database: Failure during an automated transaction commit/rollback!');
                        break;
                    }
                }

                return false;
            }

            if (! $this->pretend) {
                // Let others do something with this query.
                Events::trigger('DBQuery', $query);
            }

            return false;
        }

        $query->setDuration($startTime);

        if (! $this->pretend) {
            // Let others do something with this query
            Events::trigger('DBQuery', $query);
        }

        // If $pretend is true, then we just want to return
        // the actual query object here. There won't be
        // any results to return.
        if ($this->pretend) {
            return $query;
        }

        // resultID is not false, so it must be successful
        if ($this->isWriteType($sql)) {
            return true;
        }

        // query is not write-type, so it must be read-type query; return QueryResult
        $resultClass = str_replace('Connection', 'Result', static::class);

        return new $resultClass($this->connID, $this->resultID);
    }

    /**
     *Realiza una consulta basica a la base de datos. Sin enlace ni almacenamiento en cache
     * no se realiza ni se manejan transacciones. Simplemente toma una cruda
     * cadena de consulta y devuelve la identificacion del resultado especifico de la base de datos.
     *
     * @return mixed
     */
    public function simpleQuery(string $sql)
    {
        if (empty($this->connID)) {
            $this->initialize();
        }

        return $this->execute($sql);
    }

    /**
     * Disable Transactions
     *
     * This permits transactions to be disabled at run-time.
     */
    public function transOff()
    {
        $this->transEnabled = false;
    }

    /**
     * Activar/desactivar el modo estricto de transaccion
     *
     * Cuando el modo estricto esta habilitado, si esta ejecutando varios grupos de
     * transacciones, si un grupo falla, todos los grupos posteriores seran
     * retrotraido.
     *
     * Si el modo estricto esta deshabilitado, cada grupo se trata de forma autonoma,
     * lo que significa que el fracaso de un grupo no afectara a ningun otro
     *
     * @param bool $mode = true
     *
     * @return $this
     */
    public function transStrict(bool $mode = true)
    {
        $this->transStrict = $mode;

        return $this;
    }

    /**
     * Start Transaction
     */
    public function transStart(bool $testMode = false): bool
    {
        if (! $this->transEnabled) {
            return false;
        }

        return $this->transBegin($testMode);
    }

    /**
     * Complete Transaction
     */
    public function transComplete(): bool
    {
        if (! $this->transEnabled) {
            return false;
        }

        // The query() function will set this flag to FALSE in the event that a query failed
        if ($this->transStatus === false || $this->transFailure === true) {
            $this->transRollback();

            // If we are NOT running in strict mode, we will reset
            // the _trans_status flag so that subsequent groups of
            // transactions will be permitted.
            if ($this->transStrict === false) {
                $this->transStatus = true;
            }

            return false;
        }

        return $this->transCommit();
    }

    /**
     * Lets you retrieve the transaction flag to determine if it has failed
     */
    public function transStatus(): bool
    {
        return $this->transStatus;
    }

    /**
     * Begin Transaction
     */
    public function transBegin(bool $testMode = false): bool
    {
        if (! $this->transEnabled) {
            return false;
        }

        // When transactions are nested we only begin/commit/rollback the outermost ones
        if ($this->transDepth > 0) {
            $this->transDepth++;

            return true;
        }

        if (empty($this->connID)) {
            $this->initialize();
        }

        // Restablezca el indicador de error de transaccion.
        // Si el indicador $test_mode esta establecido en TRUE, las transacciones se revertiran
        // incluso si las consultas producen un resultado exitoso.
        $this->transFailure = ($testMode === true);

        if ($this->_transBegin()) {
            $this->transDepth++;

            return true;
        }

        return false;
    }

    /**
     * Commit Transaction
     */
    public function transCommit(): bool
    {
        if (! $this->transEnabled || $this->transDepth === 0) {
            return false;
        }

        // When transactions are nested we only begin/commit/rollback the outermost ones
        if ($this->transDepth > 1 || $this->_transCommit()) {
            $this->transDepth--;

            return true;
        }

        return false;
    }

    /**
     * Rollback Transaction
     */
    public function transRollback(): bool
    {
        if (! $this->transEnabled || $this->transDepth === 0) {
            return false;
        }

        // When transactions are nested we only begin/commit/rollback the outermost ones
        if ($this->transDepth > 1 || $this->_transRollback()) {
            $this->transDepth--;

            return true;
        }

        return false;
    }

    /**
     * Begin Transaction
     */
    abstract protected function _transBegin(): bool;

    /**
     * Commit Transaction
     */
    abstract protected function _transCommit(): bool;

    /**
     * Rollback Transaction
     */
    abstract protected function _transRollback(): bool;

    /**
     * Returns a non-shared new instance of the query builder for this connection.
     *
     * @param array|string $tableName
     *
     * @throws DatabaseException
     *
     * @return BaseBuilder
     */
    public function table($tableName)
    {
        if (empty($tableName)) {
            throw new DatabaseException('You must set the database table to be used with your query.');
        }

        $className = str_replace('Connection', 'Builder', static::class);

        return new $className($tableName, $this);
    }

    /**
     * Crea una declaracion preparada con la base de datos que luego puede
     * usarse para ejecutar multiples declaraciones en contra. Dentro de
     * cierre, aunque crearias la consulta de cualquier forma normal
     * el Generador de consultas es la forma esperada.
     *
     * Ejemplo:
     *    $stmt = $db->prepare(function($db)
     *           {
     *             return $db->table('users')
     *                   ->where('id', 1)
     *                     ->get();
     *           })
     *
     * @return BasePreparedQuery|null
     */
    public function prepare(Closure $func, array $options = [])
    {
        if (empty($this->connID)) {
            $this->initialize();
        }

        $this->pretend();

        $sql = $func($this);

        $this->pretend(false);

        if ($sql instanceof QueryInterface) {
            $sql = $sql->getOriginalQuery();
        }

        $class = str_ireplace('Connection', 'PreparedQuery', static::class);
        /** @var BasePreparedQuery $class */
        $class = new $class($this);

        return $class->prepare($sql, $options);
    }

    /**
     * Returns the last query's statement object.
     *
     * @return mixed
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    /**
     * Returns a string representation of the last query's statement object.
     */
    public function showLastQuery(): string
    {
        return (string) $this->lastQuery;
    }

    /**
     * Returns the time we started to connect to this database in
     * seconds with microseconds.
     *
     * Used by the Debug Toolbar's timeline.
     */
    public function getConnectStart(): ?float
    {
        return $this->connectTime;
    }

    /**
     * Returns the number of seconds with microseconds that it took
     * to connect to the database.
     *
     * Used by the Debug Toolbar's timeline.
     */
    public function getConnectDuration(int $decimals = 6): string
    {
        return number_format($this->connectDuration, $decimals);
    }

    /**
     * Proteger identificadores
     *
     * Esta funcion es utilizada ampliamente por la clase Query Builder y por
     * un par de funciones en esta clase.
     * Toma un nombre de columna o tabla (opcionalmente con un alias) y lo inserta
     * el prefijo de la tabla. Es necesaria cierta logica para abordar
     * nombres de columnas que incluyen la ruta. Considere una consulta como esta:
     *
     * SELECT hostname.database.table.column AS c FROM hostname.database.table
     *
     * Or a query with aliasing:
     *
     * SELECT m.member_id, m.member_name FROM members AS m
     *
     * Dado que el nombre de la columna puede incluir hasta cuatro segmentos (host, base de datos, tabla, columna)
     * o tambien tener un prefijo de alias, necesitamos trabajar un poco para resolver esto y
     * inserte el prefijo de la tabla (si existe) en la posicion adecuada y escape solo
     * los identificadores correctos.
     *
     * @param array|string $item
     * @param bool         $prefixSingle Prefix an item with no segments?
     * @param bool         $fieldExists  Supplied $item contains a field name?
     *
     * @return array|string
     */
    public function protectIdentifiers($item, bool $prefixSingle = false, ?bool $protectIdentifiers = null, bool $fieldExists = true)
    {
        if (! is_bool($protectIdentifiers)) {
            $protectIdentifiers = $this->protectIdentifiers;
        }

        if (is_array($item)) {
            $escapedArray = [];

            foreach ($item as $k => $v) {
                $escapedArray[$this->protectIdentifiers($k)] = $this->protectIdentifiers($v, $prefixSingle, $protectIdentifiers, $fieldExists);
            }

            return $escapedArray;
        }

        // Esto es basicamente una correccion de errores para consultas que usan MAX, MIN, etc.
        // Si se encuentra un parentesis sabemos que no necesitamos
        // escapar de los datos o agregar un prefijo. Probablemente haya una mas elegante.
        // manera de lidiar con esto, pero no estoy pensando en eso
        //
        // Tambien se agrego una excepcion para las comillas simples, no queremos modificar
        // cadenas literales.
        if (strcspn($item, "()'") !== strlen($item)) {
            return $item;
        }

        // Convert tabs or multiple spaces into single spaces
        $item = preg_replace('/\s+/', ' ', trim($item));

        // If the item has an alias declaration we remove it and set it aside.
        // Note: strripos() is used in order to support spaces in table names
        if ($offset = strripos($item, ' AS ')) {
            $alias = ($protectIdentifiers) ? substr($item, $offset, 4) . $this->escapeIdentifiers(substr($item, $offset + 4)) : substr($item, $offset);
            $item  = substr($item, 0, $offset);
        } elseif ($offset = strrpos($item, ' ')) {
            $alias = ($protectIdentifiers) ? ' ' . $this->escapeIdentifiers(substr($item, $offset + 1)) : substr($item, $offset);
            $item  = substr($item, 0, $offset);
        } else {
            $alias = '';
        }

        //Separe la cadena si contiene puntos y luego inserte el prefijo de la tabla
        // en la ubicacion correcta, asumiendo que el punto no indica que estamos tratando
        // con un alias. Mientras estamos en ello, escaparemos de los componentes.
        if (strpos($item, '.') !== false) {
            $parts = explode('.', $item);

            // Coincide el primer segmento del elemento descompuesto?
            // uno de los alias previamente identificados? En ese caso,
            // no tenemos nada mas que hacer aparte de escapar del elemento
            //
            // Nota la ! La condicion vacia() impide este metodo.
            // se rompa cuando QB no esta  habilitado.
            $firstSegment = trim($parts[0], $this->escapeChar);
            if (! empty($this->aliasedTables) && in_array($firstSegment, $this->aliasedTables, true)) {
                if ($protectIdentifiers === true) {
                    foreach ($parts as $key => $val) {
                        if (! in_array($val, $this->reservedIdentifiers, true)) {
                            $parts[$key] = $this->escapeIdentifiers($val);
                        }
                    }

                    $item = implode('.', $parts);
                }

                return $item . $alias;
            }

            // Is there a table prefix defined in the config file? If not, no need to do anything
            if ($this->DBPrefix !== '') {
                // We now add the table prefix based on some logic.
                // Do we have 4 segments (hostname.database.table.column)?
                // If so, we add the table prefix to the column name in the 3rd segment.
                if (isset($parts[3])) {
                    $i = 2;
                }
                // Do we have 3 segments (database.table.column)?
                // If so, we add the table prefix to the column name in 2nd position
                elseif (isset($parts[2])) {
                    $i = 1;
                }
                // Do we have 2 segments (table.column)?
                // If so, we add the table prefix to the column name in 1st segment
                else {
                    $i = 0;
                }

                // This flag is set when the supplied $item does not contain a field name.
                // This can happen when this function is being called from a JOIN.
                if ($fieldExists === false) {
                    $i++;
                }

                // Verify table prefix and replace if necessary
                if ($this->swapPre !== '' && strpos($parts[$i], $this->swapPre) === 0) {
                    $parts[$i] = preg_replace('/^' . $this->swapPre . '(\S+?)/', $this->DBPrefix . '\\1', $parts[$i]);
                }
                // We only add the table prefix if it does not already exist
                elseif (strpos($parts[$i], $this->DBPrefix) !== 0) {
                    $parts[$i] = $this->DBPrefix . $parts[$i];
                }

                // Put the parts back together
                $item = implode('.', $parts);
            }

            if ($protectIdentifiers === true) {
                $item = $this->escapeIdentifiers($item);
            }

            return $item . $alias;
        }

        // En algunos casos, especialmente 'desde', terminamos atravesando
        // proteger_identificadores dos veces. Este algoritmo no funcionara cuando
        // contiene escapeChar, asi que eliminelo.
        $item = trim($item, $this->escapeChar);

        // Is there a table prefix? If not, no need to insert it
        if ($this->DBPrefix !== '') {
            // Verify table prefix and replace if necessary
            if ($this->swapPre !== '' && strpos($item, $this->swapPre) === 0) {
                $item = preg_replace('/^' . $this->swapPre . '(\S+?)/', $this->DBPrefix . '\\1', $item);
            }
            // Do we prefix an item with no segments?
            elseif ($prefixSingle === true && strpos($item, $this->DBPrefix) !== 0) {
                $item = $this->DBPrefix . $item;
            }
        }

        if ($protectIdentifiers === true && ! in_array($item, $this->reservedIdentifiers, true)) {
            $item = $this->escapeIdentifiers($item);
        }

        return $item . $alias;
    }

    /**
     * Escape the SQL Identifiers
     *
     * This function escapes column and table names
     *
     * @param mixed $item
     *
     * @return mixed
     */
    public function escapeIdentifiers($item)
    {
        if ($this->escapeChar === '' || empty($item) || in_array($item, $this->reservedIdentifiers, true)) {
            return $item;
        }

        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->escapeIdentifiers($value);
            }

            return $item;
        }

        // Avoid breaking functions and literal values inside queries
        if (ctype_digit($item)
            || $item[0] === "'"
            || ($this->escapeChar !== '"' && $item[0] === '"')
            || strpos($item, '(') !== false) {
            return $item;
        }

        if ($this->pregEscapeChar === []) {
            if (is_array($this->escapeChar)) {
                $this->pregEscapeChar = [
                    preg_quote($this->escapeChar[0], '/'),
                    preg_quote($this->escapeChar[1], '/'),
                    $this->escapeChar[0],
                    $this->escapeChar[1],
                ];
            } else {
                $this->pregEscapeChar[0] = $this->pregEscapeChar[1] = preg_quote($this->escapeChar, '/');
                $this->pregEscapeChar[2] = $this->pregEscapeChar[3] = $this->escapeChar;
            }
        }

        foreach ($this->reservedIdentifiers as $id) {
            if (strpos($item, '.' . $id) !== false) {
                return preg_replace(
                    '/' . $this->pregEscapeChar[0] . '?([^' . $this->pregEscapeChar[1] . '\.]+)' . $this->pregEscapeChar[1] . '?\./i',
                    $this->pregEscapeChar[2] . '$1' . $this->pregEscapeChar[3] . '.',
                    $item
                );
            }
        }

        return preg_replace(
            '/' . $this->pregEscapeChar[0] . '?([^' . $this->pregEscapeChar[1] . '\.]+)' . $this->pregEscapeChar[1] . '?(\.)?/i',
            $this->pregEscapeChar[2] . '$1' . $this->pregEscapeChar[3] . '$2',
            $item
        );
    }

    /**
     * Prepends a database prefix if one exists in configuration
     *
     * @throws DatabaseException
     */
    public function prefixTable(string $table = ''): string
    {
        if ($table === '') {
            throw new DatabaseException('A table name is required for that operation.');
        }

        return $this->DBPrefix . $table;
    }

    /**
     * Returns the total number of rows affected by this query.
     */
    abstract public function affectedRows(): int;

    /**
     * "Smart" Escape String
     *
     * Escapes data based on type.
     * Sets boolean and null types
     *
     * @param mixed $str
     *
     * @return mixed
     */
    public function escape($str)
    {
        if (is_array($str)) {
            return array_map([&$this, 'escape'], $str);
        }

        if (is_string($str) || (is_object($str) && method_exists($str, '__toString'))) {
            return "'" . $this->escapeString($str) . "'";
        }

        if (is_bool($str)) {
            return ($str === false) ? 0 : 1;
        }

        return $str ?? 'NULL';
    }

    /**
     * Escape String
     *
     * @param string|string[] $str  Input string
     * @param bool            $like Whether or not the string will be used in a LIKE condition
     *
     * @return string|string[]
     */
    public function escapeString($str, bool $like = false)
    {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escapeString($val, $like);
            }

            return $str;
        }

        $str = $this->_escapeString($str);

        // escape LIKE condition wildcards
        if ($like === true) {
            return str_replace(
                [
                    $this->likeEscapeChar,
                    '%',
                    '_',
                ],
                [
                    $this->likeEscapeChar . $this->likeEscapeChar,
                    $this->likeEscapeChar . '%',
                    $this->likeEscapeChar . '_',
                ],
                $str
            );
        }

        return $str;
    }

    /**
     * Escape LIKE String
     *
     * Calls the individual driver for platform
     * specific escaping for LIKE conditions
     *
     * @param string|string[] $str
     *
     * @return string|string[]
     */
    public function escapeLikeString($str)
    {
        return $this->escapeString($str, true);
    }

    /**
     * Platform independent string escape.
     *
     * Will likely be overridden in child classes.
     */
    protected function _escapeString(string $str): string
    {
        return str_replace("'", "''", remove_invisible_characters($str, false));
    }

    /*
     * Esta funcion le permite llamar a funciones de base de datos PHP que no estan incluidas de forma nativa.
     * en CodeIgniter, de manera independiente de la plataforma.
     *
     * @param array ...$params
     *
     * @throws DatabaseException
     */
    public function callFunction(string $functionName, ...$params): bool
    {
        $driver = $this->getDriverFunctionPrefix();

        if (strpos($driver, $functionName) === false) {
            $functionName = $driver . $functionName;
        }

        if (! function_exists($functionName)) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }

            return false;
        }

        return $functionName(...$params);
    }

    /**
     * Get the prefix of the function to access the DB.
     */
    protected function getDriverFunctionPrefix(): string
    {
        return strtolower($this->DBDriver) . '_';
    }

    //--------------------------------------------------------------------
    // Metodos meta
    //--------------------------------------------------------------------

    /**
     * Devuelve una serie de nombres de tablas
     *
     * @throws DatabaseException
     *
     * @return array|bool
     */
    public function listTables(bool $constrainByPrefix = false)
    {
        // Is there a cached result?
        if (isset($this->dataCache['table_names']) && $this->dataCache['table_names']) {
            return $constrainByPrefix ?
                preg_grep("/^{$this->DBPrefix}/", $this->dataCache['table_names'])
                : $this->dataCache['table_names'];
        }

        if (false === ($sql = $this->_listTables($constrainByPrefix))) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }

            return false;
        }

        $this->dataCache['table_names'] = [];

        $query = $this->query($sql);

        foreach ($query->getResultArray() as $row) {
            // Do we know from which column to get the table name?
            if (! isset($key)) {
                if (isset($row['table_name'])) {
                    $key = 'table_name';
                } elseif (isset($row['TABLE_NAME'])) {
                    $key = 'TABLE_NAME';
                } else {
                    /* We have no other choice but to just get the first element's key.
                     * Due to array_shift() accepting its argument by reference, if
                     * E_STRICT is on, this would trigger a warning. So we'll have to
                     * assign it first.
                     */
                    $key = array_keys($row);
                    $key = array_shift($key);
                }
            }

            $this->dataCache['table_names'][] = $row[$key];
        }

        return $this->dataCache['table_names'];
    }

    /**
     * Determinar si existe una tabla en particular
     */
    public function tableExists(string $tableName): bool
    {
        return in_array($this->protectIdentifiers($tableName, true, false, false), $this->listTables(), true);
    }

    /**
     * Fetch Field Names
     *
     * @throws DatabaseException
     *
     * @return array|false
     */
    public function getFieldNames(string $table)
    {
        // Is there a cached result?
        if (isset($this->dataCache['field_names'][$table])) {
            return $this->dataCache['field_names'][$table];
        }

        if (empty($this->connID)) {
            $this->initialize();
        }

        if (false === ($sql = $this->_listColumns($table))) {
            if ($this->DBDebug) {
                throw new DatabaseException('This feature is not available for the database you are using.');
            }

            return false;
        }

        $query = $this->query($sql);

        $this->dataCache['field_names'][$table] = [];

        foreach ($query->getResultArray() as $row) {
            // Do we know from where to get the column's name?
            if (! isset($key)) {
                if (isset($row['column_name'])) {
                    $key = 'column_name';
                } elseif (isset($row['COLUMN_NAME'])) {
                    $key = 'COLUMN_NAME';
                } else {
                    // We have no other choice but to just get the first element's key.
                    $key = key($row);
                }
            }

            $this->dataCache['field_names'][$table][] = $row[$key];
        }

        return $this->dataCache['field_names'][$table];
    }

    /**
     * Determine if a particular field exists
     */
    public function fieldExists(string $fieldName, string $tableName): bool
    {
        return in_array($fieldName, $this->getFieldNames($tableName), true);
    }

    /**
     * Returns an object with field data
     *
     * @return array
     */
    public function getFieldData(string $table)
    {
        return $this->_fieldData($this->protectIdentifiers($table, true, false, false));
    }

    /**
     * Returns an object with key data
     *
     * @return array
     */
    public function getIndexData(string $table)
    {
        return $this->_indexData($this->protectIdentifiers($table, true, false, false));
    }

    /**
     * Returns an object with foreign key data
     *
     * @return array
     */
    public function getForeignKeyData(string $table)
    {
        return $this->_foreignKeyData($this->protectIdentifiers($table, true, false, false));
    }

    /**
     * Disables foreign key checks temporarily.
     */
    public function disableForeignKeyChecks()
    {
        $sql = $this->_disableForeignKeyChecks();

        return $this->query($sql);
    }

    /**
     * Enables foreign key checks temporarily.
     */
    public function enableForeignKeyChecks()
    {
        $sql = $this->_enableForeignKeyChecks();

        return $this->query($sql);
    }

    /**
     * Permite configurar el motor en un modo en el que no se realizan consultas.
     * realmente ejecutados, pero aun estan generados, cronometrados, etc.
     *
     * Esto lo utiliza principalmente la funcionalidad de consulta preparada.
     *
     * @return $this
     */
    public function pretend(bool $pretend = true)
    {
        $this->pretend = $pretend;

        return $this;
    }

    /**
     * Vacia nuestra cache de datos. Especialmente util durante las pruebas.
     *
     * @return $this
     */
    public function resetDataCache()
    {
        $this->dataCache = [];

        return $this;
    }

    /**
     * Determina si la declaracion es una consulta de tipo escritura o no.
     *
     * @param string $sql
     */
    public function isWriteType($sql): bool
    {
        return (bool) preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD|COPY|ALTER|RENAME|GRANT|REVOKE|LOCK|UNLOCK|REINDEX|MERGE)\s/i', $sql);
    }

    /**
     * Devuelve el ultimo codigo de error y mensaje.
     *
     * Must return an array with keys 'code' and 'message':
     *
     *  return ['code' => null, 'message' => null);
     */
    abstract public function error(): array;

    /**
     * Insert ID
     *
     * @return int|string
     */
    abstract public function insertID();

    /**
     * Generates the SQL for listing tables in a platform-dependent manner.
     *
     * @return false|string
     */
    abstract protected function _listTables(bool $constrainByPrefix = false);

    /**
     * Generates a platform-specific query string so that the column names can be fetched.
     *
     * @return false|string
     */
    abstract protected function _listColumns(string $table = '');

    /**
     * Platform-specific field data information.
     *
     * @see    getFieldData()
     */
    abstract protected function _fieldData(string $table): array;

    /**
     * Platform-specific index data.
     *
     * @see    getIndexData()
     */
    abstract protected function _indexData(string $table): array;

    /**
     * Platform-specific foreign keys data.
     *
     * @see    getForeignKeyData()
     */
    abstract protected function _foreignKeyData(string $table): array;

    /**
     * Accessor for properties if they exist.
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return null;
    }

    /**
     * Checker for properties existence.
     */
    public function __isset(string $key): bool
    {
        return property_exists($this, $key);
    }
}

<?php

namespace Firebird;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class FirebirdConnector extends Connector implements ConnectorInterface
{
    /**
     * Establish a database connection.
     *
     * @param  array  $config
     * @return \PDO
     */
    public function connect(array $config)
    {
        return $this->createConnection(
            $this->getDsn($config),
            $config,
            $this->getOptions($config)
        );
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param array $config
     * @return string
     */
    protected function getDsn(array $config)
    {
        $dsn = '';
        if (isset($config['host'])) {
            $dsn .= $config['host'];
        }
        if (isset($config['port'])) {
            $dsn .= "/" . $config['port'];
        }
        if (!isset($config['database'])) {
            throw new InvalidArgumentException("Database not given, required.");
        }
        if ($dsn) {
            $dsn .= ':';
        }
        $dsn .= $config['database'] . ';';
        if (isset($config['charset'])) {
            $dsn .= "charset=" . $config['charset'];
        }
        if (isset($config['role'])) {
            $dsn .= ";role=" . $config['role'];
        }
        $dsn = 'firebird:dbname=' . $dsn;

        return $dsn;
    }
}

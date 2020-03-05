<?php


namespace BeeJee;

use PDO;
use PDOException;

final class DB
{
    private static $instance;

    protected function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);

            try
            {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$instance->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            }
            catch (PDOException $e)
            {
                die('DB connection failed: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    final public function __destruct()
    {
        self::$instance = null;
    }
}
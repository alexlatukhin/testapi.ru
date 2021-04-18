<?php


namespace vendor\core;


class Db
{
    private $pdo;

    private static $instance;

    public static $countSql = 0;

    public static $queries = [];

    private function __clone()
    {
    }

    /**
     * Db constructor.
     */
    private function __construct()
    {
        $db = require ROOT . '/config/config_db.php';

        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    /**
     * @return Db
     */
    public static function instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = [])
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = [])
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);

        if ($res !== false)
        {
            return $stmt->fetchAll();
        }
        return [];
    }



}
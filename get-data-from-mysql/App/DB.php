<?php

namespace App;

use PDO;

/**
 * Class Db
 *
 * @package App\Data
 */
class DB
{
    /**
     * Активное PDO соединение
     *
     * @var PDO
     */
    private static $pdo;

    /**
     * Инициализация PDO соединения
     *
     * @param array $config
     */
    public static function init($config)
    {
        // Создаем PDO соединение
        self::$pdo = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);
        // Задаем режим выборки по умолчанию
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * Выполнение запроса select и возвращение одной строки
     *
     * @param  string  $query
     * @return mixed
     */
    public static function selectOne($query)
    {
        $records = self::select($query);
        return array_shift($records);
    }

    /**
     * Выполнение запроса select и возвращение строк
     *
     * @param  string  $query
     * @return array
     */
    public static function select($query)
    {
        $statement = self::$pdo->query($query);
        return $statement->fetchAll();
    }

    /**
     * Выполнение запроса и возвращение количества затронутых строк
     *
     * @param  string  $query
     * @return int
     */
    public static function affectingStatement($query)
    {
        $statement = self::$pdo->query($query);
        return $statement->rowCount();
    }
}
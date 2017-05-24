<?php

namespace App;

/**
 * Class Buffer
 *
 * Пример реализации буфера
 *
 * @package App
 */
class Buffer
{
    /**
     * Массив id пользователей
     *
     * @var array
     */
    private static $ids = array();

    /**
     * Массив результатов запроса количества друзей для пользователей
     *
     * @var array
     */
    private static $results = array();

    /**
     * Загрузка количества друзей из БД для всех пользователей в буфере
     */
    public static function load()
    {
        // Если данные уже были получены, то ничего не делаем
        if (!empty(self::$results)) return;
        // Иначе получаем данные из БД и сохраняем в буфер
        $rows = DB::select("SELECT u.id, COUNT(f.friend_id) AS count FROM users u LEFT JOIN friendships f ON f.user_id = u.id WHERE u.id IN (" . implode(',', self::$ids) . ") GROUP BY u.id");
        foreach ($rows as $row) {
            self::$results[$row->id] = $row->count;
        }
    }

    /**
     * Добавление id пользователя в буфер
     *
     * @param int $id
     */
    public static function add($id)
    {
        // Если такой id уже есть в буфере, то не добавляем его
        if (in_array($id, self::$ids)) return;
        self::$ids[] = $id;
    }

    /**
     * Получение количества друзей пользователя из буфера
     *
     * @param $id
     * @return int
     */
    public static function get($id)
    {
        if (!isset(self::$results[$id])) return null;
        return self::$results[$id];
    }
}

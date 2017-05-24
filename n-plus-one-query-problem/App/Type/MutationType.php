<?php

namespace App\Type;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class MutationType
 *
 * Корневой тип Mutation для GraphQL
 *
 * @package App\Type
 */
class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'changeUserEmail' => [
                        'type' => Types::user(),
                        'description' => 'Изменение E-mail пользователя',
                        'args' => [
                            'id' => Types::nonNull(Types::int()),
                            'email' => Types::nonNull(Types::email())
                        ],
                        'resolve' => function ($root, $args) {
                            // Обновляем email пользователя
                            DB::update("UPDATE users SET email = '{$args['email']}' WHERE id = {$args['id']}");
                            // Запрашиваем и возвращаем "свежие" данные пользователя
                            $user = DB::selectOne("SELECT * from users WHERE id = {$args['id']}");
                            if (is_null($user)) {
                                throw new \Exception('Нет пользователя с таким id');
                            }
                            return $user;
                        }
                    ],
                    'addUser' => [
                        'type' => Types::user(),
                        'description' => 'Добавление пользователя',
                        'args' => [
                            'user' => Types::inputUser()
                        ],
                        'resolve' => function ($root, $args) {
                            // Добавляем нового пользователя в БД
                            $userId = DB::insert("INSERT INTO users (name, email) VALUES ('{$args['user']['name']}', '{$args['user']['email']}')");
                            // Возвращаем данные только что созданного пользователя из БД
                            return DB::selectOne("SELECT * from users WHERE id = $userId");
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}
<?php

namespace App\Type;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

use App\Buffer;
use GraphQL\Deferred;

/**
 * Class UserType
 *
 * Тип User для GraphQL
 *
 * @package App\Type
 */
class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Пользователь',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::string(),
                        'description' => 'Идентификатор пользователя'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Имя пользователя'
                    ],
                    'email' => [
                        'type' => Types::email(),
                        'description' => 'E-mail пользователя'
                    ],
                    'friends' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Друзья пользователя',
                        'resolve' => function ($root) {
                            return DB::select("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                        }
                    ],
                    'countFriends' => [
                        'type' => Types::int(),
                        'description' => 'Количество друзей пользователя',
                        'resolve' => function ($root) {
                            // Добавляем id пользователя в буфер
                            Buffer::add($root->id);
                            return new Deferred(function () use ($root) {
                                // Загружаем результаты в буфер из БД (если они еще не были загружены)
                                Buffer::load();
                                // Получаем количество друзей пользователя из буфера
                                return Buffer::get($root->id);
                            });
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}
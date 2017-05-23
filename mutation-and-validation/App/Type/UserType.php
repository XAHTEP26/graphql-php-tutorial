<?php

namespace App\Type;

use App\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

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
                            return DB::affectingStatement("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}
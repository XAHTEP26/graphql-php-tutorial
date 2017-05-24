<?php

namespace App\Type;

use App\Types;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class InputUserType
 *
 * Тип InputUser для GraphQL
 *
 * @package App\Type
 */
class InputUserType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Добавление пользователя',
            'fields' => function() {
                return [
                    'name' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'Имя пользователя'
                    ],
                    'email' => [
                        'type' => Types::nonNull(Types::email()),
                        'description' => 'E-mail пользователя'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}
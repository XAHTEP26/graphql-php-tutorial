<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\DB;
use App\Types;
use GraphQL\GraphQL;
use GraphQL\Schema;

try {
    // Настройки подключения к БД
    $config = [
        'host' => 'localhost',
        'database' => 'gql',
        'username' => 'root',
        'password' => 'root'
    ];

    // Инициализация соединения с БД
    DB::init($config);

    // Получение запроса
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];

    // Создание схемы
    $schema = new Schema([
        'query' => Types::query()
    ]);

    // Выполнение запроса
    $result = GraphQL::execute($schema, $query);
} catch (\Exception $e) {
    $result = [
        'error' => [
            'message' => $e->getMessage()
        ]
    ];
}

// Вывод результата
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($result);

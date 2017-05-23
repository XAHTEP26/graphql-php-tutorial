<?php

namespace App\Type\Scalar;

use GraphQL\Type\Definition\ScalarType;

/**
 * Class EmailType
 *
 * Скалярный тип Email для GraphQL
 *
 * @package App\Type\Scalar
 */
class EmailType extends ScalarType
{
    /**
     * Сериализация внутреннего представления данных в строку для вывода
     *
     * @param mixed $value
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Парсинг данных в Variables для внутреннего представления
     *
     * @param mixed $value
     * @return mixed
     * @throws \Exception
     */
    public function parseValue($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Не корректный E-mail');
        }
        return $value;
    }

    /**
     * Парсинг данных в тексте запроса для внутреннего представления
     *
     * @param \GraphQL\Language\AST\Node $valueNode
     * @return mixed
     * @throws \Exception
     */
    public function parseLiteral($valueNode)
    {
        if (!filter_var($valueNode->value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Не корректный E-mail');
        }
        return $valueNode->value;
    }
}
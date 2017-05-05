<?php

namespace App;

use App\Type\QueryType;
use App\Type\UserType;
use GraphQL\Type\Definition\Type;

/**
 * Class Types
 *
 * Реестр и фабрика типов для GraphQL
 *
 * @package App
 */
class Types
{
    /**
     * @var QueryType
     */
    private static $query;

    /**
     * @var UserType
     */
    private static $user;

    /**
     * @return QueryType
     */
    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    /**
     * @return UserType
     */
    public static function user()
    {
        return self::$user ?: (self::$user = new UserType());
    }

    /**
     * @return \GraphQL\Type\Definition\IntType
     */
    public static function int()
    {
        return Type::int();
    }

    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @param \GraphQL\Type\Definition\Type $type
     * @return \GraphQL\Type\Definition\ListOfType
     */
    public static function listOf($type)
    {
        return Type::listOf($type);
    }
}
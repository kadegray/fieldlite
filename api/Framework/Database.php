<?php

namespace Framework;

use Illuminate\Support\Str;

class Database
{
    private static $connection = null;

    public static function connection()
    {
        if (self::$connection) {
            return self::$connection;
        }

        $serverName = getenv('DB_HOST', true) ?? '127.0.0.1';
        $userName = getenv('DB_USERNAME', true) ?? 'root';
        $password = getenv('DB_PASSWORD', true) ?? 'root';
        $databaseName = getenv('DB_NAME', true) ?? 'subscribersfields';
        $databasePort = getenv('DB_PORT', true) ?? 3306;

        $connection = new \mysqli(
            $serverName,
            $userName,
            $password,
            $databaseName,
            $databasePort
        );

        if ($connection->connect_error) {
            printf("Database connection failed: %s\n", $connection->connect_error);
            exit();
        }

        self::$connection = $connection;

        return self::$connection;
    }

    public static function escapeString($string)
    {
        return mysqli_real_escape_string(self::connection(), $string);
    }

    public static function query(string $query)
    {
        $connection = self::connection();
        $result = $connection->query($query);

        if (!$result) {
            printf("Query error message: %s\n", $connection->error);
        }

        if (Str::startsWith($query, 'INSERT')) {
            return $connection->insert_id;
        }

        if (is_bool($result)) {
            return $result;
        }

        if (!method_exists($result, 'fetch_assoc')) {
            return;
        }

        $response = [];
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }

        if (!count($response)) {
            return;
        }

        return $response;
    }
}

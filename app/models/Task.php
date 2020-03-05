<?php


namespace App\Models;

use BeeJee\Model;

class Task extends Model
{
    protected static $table = 'tasks';

    /**
     * Adds new task to database
     *
     * @param array $requestData
     * @return int
     */
    public static function create(array $requestData): int
    {
        $sql = "INSERT INTO `tasks` (`user_name`, `user_email`, `text`) VALUES (:user_name, :user_email, :text)";
        static::db()->prepare($sql)->execute($requestData);
        return static::db()->lastInsertId();
    }
}
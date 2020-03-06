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

    /**
     * Update task row
     *
     * @param array $requestData
     * @return int
     */
    public static function update(array $requestData): int
    {
        $sql = "UPDATE `tasks` SET 
                   `text` = :text,
                   `completed` = :completed,
                   `edited` = :edited
                WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        $stmt->execute($requestData);
        return $stmt->rowCount();
    }
}
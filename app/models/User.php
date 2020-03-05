<?php


namespace App\Models;

use BeeJee\Model;

class User extends Model
{

    protected static $table = 'users';

    /**
     * Get user data by name
     *
     * @param string $name
     * @return array|bool
     */
    public static function whereName(string $name)
    {
        $stmt = static::db()->prepare("SELECT * FROM `users` WHERE `name` = ? LIMIT 1");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }
}
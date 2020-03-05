<?php


namespace BeeJee;


abstract class Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $table;

    /**
     * Table name
     *
     * @var string
     */
    protected static $primaryKey = 'id';

    protected static function db()
    {
        return DB::getInstance();
    }

    /**
     * Get single row by id
     *
     * @param int $id
     * @return array
     */
    public static function find(int $id): array
    {
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
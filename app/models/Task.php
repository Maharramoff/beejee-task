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
        $sql  = "UPDATE `tasks` SET 
                   `text` = :text,
                   `completed` = :completed,
                   `edited` = :edited
                WHERE `id` = :id";
        $stmt = static::db()->prepare($sql);
        $stmt->execute($requestData);
        return $stmt->rowCount();
    }

    public static function totalRows()
    {
        return (int)static::db()->query("SELECT COUNT(*) FROM `tasks`;")->fetchColumn();
    }

    public static function paginate($page, $limit)
    {
        $totalRows = static::totalRows();
        $maxPages  = intval(($totalRows - 1) / $limit) + 1;
        $page  = $page > $maxPages ? $maxPages : ($page < 1 ? 1 : $page);
        $start = ($page * $limit) - $limit;
        return [$start, $page, $totalRows, $maxPages];
    }

    public static function allFiltered($orderBy = 'id', $sortBy = 'asc', $page = 1, $limit = 3)
    {
        [$start, $page, $totalRows, $maxPages] = static::paginate($page, $limit);

        return [
            'rows'      => static::db()->query("SELECT * FROM " . static::$table . " 
                        ORDER BY " . $orderBy . " " . $sortBy . " 
                        LIMIT " . $start . ", " . $limit)->fetchAll(),
            'totalRows' => $totalRows,
            'maxPages'  => $maxPages,
            'page'      => $page,
        ];
    }
}
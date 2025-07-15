<?php
class Category
{
    public static function getAll()
    {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

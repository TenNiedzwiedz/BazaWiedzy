<?php

namespace app\core;

class SearchEngine 
{
    /**
     * Finds in DB all rows that match given query
     * 
     * @param DbModel $dbModel
     * @param array $query ['columnName' => 'searchWords']
     * 
     * @return array
     */
    public static function findAllObjectsByQuery(DbModel $dbModel, array $query) :array
    {
        $tableName = $dbModel->tableName();
        $sql = "SELECT * FROM $tableName";



        foreach($query as $columnName => $searchWords)
        {
            if($columnName === array_key_first($query))
            {
                $sql .= " WHERE MATCH ($columnName) AGAINST (:$columnName IN BOOLEAN MODE)";
            } else {
                $sql .= " AND MATCH ($columnName) AGAINST (:$columnName IN BOOLEAN MODE)";
            }
        }

        $statement = self::prepare($sql);
        

        foreach($query as $columnName => $searchWords)
        {
            $statement->bindValue(":$columnName", $searchWords);
        }

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, $dbModel::class);
    }

    public static function prepare($sql)
    {
      return Application::$app->db->pdo->prepare($sql);
    }
}
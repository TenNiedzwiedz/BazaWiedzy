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
                $sql .= " WHERE MATCH (";
            } else {
                $sql .= " AND MATCH (";
            }

            if(is_array($searchWords))
            {
                foreach($searchWords as $name => $search)
                {
                    if($name === array_key_last($searchWords))
                    {
                        $sql .= $name;
                    } else {
                        $sql .= $name.', ';
                    }
                }
            } else {
                $sql .= $columnName;
            }

            $sql .= ") AGAINST (:$columnName IN BOOLEAN MODE)";
        }

        $statement = self::prepare($sql);
        

        foreach($query as $columnName => $searchWords)
        {
            if(is_array($searchWords))
            {
                $statement->bindValue(":$columnName", reset($searchWords));
            } else {
                $statement->bindValue(":$columnName", $searchWords);
            }
        }

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, $dbModel::class);
    }

    public static function prepare($sql)
    {
      return Application::$app->db->pdo->prepare($sql);
    }
}
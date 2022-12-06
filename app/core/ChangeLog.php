<?php

namespace app\core;

class ChangeLog
{
    private array $changes;
    private string $objectID;
    private array $dbFields;
    private string $tableName;

    /**
     * Logs object data before update.
     * 
     * @param DbModel $dbModel
     */
    public function logOriginalObject(DbModel $dbModel)
    {
        $this->objectID = $dbModel->id;
        $this->dbFields = $dbModel->getChangelogFields();
        $this->tableName = $dbModel->tableName() . 'changes';

        foreach($this->dbFields as $dbField)
        {
            $this->changes[$dbField]['oldValue'] = $dbModel->{$dbField};
        }
    }

    /**
     * Logs object data after update.
     * 
     * @param DbModel $dbModel
     */
    private function logNewObject(DbModel $dbModel)
    {
        foreach($this->dbFields as $dbField)
        {
            $this->changes[$dbField]['newValue'] = $dbModel->{$dbField};
        }
    }

    /**
     * Removes fields from the log that have not been changed.
     */
    private function compareObjects()
    {
        foreach($this->dbFields as $dbField)
        {
            if($this->changes[$dbField]['oldValue'] == $this->changes[$dbField]['newValue'])
            {
                unset($this->changes[$dbField]);
            }
        }
    }

    public function pushChanges(DbModel $dbModel, string $userID)
    {
        $this->logNewObject($dbModel);
        $this->compareObjects();

        foreach($this->changes as $key => $change)
        {
            $sql = "INSERT INTO $this->tableName (objectID, fieldName, oldValue, newValue, userID) VALUES (:objectID, :fieldName, :oldValue, :newValue, :userID)";
            $statement = $this->prepare($sql);

            $statement->bindValue(":objectID", $this->objectID);
            $statement->bindValue(":fieldName", $key);
            $statement->bindValue(":oldValue", $change['oldValue']);
            $statement->bindValue(":newValue", $change['newValue']);
            $statement->bindValue(":userID", $userID);

            $statement->execute();
        }
    }

    private function prepare(string $sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
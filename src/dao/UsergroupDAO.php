<?php

require_once(__DIR__ . '/DAO.php');

class UsergroupDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_UserGroup (name) VALUES (:name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':name', $data['name']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT * FROM BAP_UserGroup";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT * FROM BAP_UserGroup WHERE UserGroupID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_UserGroup SET name = :name WHERE UserGroupID = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':id', $data['id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM BAP_UserGroup WHERE UserGroupID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validate($data)
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = 'Gelieve een naam in te geven';
        }
        return $errors;
    }
}

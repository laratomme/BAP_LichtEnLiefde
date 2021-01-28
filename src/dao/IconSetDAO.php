<?php

require_once(__DIR__ . '/DAO.php');

class IconSetDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_IconSet (Icon) VALUES (:Icon)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Icon', $data['Icon']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT * FROM BAP_IconSet";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT * FROM BAP_IconSet WHERE IconSetID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_IconSet SET Icon = :Icon WHERE IconSetID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Icon', $data['Icon']);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM BAP_IconSet WHERE IconSetID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validate($data)
    {
        $errors = [];
        if (empty($data['Icon'])) {
            $errors['Icon'] = 'Gelieve een geldig icoon in te geven';
        }
        return $errors;
    }
}

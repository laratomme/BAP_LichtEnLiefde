<?php

require_once(__DIR__ . '/DAO.php');

class IconDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_Icon (Icon, IsCustom) VALUES (:Icon, :IsCustom)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Icon', $data['Icon']);
            $stmt->bindValue(':IsCustom', $data['IsCustom']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readById($id)
    {
        $sql = "SELECT * FROM BAP_Icon WHERE IconID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_Icon SET Icon = :Icon, IsCustom = :IsCustom WHERE IconID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Icon', $data['Icon']);
            $stmt->bindValue(':IsCustom', $data['IsCustom']);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM BAP_Icon WHERE IconID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNextId()
    {
        $sql = "SELECT coalesce(MAX(IconID), 0) + 1 as ID FROM BAP_Icon";
        $stmt = $this->pdo->prepare($sql);
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

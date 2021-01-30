<?php

require_once(__DIR__ . '/DAO.php');

class ArticleTypeDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_ArticleType (Name, Description, IconID) 
            VALUES (:Name, :Description, :IconId)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':IconId', $data['IconId']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT art.ArticleTypeID, art.Name, art.Description, art.IconID, ic.Icon
            FROM BAP_ArticleType art
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT art.ArticleTypeID, art.Name, art.Description, art.IconID, ic.Icon
            FROM BAP_ArticleType art
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID
            WHERE art.ArticleTypeID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_ArticleType SET 
                        Name = :Name, 
                        Description = :Description, 
                        IconID = :IconID
                    WHERE ArticleTypeID = :ID";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':IconID', $data['IconId']);
            $stmt->bindValue(':ID', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM BAP_ArticleType WHERE ArticleTypeID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validate($data)
    {
        $errors = [];
        if (empty($data['Name'])) {
            $errors['Name'] = 'Gelieve een naam in te geven';
        }
        if (empty($data['IconId'])) {
            $errors['Icoon'] = 'Gelieve een icoon in te geven';
        }
        return $errors;
    }
}

<?php

require_once(__DIR__ . '/DAO.php');

class ContentTypeDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_ContentType (Name, Wrap, ContentName, MetaContentName, IconID) 
            VALUES (:Name, :Wrap, :ContentName, :MetaContentName, :IconID)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Wrap', $data['Wrap']);
            $stmt->bindValue(':ContentName', $data['ContentName']);
            $stmt->bindValue(':MetaContentName', $data['MetaContentName']);
            $stmt->bindValue(':IconID', $data['IconId']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT * FROM BAP_ContentType";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT * FROM BAP_ContentType WHERE ContentTypeID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_ContentType SET 
                        Name = :Name, 
                        Wrap = :Wrap,
                        ContentName = :ContentName,
                        MetaContentname = :MetaContentName,
                        IconID = :IconID
                    WHERE ContentTypeID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Wrap', $data['Wrap']);
            $stmt->bindValue(':ContentName', $data['ContentName']);
            $stmt->bindValue(':MetaContentname', $data['MetaContentname']);
            $stmt->bindValue(':IconID', $data['IconId']);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM BAP_ContentType WHERE ContentTypeID = :Id";
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
        if (empty($data['Wrap'])) {
            $errors['Wrap'] = 'Gelieve een wrap in te geven';
        }
        if (empty($data['IconId'])) {
            $errors['Icoon'] = 'Gelieve een icoon in te geven';
        }
        return $errors;
    }
}

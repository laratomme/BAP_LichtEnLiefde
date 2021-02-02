<?php

require_once(__DIR__ . '/DAO.php');

class CategoryDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_Category (Name, Description, OnMainMenu, CategoryParentID, UserGroupID, IconID) 
                VALUES (:Name, :Description, :OnMainMenu, :CategoryParentID, :UserGroupID, :IconID)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':OnMainMenu', $data['OnMainMenu']);
            $stmt->bindValue(':CategoryParentID', !empty($data['CategoryParentId']) ? $data['CategoryParentId'] : null);
            $stmt->bindValue(':UserGroupID', !empty($data['UserGroupId']) ? $data['UserGroupId'] : null);
            $stmt->bindValue(':IconID', $data['IconId']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, catPar.Name as CategoryParentName, cat.UserGroupID, cat.Name, cat.Description, cat.OnMainMenu, cat.IconID, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            LEFT JOIN BAP_Category catPar on catPar.CategoryID = cat.CategoryParentID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllExceptId($id)
    {
        $sql = "SELECT CategoryID, Name, CategoryParentID FROM BAP_Category";
        if (!empty($id)) {
            $sql = $sql . " WHERE CategoryID != :Id";
        }
        $stmt = $this->pdo->prepare($sql);
        if (!empty($id)) {
            $stmt->bindValue(':Id', $id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllOnMainMenu()
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, cat.UserGroupID, cat.Name, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            WHERE OnMainMenu = 1 AND";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $sql = $sql . " (cat.UserGroupID is null OR cat.UserGroupID = :UserGroupID)";
        } else {
            $sql = $sql . " cat.UserGroupID is null";
        }
        $stmt = $this->pdo->prepare($sql);
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $stmt->bindValue(':UserGroupID', $_SESSION['userData']['UserGroupID']);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllChildren($parentId)
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, cat.Name, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            WHERE cat.CategoryParentID = :ParentId AND";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $sql = $sql . " (cat.UserGroupID is null OR cat.UserGroupID = :UserGroupID)";
        } else {
            $sql = $sql . " cat.UserGroupID is null";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ParentId', $parentId);
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $stmt->bindValue(':UserGroupID', $_SESSION['userData']['UserGroupID']);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, cat.UserGroupID, cat.Name, cat.Description, cat.OnMainMenu, cat.IconID, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            WHERE CategoryID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_Category SET 
                Name = :Name,
                Description = :Description,
                OnMainMenu = :OnMainMenu,
                CategoryParentID = :CategoryParentID,
                UserGroupID = :UserGroupID,
                IconID = :IconID
                WHERE CategoryID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':OnMainMenu', $data['OnMainMenu']);
            $stmt->bindValue(':CategoryParentID', !empty($data['CategoryParentId']) ? $data['CategoryParentId'] : null);
            $stmt->bindValue(':UserGroupID', !empty($data['UserGroupId']) ? $data['UserGroupId'] : null);
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
        $sql = "DELETE FROM BAP_Category WHERE CategoryID = :Id";
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

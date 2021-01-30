<?php

require_once(__DIR__ . '/DAO.php');

class ArticleDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_Article (Title, Description, ArticleTypeID, CategoryID, UserGroupID) 
                VALUES (:Title, :Description, :ArticleTypeID, :CategoryID, :UserGroupID)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Title', $data['Title']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':ArticleTypeID', $data['ArticleTypeId']);
            $stmt->bindValue(':CategoryID', $data['CategoryId']);
            $stmt->bindValue(':UserGroupID', !empty($data['UserGroupId']) ? $data['UserGroupId'] : null);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT ar.ArticleID, ar.ArticleTypeID, ar.CategoryID, ar.UserGroupID, ar.Title, ar.Description, art.Name as ArticleTypeName, ic.Icon 
            FROM BAP_Article ar
            INNER JOIN BAP_ArticleType art on art.ArticleTypeID = ar.ArticleTypeID
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllByCategoryId($id)
    {
        $sql = "SELECT ar.ArticleID, ar.Title, ar.Description, art.Name as ArticleTypeName, ic.Icon
            FROM BAP_Article ar
            INNER JOIN BAP_ArticleType art on art.ArticleTypeID = ar.ArticleTypeID
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID 
            WHERE ar.CategoryID = :Id AND ar.UserGroupID is null";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $sql = $sql . " OR ar.UserGroupID = :UserGroupID";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $stmt->bindValue(':UserGroupID', $_SESSION['userData']['UserGroupID']);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT * FROM BAP_Article WHERE ArticleID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_Article SET 
                        Title = :Title, 
                        Description = :Description, 
                        ArticleTypeID = :ArticleTypeId,
                        CategoryID = :CategoryId,
                        UserGroupID = :UserGroupId
                    WHERE ArticleID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Title', $data['Title']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':ArticleTypeId', $data['ArticleTypeId']);
            $stmt->bindValue(':CategoryId', $data['CategoryId']);
            $stmt->bindValue(':UserGroupId', !empty($data['UserGroupId']) ? $data['UserGroupId'] : null);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM BAP_Article WHERE ArticleID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validate($data)
    {
        $errors = [];
        if (empty($data['Title'])) {
            $errors['Title'] = 'Gelieve een titel in te geven';
        }
        if (empty($data['ArticleTypeId'])) {
            $errors['ArticleTypeId'] = 'Gelieve een Article Type in te geven';
        }
        if (empty($data['CategoryId'])) {
            $errors['CategoryId'] = 'Gelieve een Category in te geven';
        }
        return $errors;
    }
}

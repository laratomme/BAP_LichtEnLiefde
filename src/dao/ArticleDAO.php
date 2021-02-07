<?php

require_once(__DIR__ . '/DAO.php');

class ArticleDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_Article (Title, Description, Content, ExternalUrl, ArticleTypeID, CategoryID, UserGroupID) 
                VALUES (:Title, :Description, :Content, :ExternalUrl, :ArticleTypeID, :CategoryID, :UserGroupID)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Title', $data['Title']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':Content', !empty($data['Content']) ? $data['Content'] : null);
            $stmt->bindValue(':ExternalUrl', !empty($data['ExternalUrl']) ? $data['ExternalUrl'] : null);
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
        $sql = "SELECT ar.ArticleID, ar.ArticleTypeID, ar.CategoryID, cat.Name as CategoryName, ar.UserGroupID, ug.Name as UserGroupName, ar.Title, ar.Description, ar.ExternalUrl, art.Name as ArticleTypeName, ic.Icon 
            FROM BAP_Article ar
            INNER JOIN BAP_ArticleType art on art.ArticleTypeID = ar.ArticleTypeID
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID
            INNER JOIN BAP_Category cat on cat.CategoryID = ar.CategoryID
            LEFT JOIN BAP_UserGroup ug on ug.UserGroupID = ar.UserGroupID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllByCategoryId($id)
    {
        $sql = "SELECT ar.ArticleID, ar.Title, ar.Description, ar.Content, ar.ExternalUrl, art.Name as ArticleTypeName, ic.Icon
            FROM BAP_Article ar
            INNER JOIN BAP_ArticleType art on art.ArticleTypeID = ar.ArticleTypeID
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID 
            WHERE ar.CategoryID = :Id AND";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $sql = $sql . " (ar.UserGroupID is null OR ar.UserGroupID = :UserGroupID)";
        } else {
            $sql = $sql . " ar.UserGroupID is null";
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

    public function readByFilter($filter)
    {
        $sql = "SELECT ar.ArticleID, ar.Title, ar.ExternalUrl, art.Name as ArticleTypeName, ic.Icon, search.Relevance
            FROM BAP_Article ar
            INNER JOIN BAP_ArticleType art on art.ArticleTypeID = ar.ArticleTypeID
            INNER JOIN BAP_Icon ic on ic.IconID = art.IconID
            INNER JOIN 
            (
                select ArticleID, MATCH(Content,Title) AGAINST (:Filter) as Relevance FROM BAP_Article
            ) as search on search.ArticleID = ar.ArticleID
            WHERE search.Relevance > 0 AND";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $sql .= " (ar.UserGroupID is null OR ar.UserGroupID = :UserGroupID)";
        } else {
            $sql .= " ar.UserGroupID is null";
        }
        $sql .= " ORDER BY search.Relevance DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Filter', $filter);
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            $stmt->bindValue(':UserGroupID', $_SESSION['userData']['UserGroupID']);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_Article SET 
                        Title = :Title, 
                        Description = :Description,
                        Content = :Content,
                        ExternalUrl = :ExternalUrl,
                        ArticleTypeID = :ArticleTypeId,
                        CategoryID = :CategoryId,
                        UserGroupID = :UserGroupId
                    WHERE ArticleID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Title', $data['Title']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':Content', !empty($data['Content']) ? $data['Content'] : null);
            $stmt->bindValue(':ExternalUrl', !empty($data['ExternalUrl']) ? $data['ExternalUrl'] : null);
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
        if (empty($data['Content']) && empty($data['ExternalUrl'])) {
            $errors['Content'] = 'Gelieve een inhoud in te geven';
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

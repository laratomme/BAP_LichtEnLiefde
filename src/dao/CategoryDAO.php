<!-- Categorie DAO -->
<?php

require_once(__DIR__ . '/DAO.php');

class CategoryDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_Category (Name, Description, OnMainMenu, ExternalUrl, CategoryParentID, UserGroupID, IconID)
                VALUES (:Name, :Description, :OnMainMenu, :ExternalUrl, :CategoryParentID, :UserGroupID, :IconID)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':OnMainMenu', $data['OnMainMenu']);
            $stmt->bindValue(':ExternalUrl', !empty($data['ExternalUrl']) ? $data['ExternalUrl'] : null);
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
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, catPar.Name as CategoryParentName, cat.UserGroupID, ug.Name as UserGroupName, cat.Name, cat.Description, cat.OnMainMenu, cat.ExternalUrl, cat.IconID, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            LEFT JOIN BAP_Category catPar on catPar.CategoryID = cat.CategoryParentID
            LEFT JOIN BAP_UserGroup ug on ug.UserGroupID = cat.UserGroupID
            ORDER BY cat.Name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllExceptId($id)
    {
        $sql = "SELECT CategoryID, Name, CategoryParentID, UserGroupID
            FROM BAP_Category";
        if (!empty($id)) {
            $sql .= " WHERE CategoryID != :Id";
        }
        $sql .= " ORDER BY Name";
        $stmt = $this->pdo->prepare($sql);
        if (!empty($id)) {
            $stmt->bindValue(':Id', $id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllOnMainMenu()
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, cat.UserGroupID, cat.Name, cat.ExternalUrl, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            WHERE cat.OnMainMenu = 1";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            if ($_SESSION['userData']['UserGroupID'] !== -1) {
                $sql .= " AND (cat.UserGroupID is null OR cat.UserGroupID = :UserGroupID)";
            }
        } else {
            $sql .= " AND cat.UserGroupID is null";
        }
        $sql .= " ORDER BY cat.Name";
        $stmt = $this->pdo->prepare($sql);
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            if ($_SESSION['userData']['UserGroupID'] !== -1) {
                $stmt->bindValue(':UserGroupID', $_SESSION['userData']['UserGroupID']);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllChildren($parentId)
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, cat.Name, cat.ExternalUrl, ic.Icon
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            WHERE cat.OnMainMenu = 0 AND cat.CategoryParentID = :ParentId";
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            if ($_SESSION['userData']['UserGroupID'] !== -1) {
                $sql .= " AND (cat.UserGroupID is null OR cat.UserGroupID = :UserGroupID)";
            }
        } else {
            $sql .= " AND cat.UserGroupID is null";
        }
        $sql .= " ORDER BY cat.Name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ParentId', $parentId);
        if (!empty($_SESSION['userData']) && !empty($_SESSION['userData']['UserGroupID'])) {
            if ($_SESSION['userData']['UserGroupID'] !== -1) {
                $stmt->bindValue(':UserGroupID', $_SESSION['userData']['UserGroupID']);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT cat.CategoryID, cat.CategoryParentID, cat.UserGroupID, cat.Name, cat.Description, cat.OnMainMenu, cat.ExternalUrl, cat.IconID, ic.Icon, catPar.UserGroupID as ParentUserGroupID
            FROM BAP_Category cat
            INNER JOIN BAP_Icon ic on ic.IconID = cat.IconID
            LEFT JOIN BAP_Category catPar on catPar.CategoryID = cat.CategoryParentID
            WHERE cat.CategoryID = :Id";
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
                Externalurl = :ExternalUrl,
                CategoryParentID = :CategoryParentID,
                UserGroupID = :UserGroupID,
                IconID = :IconID
                WHERE CategoryID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Description', $data['Description']);
            $stmt->bindValue(':OnMainMenu', $data['OnMainMenu']);
            $stmt->bindValue(':ExternalUrl', !empty($data['ExternalUrl']) ? $data['ExternalUrl'] : null);
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

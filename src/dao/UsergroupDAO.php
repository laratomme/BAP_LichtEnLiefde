<!-- Gebruiker Groep DAO -->
<?php

require_once(__DIR__ . '/DAO.php');

class UsergroupDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_UserGroup (Name) VALUES (:Name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT * FROM BAP_UserGroup ORDER BY Name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT * FROM BAP_UserGroup WHERE UserGroupID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_UserGroup SET Name = :Name WHERE UserGroupID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Name', $data['Name']);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        if ($id < 0) {
            $_SESSION['error'] = "Je mag deze groep niet verwijderen, default";
        }
        $sql = "DELETE FROM BAP_UserGroup WHERE UserGroupID = :Id";
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
        return $errors;
    }
}

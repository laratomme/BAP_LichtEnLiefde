<!-- Gebruiker DAO -->
<?php

require_once(__DIR__ . '/DAO.php');

class UserDAO extends DAO
{
    public function create($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "INSERT INTO BAP_User (FirstName, LastName, Email, Login, Password, UserGroupID)
            VALUES (:FirstName, :LastName, :Email, :Login, :Password, :UserGroupId)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':FirstName', $data['FirstName']);
            $stmt->bindValue(':LastName', $data['LastName']);
            $stmt->bindValue(':Email', $data['Email']);
            $stmt->bindValue(':Login', $data['Login']);
            $stmt->bindValue(':Password', $data['Password']);
            $stmt->bindValue(':UserGroupId', $data['UserGroupId']);
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
        }
        return false;
    }

    public function readAll()
    {
        $sql = "SELECT u.UserID, u.Login, u.FirstName, u.LastName, u.Email, u.UserGroupID, ug.Name as UserGroupName
            FROM BAP_User u
            INNER JOIN BAP_UserGroup ug on ug.UserGroupID = u.UserGroupID
            ORDER BY u.LastName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id)
    {
        $sql = "SELECT u.UserID, u.Login, u.FirstName, u.LastName, u.Email, u.UserGroupID, ug.Name as UserGroupName
            FROM BAP_User u
            INNER JOIN BAP_UserGroup ug on ug.UserGroupID = u.UserGroupID
            WHERE u.UserID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readByLogin($login)
    {
        $sql = "SELECT UserID, Login, FirstName, LastName, LoginToken, UserGroupID
            FROM BAP_User
            WHERE Login = :Login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Login', $login);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readByLoginData($data)
    {
        $sql = "SELECT UserID, Login, Password, FirstName, LastName, Email, UserGroupID, LoginToken
            FROM BAP_User
            WHERE Login = :Login AND Password = :Password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Login', $data['Login']);
        $stmt->bindValue(':Password', $data['Password']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_User SET
                        FirstName = :FirstName,
                        LastName = :LastName,
                        Email = :Email,
                        Login = :Login,
                        UserGroupID = :UserGroupId
                    WHERE UserID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':FirstName', $data['FirstName']);
            $stmt->bindValue(':LastName', $data['LastName']);
            $stmt->bindValue(':Email', $data['Email']);
            $stmt->bindValue(':Login', $data['Login']);
            $stmt->bindValue(':UserGroupId', $data['UserGroupId']);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function updatePassword($data)
    {
        $errors = $this->validate($data);
        if (empty($errors)) {
            $sql = "UPDATE BAP_User SET
                        Password = :Password
                    WHERE UserID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':Password', $data['Password']);
            $stmt->bindValue(':Id', $data['Id']);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function updateToken($id, $token)
    {
        if (empty($id) || empty($token)) {
            $errors['tokan'] = 'geen token of user aanwezig';
        } else {
            $sql = "UPDATE BAP_User SET
            LoginToken = :LoginToken
        WHERE UserID = :Id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':LoginToken', $token);
            $stmt->bindValue(':Id', $id);
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
        $sql = "DELETE FROM BAP_User WHERE UserID = :Id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':Id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validate($data)
    {
        $errors = [];
        if (empty($data['FirstName'])) {
            $errors['Firstname'] = 'Gelieve een voornaam in te geven';
        }
        if (empty($data['Login'])) {
            $errors['Login'] = 'Gelieve een login naam in te geven';
        }
        if (empty($data['Id']) && empty($data['Password'])) {
            $errors['Password'] = 'Gelieve een wachtwoord in te geven';
        }
        return $errors;
    }
}

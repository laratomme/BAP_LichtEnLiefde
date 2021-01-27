<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class UsersController extends Controller
{
    private $userDAO;
    private $usergroupDAO;

    function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->usergroupDAO = new UsergroupDAO();
    }

    public function users()
    {
        if (!empty($_POST['action'])) {
            $action = $_POST['action'];

            $data = array();
            $data['Id'] = $_POST['id'];
            $data['FirstName'] = $_POST['firstname'];
            $data['LastName'] = $_POST['lastname'];
            $data['Email'] = $_POST['email'];
            $data['Login'] = $_POST['login'];
            $data['Password'] = $_POST['password'];
            $data['UserGroupId'] = $_POST['usergroupid'];

            switch ($action) {
                case 'create':
                    $id = $this->userDAO->create($data);
                    if ($id) {
                        header("Location: index.php?page=users&id=" . $id);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de Gebruiker.');
                    }
                    break;
                case 'update':
                    if ($this->userDAO->update($data)) {
                        header("Location: index.php?page=users&id=" . $data['Id']);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de Gebruiker.');
                    }
                    break;
                case 'delete':
                    $this->userDAO->delete($data['Id']);
                    $this->_handleLoad();
                    break;
            }
        } else {
            $this->_handleLoad();
        }
        $this->set('title', 'Users');
    }

    private function _handleLoad()
    {
        if (!$usergroups = $this->usergroupDAO->readAll()) {
            $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de Gebruiker Groepen.');
        }
        $this->set('usergroups', $usergroups);

        if (!empty($_GET['id'])) {
            // Detail
            if (!$user = $this->userDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de Gebruiker.');
            }
            $this->set('user', $user);
        } else {
            // List
            $users = $this->userDAO->readAll();
            $this->set('user', null);
            $this->set('users', $users);
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=users');
        exit();
    }
}

<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class UsersController extends Controller
{
    private $userDAO;
    private $usergroupDAO;
    private $security;

    function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->usergroupDAO = new UsergroupDAO();
        $this->security = new Security();
    }

    public function users()
    {
        if ($this->security->isAdmin()) {
            if (!empty($_POST['action'])) {
                $action = $_POST['action'];

                $data = array();
                $data['Id'] = $_POST['id'];
                $data['FirstName'] = $_POST['firstname'];
                $data['LastName'] = $_POST['lastname'];
                $data['Email'] = $_POST['email'];
                $data['Login'] = $_POST['login'];
                $data['UserGroupId'] = $_POST['usergroupid'];

                $data['UpdatePassword'] = empty($_POST['updatepassword']) ? 0 : 1;
                $data['Password'] = $_POST['password'];

                switch ($action) {
                    case 'create':
                        $id = $this->userDAO->create($data);
                        if ($id) {
                            header("Location: index.php?page=users&id=" . $id);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de gebruiker.');
                        }
                        break;
                    case 'update':
                        if ($data['UpdatePassword']) {
                            $this->userDAO->updatePassword($data);
                        }
                        if ($this->userDAO->update($data)) {
                            header("Location: index.php?page=users&id=" . $data['Id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de gebruiker.');
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
        }
    }

    private function _handleLoad()
    {
        if (empty($_GET['action']) && empty($_GET['id'])) {
            // List
            $this->set('user', null);
            $this->set('users', $this->userDAO->readAll());
        } else {
            // Detail
            if (!$usergroups = $this->usergroupDAO->readAll()) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de gebruiker groepen.');
            }
            $this->set('usergroups', $usergroups);

            if (!empty($_GET['id'])) {
                if (!$user = $this->userDAO->readById($_GET['id'])) {
                    $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de gebruiker.');
                }
                $this->set('user', $user);
            } else {
                $this->set('user', null);
            }
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=users');
        exit();
    }
}

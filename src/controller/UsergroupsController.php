<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class UsergroupsController extends Controller
{
    private $usergroupDAO;
    private $security;

    function __construct()
    {
        $this->usergroupDAO = new UsergroupDAO();
        $this->security = new Security();
    }

    public function usergroups()
    {
        if ($this->security->isAdmin()) {
            if (!empty($_POST['action'])) {
                $action = $_POST['action'];

                $data = array();
                $data['Id'] = $_POST['id'];
                $data['Name'] = $_POST['name'];

                switch ($action) {
                    case 'create':
                        $id = $this->usergroupDAO->create($data);
                        if ($id) {
                            header("Location: index.php?page=usergroups&id=" . $id);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de gebruiker groep.');
                        }
                        break;
                    case 'update':
                        if ($this->usergroupDAO->update($data)) {
                            header("Location: index.php?page=usergroups&id=" . $data['id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de gebruiker groep.');
                        }
                        break;
                    case 'delete':
                        $this->usergroupDAO->delete($data['Id']);
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
            $this->set('usergroups', $this->usergroupDAO->readAll());
        } else {
            // Detail
            if (!empty($_GET['id'])) {
                if (!$usergroup = $this->usergroupDAO->readById($_GET['id'])) {
                    $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de gebruiker groep.');
                }
                $this->set('usergroup', $usergroup);
            } else {
                $this->set('usergroup', null);
            }
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=usergroups');
        exit();
    }
}

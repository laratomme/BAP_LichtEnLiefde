<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class UsergroupsController extends Controller
{
    private $usergroupDAO;

    function __construct()
    {
        $this->usergroupDAO = new UsergroupDAO();
    }

    public function list()
    {
        if (!empty($_POST['action'])) {
            if ($_POST['action'] == 'create') {
                $this->handleCreate();
            }
        }

        $usergroups = $this->usergroupDAO->readAll();
        $this->set('usergroups', $usergroups);
        $this->set('title', 'Usergroups');
    }

    private function handleCreate()
    {
        $data = array(
            'name' => $_POST['name']
        );
        $createResult = $this->usergroupDAO->create($data);
        if (!$createResult) {
            $errors = $this->usergroupDAO->validate($data);
            $this->set('errors', $errors);
            if (strtolower($_SERVER['HTTP_ACCEPT']) == 'application/json') {
                header('Content-Type: application/json');
                echo json_encode(array(
                    'result' => 'error',
                    'errors' => $errors
                ));
                exit();
            }
            $_SESSION['error'] = 'De usergroup kon niet toegevoegd worden!';
        } else {
            if (strtolower($_SERVER['HTTP_ACCEPT']) == 'application/json') {
                header('Content-Type: application/json');
                echo json_encode(array(
                    'result' => 'ok',
                    'usergroup' => $createResult
                ));
                exit();
            }
            $_SESSION['info'] = 'De usergroup is toegevoegd!';
            header('Location: index.php');
            exit();
        }
    }
}

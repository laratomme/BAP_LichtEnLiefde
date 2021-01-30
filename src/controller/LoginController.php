<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/UserDAO.php';

class LoginController extends Controller
{
    private $security;
    private $userDAO;

    function __construct()
    {
        $this->security = new Security();
        $this->userDAO = new UserDAO();
    }

    public function login()
    {
        if (!empty($_POST['action'])) {
            // Login Logic
            $data = array();
            $data['Login'] = $_POST['login'];
            $data['Password'] = $_POST['password'];

            $user = $this->userDAO->readByLoginData($data);
            if ($user) {
                $this->security->storeLoginData($user);
                header("Location: index.php?page=home");
                exit();
            } else {
                $_SESSION['error'] = "Gebruikernaam of Wachtwoord is verkeerd.";
            }
        } else {
            if (!empty($_GET['action']) && $_GET['action'] == 'logout') {
                $this->security->removeLoginData();
            }
        }
    }
}

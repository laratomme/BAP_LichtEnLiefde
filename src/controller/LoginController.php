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
            $data = array();
            $data['Login'] = $_POST['login'];
            $data['Password'] = $_POST['password'];

            $user = $this->userDAO->readByLoginData($data);
            if ($user) {
                if (isset($_POST['remember'])) {
                    $this->security->storeLoginData($user);
                } else {
                    $_SESSION["userData"] = $user;
                }

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

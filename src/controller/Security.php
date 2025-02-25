<?php

// genomen van https://stackoverflow.com/questions/1354999/keep-me-logged-in-the-best-approach

require_once __DIR__ . '/../dao/UserDAO.php';

class Security
{
    private $adminID = -1;
    private $key = 'f6d30d47282fc4d57ed48442349f52cd31e711866ef000855a78dea28471a7b5';
    private $userDAO;

    function __construct()
    {
        $this->key = pack("H*", $this->key);
        $this->userDAO = new UserDAO();
    }

    public function auth()
    {
        if (!isset($_COOKIE["userData"]) || empty($_COOKIE["userData"])) {
            return false;
        }

        // Decode
        if (!$cookie = @json_decode($_COOKIE["userData"], true)) {
            return false;
        }

        // Check Params
        if (!(isset($cookie['user']) || isset($cookie['token']) || isset($cookie['signature']))) {
            return false;
        }

        $var = $cookie['user'] . $cookie['token'];

        // Check Sig
        if (!$this->verify($var, $cookie['signature'])) {
            throw new Exception("Er is gerommeld met de cookie!");
        }

        // Check User
        $user = $this->userDAO->readByLogin($cookie['user']);
        if (empty($user)) {
            return false;
        }

        // Check User Data
        if (!$info = json_decode($user['LoginToken'], true)) {
            throw new Exception("User Data corrupted");
        }

        // Verify Token
        if ($info['token'] !== $cookie['token']) {
            throw new Exception("Token mismatch!");
        }

        // Refresh Token
        $this->storeLoginData($user);
        return $info;
    }

    public function storeLoginData($user)
    {
        $cookie = [
            "user" => $user['Login'],
            "token" => $this->getRand(64),
            "signature" => null
        ];
        $cookie['signature'] = $this->hash($cookie['user'] . $cookie['token']);
        $encoded = json_encode($cookie);

        $this->userDAO->updateToken($user['UserID'], $encoded);
        $_SESSION["userData"] = $user;
        setcookie("userData", $encoded, time() + (86400 * 7));
    }

    public function removeLoginData()
    {
        $_SESSION['userData'] = null;
        unset($_COOKIE['userData']);
        setcookie("userData", "", time() - 3600);
    }

    public function isAdmin($redirect = true)
    {
        if (!isset($_SESSION["userData"]) || empty($_SESSION["userData"])) {
            if ($redirect) {
                header("Location: index.php?page=home");
                exit();
            } else {
                return false;
            }
        }

        if (!isset($_SESSION['userData']['UserGroupID'])) {
            if ($redirect) {
                header("Location: index.php?page=home");
                exit();
            } else {
                return false;
            }
        }

        return $_SESSION['userData']['UserGroupID'] === $this->adminID;
    }

    public function hasAccess($userGroupId)
    {
        if (!$this->isAdmin(false)) {
            if (!empty($userGroupId)) {
                if (!isset($_SESSION["userData"]) || empty($_SESSION["userData"])) {
                    header("Location: index.php?page=home");
                    exit();
                }

                if (!isset($_SESSION['userData']['UserGroupID'])) {
                    header("Location: index.php?page=home");
                    exit();
                }

                if ($_SESSION['userData']['UserGroupID'] != $userGroupId) {
                    header("Location: index.php?page=home");
                    exit();
                }

                return false;
            }
        }
        return true;
    }

    private function verify($data, $hash)
    {
        $rand = substr($hash, 0, 4);
        return $this->hash($data, $rand) === $hash;
    }

    private function hash($value, $rand = null)
    {
        $rand = $rand === null ? $this->getRand(4) : $rand;
        return $rand . bin2hex(hash_hmac('sha256', $value . $rand, $this->key, true));
    }

    private function getRand($length)
    {
        switch (true) {
            case function_exists("openssl_random_pseudo_bytes"):
                $r = openssl_random_pseudo_bytes($length);
                break;
            case is_readable('/dev/urandom'):
                $r = file_get_contents('/dev/urandom', false, null, 0, $length);
                break;
            default:
                $i = 0;
                $r = "";
                while ($i++ < $length) {
                    $r .= chr(mt_rand(0, 255));
                }
                break;
        }
        return substr(bin2hex($r), 0, $length);
    }
}

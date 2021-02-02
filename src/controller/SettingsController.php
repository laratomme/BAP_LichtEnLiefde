<?php

require_once __DIR__ . '/Controller.php';

class SettingsController extends Controller
{
    function __construct()
    {
    }

    public function settings()
    {
        if (!empty($_POST['action'])) {
            $data = array();
            $data['Font'] = $_POST['font'];
            $data['Contrast'] = $_POST['contrast'];

            $encoded = json_encode($data);

            $_SESSION["uiData"] = $data;
            setcookie("uiData", $encoded, time() + (86400 * 3650));
            // setcookie("auto", $encoded, time() + $expiration, "/~root/", "example.com", 1, 1);
        }
    }

    public function initSettings()
    {
        $data = array();
        $data['Font'] = "font-size-100";
        $data['Contrast'] = "color";
        $_SESSION["uiData"] = $data;
    }

    public function refreshSettings()
    {
        $this->convertSettings();
        setcookie("uiData", $_COOKIE["uiData"], time() + (86400 * 3650));
    }

    private function convertSettings()
    {
        if (!$cookie = @json_decode($_COOKIE["uiData"], true)) {
            return false;
        }
        $_SESSION["uiData"] = $cookie;
    }
}

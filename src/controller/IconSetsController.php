<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/IconSetDAO.php';

class IconSetsController extends Controller
{
    private $iconSetDAO;
    private $security;

    function __construct()
    {
        $this->iconSetDAO = new IconSetDAO();
        $this->security = new Security();
    }

    public function iconsets()
    {
        if ($this->security->isAdmin()) {
            if (!empty($_POST['action'])) {
                $action = $_POST['action'];

                $data = array();
                $data['Id'] = $_POST['id'];
                $data['IconFile'] = empty($_FILES['iconfile']) ? null : $_FILES['iconfile'];

                switch ($action) {
                    case 'create':
                        $data['Icon'] = $this->_handleUpload($data['IconFile']);
                        $id = $this->iconSetDAO->create($data);
                        if ($id) {
                            header("Location: index.php?page=iconsets&id=" . $id);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de Icon Set.');
                        }
                        break;
                    case 'update':
                        $data['Icon'] = $this->_handleUpload($data['IconFile']);

                        if ($this->iconSetDAO->update($data)) {
                            header("Location: index.php?page=iconsets&id=" . $data['Id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de Icon Set.');
                        }
                        break;
                    case 'delete':
                        $this->iconsets->delete($data['Id']);
                        $this->_handleLoad();
                        break;
                }
            } else {
                $this->_handleLoad();
            }
        }
    }

    private function _handleUpload($fileInfo)
    {
        if (!empty($fileInfo)) {
            if (DIRECTORY_SEPARATOR == '/') {
                $folder = dirname(__DIR__) . '/assets/img/iconsSets/';
            } else {
                $folder = str_replace('\\', '/', dirname(__DIR__)) . '/assets/img/iconsSets/';
            }

            $fileLoc = $folder . $fileInfo['name'];
            $file = '/assets/img/iconsSets/' . $fileInfo['name'];

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            if (move_uploaded_file($fileInfo['tmp_name'], $fileLoc)) {
                return $file;
            }
        }
        return null;
    }

    private function _handleLoad()
    {
        if (empty($_GET['action']) && empty($_GET['id'])) {
            // List
            $this->set('iconset', null);
            $this->set('iconsets', $this->iconSetDAO->readAll());
        } else {
            // Detail
            if (!empty($_GET['id'])) {
                if (!$iconset = $this->iconSetDAO->readById($_GET['id'])) {
                    $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de Icon Set.');
                }
                $this->set('iconset', $iconset);
            } else {
                $this->set('iconset', null);
            }
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=iconsets');
        exit();
    }
}

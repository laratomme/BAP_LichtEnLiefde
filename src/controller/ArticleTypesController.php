<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/IconDAO.php';
require_once __DIR__ . '/../dao/ArticleTypeDAO.php';

class ArticleTypesController extends Controller
{
    private $iconDAO;
    private $articletypeDAO;

    function __construct()
    {
        $this->iconDAO = new IconDAO();
        $this->articletypeDAO = new ArticleTypeDAO();
    }

    public function articletypes()
    {
        if (!empty($_POST['action'])) {
            $action = $_POST['action'];

            $data = array();
            $data['Id'] = $_POST['id'];
            $data['IconId'] = $_POST['iconid'];
            $data['Name'] = $_POST['name'];
            $data['Description'] = $_POST['description'];
            $data['UpdateIcon'] = empty($_POST['updateicon']) ? 0 : $_POST['updateicon'];
            $data['FontIcon'] = empty($_POST['fonticon']) ? null : $_POST['fonticon'];
            $data['CustomIcon'] = empty($_FILES['customicon']) ? null : $_FILES['customicon'];

            switch ($action) {
                case 'create':
                    $data['IconId'] = $this->_handleIcon($data, $action);
                    $id = $this->articletypeDAO->create($data);
                    if ($id) {
                        header("Location: index.php?page=articletypes&id=" . $id);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van het Artikel Type.');
                    }
                    break;
                case 'update':
                    if ($this->articletypeDAO->update($data)) {
                        $this->_handleIcon($data, $action);
                        header("Location: index.php?page=articletypes&id=" . $data['Id']);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van het Artikel Type.');
                    }
                    break;
                case 'delete':
                    $this->articletypeDAO->delete($data['Id']);
                    $this->_handleIcon($data, $action);
                    $this->_handleLoad();
                    break;
            }
        } else {
            $this->_handleLoad();
        }
        $this->set('title', 'Article Types');
    }

    private function _handleIcon($data, $action)
    {
        $icon = array();
        $icon['Id'] = $data['IconId'];
        $icon['Icon'] = !empty($data['FontIcon']) ? $data['FontIcon'] : null;
        $icon['IsCustom'] = !empty($data['FontIcon']) ? 0 : 1;

        $id = null;
        switch ($action) {
            case 'create':
                $nextId = $this->iconDAO->getNextId();
                if ($icon['IsCustom']) {
                    $icon['Icon'] = $this->_handleUpload($data['CustomIcon'], $nextId['ID']);
                }
                $id = $this->iconDAO->create($icon);
                break;
            case 'update':
                if ($data['UpdateIcon']) {
                    if ($icon['IsCustom']) {
                        $icon['Icon'] = $this->_handleUpload($data['CustomIcon'], $icon['Id']);
                    }
                    $this->iconDAO->update($icon);
                }
                break;
            case 'delete':
                $this->iconDAO->delete($icon['Id']);
                break;
        }
        return $id;
    }

    private function _handleUpload($fileInfo, $id)
    {
        if (DIRECTORY_SEPARATOR == '/'){
            $folder = dirname(__DIR__) . '/images/Icons/';
        }
        else
        {
            $folder = str_replace('\\', '/', dirname(__DIR__)) . '/images/Icons/';
        }

        $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
        $fileLoc = $folder . $id . '.' . $ext;
        $file = 'images/Icons/' . $id . '.' . $ext;

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (move_uploaded_file($fileInfo['tmp_name'], $fileLoc)) {
            return $file;
        }
        return null;
    }

    private function _handleLoad()
    {
        if (!empty($_GET['id'])) {
            // Detail
            if (!$articletype = $this->articletypeDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van het Article Type.');
            }
            $this->set('articletype', $articletype);
            $this->set('icon', $this->iconDAO->readById($articletype['IconID']));
        } else {
            // List
            $articletypes = $this->articletypeDAO->readAll();
            $this->set('articletype', null);
            $this->set('icon', null);
            $this->set('articletypes', $articletypes);
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=articletypes');
        exit();
    }
}

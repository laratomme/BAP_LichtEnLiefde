<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Icons.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/ArticleTypeDAO.php';

class ArticleTypesController extends Controller
{
    private $articletypeDAO;
    private $icons;
    private $security;

    function __construct()
    {
        $this->articletypeDAO = new ArticleTypeDAO();
        $this->icons = new Icons();
        $this->security = new Security();
    }

    public function articletypes()
    {
        if ($this->security->isAdmin()) {
            if (!empty($_POST['action'])) {
                $action = $_POST['action'];

                $data = array();
                $data['Id'] = $_POST['id'];
                $data['IconId'] = $_POST['iconid'];
                $data['Name'] = $_POST['name'];
                $data['Description'] = $_POST['description'];

                $data['UpdateIcon'] = empty($_POST['updateicon']) ? 0 : 1;
                $data['DefaultIcon'] = empty($_POST['defaulticon']) ? null : $_POST['defaulticon'];
                $data['IconFile'] = empty($_FILES['iconfile']) ? null : $_FILES['iconfile'];

                switch ($action) {
                    case 'create':
                        $data['IconId'] = $this->icons->handleIcon($data, $action);
                        $id = $this->articletypeDAO->create($data);
                        if ($id) {
                            header("Location: index.php?page=articletypes&id=" . $id);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van het inhoud type.');
                        }
                        break;
                    case 'update':
                        if ($this->articletypeDAO->update($data)) {
                            $this->icons->handleIcon($data, $action);
                            header("Location: index.php?page=articletypes&id=" . $data['Id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van het inhoud type.');
                        }
                        break;
                    case 'delete':
                        $this->articletypeDAO->delete($data['Id']);
                        $this->icons->handleIcon($data, $action);
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
            $this->set('articletypes', $this->articletypeDAO->readAll());
        } else {
            // Detail
            if (!empty($_GET['id'])) {
                if (!$articletype = $this->articletypeDAO->readById($_GET['id'])) {
                    $this->_handleError('Er is een fout gebeurd tijdens het ophalen van het inhoud type.');
                }
                $this->set('articletype', $articletype);
            } else {
                $this->set('articletype', null);
            }
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=articletypes');
        exit();
    }
}

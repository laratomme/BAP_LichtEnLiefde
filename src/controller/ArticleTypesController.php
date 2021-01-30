<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/IconsController.php';
require_once __DIR__ . '/../dao/ArticleTypeDAO.php';
require_once __DIR__ . '/../dao/IconSetDAO.php';

class ArticleTypesController extends Controller
{
    private $articletypeDAO;
    private $iconsetDAO;
    private $iconsController;
    private $security;

    function __construct()
    {
        $this->articletypeDAO = new ArticleTypeDAO();
        $this->iconsetDAO = new IconSetDAO();
        $this->iconsController = new IconsController();
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
                $data['IconSetId'] = empty($_POST['iconsetid']) ? null : $_POST['iconsetid'];
                $data['IconFile'] = empty($_FILES['iconfile']) ? null : $_FILES['iconfile'];

                switch ($action) {
                    case 'create':
                        $data['IconId'] = $this->iconsController->handleIcon($data, $action);
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
                            $this->iconsController->handleIcon($data, $action);
                            header("Location: index.php?page=articletypes&id=" . $data['Id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van het Artikel Type.');
                        }
                        break;
                    case 'delete':
                        $this->articletypeDAO->delete($data['Id']);
                        $this->iconsController->handleIcon($data, $action);
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
            $this->set('iconsets', $this->iconsetDAO->readAll());

            if (!empty($_GET['id'])) {
                if (!$articletype = $this->articletypeDAO->readById($_GET['id'])) {
                    $this->_handleError('Er is een fout gebeurd tijdens het ophalen van het Article Type.');
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

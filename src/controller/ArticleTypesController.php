<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/IconsController.php';
require_once __DIR__ . '/../dao/ArticleTypeDAO.php';

class ArticleTypesController extends Controller
{
    private $iconsController;
    private $articletypeDAO;

    function __construct()
    {
        $this->articletypeDAO = new ArticleTypeDAO();
        $this->iconsController = new IconsController();
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
        $this->set('title', 'Article Types');
    }

    private function _handleLoad()
    {
        if (!empty($_GET['id'])) {
            // Detail
            if (!$articletype = $this->articletypeDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van het Article Type.');
            }
            $this->set('articletype', $articletype);
            $this->set('icon', $this->iconsController->readByID($articletype['IconID']));
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

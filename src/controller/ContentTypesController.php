<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/IconsController.php';
require_once __DIR__ . '/../dao/ContentTypeDAO.php';

class ContentTypesController extends Controller
{
    private $iconsController;
    private $contentTypeDAO;

    function __construct()
    {
        $this->contentTypeDAO = new ContentTypeDAO();
        $this->iconsController = new IconsController();
    }

    public function contenttypes()
    {
        if (!empty($_POST['action'])) {
            $action = $_POST['action'];

            $data = array();
            $data['Id'] = $_POST['id'];
            $data['IconId'] = $_POST['iconid'];
            $data['Name'] = $_POST['name'];
            $data['Wrap'] = $_POST['wrap'];
            $data['ContentName'] = $_POST['contentname'];
            $data['MetaContentName'] = $_POST['metacontentname'];
            $data['UpdateIcon'] = empty($_POST['updateicon']) ? 0 : $_POST['updateicon'];
            $data['FontIcon'] = empty($_POST['fonticon']) ? null : $_POST['fonticon'];
            $data['CustomIcon'] = empty($_FILES['customicon']) ? null : $_FILES['customicon'];

            switch ($action) {
                case 'create':
                    $data['IconId'] = $this->iconsController->handleIcon($data, $action);
                    $id = $this->contentTypeDAO->create($data);
                    if ($id) {
                        header("Location: index.php?page=contenttypes&id=" . $id);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van het Content Type.');
                    }
                    break;
                case 'update':
                    if ($this->contentTypeDAO->update($data)) {
                        $this->iconsController->handleIcon($data, $action);
                        header("Location: index.php?page=contenttypes&id=" . $data['Id']);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van het Content Type.');
                    }
                    break;
                case 'delete':
                    $this->contentTypeDAO->delete($data['Id']);
                    $this->iconsController->handleIcon($data, $action);
                    $this->_handleLoad();
                    break;
            }
        } else {
            $this->_handleLoad();
        }
        $this->set('title', 'Content Types');
    }

    private function _handleLoad()
    {
        if (!empty($_GET['id'])) {
            // Detail
            if (!$contenttype = $this->contentTypeDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van het Content Type.');
            }
            $this->set('contenttype', $contenttype);
            $this->set('icon', $this->iconsController->readByID($contenttype['IconID']));
        } else {
            // List
            $contenttypes = $this->contentTypeDAO->readAll();
            $this->set('contenttype', null);
            $this->set('icon', null);
            $this->set('contenttypes', $contenttypes);
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=contenttypes');
        exit();
    }
}

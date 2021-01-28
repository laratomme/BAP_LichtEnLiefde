<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/IconsController.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class CategoriesController extends Controller
{
    private $iconsController;
    private $categoryDAO;
    private $usergroupDAO;

    function __construct()
    {
        $this->categoryDAO = new CategoryDAO();
        $this->usergroupDAO = new UsergroupDAO();
        $this->iconsController = new IconsController();
    }

    public function category()
    {
        if (!empty($_GET['id'])) {
            // Detail
            if (!$category = $this->categoryDAO->readById($_GET['id'])) {
                $_SESSION['error'] = 'Er is een fout gebeurd tijdens het ophalen van de Category.';
                header('Location: index.php?page=home');
                exit();
            }
            $this->set('category', $category);

            $this->set('children', $this->categoryDAO->readAllChildren($category['CategoryID']));

            $this->set('title', $category['Name']);
        } else {
            header('Location: index.php?page=home');
            exit();
        }
    }

    public function categories()
    {
        if (!empty($_POST['action'])) {
            $action = $_POST['action'];

            $data = array();
            $data['Id'] = $_POST['id'];
            $data['IconId'] = $_POST['iconid'];
            $data['CategoryParentId'] = $_POST['categoryparentid'];
            $data['UserGroupId'] = $_POST['usergroupid'];
            $data['Name'] = $_POST['name'];
            $data['Description'] = $_POST['description'];
            $data['OnMainMenu'] = empty($_POST['onmainmenu']) ? 0 : 1;
            $data['UpdateIcon'] = empty($_POST['updateicon']) ? 0 : 1;
            $data['FontIcon'] = empty($_POST['fonticon']) ? null : $_POST['fonticon'];
            $data['CustomIcon'] = empty($_FILES['customicon']) ? null : $_FILES['customicon'];

            switch ($action) {
                case 'create':
                    $data['IconId'] = $this->iconsController->handleIcon($data, $action);
                    $id = $this->categoryDAO->create($data);
                    if ($id) {
                        header("Location: index.php?page=categories&id=" . $id);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de Category.');
                    }
                    break;
                case 'update':
                    if ($this->categoryDAO->update($data)) {
                        $this->iconsController->handleIcon($data, $action);
                        header("Location: index.php?page=categories&id=" . $data['Id']);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de Category.');
                    }
                    break;
                case 'delete':
                    $this->categoryDAO->delete($data['Id']);
                    $this->iconsController->handleIcon($data, $action);
                    $this->_handleLoad();
                    break;
            }
        } else {
            $this->_handleLoad();
        }
        $this->set('title', 'Categories');
    }

    private function _handleLoad()
    {
        $this->set('usergroups', $this->usergroupDAO->readAll());
        $this->set('parents', $this->categoryDAO->readAllExceptId(!empty($_GET['id']) ? $_GET['id'] : null));

        if (!empty($_GET['id'])) {
            // Detail
            if (!$category = $this->categoryDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van Category.');
            }

            $this->set('category', $category);
            $this->set('icon', $this->iconsController->readByID($category['IconID']));
        } else {
            // List
            $this->set('categories', $this->categoryDAO->readAll());
            $this->set('category', null);
            $this->set('icon', null);
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=categories');
        exit();
    }
}

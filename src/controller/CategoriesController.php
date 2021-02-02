<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/IconsController.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/ArticleDAO.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';
require_once __DIR__ . '/../dao/IconSetDAO.php';

class CategoriesController extends Controller
{
    private $articleDAO;
    private $categoryDAO;
    private $usergroupDAO;
    private $iconsetDAO;
    private $iconsController;
    private $security;

    function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->usergroupDAO = new UsergroupDAO();
        $this->iconsetDAO = new IconSetDAO();
        $this->iconsController = new IconsController();
        $this->security = new Security();
    }

    public function category()
    {
        if (!empty($_GET['id'])) {
            if (!$category = $this->categoryDAO->readById($_GET['id'])) {
                $_SESSION['error'] = 'Er is een fout gebeurd tijdens het ophalen van de Category.';
                header('Location: index.php?page=home');
                exit();
            }
            $this->set('category', $category);

            $this->set('children', $this->categoryDAO->readAllChildren($category['CategoryID']));
            $this->set('articles', $this->articleDAO->readAllByCategoryId($category['CategoryID']));
        } else {
            header('Location: index.php?page=home');
            exit();
        }
    }

    public function categories()
    {
        if ($this->security->isAdmin()) {
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
                $data['IconSetId'] = empty($_POST['iconsetid']) ? null : $_POST['iconsetid'];
                $data['IconFile'] = empty($_FILES['iconfile']) ? null : $_FILES['iconfile'];

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
                        $this->_handleLoadList();
                        break;
                }
            } else if (!empty($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'create':
                        $this->_handleLoadSubData();
                        $category = null;
                        if (!empty($_GET['parentid'])) {
                            $category['CategoryParentID'] = (int)$_GET['parentid'];
                            $category['OnMainMenu'] = false;
                        }
                        $this->set('category', $category);
                        break;
                    case 'delete':
                        if (!empty($_GET['id'])) {
                            $this->categoryDAO->delete($_GET['id']);
                            if (!empty($_GET['parentid'])) {
                                header('Location: index.php?page=category&id=' . $_GET['parentid']);
                            } else {
                                header('Location: index.php?page=home');
                            }
                            exit();
                        }
                        break;
                    default:
                        $_SESSION['error'] = "Actie is niet geimplementeerd";
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                        exit();
                        break;
                }
            } else if (empty($_GET['id'])) {
                $this->_handleLoadList();
            } else {
                $this->_handleLoadDetail();
            }
        }
    }

    private function _handleLoadList()
    {
        $this->set('categories', $this->categoryDAO->readAll());
    }

    private function _handleLoadDetail()
    {
        $this->_handleLoadSubData();

        if (!empty($_GET['id'])) {
            if (!$category = $this->categoryDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van Category.');
            }
            $this->set('category', $category);
        } else {
            $this->set('category', null);
        }
    }

    private function _handleLoadSubData()
    {
        $this->set('iconsets', $this->iconsetDAO->readAll());
        $this->set('parents', $this->categoryDAO->readAllExceptId(!empty($_GET['id']) ? $_GET['id'] : null));

        if (!$usergroups = $this->usergroupDAO->readAll()) {
            $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de Usergroups.');
        }
        $this->set('usergroups', $usergroups);
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=categories');
        exit();
    }
}

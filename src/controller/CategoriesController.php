<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Icons.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/ArticleDAO.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class CategoriesController extends Controller
{
    private $articleDAO;
    private $categoryDAO;
    private $usergroupDAO;
    private $icons;
    private $security;

    function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->usergroupDAO = new UsergroupDAO();
        $this->icons = new Icons();
        $this->security = new Security();
    }

    public function category()
    {
        if (!empty($_GET['id'])) {
            if (!$category = $this->categoryDAO->readById($_GET['id'])) {
                $_SESSION['error'] = 'Er is een fout gebeurd tijdens het ophalen van de categorie.';
                header('Location: index.php?page=home');
                exit();
            }

            if ($this->security->hasAccess($category['UserGroupID'])) {
                $this->set('category', $category);

                $this->set('children', $this->categoryDAO->readAllChildren($category['CategoryID']));
                $this->set('articles', $this->articleDAO->readAllByCategoryId($category['CategoryID']));
            }
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

                $categoryParent = !empty($_POST['categoryparent']) ? explode("_", trim($_POST['categoryparent'])) : null;
                $data['CategoryParentId'] = !empty($categoryParent) ? $categoryParent[0] : null;
                
                $data['UserGroupId'] = $_POST['usergroupid'];
                $data['Name'] = $_POST['name'];
                $data['Description'] = $_POST['description'];
                $data['OnMainMenu'] = empty($_POST['onmainmenu']) ? 0 : 1;
                $data['ExternalUrl'] =  !empty($_POST['externalurl']) ? $this->_fixUrl($_POST['externalurl']) : null;

                $data['UpdateIcon'] = empty($_POST['updateicon']) ? 0 : 1;
                $data['DefaultIcon'] = empty($_POST['defaulticon']) ? null : $_POST['defaulticon'];
                $data['IconFile'] = empty($_FILES['iconfile']) ? null : $_FILES['iconfile'];

                switch ($action) {
                    case 'create':
                        $data['IconId'] = $this->icons->handleIcon($data, $action);
                        $id = $this->categoryDAO->create($data);
                        if ($id) {
                            header("Location: index.php?page=categories&id=" . $id);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de categorie.');
                        }
                        break;
                    case 'update':
                        if ($this->categoryDAO->update($data)) {
                            $this->icons->handleIcon($data, $action);
                            header("Location: index.php?page=categories&id=" . $data['Id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de categorie.');
                        }
                        break;
                    case 'delete':
                        $this->categoryDAO->delete($data['Id']);
                        $this->icons->handleIcon($data, $action);
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
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van categorie.');
            }
            $this->set('category', $category);
        } else {
            $this->set('category', null);
        }
    }

    private function _handleLoadSubData()
    {
        $this->set('parents', $this->categoryDAO->readAllExceptId(!empty($_GET['id']) ? $_GET['id'] : null));

        if (!$usergroups = $this->usergroupDAO->readAll()) {
            $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de gebruiker groepen.');
        }
        $this->set('usergroups', $usergroups);
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=categories');
        exit();
    }

    private function _fixUrl($url, $scheme = 'http://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }
}

<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Security.php';
require_once __DIR__ . '/../dao/ArticleDAO.php';
require_once __DIR__ . '/../dao/ArticleTypeDAO.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';
require_once __DIR__ . '/../dao/UsergroupDAO.php';

class ArticlesController extends Controller
{
    private $articleDAO;
    private $articleTypeDAO;
    private $categoryDAO;
    private $usergroupDAO;
    private $security;

    function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->articleTypeDAO = new ArticleTypeDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->usergroupDAO = new UsergroupDAO();
        $this->security = new Security();
    }

    public function article()
    {
        if (!empty($_GET['id'])) {
            if (!$article = $this->articleDAO->readById($_GET['id'])) {
                $_SESSION['error'] = 'Er is een fout gebeurd tijdens het ophalen van de inhoud.';
                header('Location: index.php?page=home');
                exit();
            }
            $this->set('article', $article);
        } else {
            header('Location: index.php?page=home');
            exit();
        }
    }

    public function articles()
    {
        if ($this->security->isAdmin()) {
            if (!empty($_POST['action'])) {
                $action = $_POST['action'];

                $data = array();
                $data['Id'] = $_POST['id'];
                $data['ArticleTypeId'] = $_POST['articletypeid'];
                $data['CategoryId'] = $_POST['categoryid'];
                $data['UserGroupId'] = $_POST['usergroupid'];
                $data['Title'] = $_POST['title'];
                $data['Description'] = $_POST['description'];
                $data['Content'] = $_POST['content'];
                $data['ExternalUrl'] =  !empty($_POST['externalurl']) ? $this->_fixUrl($_POST['externalurl']) : null;

                switch ($action) {
                    case 'create':
                        $id = $this->articleDAO->create($data);
                        if ($id) {
                            header("Location: index.php?page=articles&id=" . $id);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van de inhoud.');
                        }
                        break;
                    case 'update':
                        if ($this->articleDAO->update($data)) {
                            header("Location: index.php?page=articles&id=" . $data['Id']);
                            exit();
                        } else {
                            $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van de inhoud.');
                        }
                        break;
                    case 'delete':
                        $this->articleDAO->delete($data['Id']);
                        $this->_handleLoadList();
                        break;
                }
            } else if (!empty($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'create':
                        $this->_handleLoadSubData();
                        $article = null;
                        if (!empty($_GET['categoryid'])) {
                            $article['CategoryID'] = (int)$_GET['categoryid'];
                        }
                        $this->set('article', $article);
                        break;
                    case 'delete':
                        if (!empty($_GET['id'])) {
                            $this->articleDAO->delete($_GET['id']);
                            header('Location: index.php?page=category&id=' . $_GET['categoryid']);
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
        $this->set('articles', $this->articleDAO->readAll());
    }

    private function _handleLoadDetail()
    {
        $this->_handleLoadSubData();

        if (!empty($_GET['id'])) {
            if (!$article = $this->articleDAO->readById($_GET['id'])) {
                $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de inhoud.');
            }
            $this->set('article', $article);
        } else {
            $this->set('article', null);
        }
    }

    private function _handleLoadSubData()
    {
        if (!$articletypes = $this->articleTypeDAO->readAll()) {
            $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de inhoud types.');
        }
        $this->set('articletypes', $articletypes);

        if (!$categories = $this->categoryDAO->readAll()) {
            $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de categorieën.');
        }
        $this->set('categories', $categories);

        if (!$usergroups = $this->usergroupDAO->readAll()) {
            $this->_handleError('Er is een fout gebeurd tijdens het ophalen van de gebruiker groepen.');
        }
        $this->set('usergroups', $usergroups);
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=articles');
        exit();
    }

    private function _fixUrl($url, $scheme = 'http://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }
}

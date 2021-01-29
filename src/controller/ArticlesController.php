<?php

require_once __DIR__ . '/Controller.php';
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

    function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->articleTypeDAO = new ArticleTypeDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->usergroupDAO = new UsergroupDAO();
    }

    public function article()
    {
        // if (!empty($_GET['id'])) {
        //     if (!$category = $this->categoryDAO->readById($_GET['id'])) {
        //         $_SESSION['error'] = 'Er is een fout gebeurd tijdens het ophalen van de Category.';
        //         header('Location: index.php?page=home');
        //         exit();
        //     }
        //     $this->set('category', $category);

        //     $this->set('children', $this->categoryDAO->readAllChildren($category['CategoryID']));

        //     $this->set('title', $category['Name']);
        // } else {
        //     header('Location: index.php?page=home');
        //     exit();
        // }
    }

    public function articles()
    {
        if (!empty($_POST['action'])) {
            $action = $_POST['action'];

            $data = array();
            $data['Id'] = $_POST['id'];
            $data['ArticleTypeId'] = $_POST['articletypeid'];
            $data['CategoryId'] = $_POST['categoryid'];
            $data['UserGroupId'] = $_POST['usergroupid'];
            $data['Title'] = $_POST['title'];
            $data['Description'] = $_POST['description'];

            switch ($action) {
                case 'create':
                    $id = $this->articleDAO->create($data);
                    if ($id) {
                        header("Location: index.php?page=articles&id=" . $id);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanmaken van het Artikel.');
                    }
                    break;
                case 'update':
                    if ($this->articleDAO->update($data)) {
                        header("Location: index.php?page=articles&id=" . $data['Id']);
                        exit();
                    } else {
                        $this->_handleError('Er is een fout gebeurd tijdens het aanpassen van het Artikel.');
                    }
                    break;
                case 'delete':
                    $this->articleDAO->delete($data['Id']);
                    $this->_handleLoad();
                    break;
            }
        } else {
            $this->_handleLoad();
        }
        $this->set('title', 'Articles');
    }

    private function _handleLoad()
    {
        if (empty($_GET['action']) && empty($_GET['id'])) {
            // List
            $this->set('article', null);
            $this->set('articles', $this->articleDAO->readAll());
        } else {
            // Detail
            $this->set('articletypes', $this->articleTypeDAO->readAll());
            $this->set('categories', $this->categoryDAO->readAll());
            $this->set('usergroups', $this->usergroupDAO->readAll());

            if (!empty($_GET['id'])) {
                if (!$article = $this->articleDAO->readById($_GET['id'])) {
                    $this->_handleError('Er is een fout gebeurd tijdens het ophalen van het Artikel.');
                }
                $this->set('article', $article);
            } else {
                $this->set('article', null);
            }
        }
    }

    private function _handleError($Message)
    {
        $_SESSION['error'] = $Message;
        header('Location: index.php?page=articles');
        exit();
    }
}

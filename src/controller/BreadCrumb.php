<?php

require_once __DIR__ . '/../dao/ArticleDAO.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';

class BreadCrumb
{
    private $articelDAO;
    private $categoryDAO;

    function __construct()
    {
        $this->articelDAO = new ArticleDAO();
        $this->categoryDAO = new CategoryDAO();
    }

    public function generateBreadCrumb($route)
    {
        $crumb = array();
        if (!empty($_GET['page']) && $_GET['page'] !== 'home') {
            $page = $_GET['page'];

            if ($page === 'article' || $page === 'category') {
                $id = !empty($_GET['id']) ? $_GET['id'] : null;
                if (!empty($id)) {
                    $parentId = null;
                    switch ($page) {
                        case 'article':
                            $article = $this->articelDAO->readById($id);
                            $parentId = $article['CategoryID'];
                            array_push($crumb, array('id' => $id, 'page' => $page, 'name' => $article['Title']));
                            break;
                        case 'category':
                            $category = $this->categoryDAO->readById($id);
                            $parentId = $category['CategoryParentID'];
                            array_push($crumb, array('id' => $id, 'page' => $page, 'name' => $category['Name']));
                            break;
                    }

                    if (!empty($parentId)) {
                        $categories = $this->categoryDAO->readAll();

                        while (!empty($parentId)) {
                            $key = array_search($parentId, array_column($categories, 'CategoryID'));
                            if ($key !== false) {
                                $parent = $categories[$key];
                                array_push($crumb, array('id' => $parent['CategoryID'], 'page' => 'category', 'name' => $parent['Name']));
                                $parentId = $parent['CategoryParentID'];
                            } else {
                                $parentId = null;
                            }
                        }
                    }
                }
            } else {
                array_push($crumb, array('id' => null, 'page' => $page, 'name' => $route['name']));
            }
        }

        array_push($crumb, array('id' => null, 'page' => 'home', 'name' => 'Home'));
        return array_reverse($crumb);
    }
}
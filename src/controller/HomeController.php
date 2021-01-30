<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';

class HomeController extends Controller
{
    private $categoryDAO;

    function __construct()
    {
        $this->categoryDAO = new CategoryDAO();
    }

    public function index()
    {
        $this->set('categories', $this->categoryDAO->readAllOnMainMenu());
    }
}

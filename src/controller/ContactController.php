<?php

require_once __DIR__ . '/Controller.php';

class ContactController extends Controller
{
    function __construct()
    {
        $this->categoryDAO = new CategoryDAO();
    }

    public function contact()
    {
        $this->set('title', 'Contact');
    }
}

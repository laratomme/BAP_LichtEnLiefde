<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);

// basic .env file parsing
if (file_exists("../.env")) {
    $variables = parse_ini_file("../.env", true);
    foreach ($variables as $key => $value) {
        putenv("$key=$value");
    }
}

$routes = array(
    'home' => array(
        'controller' => 'Home',
        'action' => 'index',
        'name' => 'Home'
    ),
    'article' => array(
        'controller' => 'Articles',
        'action' => 'article',
        'name' => 'Inhoud'
    ),
    'category' => array(
        'controller' => 'Categories',
        'action' => 'category',
        'name' => 'Categorie'
    ),
    'contact' => array(
        'controller' => 'Contact',
        'action' => 'contact',
        'name' => 'Contact'
    ),
    'login' => array(
        'controller' => 'Login',
        'action' => 'login',
        'name' => 'Login'
    ),
    'settings' => array(
        'controller' => 'Settings',
        'action' => 'settings',
        'name' => 'Instellingen'
    ),
    'articles' => array(
        'controller' => 'Articles',
        'action' => 'articles',
        'name' => 'Inhoud'
    ),
    'articletypes' => array(
        'controller' => 'Articletypes',
        'action' => 'articletypes',
        'name' => 'Inhoud Types'
    ),
    'categories' => array(
        'controller' => 'Categories',
        'action' => 'categories',
        'name' => 'Categorieën'
    ),
    'users' => array(
        'controller' => 'Users',
        'action' => 'users',
        'name' => 'Gebruikers'
    ),
    'usergroups' => array(
        'controller' => 'Usergroups',
        'action' => 'usergroups',
        'name' => 'Gebruiker Groepen'
    )
);

if (empty($_GET['page'])) {
    $_GET['page'] = 'home';
}
if (empty($routes[$_GET['page']])) {
    header('Location: index.php');
    exit();
}

$route = $routes[$_GET['page']];
$controllerName = $route['controller'] . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();

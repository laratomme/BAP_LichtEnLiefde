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
        'action' => 'index'
    ),
    'article' => array(
        'controller' => 'Articles',
        'action' => 'article'
    ),
    'category' => array(
        'controller' => 'Categories',
        'action' => 'category'
    ),
    'contact' => array(
        'controller' => 'Contact',
        'action' => 'contact'
    ),
    'login' => array(
        'controller' => 'Login',
        'action' => 'login'
    ),
    'settings' => array(
        'controller' => 'Settings',
        'action' => 'settings'
    ),
    'articles' => array(
        'controller' => 'Articles',
        'action' => 'articles'
    ),
    'articletypes' => array(
        'controller' => 'Articletypes',
        'action' => 'articletypes'
    ),
    'categories' => array(
        'controller' => 'Categories',
        'action' => 'categories'
    ),
    'contenttypes' => array(
        'controller' => 'ContentTypes',
        'action' => 'contenttypes'
    ),
    'iconsets' => array(
        'controller' => 'IconSets',
        'action' => 'iconsets'
    ),
    'users' => array(
        'controller' => 'Users',
        'action' => 'users'
    ),
    'usergroups' => array(
        'controller' => 'Usergroups',
        'action' => 'usergroups'
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

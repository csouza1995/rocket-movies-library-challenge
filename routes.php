<?php

// get the controller from the URL
$controller = str_replace('/', '', parse_url($_SERVER['REQUEST_URI'])['path']);
if (!$controller) {
    $controller = 'index';
}

// request prevention
if (!file_exists(ROOT . "/controllers/{$controller}.controller.php")) {
    abort(404);
}

// appoint the route to nav styles
$route = $controller;

// like a middleware
$allowedRoutesToGuest = ['login', 'register', 'forgot-password', 'reset-password'];
if (in_array($route, $allowedRoutesToGuest) && auth()) {
    redirect('/');
} elseif (!in_array($route, $allowedRoutesToGuest) && !auth()) {
    redirect('/login');
}

// include the controller
require ROOT . "/controllers/{$controller}.controller.php";

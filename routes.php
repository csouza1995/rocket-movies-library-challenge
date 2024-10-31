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

require ROOT . "/controllers/{$controller}.controller.php";

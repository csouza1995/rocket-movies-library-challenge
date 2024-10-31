<?php

// set ROOT to ../
define('ROOT', dirname(__DIR__ . '/../../'));

// requires
require ROOT . "/functions.php";

require ROOT . "/sessions/Session.php";
require ROOT . "/database/Database.php";
require ROOT . "/storage/Storage.php";
require ROOT . "/validators/Validator.php";

// models
require ROOT . "/models/User.php";

Session::start();

require ROOT . "/routes.php";

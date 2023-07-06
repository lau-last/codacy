<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';
require_once '../config/global.php';

\App\SessionBlog\SessionBlog::start();

(new \Core\Router\Router(require ROOT . '/config/routes.php'))->run(new \Core\Http\Request());
<?php
require "../vendor/autoload.php";
session_start();
use App\routes\Router;
$router = new Router();
$router->run();
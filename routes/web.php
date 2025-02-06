<?php        

require_once 'app/Controllers/HomeController.php';
require_once 'app/Controllers/AboutController.php';
require_once 'app/Controllers/IndexController.php';

Router::get('/', IndexController::class , 'index');
Router::get('/home', HomeController::class , 'home');
Router::get('/home/:id', HomeController::class , 'home');
Router::get('/home-data/:id', HomeController::class , 'data');
Router::get('/country', HomeController::class, 'displayCountry');
Router::get('/about', AboutController::class, 'index');
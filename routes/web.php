<?php        

require_once 'app/Controllers/HomeController.php';

Router::get('/home', HomeController::class , 'home');
Router::get('/home/:id', HomeController::class , 'home');
Router::get('/home-data/:id', HomeController::class , 'data');
Router::get('/country', HomeController::class, 'displayCountry');
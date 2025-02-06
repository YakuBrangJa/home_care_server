<?php        

require_once 'app/Controllers/HomeController.php';
require_once 'app/Controllers/AboutController.php';
require_once 'app/Controllers/IndexController.php';

Router::group('/v1', function() {
  Router::get('/user/:id', HomeController::class , 'displayUser');
  Router::get('/users', HomeController::class , 'displayUsers');
});
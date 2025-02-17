<?php        

require_once 'app/Controllers/HomeController.php';
require_once 'app/Controllers/CustomerController.php';
require_once 'app/Controllers/ServiceRequestController.php';

Router::group('/v1', function() {
  Router::group('/test', function() {
    Router::get('/user/:id', HomeController::class , 'displayUser');
    Router::get('/users', HomeController::class , 'displayUsers');
    Router::get('/email', HomeController::class , 'testemail');
  });

  Router::group('/customer', function() {
    Router::get('/users', CustomerController::class , 'displayUsers');
    Router::get('/user/:id', CustomerController::class , 'getCustomer');
    Router::post('/register', CustomerController::class , 'register');
    Router::post('/login', CustomerController::class , 'login');
    Router::post('/logout', CustomerController::class , 'logout');
    Router::post('/update/:id', CustomerController::class , 'update');
  });

  Router::group('/manager', function() {
    
  });

  Router::group('/worker', function() {

  }); 

  Router::group('/service', function() {
    Router::post('/request', ServiceRequestController::class, 'createRequest');
  });
});
<?php

require_once 'app/Models/Home.php';


class HomeController extends Controller
{
  // protected $home = new Home();

  public function index() {
      $this->render('index');
  }

  function data($param) {
    $data = [
      'name' => 'Yaku',
      'age' => 24,
      'param' => $param
    ]; 

    echo json_encode($data);
  }

  function home($param) {
    // $data = [
    //   'name' => 'Yaku',
    //   'age' => 24,
    //   'param' => $param
    // ]; 
    
    $this->render('home');
    // echo json_encode($data);
  }
  
  function displayCountry() {
    $data = Home::fetchCountry();
    echo json_encode($data);
  }

  function displayUsers() {
    $data = Home::fetchUsers();
    echo json_encode($data);
  }

  function displayUser($id) {
    $data = Home::fetchUser($id);
    echo json_encode($data);
  }
  
  function testemail() {
    $data = Home::testEmail();
    echo json_encode($data);
  }
}
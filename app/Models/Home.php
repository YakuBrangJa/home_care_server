<?php

class Home extends Model {

  public static function fetchCountry() {
    return self::query('select * from country;');
  }

  public static function fetchUsers() {
    return self::query('SELECT * FROM Customer');
  }
  
  public static function fetchUser($id) {
    return self::query('SELECT * FROM Customer WHERE id=' . $id . ';');
  }
  
  public static function testEmail() {
    return self::query("INSERT INTO Customer (firstname, lastname, phone, email, address, password) VALUES ('test1', 'test1', '989283923', 'test1@gmail.com','sdf', 'sdfasdf')");
  }
}
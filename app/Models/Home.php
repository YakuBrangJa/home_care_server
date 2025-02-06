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

}
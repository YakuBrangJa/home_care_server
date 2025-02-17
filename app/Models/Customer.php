<?php

require_once 'utils/db.utils.php';

class Customer extends Model {

    public static function fetchUsers() {
      return self::query('SELECT * FROM Customer');
    }

    public static function findByEmail($email, $columns = []) {
        $selectClause = DBUtils::createSelectClause($columns);
        $result = self::query("SELECT $selectClause FROM Customer WHERE email = ?", [$email]);
        return !empty($result) ? $result[0] : null;
    }

    public static function findByPhone($phone, $columns = []) {
        $selectClause = DBUtils::createSelectClause($columns);
        $result = self::query("SELECT $selectClause FROM Customer WHERE phone = ?", [$phone]);
        return !empty($result) ? $result[0] : null;
    }

    public static function findById($id, $columns = []) {
        $selectClause = DBUtils::createSelectClause($columns);
        $result = self::query("SELECT $selectClause FROM Customer WHERE id = ?", [$id]);
        return !empty($result) ? $result[0] : null;
    }

    public static function isEmailTaken($email, $customerId = null) {
        if ($customerId) {
            $query = self::query(
                "SELECT id FROM Customer WHERE email = ? AND id != ?",
                [$email, $customerId]
            );
        } else {
            $query = self::query(
                "SELECT id FROM Customer WHERE email = ?",
                [$email]
            );
        }
        
        return !empty($query); // Returns true if email exists
    }

    public static function isPhoneTaken($phone, $customerId = null) {
        if ($customerId) {
            $query = self::query(
                "SELECT id FROM Customer WHERE phone = ? AND id != ?",
                [$phone, $customerId]
            );
        } else {
            $query = self::query(
                "SELECT id FROM Customer WHERE phone = ?",
                [$phone]
            );
        }
        
        return !empty($query); // Returns true if email exists
    }


    public static function register($firstname, $lastname, $phone, $email, $password, $address) {
      // Check if the email or phone already exists
      $existingCustomer = self::query("SELECT id FROM Customer WHERE email = ? OR phone = ?", [$email, $phone]);
      if (!empty($existingCustomer)) {
          return ['status' => false, 'message' => 'Email or phone number already exists'];
      }

      // Hash the password
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      // Insert the new customer into the database
      $inserted = self::query(
          "INSERT INTO Customer (firstname, lastname, phone, email, address, password) VALUES (?, ?, ?, ?, ?, ?)", 
          [$firstname, $lastname, $phone, $email, $address, $hashedPassword]
      );

      if ($inserted) {
          return ['status' => true, 'message' => 'Account created successfully'];
      } else {
          return ['status' => false, 'message' => 'Failed to create account'];
      }
    }

    public static function login($email, $password) {
        $customer = self::query("SELECT * FROM Customer WHERE email = ?", [$email]);

        if ($customer && password_verify($password, $customer[0]['password'])) {
            $_SESSION['customer_id'] = $customer[0]['id'];
            $_SESSION['customer_name'] = $customer[0]['firstname'] . ' ' . $customer[0]['lastname'];
            return true;
        }
        
        return false;
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

     public static function updateCustomer($id, $data) {
        $query = self::query(
            "UPDATE Customer SET firstname = ?, lastname = ?, phone = ?, email = ?, address = ? WHERE id = ?",
            [$data['firstname'], $data['lastname'], $data['phone'], $data['email'], $data['address'], $id]
        );

        return $query ? true : false;
    }
    
    // public static function findByEmail($email) {
    //     $result = self::query("SELECT * FROM Customer WHERE email = ?", [$email]);
    //     return !empty($result) ? $result[0] : null;
    // }

    // public static function findByPhone($email) {
    //     $result = self::query("SELECT * FROM Customer WHERE phone = ?", [$email]);
    //     return !empty($result) ? $result[0] : null;
    // }

    // public static function findById($id) {
    //     $result = self::query("SELECT * FROM Customer WHERE id = ?", [$id]);
    //     return !empty($result) ? $result[0] : null;
    // }

}
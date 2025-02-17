<?php

require_once 'app/Models/Customer.php';

class CustomerController extends Controller
{
  function displayUsers() {
    $data = Home::fetchUsers();
    echo json_encode($data);
  }

  public function register() {
    header('Content-Type: application/json'); // Set JSON response type

    try {
        // Get the raw input
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate input
        if (
            empty($data['firstname']) || empty($data['lastname']) || 
            empty($data['phone']) || empty($data['email']) || 
            empty($data['password']) || empty($data['address'])
        ) {
            http_response_code(400); // Bad Request
            echo json_encode(['status' => false, 'message' => 'All fields are required']);
            return;
        }

        // Check if the email already exists
        if (Customer::findByEmail($data['email'])) {
            http_response_code(409); // Conflict
            echo json_encode([
              'status' => false, 
              'message' => 'Data conflict',
              'errors' => [
                'email' => 'Email already exists'
              ]
            ]);
            return;
        }

        // Check if the email already exists
        if (Customer::findByPhone($data['phone'])) {
            http_response_code(409); // Conflict
            echo json_encode([
              'status' => false, 
              'message' => 'Data conflict',
              'errors' => [
                'phone' => 'Phone already exists'
              ]
            ]);
            return;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Register the user
        $response = Customer::register(
            $data['firstname'], $data['lastname'], 
            $data['phone'], $data['email'], 
            $hashedPassword, $data['address']
        );

        if ($response) {
            $user = Customer::findByEmail($data['email']);
            unset($user['password']);
            
            http_response_code(201); 
            echo json_encode([
              'status' => true, 
              'message' => 'Registration successful',
              'data' => $user
            ]);
        } else {
            http_response_code(500); 
            echo json_encode(['status' => false, 'message' => 'Registration failed']);
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo json_encode(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()]);
    }
}
  
  public function login() {
      header('Content-Type: application/json');

      try {
          $data = json_decode(file_get_contents("php://input"), true);

          // Validate input fields
          if (empty($data['email']) || empty($data['password'])) {
              http_response_code(400); // Bad Request
              echo json_encode(['status' => false, 'message' => 'Email and password are required']);
              return;
          }

          $customer = Customer::findByEmail($data['email']);

          // Validate email existence and password match
          if (!$customer || !password_verify($data['password'], $customer['password'])) {
              http_response_code(401); // Unauthorized
              echo json_encode(['status' => false, 'message' => 'Invalid email or password']);
              return;
          }

          // Start session and store customer info
          session_start();
          $_SESSION['customer_id'] = $customer['id'];
          $_SESSION['customer_email'] = $customer['email'];

          // Remove password before sending response
          unset($customer['password']);

          http_response_code(200); 
          echo json_encode([
              'status' => true, 
              'message' => 'Login successful',
              'data' => $customer
          ]);
      } catch (Exception $e) {
          http_response_code(500); 
          echo json_encode(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()]);
      }
  }


  public function logout() {
      header('Content-Type: application/json'); 

      try {
          session_start();
          session_destroy();

          http_response_code(200); 
          echo json_encode(['status' => true, 'message' => 'Logout successful']);
      } catch (Exception $e) {
          http_response_code(500); 
          echo json_encode(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()]);
      }
  }


  public function getCustomer($id) {
      try {
        $customer = Customer::findById($id);
        
        unset($customer['password']);

        if (!$customer) {
            http_response_code(404);
            echo json_encode(['status' => false, 'message' => 'Customer not found']);
            return;
        }

        http_response_code(200);
        echo json_encode(['status' => true, 'data' => $customer]);

      } catch (Exception $e) {
          http_response_code(500);
          echo json_encode(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()]);
      }
  }

   public function update($id) {
      header('Content-Type: application/json');

      try {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate input
        if (
            empty($data['firstname']) || empty($data['lastname']) || 
            empty($data['phone']) || empty($data['email']) || 
            empty($data['address'])
        ) {
            http_response_code(400); // Bad Request
            echo json_encode(['status' => false, 'message' => 'All fields are required']);
            return;
        }

        // Check if the email already exists
        if (Customer::isEmailTaken($data['email'], $id)) {
            http_response_code(409); // Conflict
            echo json_encode([
              'status' => false, 
              'message' => 'Data conflict',
              'errors' => [
                'email' => 'Email already exists'
              ]
            ]);
            return;
        }

        // Check if the email already exists
        if (Customer::isPhoneTaken($data['phone'], $id)) {
            http_response_code(409); // Conflict
            echo json_encode([
              'status' => false, 
              'message' => 'Data conflict',
              'errors' => [
                'phone' => 'Phone already exists'
              ]
            ]);
            return;
        }

        // Call model to update the customer
        $success = Customer::updateCustomer($id, $data);

        if (!$success) {
            http_response_code(500); // Internal Server Error
            echo json_encode([
              'status' => false, 
              'message' => 'Failed to update customer',
            ]);
            return;
        }

        $user = Customer::findById($id);
        unset($user['password']);
        http_response_code(200);
        
        echo json_encode([
          'status' => true, 
          'message' => 'Customer updated successfully',
          'data' => $user
        ]);

      } catch (Exception $e) {
          http_response_code(500);
          echo json_encode(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()]);
      }
    }
}
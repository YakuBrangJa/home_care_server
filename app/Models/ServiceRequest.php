<?php

require_once 'utils/db.utils.php';

class ServiceRequest extends Model {

    public static function createRequest($data) {
      $query = self::query(
        "INSERT INTO Request (subject, description, urgency, status, requested_at, customer_id, service_id) 
          VALUES (?, ?, ?, ?, NOW(), ?, ?)",
        [
            $data['subject'],
            $data['description'],
            $data['urgency'],
            'pending', // Default status
            $data['customer_id'],
            $data['service_id'],
        ]
      );

      return $query ? self::lastInsertId() : false;
    }

        // Get all service requests for a specific customer
    public static function getCustomerRequests($customerId) {
        return self::query(
            "SELECT * FROM Request WHERE customer_id = ? ORDER BY requested_at DESC",
            [$customerId]
        );
    }

    // Get a specific request by ID
    public static function getRequestById($requestId, $customerId) {
        return self::query(
            "SELECT * FROM Request WHERE id = ? AND customer_id = ?",
            [$requestId, $customerId],
            true
        );
    }

}
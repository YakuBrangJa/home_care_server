<?php

require_once 'app/Models/ServiceRequest.php';

class ServiceRequestController extends Controller {

   public function createRequest() {
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (
                empty($data['subject']) || empty($data['description']) ||
                empty($data['urgency']) || empty($data['customer_id']) || empty($data['service_id'])
            ) {
                http_response_code(400);
                echo json_encode(['status' => false, 'message' => 'All fields are required']);
                return;
            }

            $requestId = ServiceRequest::createRequest($data);

            if (!$requestId) {
                http_response_code(500);
                echo json_encode(['status' => false, 'message' => 'Failed to create request']);
                return;
            }

            http_response_code(201);
            echo json_encode(['status' => true, 'message' => 'Service request created successfully', 'request_id' => $requestId]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()]);
        }
    }

}
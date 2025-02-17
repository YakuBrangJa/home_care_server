-- Customer request a service
INSERT INTO Request (subject, description, urgency, status, requested_at, customer_id, service_id) 
          VALUES (?, ?, ?, ?, NOW(), ?, ?)


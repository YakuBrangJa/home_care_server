-- Checking if the customer with provided email already exit
SELECT * FROM Customer WHERE email = ?;
SELECT * FROM Customer WHERE phone = ?;

-- Customer account creation
INSERT INTO Customer (firstname, lastname, phone, email, address, password) VALUES (?, ?, ?, ?, ?, ?)


-- Customer data fetching
SELECT * FROM Customer WHERE id = ?;


-- Updating customer data
SELECT id FROM Customer WHERE id != ? AND (email = ? OR phone = ?) -- validating email and phone
UPDATE Customer SET firstname = ?, lastname = ?, phone = ?, email = ?, address = ? WHERE id = ?

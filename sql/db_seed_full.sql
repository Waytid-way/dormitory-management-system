

DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS billings;
DROP TABLE IF EXISTS leases;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS tenants;

CREATE TABLE tenants (
    tenant_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    id_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL,
    floor INT,
    room_type VARCHAR(50),
    price_per_month DECIMAL(10,2),
    status ENUM('available','occupied','maintenance') DEFAULT 'available'
);

CREATE TABLE leases (
    lease_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT,
    room_id INT,
    start_date DATE,
    end_date DATE,
    deposit_amount DECIMAL(10,2),
    active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (tenant_id) REFERENCES tenants(tenant_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

CREATE TABLE billings (
    billing_id INT AUTO_INCREMENT PRIMARY KEY,
    lease_id INT,
    billing_date DATE,
    due_date DATE,
    rent_amount DECIMAL(10,2),
    water_bill DECIMAL(10,2),
    electric_bill DECIMAL(10,2),
    total_amount DECIMAL(10,2),
    status ENUM('unpaid','paid','overdue') DEFAULT 'unpaid',
    FOREIGN KEY (lease_id) REFERENCES leases(lease_id)
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    billing_id INT,
    amount DECIMAL(10,2),
    payment_date DATE,
    method ENUM('cash','transfer','card'),
    FOREIGN KEY (billing_id) REFERENCES billings(billing_id)
);

-- INSERT TENANTS
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('ทินวัฒน์ นาคะนคร', '0852876769', 'ทินวัฒน์0@mockmail.com', '1074596118383');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('ปิยนาฎ นุตตาร', '0819738277', 'ปิยนาฎ1@mockmail.com', '4915517082865');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('จณิสตา ฉิมพาลี', '0857009115', 'จณิสตา2@mockmail.com', '5397766899266');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('กองสิน ดาบเงิน', '0826097323', 'กองสิน3@mockmail.com', '5260096833686');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('ปฐวีกานต์ แก้วอยู่', '0884037146', 'ปฐวีกานต์4@mockmail.com', '6396526528468');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('อรจิรา บุญบำรุง', '0843696905', 'อรจิรา5@mockmail.com', '3341859524314');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('วีร์สุดา สันตะวงศ์', '0810699447', 'วีร์สุดา6@mockmail.com', '5516232059804');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('ปฐวีกานต์ ซูสารอ', '0835711954', 'ปฐวีกานต์7@mockmail.com', '7911611575651');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('ธีรลักษณ์ ตวงทอง', '0889965876', 'ธีรลักษณ์8@mockmail.com', '1331978585303');
INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('สมเกียรติ ถมังรักษสัตว์', '0819510154', 'สมเกียรติ9@mockmail.com', '9506065731805');
-- INSERT ROOMS
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('101', 1, 'Deluxe', 4000, 'occupied');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('102', 1, 'Deluxe', 4000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('103', 1, 'Deluxe', 4000, 'occupied');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('104', 1, 'Deluxe', 4000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('105', 1, 'Standard', 3500, 'maintenance');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('201', 2, 'Suite', 3500, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('202', 2, 'Deluxe', 4000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('203', 2, 'Deluxe', 5000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('204', 2, 'Suite', 3500, 'occupied');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('205', 2, 'Suite', 4000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('301', 3, 'Deluxe', 3500, 'occupied');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('302', 3, 'Suite', 4000, 'maintenance');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('303', 3, 'Suite', 4000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('304', 3, 'Deluxe', 4000, 'available');
INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('305', 3, 'Standard', 4000, 'occupied');
-- INSERT LEASES
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (2, 5, '2025-06-22', '2026-06-22', 5000, TRUE);
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (10, 5, '2025-01-22', '2026-01-22', 5000, TRUE);
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (6, 15, '2025-02-08', '2026-02-08', 6000, FALSE);
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (8, 10, '2025-02-16', '2026-02-16', 7000, FALSE);
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (7, 1, '2025-06-22', '2026-06-22', 7000, FALSE);
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (7, 9, '2025-04-23', '2026-04-23', 6000, FALSE);
INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES (4, 7, '2025-04-27', '2026-04-27', 6000, FALSE);
-- INSERT BILLINGS
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (2, '2025-09-01', '2025-09-11', 4000, 136, 353, 4489, 'overdue');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (6, '2025-09-01', '2025-09-11', 5000, 145, 303, 5448, 'unpaid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (4, '2025-07-01', '2025-07-11', 4000, 120, 399, 4519, 'unpaid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (7, '2025-10-01', '2025-10-11', 4000, 144, 412, 4556, 'paid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (6, '2025-09-01', '2025-09-11', 4000, 168, 393, 4561, 'unpaid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (4, '2025-07-01', '2025-07-11', 4000, 176, 483, 4659, 'unpaid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (1, '2025-07-01', '2025-07-11', 4000, 183, 473, 4656, 'paid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (6, '2025-09-01', '2025-09-11', 5000, 118, 457, 5575, 'paid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (3, '2025-08-01', '2025-08-11', 4000, 186, 396, 4582, 'unpaid');
INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES (3, '2025-07-01', '2025-07-11', 5000, 174, 412, 5586, 'paid');
-- INSERT PAYMENTS
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (8, 4800, '2025-10-06', 'card');
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (5, 4500, '2025-10-14', 'card');
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (6, 4500, '2025-10-12', 'transfer');
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (10, 4500, '2025-10-14', 'transfer');
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (10, 4800, '2025-10-09', 'transfer');
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (9, 4000, '2025-10-05', 'cash');
INSERT INTO payments (billing_id, amount, payment_date, method) VALUES (9, 4500, '2025-10-06', 'cash');
import random
from faker import Faker
from datetime import datetime, timedelta
import os


fake = Faker('th_TH')

output_dir = "sql"
output_file = os.path.join(output_dir, "db_seed_full.sql")

os.makedirs(output_dir, exist_ok=True)


schema = """
-- Dormitory Management System (Mockup LAMP)
-- Phase 2 Unified (Awardspace Import Version)
-- Generated automatically via Python script

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
"""


#TENANTS

tenants_sql = ["\n-- INSERT TENANTS"]
for i in range(10):
    name = fake.name()
    phone = "08" + str(random.randint(10000000, 99999999))
    email = f"{name.split()[0].lower()}{i}@mockmail.com".replace(" ", "")
    id_number = str(random.randint(1000000000000, 9999999999999))
    tenants_sql.append(
        f"INSERT INTO tenants (full_name, phone, email, id_number) VALUES ('{name}', '{phone}', '{email}', '{id_number}');"
    )


#ROOMS
rooms_sql = ["\n-- INSERT ROOMS"]
statuses = ['available', 'occupied', 'maintenance']
for i in range(15):
    floor = (i // 5) + 1
    room_number = f"{floor}0{(i % 5) + 1}"
    room_type = random.choice(['Standard', 'Deluxe', 'Suite'])
    price = random.choice([3500, 4000, 5000])
    status = random.choices(statuses, weights=[0.5, 0.4, 0.1])[0]
    rooms_sql.append(
        f"INSERT INTO rooms (room_number, floor, room_type, price_per_month, status) VALUES ('{room_number}', {floor}, '{room_type}', {price}, '{status}');"
    )


#LEASES

leases_sql = ["\n-- INSERT LEASES"]
for i in range(7):
    tenant_id = random.randint(1, 10)
    room_id = random.randint(1, 15)
    start_date = datetime(2025, random.randint(1, 6), random.randint(1, 28))
    end_date = start_date + timedelta(days=365)
    deposit = random.choice([5000, 6000, 7000])
    active = random.choice([True, False])
    leases_sql.append(
        f"INSERT INTO leases (tenant_id, room_id, start_date, end_date, deposit_amount, active) VALUES ({tenant_id}, {room_id}, '{start_date.date()}', '{end_date.date()}', {deposit}, {str(active).upper()});"
    )


#BILLINGS

billings_sql = ["\n-- INSERT BILLINGS"]
statuses_b = ['unpaid', 'paid', 'overdue']
for i in range(10):
    lease_id = random.randint(1, 7)
    billing_date = datetime(2025, random.randint(7, 10), 1)
    due_date = billing_date + timedelta(days=10)
    rent = random.choice([3500, 4000, 5000])
    water = random.randint(100, 200)
    electric = random.randint(300, 500)
    total = rent + water + electric
    status = random.choices(statuses_b, weights=[0.4, 0.5, 0.1])[0]
    billings_sql.append(
        f"INSERT INTO billings (lease_id, billing_date, due_date, rent_amount, water_bill, electric_bill, total_amount, status) VALUES ({lease_id}, '{billing_date.date()}', '{due_date.date()}', {rent}, {water}, {electric}, {total}, '{status}');"
    )


#PAYMENTS

payments_sql = ["\n-- INSERT PAYMENTS"]
methods = ['cash', 'transfer', 'card']
for i in range(7):
    billing_id = random.randint(1, 10)
    amount = random.choice([4000, 4500, 4800, 5000])
    pay_date = datetime(2025, 10, random.randint(5, 15))
    method = random.choice(methods)
    payments_sql.append(
        f"INSERT INTO payments (billing_id, amount, payment_date, method) VALUES ({billing_id}, {amount}, '{pay_date.date()}', '{method}');"
    )



with open(output_file, "w", encoding="utf-8") as f:
    f.write(schema)
    f.write("\n".join(tenants_sql))
    f.write("\n".join(rooms_sql))
    f.write("\n".join(leases_sql))
    f.write("\n".join(billings_sql))
    f.write("\n".join(payments_sql))

print(f"SQL export complete: {output_file}")
print("��� Import this file into phpMyAdmin → your database → Import tab → Go.")

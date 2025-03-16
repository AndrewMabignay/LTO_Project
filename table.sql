-- COMMENT --

CREATE DATABASE lto;
USE lto;

CREATE TABLE accounts(
 ID INT PRIMARY KEY AUTO_INCREMENT,
 Name VARCHAR(100) NOT NULL,
 Age INT NOT NULL,
 Address VARCHAR(200) NOT NULL,
 Password VARCHAR(100) NOT NULL,
 Role ENUM('User', 'Admin') NOT NULL
);

DESC accounts;

CREATE TABLE registered (
    Name VARCHAR(100) NOT NULL, 
    Address VARCHAR(200) NOT NULL,
    Model VARCHAR(100) NOT NULL,
    Plate VARCHAR(100) NOT NULL,
    Official_Receipt VARCHAR(100) NOT NULL,
    Certificate_Registration VARCHAR(100) NOT NULL,
    Date DATE NOT NULL
);

DESC registered;
DESC accounts;

INSERT INTO accounts(Name, Age, Address, Password, Role) VALUES
('admin', 100, 'Dyan lang sa gedli', 'admin', 'Admin');

SELECT * FROM accounts;

ALTER TABLE registered ADD CONSTRAINT unique_plate UNIQUE (Plate);
ALTER TABLE registered ADD CONSTRAINT unique_official_receipt UNIQUE (Official_Receipt);
ALTER TABLE registered ADD CONSTRAINT unique_certificate_registration UNIQUE (Certificate_Registration);

DESC registered;

INSERT INTO registered(Name, Address, Model, Plate, Official_Receipt, Certificate_Registration, Date) VALUES
('AdminTest', 'AdminAddress', 'Honda Bike', '333-6666', 'AR-123-456', 'XYZ-091','2025-03-16');


SELECT Official_Receipt, Certificate_Registration FROM registered WHERE plate = 'ABC1234';
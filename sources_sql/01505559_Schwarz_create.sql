CREATE TABLE orderr(
    orderID int,
    price float,
    paymentMethod varchar(30) DEFAULT 'cash',
    customerID int NOT NULL,
    CONSTRAINT orderr_pk PRIMARY KEY (orderID),
    CHECK (price >= 0) 
);

CREATE TABLE customer(
    customerID int,
    emailAddress varchar(50) unique NOT NULL,
    postal_code varchar(10),
    street varchar(50),
    firstName varchar(30) NOT NULL,
    surname varchar(30) NOT NULL,
    telephoneNr varchar(30) unique,
    CONSTRAINT customer_pk PRIMARY KEY (customerID)
);

CREATE TABLE delivery(
    orderID int,
    type varchar(10) NOT NULL,
    deliveryDate date NOT NULL,
    CONSTRAINT delivery_pk PRIMARY KEY (orderID)
);

CREATE TABLE employee(
    employeeID int,
    firstName varchar(30) NOT NULL,
    surname varchar(30) NOT NULL,
    telephoneNr varchar(30) unique NOT NULL,
    workingHours float NOT NULL,
    paycheck float NOT NULL,
    postal_code varchar(10) NOT NULL,
    street varchar(50) NOT NULL,
    position varchar(20) NOT NULL,
    CONSTRAINT employee_pk PRIMARY KEY (employeeID),
    CHECK (workingHours >= 0),
    CHECK (paycheck >= 0)
);

CREATE TABLE postal_code( --to avoid redundancy sparked by city/postalcode in employee and customer
    pc varchar(10),
    city_name varchar(30) UNIQUE NOT NULL,
    country_abbr varchar(10) NOT NULL,
    CONSTRAINT postal_codes_pk PRIMARY KEY (pc) 
);


CREATE TABLE product(
    productID int,
    name varchar(30) NOT NULL,
    inStock int NOT NULL,
    supplier varchar(50) NOT NULL,
    price float NOT NULL,
    categoryID int NOT NULL,
    CONSTRAINT product_pk PRIMARY KEY (productID),
    CHECK (inStock >= 0),
    CHECK (price >= 0)
);

CREATE TABLE category(
    categoryID int,
    name varchar(30) NOT NULL,
    CONSTRAINT category_pk PRIMARY KEY (categoryID)
);

CREATE TABLE targetGroup(
    name varchar(30),
    CONSTRAINT tg_pk PRIMARY KEY (name)
);

CREATE TABLE worksON(
    employeeID int,
    orderID int,
    CONSTRAINT worksON_pk PRIMARY KEY (employeeID, orderID)
);

CREATE TABLE refers(
    customer1ID int NOT NULL,
    customer2ID int NOT NULL,
    CONSTRAINT refers_pk PRIMARY KEY (customer1ID,customer2ID),
    CHECK (customer1ID != customer2ID)
);

CREATE TABLE has1(
    orderID int,
    customerID int NOT NULL,
    CONSTRAINT has1_pk PRIMARY KEY (orderID)
);

CREATE TABLE has2(
    orderID int,
    productID int,
    amount int,
    CONSTRAINT has2_pk PRIMARY KEY (orderID,productID)
);

CREATE TABLE hasTargetGroup(
    TGName varchar(30),
    categoryID int,
    CONSTRAINT hasTargetGroup PRIMARY KEY (TGName, categoryID)
);

CREATE SEQUENCE seq_orderid
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
    
CREATE SEQUENCE seq_customerid
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
    
CREATE SEQUENCE seq_employeeid
START WITH 1
MINVALUE 1
INCREMENT BY 1
CACHE 100;

CREATE SEQUENCE seq_productid
    START WITH 1
    MINVALUE 1
    INCREMENT BY 1
    CACHE 100;
    
CREATE SEQUENCE seq_categoryid
START WITH 1
MINVALUE 1
INCREMENT BY 1
CACHE 100;


CREATE OR REPLACE TRIGGER tri_orderid
    BEFORE INSERT ON orderr
    FOR EACH ROW
    BEGIN
        SELECT seq_orderid.nextval
        INTO: new.orderID
        FROM dual;
    END;
/

CREATE OR REPLACE TRIGGER tri_customerid
    BEFORE INSERT ON customer
    FOR EACH ROW
    BEGIN
        SELECT seq_customerid.nextval
        INTO: new.customerID
        FROM dual;
    END;
/

CREATE OR REPLACE TRIGGER tri_employeeid
    BEFORE INSERT ON employee
    FOR EACH ROW
    BEGIN
        SELECT seq_employeeid.nextval
        INTO: new.employeeID
        FROM dual;
    END;
/

CREATE OR REPLACE TRIGGER tri_productid
    BEFORE INSERT ON product
    FOR EACH ROW
    BEGIN
        SELECT seq_productid.nextval
        INTO: new.productID
        FROM dual;
    END;
/

CREATE OR REPLACE TRIGGER tri_categoryid
    BEFORE INSERT ON category
    FOR EACH ROW
    BEGIN
        SELECT seq_categoryid.nextval
        INTO: new.categoryID
        FROM dual;
    END;
/

CREATE OR REPLACE PROCEDURE p_delete_postal_code (postalcode IN postal_code.pc%TYPE, errorcode OUT number) 
IS
BEGIN 
    DELETE FROM postal_code
    WHERE postal_code.pc = postalcode;
    errorcode := SQL%ROWCOUNT;
    IF (errorcode = 1)
    THEN
        COMMIT;
    ELSE
        ROLLBACK;
    END IF;
    EXCEPTION WHEN OTHERS THEN
    errorcode := SQLCODE;
END;
/

CREATE OR REPLACE PROCEDURE p_delete_customer (cid IN customer.customerid%TYPE, errorcode OUT number) 
IS
BEGIN 
    DELETE FROM customer
    WHERE customer.customerid = cid;
    errorcode := SQL%ROWCOUNT;
    IF (errorcode = 1)
    THEN
        COMMIT;
    ELSE
        ROLLBACK;
    END IF;
    EXCEPTION WHEN OTHERS THEN
    errorcode := SQLCODE;
END;
/

CREATE OR REPLACE PROCEDURE p_delete_product (pid IN product.productid%TYPE, errorcode OUT number) 
IS
BEGIN 
    DELETE FROM product
    WHERE product.productid = pid;
    errorcode := SQL%ROWCOUNT;
    IF (errorcode = 1)
    THEN
        COMMIT;
    ELSE
        ROLLBACK;
    END IF;
    EXCEPTION WHEN OTHERS THEN
    errorcode := SQLCODE;
END;
/

CREATE OR REPLACE PROCEDURE p_delete_order (oid IN orderr.orderid%TYPE, errorcode OUT number) 
IS
BEGIN 
    DELETE FROM orderr
    WHERE orderr.orderid = oid;
    errorcode := SQL%ROWCOUNT;
    IF (errorcode = 1)
    THEN
        COMMIT;
    ELSE
        ROLLBACK;
    END IF;
    EXCEPTION WHEN OTHERS THEN
    errorcode := SQLCODE;
END;
/

ALTER SESSION SET NLS_DATE_FORMAT = 'DD.MM.YY';

ALTER TABLE customer ADD CONSTRAINT customer_fk FOREIGN KEY (postal_code) REFERENCES postal_code(pc) ON DELETE SET NULL;
ALTER TABLE employee ADD CONSTRAINT employee_fk FOREIGN KEY (postal_code) REFERENCES postal_code(pc) ON DELETE SET NULL;
ALTER TABLE orderr ADD CONSTRAINT orderr_fk FOREIGN KEY (customerID) REFERENCES customer(customerID) ON DELETE CASCADE;
ALTER TABLE delivery ADD CONSTRAINT delivery_fk FOREIGN KEY (orderID) REFERENCES orderr(orderID) ON DELETE CASCADE;
ALTER TABLE product ADD CONSTRAINT product_fk FOREIGN KEY (categoryID) REFERENCES category(categoryID) ON DELETE SET NULL;
ALTER TABLE worksOn ADD CONSTRAINT worksOn_fk1 FOREIGN KEY (employeeID) REFERENCES employee(employeeID) ON DELETE CASCADE;
ALTER TABLE worksOn ADD CONSTRAINT worksOn_fk2 FOREIGN KEY (orderID) REFERENCES orderr(orderID) ON DELETE CASCADE;
ALTER TABLE refers ADD CONSTRAINT refers_fk1 FOREIGN KEY (customer1ID) REFERENCES customer(customerID) ON DELETE CASCADE;
ALTER TABLE refers ADD CONSTRAINT refers_fk2 FOREIGN KEY (customer2ID) REFERENCES customer(customerID) ON DELETE CASCADE;
ALTER TABLE has1 ADD CONSTRAINT has1_fk1 FOREIGN KEY (orderID) REFERENCES orderr(orderID) ON DELETE CASCADE;
ALTER TABLE has1 ADD CONSTRAINT has1_fk2 FOREIGN KEY (customerID) REFERENCES customer(customerID) ON DELETE CASCADE;
ALTER TABLE has2 ADD CONSTRAINT has2_fk1 FOREIGN KEY (orderID) REFERENCES orderr(orderID) ON DELETE CASCADE;
ALTER TABLE has2 ADD CONSTRAINT has2_fk2 FOREIGN KEY (productID) REFERENCES product(productID) ON DELETE CASCADE;
ALTER TABLE hasTargetGroup ADD CONSTRAINT hasTG_fk1 FOREIGN KEY (TGName) REFERENCES TargetGroup(name) ON DELETE CASCADE;
ALTER TABLE hasTargetGroup ADD CONSTRAINT hasTG_fk2 FOREIGN KEY (categoryID) REFERENCES category(categoryID) ON DELETE CASCADE;




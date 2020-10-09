<?php
/** 
 * Stored procedures 
 * 
 * PROCEDURE (IN/OUT)
 * FUNCTION (IN) RETURN
 */
$db = new Pdo_dump(CONN, 'user', 'pass', [
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true 
]);

$db->exec("USE classicmodels;");
$db->exec(<<<Q
DROP PROCEDURE IF EXISTS search_classic;
CREATE PROCEDURE search_classic (
    IN cname VARCHAR(10),
    OUT output_total INT(3),
    INOUT counter INT
) 
NOT DETERMINISTIC 
NO SQL 
COMMENT 'search' 
SQL SECURITY INVOKER
BEGIN
    DECLARE totalSales, sumSales DEC(10, 2) DEFAULT 0.0;
    DECLARE credit, credit2 INT DEFAULT 0;
    DECLARE pCustomerLevel VARCHAR(15);
    SET counter = counter + 1;
    SELECT COUNT(customerName) INTO output_total
    FROM customers AS c1 WHERE customerName LIKE cname;
    SELECT count(creditLimit), COUNT(creditLimit)+1 INTO credit, credit2
    FROM customers AS c2 WHERE customerNumber LIKE '%17%';
    IF credit > 50000 THEN
        SET pCustomerLevel = 'PLATINUM';
    ELSEIF credit <= 50000 AND credit > 10000 THEN
        SET pCustomerLevel = 'GOLD';
    ELSE
        SET pCustomerLevel = 'SILVER';
    END IF;
END
Q);

/*
issue: "Result consisted of more than one row"
SELECT customerName INTO output_total
fix: 
SELECT COUNT(customerName) INTO output_total
*/
/*
Issue: "The used SELECT statements have a different number of columns"
SELECT COUNT(creditLimit), COUNT(creditLimit) INTO credit
Fix:
SELECT COUNT(creditLimit), COUNT(creditLimit) INTO credit, credit2
*/
$db->exec("ALTER PROCEDURE search_classic COMMENT 'search';");
$db->exec("SET @counter = 1;");
$stmt = $db->query("CALL search_classic('%ltd%', @total_passed, @counter);");
$stmt = $db->query("SELECT @total_passed as total, @counter as counted");

// -------case---------
/*
CASE customerCountry
        WHEN  'USA' THEN
           SET pShipping = '2-day Shipping';
        WHEN 'Canada' THEN
           SET pShipping = '3-day Shipping';
        WHEN waitingDay >= 1 AND waitingDay < 5 THEN
            SET pDeliveryStatus = 'Late';
        ELSE
           SET pShipping = '5-day Shipping';
    END CASE;
*/
// -loop-----------------
// WITH LABEL(cur_proc)
// ITERATE ~> next
$db->exec(<<<Q
DROP PROCEDURE IF EXISTS loop_demo;
CREATE PROCEDURE loop_demo(
    IN inside INT
)
cur_proc: 
BEGIN
    DECLARE x INT;
    DECLARE str VARCHAR(255);
        
    SET x = 1;
    SET str = '';
        
    loop_label: 
    LOOP
        IF x > 10 THEN 
            LEAVE loop_label;
        END  IF;
            
        SET x = x + 1;
        IF (x mod 2) THEN
            ITERATE loop_label;
        ELSE
            SET str = CONCAT(str, x, ',');
        END  IF;
    END LOOP;
    SELECT str;
END
Q);

// --repeat ----------------------
/*
[label]: REPEAT
    SET result = CONCAT(result,counter,',');
    SET counter = counter + 1;
UNTIL counter >= 10
END REPEAT [label];
*/

// --while--------------
/*
[label]: WHILE counter <= day DO
    CALL InsertCalendar(dt);
    SET counter = counter + 1;
    SET dt = DATE_ADD(dt,INTERVAL 1 day);
END WHILE [label];
*/

// -- LEAVE ---------------
/*
IF inside = 0 THEN
    LEAVE <label>;
END IF;
*/

// - call ----------------------
//CALL LeaveDemo(@result);
//SELECT @result;
// -------------------Show
$s = $db->query("SHOW PROCEDURE STATUS LIKE 'search%';");
// Root: SELECT routine_name FROM information_schema.routines
                                    /**********
                                    * FUNCTION
                                    **********/
/*
* function return a value
A deterministic function always returns the same result for the same input parameters (~ hard-code)
a {non-deterministic - default} function returns different results for the same input parameters. 
*/
/*
CREATE FUNCTION function_name(
    param1,
    param2,…
)
RETURNS datatype
[NOT] DETERMINISTIC
BEGIN
    -- statements
END $$
*/


                                        /************
                                         * cursor
                                         ***********/
/* - Read-only, non-scrollable(only forward), asensitive(point to real data)
 * -> declare, open, fetch, not found?, close
 * 
 * DECLARE cursor_name CURSOR FOR SELECT_statement;
 * OPEN cursor_name;
 * FETCH cursor_name INTO variables list;
 * CLOSE cursor_name;
 * DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
 */
/*
- sample -
CREATE PROCEDURE createEmailList (
    INOUT emailList varchar(4000)
)
BEGIN
    DECLARE finished INTEGER DEFAULT 0;
    DECLARE emailAddress varchar(100) DEFAULT "";
    -- declare cursor for employee email
    DECLARE curEmail 
        CURSOR FOR 
            SELECT email FROM employees;
    -- declare NOT FOUND handler
    DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;
    OPEN curEmail;
    getEmail: LOOP
        FETCH curEmail INTO emailAddress;
        IF finished = 1 THEN 
            LEAVE getEmail;
        END IF;
        -- build email list
        SET emailList = CONCAT(emailAddress,";",emailList);
    END LOOP getEmail;
    CLOSE curEmail;
END//
SET @emailList = ""; 
CALL createEmailList(@emailList); 
SELECT @emailList;
*/


                                        /*********
                                         *  Error
                                         ********/
/*
DECLARE {action CONTINUE|EXIT} HANDLER FOR {condition_value sqlstate SQLWARNING|SQLEXCEPTION|NOT FOUND} begin_end_or_select_statement;
DECLARE {action CONTINUE|EXIT} HANDLER FOR {NOT FOUND} begin_end_or_select_statement;
*/
/*
- sample -
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION 
SET hasError = 1;
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
END;
DECLARE CONTINUE HANDLER FOR NOT FOUND 
SET RowNotFound = 1;
DECLARE CONTINUE HANDLER FOR 1062 --(1062: duplicate key)
SELECT 'Error, duplicate key occurred';
*/
/*
- sample -
CREATE PROCEDURE InsertSupplierProduct(
    IN inSupplierId INT, 
    IN inProductId INT
)
BEGIN
    -- condition sample --------------
    DECLARE DuplicateKey  CONDITION for 1062; 
    DECLARE TableNotFound CONDITION for 1146; 
    DECLARE division_by_zero CONDITION FOR SQLSTATE '22012';
    -- samples ------------------------
    -- exit if the duplicate key occurs
    DECLARE EXIT HANDLER FOR 1062 
        SELECT 'Duplicate keys error encountered' Message; 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
        SELECT 'SQLException encountered' Message; 
    DECLARE EXIT HANDLER FOR SQLSTATE '23000' 
        SELECT 'SQLSTATE 23000' ErrorCode;
    DECLARE EXIT HANDLER FOR TableNotFound 
        SELECT 'Please create table abc first' Message; 
    SELECT * FROM abc;
    -- exit if the duplicate key occurs
    DECLARE EXIT HANDLER FOR 1062
    BEGIN
        SELECT CONCAT('Duplicate key (',inSupplierId,',',inProductId,') occurred') AS message;
    END;
    
    -- insert a new row into the SupplierProducts
    INSERT INTO SupplierProducts(supplierId,productId)
    VALUES(inSupplierId,inProductId);
    
    -- return the products supplied by the supplier id
    SELECT COUNT(*) 
    FROM SupplierProducts
    WHERE supplierId = inSupplierId;
    
END$$ 
*/


                                    /******** 
                                    * SIGNAL
                                    *********/
/*
- throw an error -
SIGNAL SQLSTATE | condition_name;
SET {condition_information1 MESSAGE_TEXT, MYSQL_ERRORNO, CURSOR_NAME, etc...} = value_1, 
    {condition_information2 MESSAGE_TEXT, MYSQL_ERRORNO, CURSOR_NAME, etc...} = value_2, etc;
RESIGNAL (within ERROR handler)
*/
/*
    DECLARE CONTINUE HANDLER FOR division_by_zero 
    -- check if orderNumber exists
    IF(C != 1) THEN 
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Order No not found in orders table';
    END IF; 
    
    -- resignal
    RESIGNAL SET MESSAGE_TEXT = 'Division by zero / Denominator cannot be zero';
    
    -- 
    IF denominator = 0 THEN
        SIGNAL division_by_zero;
    ELSE
        SET result := numerator / denominator;
    END IF;
*/
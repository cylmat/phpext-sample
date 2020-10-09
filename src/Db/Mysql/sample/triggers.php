<?php
/**
 * Triggers
 */
$db = new Pdo_dump(CONN, 'user', 'pass', [
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true 
]);

/*
 * Response to insert, update, delete
 * Row-level trigger or statement-level trigger (not supported in mysql)
 * Extended validations over NOT NULL, UNIQUE, CHECK and FOREIGN KEY
 * 
 * use OLD and NEW
*/
/*
CREATE TRIGGER trigger_name
{BEFORE | AFTER} {INSERT | UPDATE| DELETE }
ON table_name FOR EACH ROW
    {FOLLOWS|PRECEDES} existing_trigger_name   (for mysql 5.7.2+)
[begin] trigger_body [end];
SHOW TRIGGERS {FROM|IN} classicmodels WHERE `table` = 'products';
SELECT  trigger_name, action_order FROM information_schema.triggers WHERE trigger_schema = 'classicmodels'
DROP TRIGGER [IF EXISTS] [schema_name.]trigger_name;
*/
/*
    BEFORE INSERT trigger, you can access and change the NEW values.
    BEFORE UPDATE trigger, you can update the NEW values but cannot update the OLD values
    BEFORE DELETE trigger, you can access the OLD row but cannot update it.
    AFTER INSERT trigger, you can access the NEW values but you cannot change them
    AFTER UPDATE trigger, you can access OLD and NEW rows but cannot update them
    AFTER DELETE trigger, you can access the OLD row but cannot change it.
*/
$db->exec(<<<Q
DROP TRIGGER IF EXISTS before_employee_update;
CREATE TRIGGER before_employee_update 
    {BEFORE|AFTER} {INSERT|UPDATE|DELETE} ON employees
    FOR EACH ROW 
INSERT INTO employees_audit
SET action = 'update',
     employeeNumber = OLD.employeeNumber,
     lastname = OLD.lastname,
     changedat = NOW();
Q);

/*
- sample signal -
DELIMITER $$
CREATE TRIGGER before_billing_update
    BEFORE UPDATE 
    ON billings FOR EACH ROW
BEGIN
    IF new.amount > old.amount * 10 THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'New amount cannot be 10 times greater than the current amount.';
    END IF;
END$$   
DELIMITER ;
 */
/*
AFTER UPDATE ON sales FOR EACH ROW
BEGIN
    IF OLD.quantity <> new.quantity THEN
        INSERT INTO SalesChanges(salesId,beforeQuantity, afterQuantity)
        VALUES(old.id, old.quantity, new.quantity);
    END IF;
END
*/

/*********************************************************
 *                      EVENTS
 ******************************************************/
/*
SET GLOBAL event_scheduler = {ON|OFF};
SHOW PROCCESS LIST
CREATE EVENT [IF NOT EXIST] event_name
ON SCHEDULE AT timestamp [+ INTERVAL]
[ON COMPLETION PRESERVE] --keep running
DO
event_body
*/
$db = new class { function exec($s) {} }; // empty
$db->exec(<<<Q
DROP EVENT IF EXIST test_event_03;
CREATE EVENT test_event_02
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE
DO
   INSERT INTO messages(message,created_at)
   VALUES('Test MySQL Event 2',NOW());
Q);

$db->exec(<<<Q
DROP EVENT IF EXIST test_event_03;
CREATE EVENT test_event_03
ON SCHEDULE EVERY 1 MINUTE
STARTS CURRENT_TIMESTAMP
ENDS CURRENT_TIMESTAMP + INTERVAL 1 HOUR
DO
   INSERT INTO messages(message,created_at)
   VALUES('Test MySQL recurring Event', NOW());
Q);

/*
SHOW EVENTS FROM classicmodels;
 * 
 * ALTER EVENT event_name
ON SCHEDULE schedule
ON COMPLETION [NOT] PRESERVE
RENAME TO new_event_name
ENABLE | DISABLE
DO
  event_body
  --sample
ALTER EVENT test_event_04 ON SCHEDULE EVERY 2 MINUTE;
ALTER EVENT test_event_04 {ENABLE|DISABLE};
ALTER EVENT test_event_04 RENAME TO test_event_05;
ALTER EVENT classicmodels.test_event_05 RENAME TO newdb.test_event_05;
 */
//-----------------------------------------------
/*
MySQL triggers cannot:
    Use SHOW, LOAD DATA, LOAD TABLE, BACKUP DATABASE, RESTORE, FLUSH and RETURN statements.
    Use statements that commit or rollback implicitly or explicitly such as COMMIT , ROLLBACK , START TRANSACTION , LOCK/UNLOCK TABLES , ALTER , CREATE , DROP ,  RENAME.
    Use prepared statements such as PREPAREand EXECUTE.
    Use dynamic SQL statements.
*/


/**********************
 * ERRORS
 *****************/

/*---------------HANDLER
https://dev.mysql.com/doc/refman/5.7/en/declare-handler.html

-------------CONDITION
https://dev.mysql.com/doc/refman/5.7/en/declare-condition.html

------------SIGNAL
https://dev.mysql.com/doc/refman/5.7/en/signal.html


DROP TRIGGER bu_customer;
DELIMITER //
CREATE TRIGGER bu_customer
BEFORE UPDATE ON customers FOR EACH ROW
BEGIN
    DECLARE ownError9 CONDITION FOR SQLSTATE '45999';
    DECLARE ownError CONDITION FOR SQLSTATE '45001';

    DECLARE EXIT HANDLER FOR SQLSTATE '45900'
        SIGNAL SQLSTATE '45001' SET MESSAGE_TEXT = "err-handled9";

    DECLARE CONTINUE HANDLER FOR ownError
        SET @custom_warnings = 'Warning';

    DECLARE EXIT HANDLER FOR ownError9
        SIGNAL ownError SET MESSAGE_TEXT = "err-handled1";

    SIGNAL SQLSTATE '45005' SET MESSAGE_TEXT = "err-throws";
    SIGNAL ownError SET MESSAGE_TEXT = "err-throws9";
END//
DELIMITER ;
UPDATE customers SET creditLimit = 31000.00 WHERE customerNumber = 503;
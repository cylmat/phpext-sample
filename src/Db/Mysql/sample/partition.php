<?php
/*******************
 * Partitionnement *
 ******************/
$db = new Pdo_dump(CONN, 'user', 'pass', [
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true 
]);
/******************************
 *      SAMPLE
 * ref: https://krierjon.developpez.com/mysql/partitionnement/
 * 
 *  RANGE or LIST. 
 *      Subpartitions may use either HASH or KEY p
 ****************************/
$db->exec(<<<Q
DROP TABLE trans;
CREATE TABLE IF NOT EXISTS trans (
   id INT UNSIGNED,
   montant INT UNSIGNED NOT NULL,
   jour DATE NOT NULL,
   codePays ENUM('FR', 'BE', 'UK', 'US', 'CA', 'JP') NOT NULL,
   PRIMARY KEY `primary_on_id` (`id`, `montant`)
) ENGINE=InnoDB CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci;
Q); 
/*******
 * RANGE
 */
# an index key must be included!
#  PRIMARY KEY `primary_on_id` (`id`) : doesn't work
#  PRIMARY KEY `primary_on_id` (`id`, `montant`) : yes!
$db->exec(<<<Q
ALTER TABLE trans
PARTITION BY RANGE(montant) (
    PARTITION m1 VALUES LESS THAN(100) ENGINE = MyISAM,
    PARTITION m2 VALUES LESS THAN MAXVALUE ENGINE = Memory
);
Q); 
// CAN -NOT- MIX ENGINES !
$db->exec(<<<Q
ALTER TABLE trans
PARTITION BY RANGE(montant) 
SUBPARTITION BY HASH(id) (
    PARTITION m1 VALUES LESS THAN (100) (
        SUBPARTITION s0,
        SUBPARTITION s1
    ),
    PARTITION m2 VALUES LESS THAN (200) (
        SUBPARTITION s2,
        SUBPARTITION s3
    ),
    PARTITION m3 VALUES LESS THAN MAXVALUE (
        SUBPARTITION s4,
        SUBPARTITION s5
    )
);
Q); 
/*******
 * LIST
 */
/*$db->exec(<<<Q
ALTER TABLE trans
PARTITION BY LIST(<column>) (
    PARTITION l1 VALUES IN (2,3),
    PARTITION l2 VALUES IN (0,1)
);
Q); */
// ADD
// ALTER TABLE trans ADD PARTITION (PARTITION p2 VALUES IN (7, 14, 21));
/*****
 * HASH, KEY
 */
$db->exec(<<<Q
ALTER TABLE trans PARTITION BY HASH(id) PARTITIONS 8;
Q);
$db->exec(<<<Q
ALTER TABLE trans PARTITION BY LINEAR KEY(id) PARTITIONS 6; --same number of keys
Q);
/********
 * REMOVE
 */
//ALTER TABLE e2 REMOVE PARTITIONING;
                            
/**
 * SAMPLE
 */
// insert into trans values (3, 95, date(now()), 'fr');
// explain select * from trans where montant=95;
$db->exec(<<<Q
CREATE TABLE IF NOT EXISTS trans_part (
    id INT UNSIGNED NOT NULL,
    montant INT UNSIGNED NOT NULL,
    jour DATE NOT NULL,
    codePays ENUM('FR', 'BE', 'UK', 'US', 'CA', 'JP') NOT NULL,
    INDEX `index_on_year` (`jour`)
) ENGINE=InnoDB CHARACTER SET=utf8mb4 COLLATE=utf8mb4_general_ci 
PARTITION BY RANGE(YEAR(jour)) (
   PARTITION p1 VALUES LESS THAN(1997),
   PARTITION p2 VALUES LESS THAN(1998),
   PARTITION p3 VALUES LESS THAN(1999),
   PARTITION p4 VALUES LESS THAN(2000),
   PARTITION p5 VALUES LESS THAN(2001),
   PARTITION p6 VALUES LESS THAN(2002),
   PARTITION p7 VALUES LESS THAN(2003),
   PARTITION p8 VALUES LESS THAN(2004),
   PARTITION p9 VALUES LESS THAN(2005),
   PARTITION p10 VALUES LESS THAN(2006),
   PARTITION p11 VALUES LESS THAN MAXVALUE
);
Q);
$proc_exists = null;
#$proc = $db->query("SHOW PROCEDURE STATUS WHERE Name LIKE '%remplir%';"); //dont use exec()
#$proc && $proc_exists = $proc->fetch();
if (!$proc_exists) { 
    $db->beginTransaction();
# DELIMITER //
    $db->exec(<<<Q
DROP PROCEDURE IF EXISTS remplir_transaction;
CREATE PROCEDURE remplir_transaction(IN nbTransacs INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE nbAlea DOUBLE;
    DECLARE _jour DATE;
    DECLARE _montant INT UNSIGNED;
    DECLARE _codePays TINYINT UNSIGNED;
    WHILE i <= nbTransacs DO
        SET nbAlea = RAND();
        SET _jour = ADDDATE('1996-01-01', FLOOR(nbAlea * 4015));
        SET _montant = FLOOR(1 + (nbAlea * 9999));
        SET nbAlea = RAND();
        SET _codePays = FLOOR(1 + (nbAlea * 6));
        INSERT INTO trans (id, montant, jour, codePays) VALUES (i, _montant, _jour, _codePays);
        SET i = i + 1;
    END WHILE;
END;
Q);
# DELIMITER ;
    $db->commit();
}
if($db->errorInfo()[2])var_dump($db->errorInfo());
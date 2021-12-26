<?php

namespace Phpext\Db\Mysql;

/*****************************
 * MASTER - SLAVE
 ************************/
/*
CONFIGURATION MASTER
*/
/*
- mysql.cnf
log_bin=mysql-bin # MANDATORY!
server_id=1
- sql
CREATE USER "repl"@"localhost" IDENTIFIED BY "pass";
GRANT REPLICATION SLAVE on *.* to "repl"@"localhost";
SHOW MASTER STATUS; # -> bin, position
- shell:
mysqldump -u root -p --database test1 > test1.sql
scp test1.sql root@192.168.1.21:/root
mysql -u root -p < test1.sql
*/
/*
CONFIGURATION SLAVE
*/
/*
- mysql.cnf
server_id=2
CHANGE MASTER TO
    MASTER_HOST='mysql',
    MASTER_USER='root',
    MASTER_PASSWORD='root',
    MASTER_LOG_FILE='mysql-bin.000002',
    MASTER_LOG_POS=154;
- SQL
STOP SLAVE;
CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.000002', MASTER_LOG_POS=154; 
START SLAVE;
SHOW SLAVE STATUS\G;
    Slave_IO_State: Waiting for...
    Slave_IO_Running: Yes
    Slave_SQL_Running: Yes
*/


/*****************************
 * MASTER - MASTER
 ************************/
# 1) SHOW MASTER STATUS;
# 2) CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.<from1>', MASTER_LOG_POS=<from1>; 
# 2) SHOW MASTER STATUS;
# 1) CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.<from2>', MASTER_LOG_POS=<from2>;


/*****************************
 * RESYNCHRO AFTER DOWN
 ************************/
// - verifier data
// SHOW MASTER STATUS - SHOW SLAVE STATUS -> "position" <> "Read/Exec_Master_Log_Pos"
// - stop master
// RESET MASTER; FLUSH TABLES WITH READ LOCK; SHOW MASTER STATUS;
//     ->exporter les données (manquantes)
// UNLOCK TABLES;
// - slave
// STOP SLAVE;
// CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.<new_index>', MASTER_LOG_POS=<newpos>; 
// START SLAVE; SHOW SLAVE STATUS;

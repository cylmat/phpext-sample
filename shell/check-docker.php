<?php

class Check
{
    static function pdo(string $type, string $dsn)
    {
        try {
            $pdo = new PDO($dsn, $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
            $pdo->exec("SET CHARACTER SET utf8");
            $pdo->exec("CREATE TABLE IF NOT EXISTS tests_my (id INT, my TEXT);");
            $pdo->exec("TRUNCATE TABLE tests_my;");
            $pdo->exec('INSERT INTO tests_my (id, my) VALUES (96, " '.$type.':ok ") ON DUPLICATE KEY UPDATE id=id;');
            $r = $pdo->query("SELECT * FROM tests_my");
            if (false === $r) throw new PDOException("Query failed");
            if(is_array($res = $r->fetch())) {
                echo $res['my'] . PHP_EOL;
            }
        } catch (PDOException $e) {
            echo " $type:".$e->getMessage().PHP_EOL;
        }
    }
}

Check::pdo('mysql','mysql:host=mysql;dbname=mydb');
Check::pdo('mysql2','mysql:host=mysql2;dbname=my2db'); //second one
Check::pdo('mysqlr','mysql:host=mysqlr;dbname=myrdb'); //replicas
Check::pdo('maria','mysql:host=mariadb;dbname=madb');
Check::pdo('postgres','pgsql:host=postgres;port=5432;dbname=pgdb'); //postgres
Check::pdo('sqlite','sqlite:/sqlite/sqlite.db3'); //postgres


try {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=pgdb', $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    $pdo->exec("SET CHARACTER SET utf8");
    $pdo->exec("CREATE TABLE IF NOT EXISTS tests_my (id INT, my TEXT);");
    $pdo->exec("TRUNCATE TABLE tests_my;");
    $pdo->exec('INSERT INTO tests_my (id, my) VALUES (96, " pg:ok ") ON DUPLICATE KEY UPDATE id=id;');
    $r = $pdo->query("SELECT * FROM tests_my");
    if (false === $r) throw new PDOException("Query failed");

    if($res = $r->fetch(PDO::FETCH_ASSOC)) {
        var_dump($res);
    } var_dump($res);
} catch (PDOException $e) {
    echo " $type:".$e->getMessage().PHP_EOL;
}

//mysql8
// try {
//     $pdo = new PDO("mysql:host=mysql8;port=3307;dbname=mydb8", $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
//     $pdo->exec("SET CHARACTER SET utf8");
//     $pdo->exec("CREATE TABLE IF NOT EXISTS tests_my (id INT, my TEXT);");
//     $pdo->exec("TRUNCATE TABLE tests_my;");
//     $pdo->exec('INSERT INTO tests_my (id, my) VALUES (96, " mysql-ok ") ON DUPLICATE KEY UPDATE id=id;');
//     $r = $pdo->query("SELECT * FROM tests_my");
//     if (false === $r) throw new PDOException("Query failed");
//     echo $r->fetch()['my'] . PHP_EOL;
// } catch (PDOException $e) {
//     echo " MY8:".$e->getMessage().PHP_EOL;
// }



// odbc mysql
$connection = odbc_connect("DRIVER={MySQL ODBC 8.0 Unicode Driver};Server=mysql;Database=mydb;Port=3306;String Types=Unicode", $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
if(!$connection) {
    echo ' ODBC fail connection '.PHP_EOL;
}
odbc_exec($connection,'INSERT INTO tests_my (id, my) VALUES (21, " odbc-ok ")');
$res = odbc_exec($connection, "SELECT * FROM tests_my WHERE id=21");
odbc_fetch_row ($res, 0);
if($r = odbc_result($res, 'my')) {
    echo $r.PHP_EOL;
} else {
    echo ' ODBC:fail query '.PHP_EOL;
}
odbc_close($connection);


/***********************  cache */
/** DBA */
    //echo (implode(' ',dba_handlers())); //=> cdb, cdb_make, db4, inifile, flatfile, qdbm, lmdb
    $dba = dba_open("/tmp/test.db4", "n", "db4"); //n: rwc
    if (!$dba) {
        echo " dba_open failed \n";
    }
    dba_replace("key", " dba-ok ".PHP_EOL, $dba);
    if (dba_exists("key", $dba)) {
        echo dba_fetch("key", $dba);
        dba_delete("key", $dba);
    } else {
        echo " DBA:failed \n";
    }
    dba_close($dba);


try {
    $mc = new Memcached; 
    $mc->addServer("memcached", 11211); 
    $mc->set("test", " memcached-ok "); 
    echo $mc->get("test").PHP_EOL;
} catch(\Exception $e) {
    echo $e->getMessage().PHP_EOL;
}

try { 
    $redis = new Redis;
    $redis->connect('redis',6379);
    $redis->set("key", " redis-ok ");
    echo $redis->get("key").PHP_EOL;
} catch(\Exception $e) {
    echo $e->getMessage().PHP_EOL;
}


/************************* lua */
try {
    $lua = new Lua;
    $lua->assign("phplua_var", " lua-ok "); 
    $lua->eval("print(phplua_var);").PHP_EOL;
} catch(\Exception $e) {
    echo $e->getMessage().PHP_EOL;
}


/********* sodium */

/******** swoole */

/********** zlib */

echo PHP_EOL;

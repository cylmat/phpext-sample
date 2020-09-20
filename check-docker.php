<?php

/* mysql */
try {
    $pdo = new PDO("mysql:host=mysql;port=3306;dbname=mydb", $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
    $pdo->exec("SET CHARACTER SET utf8");
    $pdo->exec("CREATE TABLE IF NOT EXISTS tests_my (id INT, my TEXT);");
    $pdo->exec("TRUNCATE TABLE tests_my;");
    $pdo->exec('INSERT INTO tests_my (id, my) VALUES (96, " mysql-ok ") ON DUPLICATE KEY UPDATE id=id;');
    $r = $pdo->query("SELECT * FROM tests_my");
    if (false === $r) throw new PDOException("Query failed");
    echo $r->fetch()['my'] . PHP_EOL;
} catch (PDOException $e) {
    echo " MY:".$e->getMessage().PHP_EOL;
}
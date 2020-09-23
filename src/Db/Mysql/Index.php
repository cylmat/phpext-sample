<?php

namespace Db\Mysql;

class Index
{   
    function index()
    {
        //UTF-8
        $dbh = mysqli_connect('mysql81','user','pass','db');
        $dbh->set_charset('utf8mb4'); // object oriented style
        mysqli_set_charset($dbh, 'utf8mb4'); // procedural style

        $res = $dbh->query('DROP TABLE db.test');
        $res = $dbh->query('CREATE TABLE IF NOT EXISTS db.test (user VARCHAR(200) NOT NULL) ENGINE=InnoDB;');
        $r = mysqli_fetch_all($dbh->query("SELECT * FROM db.test"));
        if(!count($r)) {
            $dbh->query("INSERT INTO db.test (user) VALUES ('john')");
            echo $dbh->error;
        }
        $r = mysqli_fetch_all($dbh->query("SELECT * FROM test"), MYSQLI_ASSOC);
        echo $dbh->error;
        foreach($r as $row) {
            echo $row['user'];
        }
    }
}
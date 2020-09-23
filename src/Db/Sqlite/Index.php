<?php

namespace Db\Sqlite;

class Index
{   
    function index()
    {
        ####################################
        # https://www.sqlite.org/inmemorydb.html
        ####################################

        //try in-memory sqlite
        $dbh = new \PDO('sqlite::memory:');
        
        $dbh->exec("CREATE TABLE testing (user int);");
        $smt = $dbh->prepare("INSERT INTO testing (user) VALUES (:try)");
        $smt->bindValue(':try', 'john');
        $smt->execute();
        $res = $dbh->query("SELECT * FROM testing");
        foreach ($res->fetchAll() as $row) {
            echo implode('',$row);
        }
    }
}
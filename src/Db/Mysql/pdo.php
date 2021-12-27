<?php

namespace Phpext\Db\Mysql;

/**
 * \PDO sample
 */
$db = new \PDO("mysql:host=mysql;dbname=mydb", 'user', 'pass', [
    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_BOTH,
    \PDO::ATTR_PERSISTENT => false 
]);
$db->exec("SET NAMES UTF8");

\PDO::getAvailableDrivers(); //mysql, odbc, pgsql, sqlite

/**
 * Attributes
 */
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //ERRMODE_SILENT | ERRMODE_WARNING
$db->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_NATURAL); //NULL_EMPTY_STRING | NULL_TO_STRING
//columns
$db->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL); //CASE_LOWER | CASE_UPPER
//results
$db->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, true); //fetches to string
$db->setAttribute(\PDO::ATTR_AUTOCOMMIT, 1);
$db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1); //simulation requetes préparé si non supporté
//cache
$db->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); 
//stmt
$db->setAttribute(\PDO::ATTR_STATEMENT_CLASS, ['\PDOStatement']); 
$db->setAttribute(\PDO::ATTR_CURSOR , \PDO::CURSOR_FWDONLY); //CURSOR_FWDONLY | CURSOR_SCROLL

//get
//ATTR_DRIVER_NAME | ATTR_CONNECTION_STATUS | ATTR_SERVER_VERSION | ATTR_CLIENT_VERSION | ATTR_SERVER_INFO
$attr = $db->getAttribute(\PDO::ATTR_EMULATE_PREPARES); 

/**
 * Transact
 */
$db->beginTransaction();

/**
 * Query
 */
$db->exec("CREATE TABLE IF NOT EXISTS tl (id INT, testing VARCHAR(20)) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$count = $db->exec("INSERT INTO tl(id, testing) VALUES (5, 'vingt'), (9, 'trois'), (16, 'trente')");
$last = $db->lastInsertId();
$stmt = $db->query("SELECT * FROM tl");
#public \PDO::query ( string $statement , int $fetch_style = \PDO::FETCH_COLUMN , int $colno ) : \PDOStatement
#public \PDO::query ( string $statement , int $fetch_style = \PDO::FETCH_CLASS , string $classname , array $ctorargs ) : \PDOStatement
#public \PDO::query ( string $statement , int $fetch_style = \PDO::FETCH_INTO , object $object ) : \PDOStatement
$db->quote("Place d'été", \PDO::PARAM_STR) . "\n";

/**
 * Prepare
 */
$stmt = $db->prepare("SELECT * FROM tl WHERE 1=1 OR id=:inty OR testing=:couleur LIMIT 3", [
    \PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY, //CURSOR_SCROLL
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_BOTH,
    \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    \PDO::MYSQL_ATTR_DIRECT_QUERY => true, //pas de requête préparée
    \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, //desactive verification SSL
    \PDO::MYSQL_ATTR_FOUND_ROWS => true //return number of founded rows, not changed ones
    //\PDO::MYSQL_ATTR_MAX_BUFFER_SIZE => '1M', //not with mysqlnd 
    //\PDO::MYSQL_READ_DEFAULT_FILE => '<path/to/<file.cnf>'
]);

/**
 * Params
 */
$couleur = 'red';
//PARAM_STR | PARAM_BOOL | PARAM_NULL | PARAM_INT | PARAM_STR_CHAR | PARAM_L(arge)OB(ject) | PARAM_STMT | PARAM_INPUT_OUTPUT (stockée)
$stmt->bindParam(':couleur', $couleur, \PDO::PARAM_STR, 5); 
$stmt->bindValue(':inty', 8, \PDO::PARAM_INT); 
#$stmt->debugDumpParams();
$stmt->errorInfo(); //errorCode()

/**
 * Bind columns
 */
$stmt->execute([':couleur' => $couleur, ':inty' => 8]);
$count = $stmt->rowCount();
/* Lie par les numéros de colonnes */
$stmt->bindColumn(1, $id);
$stmt->bindColumn(2, $testing);
/* Lie par les noms de colonnes */
$stmt->bindColumn('id', $id);
$stmt->bindColumn('testing', $testing);
$stmt->setFetchMode(\PDO::FETCH_BOUND);
$bool = $stmt->fetch(\PDO::FETCH_BOUND);
$id . ' - ' . $testing; //echo
$count = $stmt->columnCount(); 
$testing = $stmt->fetchColumn(1);
$stmt->getColumnMeta(1); //type, \PDO_type, flags, table, name, len, precision

/**
 * Fetching
 */
$stmt->execute();
// \PDO::FETCH_ASSOC | FETCH_NAMED(column duplicate) | FETCH_KEY_PAIR
// FETCH_NUM | FETCH_BOTH | FETCH_BOUND | FETCH_INTO | FETCH_OBJ 
// FETCH_LAZY : combine \PDO::FETCH_BOTH et \PDO::FETCH_OBJ
// FETCH_CLASS | FETCH_CLASSTYPE | FETCH_PROPS_LATE 
$row = $stmt->fetch(\PDO::FETCH_ASSOC); 
$ids = array_column([$row], 'id');

$row = $stmt->fetch(\PDO::FETCH_LAZY); 
$testing_lazy = $row->testing;

$row = $stmt->fetch(\PDO::FETCH_OBJ); 
$testing = $row->testing;

$stmt = $db->query("SELECT id, testing FROM tl");
$key_pair = $stmt->fetch(\PDO::FETCH_KEY_PAIR); 
$id_values = $stmt->fetchAll(\PDO::FETCH_UNIQUE);  //SELECT uniq_name, users.* FROM users

$stmt = $db->query("SELECT testing, id FROM tl LIMIT 10");
$group_values = $stmt->fetchAll(\PDO::FETCH_GROUP); //array[testing => [id, columns...]]

/*
 * for cursor_scroll: FETCH_ORI_PRIOR | FETCH_ORI_NEXT | FETCH_ORI_FIRST | FETCH_ORI_LAST | FETCH_ORI_ABS | FETCH_ORI_REL 
 */
/**
 * Prepare
 */
$stmt = $db->prepare("SELECT * FROM tl WHERE 1=1 LIMIT 3", [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
$stmt->execute();
$last = $stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_LAST);
$first = $stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_FIRST);

/**
 * Class
 */
class Setting { private $id, $testing; function getid() {return $this->id;} }
$stmt->execute();
$object = new Setting;
$stmt->setFetchMode(\PDO::FETCH_INTO, $object); //update $object
$stmt->setFetchMode(\PDO::FETCH_CLASS, 'Setting', []); //new object
$class = $stmt->fetch();
$id = $class->getid();
$id2 = ($stmt->fetch())->getId();

//\PDO::FETCH_COLUMN + (FETCH_UNIQUE | FETCH_GROUP)
$testing_id = $db
    ->query('SELECT * FROM tl LIMIT 5')
    ->fetchAll(\PDO::FETCH_FUNC, function($id, $testing) {return $testing.$id;});

/**
 * Transact
 */
$db->inTransaction(); //echo
//$db->commit();
$db->rollback();

/**
 * Error
 */
if ($db->errorInfo()[2]) {
    var_dump($db->errorInfo());
}
if ($stmt->errorInfo()[2]) {
    var_dump($stmt->errorInfo());
}

/**
 * Close
 */
$stmt->closeCursor();
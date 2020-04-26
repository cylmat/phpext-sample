<?php
/**
 * PHP SHEETS
 * FUNCTIONS REFERENCES
 * 
 * https://www.php.net/manual/en/funcref.php
 * 
 * Affecte le comportement de PHP
 * Manipulation audio
 * Services d'identification
 * Extensions spécifiques à la ligne de commande
 * Extensions sur l'archivage et la compression
 * Traitement des cartes de crédit
 * Extensions sur la cryptographie
 * Extensions sur les bases de données
 * Extensions relatives aux dates et aux heures
 * Extensions relatives aux systèmes de fichiers
 * Support du langage humain et de l'encodage de caractères
 * Génération et traitement des images
 * Extensions relatives aux emails
 * Extensions sur les mathématiques
 * Affichage des données non-textuelles
 * Extensions sur le contrôle des processus
 * Autres extensions basiques
 * Autres services
 * Extensions spécifiques aux moteurs de recherche
 * Extensions spécifiques aux serveurs
 * Extensions sur les Sessions
 * Traitement du texte
 * Extensions relatives aux variables et aux types
 * Services Web
 * Extensions pour Windows uniquement
 * Manipulation XML
 * Extensions GUI
 */




/***
 * ANNOTATIONS
 * https://www.php.net/manual/fr/reflectionclass.getdoccomment.php
 */


                                                            /* PHP Behavior */
/*************************
* Bytecode compiler
* https://www.php.net/manual/en/book.bcompiler.php
*/
                                                            
 /*****************************
  * op Cache
  * https://www.php.net/manual/en/book.opcache.php
  */

 /********************************
  * ERRORS handling - debug
  * https://www.php.net/manual/en/book.errorfunc.php
  * 
  * https://www.php.net/manual/en/book.phpdbg.php
  */
trigger_error('error displaying!!', E_USER_WARNING);


/**************************
 * Output - Bufferisation
 * 
 * https://www.php.net/manual/fr/ref.outcontrol.php
 */
function rappel($buffer){
  // remplace toutes les pommes par des carottes
  return (str_replace("pommes de terre", "carottes", $buffer));
}

//flush: "affleurer/vider"
flush(); //flush - Vide les tampons de sortie du système // Cette fonction tente d'envoyer tout l'affichage courant au navigateur, sous quelques conditions. 
ob_start("rappel"); // ob_start ([ callable $output_callback = NULL [, int $chunk_size = 0 [, int $flags = PHP_OUTPUT_HANDLER_STDFLAGS ]]] ) : bool
ob_clean(); //  Efface le tampon de sortie
ob_end_clean(); //  Détruit les données du tampon de sortie et éteint la temporisation de sortie
ob_end_flush(  ); //Lit le contenu courant du tampon de sortie puis l'efface
ob_flush();
ob_get_clean(); //ob_get_clean() essentially executes both ob_get_contents() and ob_end_clean(). 
ob_get_contents(); //  Retourne le contenu du tampon de sortie
ob_get_flush(); // Vide le tampon, le retourne en tant que chaîne et stoppe la temporisation
ob_get_status(); //  Lit le statut du tampon de sortie
ob_implicit_flush(); //  Active/désactive l'envoi implicite

/* exemple */
ob_start();
include 'view.php';
$output = ob_get_contents();
ob_end_clean();
 
 
 
 /**************************
 * PHPINFOS / options
 */
extension_loaded();
 
 
 /**************************
 * Php Debugger
 */
 


                                                             /* DATABASE */
/************************************
 * PDO
 * https://www.php.net/manual/fr/pdo.connections.php
 * 
 *  A.C.I.D, 
 *      pour Atomicity,  principe du tout ou rien BEGIN, COMMIT et ROLLBACK
 *      Coherence,  Une fois votre transaction validée ces règles seront toujours validées 
 *      Isolation 
 *      Durability. les données retirées, ajoutées ou modifiées, devront rester en place,
 *      
 */
    /*PDO::beginTransaction — Initiates a transaction
    PDO::commit — Commits a transaction
    PDO::__construct — Creates a PDO instance representing a connection to a database
    PDO::errorCode — Fetch the SQLSTATE associated with the last operation on the database handle
    PDO::errorInfo — Fetch extended error information associated with the last operation on the database handle
    PDO::exec — Execute an SQL statement and return the number of affected rows
    PDO::getAttribute — Retrieve a database connection attribute
    PDO::getAvailableDrivers — Return an array of available PDO drivers
    PDO::inTransaction — Checks if inside a transaction
    PDO::lastInsertId — Returns the ID of the last inserted row or sequence value
    PDO::prepare — Prepares a statement for execution and returns a statement object
    PDO::query — Executes an SQL statement, returning a result set as a PDOStatement object
     * 
public PDO::query ( string $statement , int $PDO::FETCH_COLUMN , int $colno ) : PDOStatement
PDO::query ( string $statement , int $PDO::FETCH_CLASS , string $classname , array $ctorargs ) 
PDO::query ( string $statement , int $PDO::FETCH_INTO , object $object )
     * 
     * 
    PDO::quote — Quotes a string for use in a query
    PDO::rollBack — Rolls back a transaction
    PDO::setAttribute — Set an attribute*/

/*
 * PDOStatement — The PDOStatement class

    PDOStatement::bindColumn — Bind a column to a PHP variable
    PDOStatement::bindParam — Binds a parameter to the specified variable name
    PDOStatement::bindValue — Binds a value to a parameter
    PDOStatement::closeCursor — Closes the cursor, enabling the statement to be executed again
    PDOStatement::columnCount — Returns the number of columns in the result set
    PDOStatement::debugDumpParams — Dump an SQL prepared command
    PDOStatement::errorCode — Fetch the SQLSTATE associated with the last operation on the statement handle
    PDOStatement::errorInfo — Fetch extended error information associated with the last operation on the statement handle
    PDOStatement::execute — Executes a prepared statement
    PDOStatement::fetch — Fetches the next row from a result set
    PDOStatement::fetchAll — Returns an array containing all of the result set rows
    PDOStatement::fetchColumn — Returns a single column from the next row of a result set
    PDOStatement::fetchObject — Fetches the next row and returns it as an object
    PDOStatement::getAttribute — Retrieve a statement attribute
    PDOStatement::getColumnMeta — Returns metadata for a column in a result set
    PDOStatement::nextRowset — Advances to the next rowset in a multi-rowset statement handle
    PDOStatement::rowCount — Returns the number of rows affected by the last SQL statement
    PDOStatement::setAttribute — Set a statement attribute
    PDOStatement::setFetchMode 
 */

//DEFINItion : DDL (table creation/alteration)

//PERSISTANT
$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(
    PDO::ATTR_PERSISTENT => true
));

/* EX */
$dbConnection = new PDO($dsn, $user, $pass);
// Set the case in which to return column_names.
$dbConnection->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

/* autorollback */
//setAttribute(ATTRIBUTE, OPTION);
//ex: $dbConnection->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 


/* prepare */
$sql = 'INSERT INTO fruit (name, colour, calories) VALUES (?, ?, ?)';
$sth = $dbh->prepare($sql);
foreach ($fruits as $fruit) {
    $sth->execute([
        $fruit->name,
        $fruit->colour,
        $fruit->calories,
    ]);
}
$sth = $dbh->prepare($sql)->execute(['val'=>'']); //linked

/* bind */
$sth = $dbh->prepare('SELECT name, colour, calories
    FROM fruit
    WHERE calories < :calories AND colour = :colour');
$sth->bindValue(':calories', $calories, PDO::PARAM_INT);
$sth->bindValue(':colour', $colour, PDO::PARAM_STR);
$sth->execute();

/* SQLITE */
$conn = new PDO('sqlite:/home/lynn/music.sql3');

/*Columns*/
$sth = $this->dbh->prepare( 'SELECT nom, prenom FROM users 
                WHERE prenom LIKE :n LIMIT 10' );
$sth->bindValue(':n','D%');
$sth->bindColumn('prenom',$namis);
//$sth->bindParam(':pres',$variable,PDO::PARAM_STR,10); //-> (&)$variable !!
$sth->execute();
while( $sth->fetch(PDO::FETCH_BOUND) )
    echo "{$row[nom]}:{$row[prenom]} nameis:{$namis}<br/>".PHP_EOL;

/* Simple string */
$string = 'Nice';
print "Unquoted string: $string\n";
print "Quoted string: " . $pdo->quote($string) . "\n";

/************************************
 * mysqli
 */
    /*mysqli::$affected_rows — Gets the number of affected rows in a previous MySQL operation
    mysqli::autocommit — Turns on or off auto-committing database modifications
    mysqli::begin_transaction — Starts a transaction
    mysqli::change_user — Changes the user of the specified database connection
    mysqli::character_set_name — Returns the default character set for the database connection
    mysqli::close — Closes a previously opened database connection
    mysqli::commit — Commits the current transaction
    mysqli::$connect_errno — Returns the error code from last connect call
    mysqli::$connect_error — Returns a string description of the last connect error
    mysqli::__construct — Open a new connection to the MySQL server
    mysqli::debug — Performs debugging operations
    mysqli::dump_debug_info — Dump debugging information into the log
    mysqli::$errno — Returns the error code for the most recent function call
    mysqli::$error_list — Returns a list of errors from the last command executed
    mysqli::$error — Returns a string description of the last error
    mysqli::$field_count — Returns the number of columns for the most recent query
    mysqli::get_charset — Returns a character set object
    mysqli::$client_info — Get MySQL client info
    mysqli::$client_version — Returns the MySQL client version as an integer
    mysqli::get_connection_stats — Returns statistics about the client connection
    mysqli::$host_info — Returns a string representing the type of connection used
    mysqli::$protocol_version — Returns the version of the MySQL protocol used
    mysqli::$server_info — Returns the version of the MySQL server
    mysqli::$server_version — Returns the version of the MySQL server as an integer
    mysqli::get_warnings — Get result of SHOW WARNINGS
    mysqli::$info — Retrieves information about the most recently executed query
    mysqli::init — Initializes MySQLi and returns a resource for use with mysqli_real_connect()
    mysqli::$insert_id — Returns the auto generated id used in the latest query
    mysqli::kill — Asks the server to kill a MySQL thread
    mysqli::more_results — Check if there are any more query results from a multi query
    mysqli::multi_query — Performs a query on the database
    mysqli::next_result — Prepare next result from multi_query
    mysqli::options — Set options
    mysqli::ping — Pings a server connection, or tries to reconnect if the connection has gone down
    mysqli::poll — Poll connections
    mysqli::prepare — Prepare an SQL statement for execution
    mysqli::query — Performs a query on the database
    mysqli::real_connect — Opens a connection to a mysql server
    mysqli::real_escape_string — Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    mysqli::real_query — Execute an SQL query
    mysqli::reap_async_query — Get result from async query
    mysqli::refresh — Refreshes
    mysqli::release_savepoint — Removes the named savepoint from the set of savepoints of the current transaction
    mysqli::rollback — Rolls back current transaction
    mysqli::rpl_query_type — Returns RPL query type
    mysqli::savepoint — Set a named transaction savepoint
    mysqli::select_db — Selects the default database for database queries
    mysqli::send_query — Send the query and return
    mysqli::set_charset — Sets the default client character set
    mysqli::set_local_infile_default — Unsets user defined handler for load local infile command
    mysqli::set_local_infile_handler — Set callback function for LOAD DATA LOCAL INFILE command
    mysqli::$sqlstate — Returns the SQLSTATE error from previous MySQL operation
    mysqli::ssl_set — Used for establishing secure connections using SSL
    mysqli::stat — Gets the current system status
    mysqli::stmt_init — Initializes a statement and returns an object for use with mysqli_stmt_prepare
    mysqli::store_result — Transfers a result set from the last query
    mysqli::$thread_id — Returns the thread ID for the current connection
    mysqli::thread_safe — Returns whether thread safety is given or not
    mysqli::use_result — Initiate a result set retrieval
    mysqli::$warning_count — Returns the number of warnings from the last query for the given link*/



                                                            /* DATE TIME */
/*****************************
 * DATE
 * https://www.php.net/manual/fr/ref.datetime.php
 */
 date (  $format , $timestamp  ); //:string
 //FORMAT
 // d 01 01    j 31       W (42eme)        D Mon     l Sunday     w 4
 // F January   m 01   n 8      M Jan    
 //Y 2019     y 19      
 //h 01     H 3     m 59       s 43
 
 //DATE_ATOM : Y-m-d\TH:i:sP
 date('Y-m-d H:i:s', $phpdate);
 $date = new DateTime('2000-01-01');
echo $date->format('Y-m-d');

$date = date_create('2000-01-01');
date_add($date, date_interval_create_from_date_string('10 days'));
echo date_format($date, 'Y-m-d');

//DateInterval
//https://www.php.net/manual/fr/dateinterval.construct.php
$dv = new DateInterval('PT'.$timespan.'S');  //P:periode   T:time
//P2YT5S == P:2Y T:5S  == 2year 5seconds
echo $interval->format('%m month, %d days');

//EXEMPLE
echo date('Y-m-d H:m:s',time()+(24*60*60)).'<br/><br/>';
$a=new DateTime();
$a->add( new DateInterval('P1D') );
echo $a->format('Y-m-d H:m:s').'<br/><br/>';
 
                                                            /* FILE SYSTEM */
 /*******************************
  * Files system
  * https://www.php.net/manual/fr/refs.fileprocess.file.php
  * https://www.php.net/manual/fr/ref.filesystem.php
  * https://www.php.net/manual/fr/book.filesystem.php
  */

 
 
 
 
                                                         /* HUMAN LANGUAGE */
 
 /*******************************
  * Gettext
  * https://www.php.net/manual/en/book.gettext.php
  */
// putenv ( string $setting ) : bool
//  getenv ( string $varname [, bool $local_only = FALSE ] ) : string
//   getenv ( void ) : array

 //setlocale ( int $category , string $locale [, string $... ] ) : string
// setlocale ( int $category , array $locale ) : string
/*
 * 
    LC_ALL for all of the below
    LC_COLLATE for string comparison, see strcoll()
    LC_CTYPE for character classification and conversion, for example strtoupper()
    LC_MONETARY for localeconv()
    LC_NUMERIC for decimal separator (See also localeconv())
    LC_TIME for date and time formatting with strftime()
    LC_MESSAGES for system responses (available if PHP was compiled with libintl)

 */
 
  /****************************
  * iconv
  */
                                                        /* PROCESS */
 /*************************
  * POSIX
  * https://www.php.net/manual/en/book.posix.php
  */
 
 
 
                                                /* 
                                                 * OTHER BASICS 
                                                 *  json, spl, yaml   
                                                 * seaslog, v8js, url                                                        
                                                 */
 /*******************************
  * stream - wrappers
  * https://www.php.net/manual/en/book.stream.php
  * https://www.php.net/manual/fr/ref.stream.php
  */
$fp = fopen('php://output', 'w');
fwrite($fp, 'Hello World!'); //User will see Hello World!
fclose($fp);
 
 
 
 
 
                                                        /* OTHERS services */
  /*******************************
  * curl
  * https://www.php.net/manual/en/book.curl.php
  */
 

 
 
 
 
                                                         /* TEXT processing */
 /**********************
  * STRING
  */
 htmlentities("<strong>gras"); // &lt;strong&gt;gras         — Convertit tous les caractères éligibles en entités HTML
html_entity_decode(); //inverse
htmlspecialchars("<a href='test' "); //&lt;a href=&#039;test&#039;         Convertit les caractères spéciaux en entités HTML
 
 



                                                            /* WEB SERVICES */
  /*********************************
  * REST - OAuth
  * https://www.php.net/manual/en/refs.webservice.php
  */

/********** REST APPLICATION
 * 
 * use GET when you need to access a resource and retrieve data, and you don't have to modify or alter the state of this data.
use POST when you need to send some data to the server. Ex. from a form to save these data somewhere.
use HEAD when you need to access a resource and retrieve just the Headers from the response, without any resource data.
use PUT when you need to replace the state of some data already existing on that system.
use DELETE when you need to delete a resource (relative to the URI you've sent) on that system.
use OPTIONS when you need to get the communication options from a resource, so for checking allowed methods for that resource. Ex. we use it for CORS request and permissions rules.
 * 
 * <input name="_method" type="hidden" value="delete" />
 * 
    Lire une ressource (GET)
    Modifier une ressource(PUT)
    Ecrire une ressource(POST)
    Supprimer une ressource (DELETE)

 */

/*
 * SOAP
 * https://www.php.net/manual/en/soap.constants.php
 * 
 */
// is_soap_fault ( mixed $object ) : bool — Checks if a SOAP call has failed
//use_soap_error_handler()



                                                                /* XML */
 /*************************
  * DOM
  * https://www.php.net/manual/en/book.dom.php
  */
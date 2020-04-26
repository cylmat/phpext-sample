<?php

/**
 * PHP SHEETS 
 * security & features
 */
putenv("LANG=" . $locale); 
putenv("UNIQID=$uniqid");

getenv("LANG");
$_ENV["USER"]='R';

/****************************
                            * SECURITY
                            * as cgi/bin or apache module
 * 
 * 
 * 
 * There are two important measures you should take to prevent these issues.

    Only allow limited permissions to the PHP web user binary.
    Check all variables which are submitted.

 */
ini_set('include_path',".:/php/includes");
ini_set('doc_root'); // string
ini_set('open_basedir'); // string you can control and restrict what directories are allowed to be used for PHP.
//Limit the files that can be accessed by PHP to the specified directory-tree, including the file itself.
// This directive is NOT affected by whether Safe Mode is turned On or Off. 

//session
ini_set("session.use_strict_mode", "on");
 session_regenerate_id();
// session.use_trans_sid 

 
 //FILES white list
 $file = $_GET['file']; 

// Whitelisting possible values
switch ($file) {
    case 'main':
    case 'foo':
    case 'bar':
        include '/home/wwwrun/include/'.$file.'.php';
        break;
    default:
        include '/home/wwwrun/include/main.php';
}

///ATTACK!!!!!    Check all variables which are submitted. 
$username = $_POST['user_submitted_name']; // "../etc"
$userfile = $_POST['user_submitted_filename']; // "passwd"
$homedir  = "/home/$username"; // "/home/../etc"
unlink("$homedir/$userfile"); // "/home/../etc/passwd"
echo "The file has been deleted!";

//-> better script
if (!ctype_alnum($username) || !preg_match('/^(?:[a-z0-9_-]|\.(?!\.))+$/iD', $userfile)) {
    die("Bad username/filename");
}

$username = $_SERVER['REMOTE_USER']; // using an authentication mechanism
$userfile = basename($_POST['user_submitted_filename']);
$homedir  = "/home/$username";
$filepath = "$homedir/$userfile";

/**
 * SQL security 
 * settype, sprintf, hash, etc....
 * 
 *  mysqli_real_escape_string(), sqlite_escape_string(), PDO::quote()...
 * 
 *  Mcrypt and Mhash, password_hash(), password_verify ()
 *  hash ( string $algo , string $data [, bool $raw_output = FALSE ] ) : string
 *             careful 32bits -    crc32 ( string $str ) : int
 * crypt ( string $str [, string $salt ] ) : string
 *            deprecated  -   md5() and sha1() 
 */
settype($offset, 'integer');
$query = "SELECT id, name FROM products ORDER BY name LIMIT 20 OFFSET $offset;";
$query = sprintf("SELECT id, name FROM products ORDER BY name LIMIT 20 OFFSET %d;", $offset);

$query  = sprintf("INSERT INTO users(name,pwd) VALUES('%s','%s');",
            pg_escape_string($username),
            password_hash($password, PASSWORD_DEFAULT)); //postGRE


//ERRORS
 /*  show_source(), highlight_string(), or highlight_file()
 * error_reporting=0 in production env
 */
/*
    Will this script only affect the intended files?
    Can unusual or undesirable data be acted upon?
    Can this script be used in unintended ways?
    Can this be used in conjunction with other scripts in a negative manner?
    Will any transactions be adequately logged?*/

//magic-quotes (remove in php5.4) = addslashes()   /  stripslashes(). 

/*
 * obscure php
 * # Make PHP code look like unknown types
AddType application/x-httpd-php .bop .foo .133t
 */



/*******************
 * 
 *                                      FEATURES
 */

/*
 * http authenticate
 */
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} else {
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
}

//digest
if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

    die('Text to send if user hits Cancel button');
}

/******************
 * cookies / sessions
 *  Cookies are part of the HTTP header, so setcookie() must be called before any output is sent to the browser
 * ->see ob_start, etc...
 */
//setrawcookie ( string $name [, string $value [, int $expires = 0 [, string $path [, string $domain [, bool $secure = FALSE [, bool $httponly = FALSE ]]]]]] ) : bool
//setrawcookie ( string $name [, string $value [, array $options = [] ]] ) : bool

/*************
 * xform 
 */
//https://www.w3.org/MarkUp/Forms/

/***************
 * File upload
 *  file_uploads, upload_max_filesize, upload_tmp_dir, post_max_size and max_input_time directives in php.ini
 * 
 *  set_time_limit ( int $seconds ) : bool
 * ini_set(  post_max_size   );
 * 
 * input SECURITY!!!!
 */
?>
<form enctype="multipart/form-data" action="__URL__" method="POST">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<?php    
global $_FILES; //$_FILES['userfile']['name'] ...

//->then
 is_uploaded_file(); 
 move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
 basename("/etc/sudoers.d", ".d") ; //-> sudoers
 dirname(); // - Returns a parent directory's path
pathinfo(); // Returns information about a file path

//error
$_FILES['userfile']['error']; //UPLOAD_ERR_OK,UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE ...

//multiple
?>
<form action="file-upload.php" method="post" enctype="multipart/form-data">
  Send these files:<br />
  <input name="userfile[]" type="file" /><br />
  <input name="userfile[]" type="file" /><br />
  <input type="submit" value="Send files" />
</form>
<?php

//$_FILES['userfile']['name'][0] would contain the value review.html, and $_FILES['userfile']['name'][1]

/***************
 * PUT
 */
//PUT /path/filename.html HTTP/1.1
/* PUT data comes in on the stdin stream */
$putdata = fopen("php://input", "r");

/* Open a file for writing */
$fp = fopen("myputfile.ext", "w");

/* Read the data 1 KB at a time
   and write to the file */
while ($data = fread($putdata, 1024))
  fwrite($fp, $data);

/* Close the streams */
fclose($fp);
fclose($putdata);

/******************
 * remote files
 * php.ini : allow_url_fopen=1
 */
$file = fopen ("http://www.example.com/", "r");
$line = fgets ($file, 1024);
//'ftp://user:password@ftp.example.com/path/to/file'

//error
 //syslog ( int $priority , string $message ) : bool

/*********************
 * Connection handling (break or out by client)
 *  connection_aborted ( void ) : int
 * // ignore_user_abort ([ bool $value ] ) : int
 * 
 *  connection_status ( void ) : int      - Returns connection status bitfield
0 - NORMAL
1 - ABORTED
2 - TIMEOUT
3 - ABORTED and TIMEOUT
 */

//ignore_user_abort php.ini
//
// register_shutdown_function ( callable $callback [, mixed $... ] ) : void
//Registers a callback to be executed after script execution finishes or exit() is called.
function shutdown()
{
    echo 'Script executed with success', PHP_EOL;
}
register_shutdown_function('shutdown');

/*****************
 * persistent DB connection
 *      !!! careful
 * 
 * avoid the problem entirely by not using persistent connections 
 * in scripts which use table locks or transactions (you can still use them elsewhere). 
 */
mysqli_connect(); // with p: host prefix
PDO::__construct(); // with PDO::ATTR_PERSISTENT as a driver option

/*****************
 * CLI    --enable-cli
 * command line interpreter/interface
 * SAPI server application  programming interface
 *                      TODO?
 */

/*
 * Garbage Collection
 * A PHP variable is stored in a container called a "zval"  => refcount++ with each &reference
 * 
 * ini: zend.enable_gc
 */
$a = "new string";
debug_zval_dump($a);
memory_get_usage();
 //debug_zval_dump ( mixed $variable [, mixed $... ] ) : void

/*
 * Dynamic Trace
 * --todo
 */





        /******************************
        * 
        * PHP 7
         * 
         * ERREURS(Throwable), VARIABLES, LIST, FOREACH, chaines
         * https://www.php.net/manual/fr/migration70.new-features.php
         * 
         */

/***************
 * Incompatibilité
 */

//De nombreuses erreurs fatales et récupérables ont été converties en exceptions dans PHP 7.
//Ces exceptions d'erreur héritent de la classe Error, qui implémente elle-même l'interface Throwable 
try{} catch (Error $e) {  }

// set_exception_handler() n'est plus garanti de recevoir des objets Exception ¶
// Code pour PHP 5 qui va se briser.
function handler(Exception $e) {  }
set_exception_handler('handler');

// Compatible PHP 5 et 7.
function handler_($e) {  }

// PHP 7 seulement.
function handler__(Throwable $e) {  }

//+Les constructeurs internes lèvent toujours des exceptions en cas d'échec 

//+Les erreurs d'analyse lèvent une ParseError ¶

//+Changements de gravité des avis E_STRICT ¶
error_reporting(E_ALL|E_STRICT);

/*
 * Modifications apportées à la gestion des variables, propriétés et méthodes indirectes ¶
 * 
 *                              5                       7
$$foo['bar']['baz'] 	${$foo['bar']['baz']} 	($$foo)['bar']['baz']
$foo->$bar['baz'] 	$foo->{$bar['baz']} 	($foo->$bar)['baz']
$foo->$bar['baz']() 	$foo->{$bar['baz']}() 	($foo->$bar)['baz']()
Foo::$bar['baz']() 	Foo::{$bar['baz']}() 	(Foo::$bar)['baz']()*/

// Valide en PHP 5 uniquement.
global $$foo->bar;
// Valide en PHP 5 et 7.
global ${$foo->bar};

/*
 * +la liste() n'assigne plus de variable dans l'ordre inverse 
 */
//Les constructions de list() ne peuvent plus être vides
//list() ne peut plus défaire les variables de chaîne de caractères. str_split() devrait être utilisé à la place. 
list($a[], $a[], $a[]) = [1, 2, 3];

//+L'ordre des éléments des tableaux a changé lorsque les éléments sont créés automatiquement pendant les affectations de référence ¶

//+Les parenthèses autour des arguments de fonction n'affectent plus le comportement ¶
squareArray((getArray()));// Generates a warning in PHP 7.

//+foreach ne modifie plus le pointeur interne de tableau ¶
//+foreach par valeur travaille sur une copie du tableau ¶

//Si des valeurs sont ajoutées à un tableau pendant son parcours, alors ces nouvelles valeurs seront également parcourues : 
$array = [0];
foreach ($array as &$val) {
    var_dump($val);
    $array[1] = 1;
} //echo int(0) int(1)

/****
 * Modifications apportées à la gestion d'entier ¶
 */
var_dump(1 >> -1); //php5 int(0)    php7 Fatal error:

var_dump(3/0); //float(INF)
var_dump(0/0); //float(NAN)
var_dump(0%0); //PHP Fatal error: 

//+Les chaînes hexadécimales ne sont plus considérées comme numériques ¶
var_dump(is_numeric("0x123")); //false
var_dump(substr("foo", "0x1")); //false

$str = "0xffff";
$int = filter_var($str, FILTER_VALIDATE_INT, FILTER_FLAG_ALLOW_HEX);
if (false === $int) {
    throw new Exception("Invalid integer!");
}
var_dump($int); // int(65535)

//+\u{ peut provoquer des erreurs ¶
echo "\u{9999}";  //香

/*
 * supprimé
 * 
 * call_user_method() et call_user_method_array()  -> call_user_func() et call_user_func_array(). 
 * ereg ont été supprimées. PCRE est une alternative recommandée. 
 *  mcrypt_generic_end() a été remplacée par mcrypt_generic_deinit(). 
 *      new -> datefmt_set_timezone() et IntlDateFormatter::setTimeZone(). 
 * dl() ne peut plus être utilisé avec PHP-FPM. Il continue à fonctionner dans les SAPIs CLI et Embed. 
 * 
 * class C {}   $c =& new C; //syntax error,
 * <%  <%=  <script language="php">
 * A::test();  on non-static  //Deprecated
 * 
 * echo yield -1;       =>    echo yield (-1);
 * yield $foo or die;     =>    (yield $foo) or die;
 */

//+Fonctions d'inspection des arguments signalent la valeur actuelle du paramètre ¶
function foo($x) {
    $x++;
    var_dump(func_get_arg(0));
}
foo(1); //php5: 1       php7: 2

//+Les instructions Switch ne peuvent pas avoir plusieurs blocs par défaut ¶

//+$HTTP_RAW_POST_DATA n'est plus disponible. Le flux php://input doit être utilisé à la place. 


/**********
 * nouvelles fonctionnalités
 */
//Déclarations du type scalaire : coercitive (par défaut) ou stricte
function sommeEntiers(int ...$entiers){ return array_sum($entiers); }
var_dump(sommeEntiers(2, '3', 4.1)); //int(9)

//Déclarations du type de retour ¶
//function sommeTableaux(array ...$tableaux): array

//L'opérateur Null coalescent (??)
//$identifiant = $_GET['utilisateur'] ?? 'aucun'; =>
$identifiant = isset($_GET['utilisateur']) ? $_GET['utilisateur'] : 'aucun';

//spaceship $a<=>$b;
// Il retourne -1, 0 ou 1 quand $a est respectivement inférieur, égal ou supérieur à $b

//Les tableaux constants à l'aide de define() ¶ Dans PHP 5.6, ils pouvaient être défini seulement avec const. 

//+classes anonymes
/*new class implements Logger {
    public function log(string $msg) {
        echo $msg;
    }
}*/

//Closure::call()
$getX = function() {return $this->x;};
echo $getX->call($a);

//+unserialize() est filtrée ¶
// Convertit tous les objets vers un objet __PHP_Incomplete_Class
$data = unserialize($foo, ["allowed_classes" => ["MyClass", "MyClass2"]]); //false || ["MyClass", "MyClass2"] || true

//+IntlChar ¶  caractères unicodes
echo IntlChar::charName('@'); //COMMERCIAL AT

//ASSERTS
ini_set('zend.assertions');
ini_set('assert.exception');
class CustomError extends AssertionError {}
assert(false, new CustomError('Un message d\'erreur'));

//regroupement use
/*use some\namespace\{ClassA, ClassB, ClassC as C};
use function some\namespace\{fn_a, fn_b, fn_c};
use const some\namespace\{ConstA, ConstB, ConstC};*/

//+retour générateur
$gen = (function() {
    yield 1;
    yield 2;
    return 3; //valeur finale
}); //})();

foreach ($gen as $val) {
    echo $val, PHP_EOL;
}

echo $gen->getReturn(), PHP_EOL; //echo 1 2 3

//+Délégation de générateur 
function gen() { yield 1; yield 2;
    //yield from gen2();
}
function gen2() { yield 3; yield 4; }
foreach (gen() as $val) { echo $val, PHP_EOL; }

//+La division d’entiers avec intdiv() ¶

/*SESSION
 * +session_start([
    'cache_limiter' => 'private',
    'read_and_close' => true,
]);*/

//+preg_replace_callback_array — Éffectue une recherche de correspondance avec une expression régulière et remplace grâce à une fonction de rappel

//+Deux nouvelles fonctions ont été ajoutée pour générer cryptographiquement des entiers et 
//des chaînes de caractères sécurisés de façon multi-plateforme : random_bytes() et random_int(). 

//+La fonction list() peut toujours déballer les objets qui implémentent ArrayAccess ¶
//+L'accès aux membres de la classe (attributs et méthodes) lors du clonage a été ajouté. Exemple, (clone $foo)->bar(). 


/**
 * deprecated
 */
//constructeur ayant le même nom que la classe
class foo { function foo() {}}
//+Les appels statiques à des méthodes non statiques ¶
//+L'option salt de la fonction password_hash() ¶
//+L'option capture_session_meta du contexte SSL 
//+ldap_sort()

/*
 * functions modifiés
 *

debug_zval_dump() affiche désormais "int" au lieu de "long" et "float" au lieu de "double"
La fonction dirname() prend désormais un deuxième paramètre optionnel, depth, pour indiquer le nombre de niveaux plus haut (par rapport au dossier courant) pour atteindre le nom du dossier dans l'arborescence.
getrusage() est désormais supporté sur Windows.
Les fonctions mktime() et gmmktime() n'acceptent plus le paramètre is_dst.
la fonction preg_replace() ne supporte plus "\e" (PREG_REPLACE_EVAL). preg_replace_callback() devrait être utilisé à la place.
La fonction setlocale() n'accepte plus que le paramètre category soit passé comme chaîne de caractères. Les constantes LC_* doivent être utilisées à la place.
Les fonctions exec(), system() et passthru() ont désormais l'octet NULL de protection.
shmop_open() retourne désormais une ressource à la place d'un entier qui doit être passé aux fonctions shmop_size(), shmop_write(), shmop_read(), shmop_close() et shmop_delete().
substr() et iconv_substr() retourne désormais une chaîne de caractères vide, si la longueur de la chaîne est égale à $start.
xml_parser_free() n'est plus suffisant pour libérer la ressource de l'analyseur, s'il fait référence à un objet et que cet objet fait référence à cette ressource d'analyseur. Dans ce cas, il est nécessaire de libérer également le $parser.
*/

/*
 * nouvelles fct
 */
//Closure::call(), random_bytes(), random_int(), error_clear_last(), Generator::getReturn(), gmp_random_seed()
//intdiv(), preg_replace_callback_array(), gc_mem_caches(), get_resources(), posix_setrlimit()
//ReflectionParameter::getType(),ReflectionParameter::hasType(),ReflectionFunctionAbstract::getReturnType(),ReflectionFunctionAbstract::hasReturnType()
//ZipArchive::setCompressionIndex(),ZipArchive::setCompressionName()
//inflate_add(),deflate_add(),inflate_init(),deflate_init()

/*CLASSES */
//IntlChar, ReflectionGenerator,ReflectionType, SessionUpdateTimestampHandlerInterface
//Throwable, Error, TypeError, ParseError, AssertionError, ArithmeticError, DivisionByZeroError

/*global */
//PHP_INT_MIN, IMG_WEBP , JSON_ERROR_INVALID_PROPERTY_NAME, LibXML , PREG_JIT_STACKLIMIT_ERROR,  POSIX_RLIMIT_AS, POSIX_RLIMIT_CORE, ZLIB_ENCODING_RAW ...

/*module sapi */
//PHP 7 accepte désormais les demandes faites via IPv4 et IPv6. 

/*extension supprimées*/
//ereg, mssql, mysql, sybase_ct  -   aolserver, apache, apache_hooks, apache2filter 

/*autre*/
// 'new', 'private' et 'for' étaient inutilisable auparavant
//Project::new('Project Name')->private()->for('purpose here')->with('username here');













            /******************************
             * 
             * PHP 5.6 
             * if (version_compare(PHP_VERSION, '5.6', '<')) {
             * https://www.developpez.com/actu/74654/PHP-5-6-sort-en-version-stable-et-marque-la-fin-de-l-integration-des-nouveautes-a-la-branche-5-x/
             *
    L’introduction des expressions scalaires constantes, qui permet désormais aux développeurs de fournir une expression scalaire impliquant des littéraux numériques et de chaine et/ou des constantes dans des contextes ou PHP auparavant prévoyait une valeur statique, comme les constantes et les déclarations de propriétés ;
    Le support des fonctions variadiques (fonction qui accepte un nombre variable de paramètres) ;
    La prise en charge de l’exponentiation, grâce à l’introduction de l’opérateur « ** » ;
    L’intégration de phpdbg, un débogueur PHP interactif mis en œuvre dans le module SAPI ;
    « php://input » est désormais réutilisable et « $HTTP_RAW_POST_DATA » a été marqué comme obsolète ;
    Les objets GMP (GNU Multiple Precision - bibliothèque logicielle de calcul multiprécision sur des nombres entiers, rationnels et en virgule flottante) prendront dorénavant en charge la surcharge d’opérateur ;
    Avec PHP 5.6, le téléchargement des fichiers de plus de 2 Go est maintenant accepté.

    Le fait que les clés de votre tableau ne seront pas écrasées lors de la définition de celui-ci comme une propriété d’une classe via un littéral de tableau ;
    La fonction json_decode() est désormais plus stricte ;
    Les ressources GMP sont désormais des objets ;
    Les fonctions Mcrypt (bibliothèque pour le chiffrement/déchiffrement des données en PHP) exigeront dorénavant des clés valides.
*/
/*
 * incompatibilite
 */
//définition d'un tableau comme une propriété d'une classe : VALABLE
/*public $array = [
        self::ONE => 'foo',
        'bar',
        'quux',
    ];*/

//+json_decode() rejette maintenant les variantes non écrites en minuscule des littéraux JSON true, false et null,
//+Tous les flux clients cryptés activent désormais la vérification par paire par défaut.
        // en utilisant les options de contexte cafile ou capath. 

//+Les ressources GMP sont maintenant des objets
//+Les fonctions Mcrypt requièrent maintenant des clés ou IV valides ¶
    //mcrypt_encrypt(), mcrypt_decrypt(), mcrypt_cbc(), mcrypt_cfb(), mcrypt_ecb(), mcrypt_generic() et mcrypt_ofb()
    // n'acceptent plus de clés ou de vecteurs d'initialisation (IVs) de tailles incorrectes,

//Le téléchargement de fichier en utilisant la syntaxe @file nécessite maintenant 
//que la directive CURLOPT_SAFE_UPLOAD soit définie à FALSE. CURLFile doit plutôt être utilisé à la place. 

/*
 * Expressions de constante
 */
function f($a = UN + self::TROIS) {return $a;}

//une constante tableau 
const ARR = ['a', 'b'];

//Les fonctions variables peuvent maintenant être implémentées en utilisant l'opérateur de décomposition ..., au lieu d'utiliser la fonction func_get_args(). 
function fd($req, $opt = null, ...$params) {}
//function foo (stdclass ... $inbound) {

//Décompression des arguments via l'opérateur de décomposition ... ¶
function add($a, $b, $c) { return $a + $b + $c;}
$operators = [2, 3];
add(1, ...$operators);

//L'exponentiation via l'opérateur ** ¶
2 ** 3 ==      8;

//use function et use const ¶
use const Name\Space\FOO;
use function Name\Space\f;

/* PHPDBG */
// phpdbg_break_file ( string $file , int $line ) : void
//  phpdbg_break_method ( string $class , string $method ) : void

//Encodage de caractères par défaut ¶
  htmlentities(); html_entity_decode();  htmlspecialchars();
//ini:  default_charset string  (UTF-8)

/*php://input est ré-utilisable */
//les fichiers de plus de 2 GigaOctets sont maintenant acceptés. 
  
  /* GMP supporte la surcharge d'opérateur ¶ */
  //echo gmp_intval(gmp_add($a, $b)), PHP_EOL;

/*hash_equals()*/
  //pour la comparaison des chaîne de caractères permettant d'éviter les attaques de type timing
  hash_equals(crypt('12345', '$2a$07$usesomesillystringforsalt$'), $correct);
  
  /*__debugInfo() */ //   >  var_dump(). 
  
  //Améliorations SSL/TLS ¶
  // options de contexte SSL
  
  //L'extension pgsql supporte désormais les connexions et requêtes asynchrones,
  // pg_connect_poll(), pg_socket(), pg_consume_input() et pg_flush() asynchrone

/*
 * OBSOLETE
 */
//+Appel depuis un contexte incompatible ¶
//Non-static method A::f() should not be called statically

//POST
/*  Le nouveau code devrait utiliser php://input à la place de $HTTP_RAW_POST_DATA, */

/*iconv*/
//Les options de configuration iconv et mbstring relatives à l'encodage sont devenues obsolètes en faveur de l'option default_charset. 

/*
 * modifié
 */
/*
 * 
    crypt() lève maintenant une erreur E_NOTICE si le paramètre salt est omit.
    substr_compare() accepte désormais 0 pour son paramètre length.
    unserialize() va désormais échouer si les données linéarisées passées ont été manipulées pour instancier un objet sans appeler son constructeur.

 */
//L'envoi de fichier en utilisant la syntaxe @file est maintenant uniquement supporté si 
//l'option CURLOPT_SAFE_UPLOAD est définie à FALSE. CURLFile devrait être utilisé à la place. 

//Le paramètre source de mcrypt_create_iv() a maintenant pour valeur de défaut MCRYPT_DEV_URANDOM à la place de MCRYPT_DEV_RANDOM. 

//OPENSSL stream_socket_enable_crypto() permet désormais au paramètre crypto_type d'être optionnel si le contexte SSL de flux inclut la nouvelle option crypto_type. 

/*
    pg_insert(), pg_select(), pg_update() et pg_delete() ne sont plus à l'état expérimental.
    pg_send_execute(), pg_send_prepare(), pg_send_query() et pg_send_query_params() ne bloqueront plus jusqu'à la fin de l'écriture de la requête si la connexion vers la base est établie en mode non bloquant.

//ReflectionClass::newInstanceWithoutConstructor() autorise désormais les classes internes non-finales à être instanciées. 
 * 
 * XMLReader::getAttributeNs() et XMLReader::getAttributeNo() retournent maintenant NULL si l'attribut ne peut être trouvé, comme XMLReader::getAttribute(). 
 */

  /**
   * nouvelles fonctions
   * 
   * +fonctionnalités SSL
   */
   //+
  DateTimeImmutable::createFromMutable ();
gmp_root(); // — Récupère la partie entière de la n-ème racine

    ldap_escape(); ldap_modify_batch();  mysqli_get_links_stats(); openssl_spki_new(); openssl_spki_verify(); pg_flush(); pg_socket(); 
  session_abort(); session_reset();   ZipArchive::setPassword();
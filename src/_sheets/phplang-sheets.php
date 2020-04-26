<?php
/**
* 
 * 
    Avec l'en-tête HTTP Content-type :
        Via un fichier .htaccess : AddDefaultCharset UTF-8
        En PHP : header('Content-Type: text/html;charset=UTF-8');
    En XML et XHTML, avec le prologue : <?xml version="1.0" encoding="UTF-8"?>
    Grâce à la balise meta dans le code
        En HTML5 : <meta charset="UTF-8">
        En HTML4 : <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        En XHTML 1.1 : <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

*/

/**************
 * 
 * LANGUAGE ref
 * 
 */
Language_référence();



/**************
 * types
 */
types($bool, $int, $array, $string, $iterable, $res, $float, $obj); //type

//list
$info = array('coffee', 'brown', 'caffeine');
list($drink, $color, $power) = $info;

//fct call
function increment(&$var){$var++;}
call_user_func('increment', $a);
call_user_func_array('increment', array(&$a));

echo "$a ${$a}"; //variable
echo $foo->{$baz[1]} . "\n";
echo $foo->{$start . $end} . "\n";
$$a = 'world';

//__LINE__, __FILE__, __DIR__, __FUNCTION__, __CLASS__, __TRAIT__, __METHOD__, __NAMESPACE__, ClassName::class 
// As of PHP 5.3.0
$heredoc = <<<EOD
dfdsfsre qgdfgeeqg
EOD;
echo <<<"FOOBAR"
FOOBAR;
$nowdoc = <<<'ONLY'
$define
ONLY;

//classes
$c = get_called_class();



/************
 * expression   
 */
$first ? $second : $third;
if (func1() || func2()) echo ''; //if true don't run
if (func1() && func2()) echo ''; //if false don't run



/******************
 *  operator (assignment, bitwise, logical, exec) 
 */
($a ** $b).PHP_EOL; 	//Exponentiation (Pow)
E_ALL ^ E_NOTICE; //one or two but not both    $a xor $b
E_ALL & ~E_NOTICE; //and !
$a << $b; //shift left, multiply b two
$a <> $b; 	//Inequality
//var_dump($a instanceof MyClass);

//PHP7
//The expression (expr1) ?? (expr2) evaluates to expr2 if expr1 is NULL, and expr1 otherwise.  
//echo 1.5 <=> 1.5; // 0             echo 1.5 <=> 2.5; // -1             echo 2.5 <=> 1.5; // 1

//not sending error =>  @include();
//echo `ping -n 3 {$host}`;
$out = `ls --al`; //=> shell_exec('ls -al'); //sauf safe_mode

echo 'qwe{$a}rty'; // qwe{$a}rty, string single quotes are not parsed
//"{$str1}{$str2}{$str3}"; // one concat = fast



/*****************
 * Controle STRUCTURE
 */
//if else;  while, do-while, foreach, continue, switch, declare, include, goto
if ($a == 5):  echo 'A is equal to 5'; endif; 
switch ($foo): case 1: break; endswitch; //isset( $value ) AND print( $value );
//$a=5;( $a==5 ) AND print<<<yepbabyyeah baby !!! php roolez !!! yepbaby;

//DECLARE ( ticks, encoding, strict_types )
declare(ticks=1); 
declare(ticks=1) {
    // entire script here
}
// A function called on each tick event
function tick_handler(){ echo "tick_handler() called\n";}
register_tick_function('tick_handler');
declare(encoding='ISO-8859-1');
//php7
declare(strict_types=1);

/* GOTO */
for($i=0,$j=50; $i<100; $i++) {
  while($j--) {
    if($j==17) goto end; 
  }  
}
echo "i = $i";
end:
echo 'j hit 17';


/*******************
 * functions
 */
8//function add_some_extra(&$string); //reference
//function makecoffee($types = array("cappuccino"), $coffeeMaker = NULL)

//Class/interface,self,array,callable   5.4
 //       bool,float,int,string,iterable,object 	 //7
function small_numbers(){ return array (0, 1, 2);}
list ($zero, $one, $two) = small_numbers();
//function sum($a, $b): float  //7

//arguments variables
function sum(...$numbers) { //1, 2, 3 ou + arguments
    $acc = 0;
    foreach ($numbers as $n) {
        $acc += $n;
    }
    return $acc;
}

//variable function
$func = 'echoit';
$func('test');  // This calls echoit('test')
$funcname = "Variable";
$foo->$funcname();  // This calls $foo->Variable()

//dl(string $library ) : bool — Loads a PHP extension at runtime    ex: dl('php_sqlite.dll'); (except safe mode)

//anonymous
echo preg_replace_callback('~-([a-z])~', function ($match) {});
$greet = function($name){ printf("Hello %s\r\n", $name); };
$greet('World');

//inherit
$message = 'hello';
$example = function () use ($message) { var_dump($message); };
$example = function () use (&$message) { var_dump($message); };
$example = function ($arg) use ($message) { var_dump($arg . ' ' . $message); };
$example();




/*****************
 * Class / object:
 */
// visibility, abstract, final, magic_methods, interface, cloning, typehinting
$instance = new SimpleClass();
$assigned   =  $instance;
$reference  =& $instance;
$instance->var = '$assigned will have this value';
$instance = null; // $instance and $reference become null
var_dump($instance); //NULL
var_dump($reference); //NULL
var_dump($assigned); //->string(30) "$assigned will have this value"

parent::displayVar(); //parent::
echo ClassName::class; //::class  name of class

$func = $obj->bar;
echo $func(), PHP_EOL;
//echo ($obj->bar)(), PHP_EOL;// alternatively, as of PHP 7.0.0:
//->spl_autoload_register()
//set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);

//Paamayim Nekudotayim :: access to static, constant, and -overridden- properties or methods of a class. 
//Static properties defined ONLY in the parent class will share a COMMON value.

//abstract class AbstractClass {
    // Force Extending class to define this method
    //abstract protected function getValue(); }

interface iTemplate
{
    public function setVariable($name, $var);
    public function getHtml($template);
}
//class Template implements iTemplate {}

/*
 * traits   php5.4
 */
trait ezcReflectionReturnInfo {
    public $x = 1;
    function getReturnType() { /*1*/ static $c = 0; }
    static function getReturnDescription() { /*2*/ } 
    //abstract public function getWorld();
}
class ezcReflectionMethod extends ReflectionMethod { use ezcReflectionReturnInfo;}
class ezcReflectionFunction extends ReflectionFunction { use ezcReflectionReturnInfo;}

//choose
class Talker {
    use A, B, SayThree {
        B::smallTalk insteadof A;
        A::bigTalk insteadof B;
        B::bigTalk as talk;
    }
    use HelloWorld { sayHello as protected; }
    use HelloWorld { sayHello as private myPrivateHello; }
    
    final public function sayHello() { parent::sayHello(); echo 'World!'; }   
}

//php7
//new class(10) extends SomeClass implements SomeInterface { use SomeTrait; }   //7
//$util->setLogger(new class { public function log($msg) })
//echo (new Outer)->func2()->func3();

//overloading __set __get __isset __unset       __call __callStatic

//magicals             $a = clone $b;
//public __construct(), __destruct(), __call(), __callStatic(), __get(), __set(), __isset(), __unset(), 
//__sleep(), __wakeup(), __toString(), __invoke(), __set_state(), __clone() and __debugInfo()

//__set_state ( array $properties ) : object

/*
 * Late STATIC binding!
 */
class Bet extends Aet { public static function who() { echo __CLASS__; } }
class Aet {
    public static function who() { echo __CLASS__; }
    public static function test() {
        self::who(); //echo Aet 
        static::who(); // Here comes Late Static Bindings       echo Bet
        //STATIC -> object ITSELF       php5.3
    }
}

//reference (https://www.php.net/manual/en/language.oop5.references.php)
$a = new Foo; // $a is a pointer pointing to Foo object 0
$b = $a; // $b is a pointer pointing to Foo object 0, however, $b is a copy of $a
$c = &$a; // ($c and $a) are now references of a pointer pointing to Foo object 0
$a = new Foo; // ($a and $c) are now references of a pointer pointing to Foo object 1, $b is still a pointer pointing to Foo object 0
unset($a); // A reference with reference count 1 is automatically converted back to a value. Now $c is a pointer to Foo object 1
$a = &$b; // $a and $b are now references of a pointer pointing to Foo object 0
$a = NULL; // $a and $b now become a reference to NULL. Foo object 0 can be garbage collected now
unset($b); // $b no longer exists and $a is now NULL
$a = clone $c; // $a is now a pointer to Foo object 2, $c remains a pointer to Foo object 1
unset($c); // Foo object 1 can be garbage collected now.
$c = $a; // $c and $a are pointers pointing to Foo object 2
unset($a); // Foo object 2 is still pointed by $c
$a = &$c; // Foo object 2 has 1 pointers pointing to it only, that pointer has 2 references: $a and $c;



/***************
 * namespace
 *  (no white space, exception: declare)
 * https://www.php.net/manual/en/language.namespaces.rules.php
 */
namespace MyProject\Sub\Level;
$c = new \my\name\MyClass; // see "Global Space" section
$d = namespace\MYCONST; // see "namespace operator and __NAMESPACE__
$d = __NAMESPACE__ . '\MYCONST'; 
define(__NAMESPACE__ . '\GOODBYE', 'Goodbye!');

$a = "\\namespacename\\classname"; // if double quotes, \\ must be used    "\n"!!
$a = '\namespacename\classname';

namespace NS;
define(__NAMESPACE__ .'\foo','111');
define('foo','222');
echo foo;  // 111.
echo \foo;  // 222.
echo \NS\foo;  // 111.
echo NS\foo;  // fatal error. assumes \NS\NS\foo.
Sub\Level\connect();

namespace { // global code
    session_start();
    $a = MyProject\connect();
    echo MyProject\Connection::start();
}

//use
use function blah\blah as mine; 
blah\mine(); // Will NOT work
mine(); // Will work
use const My\Full\CONSTANT;

use My\Full\Classname as Another, My\Full\NSname;
$obj = new Another; // instantiates object of class My\Full\Classname
$obj = new \Another; // instantiates object of class Another
$obj = new Another\thing; // instantiates object of class My\Full\Classname\thing
$obj = new \Another\thing; // instantiates object of class Another\thing

//namespace == self
namespace\blah\mine(); // calls function MyProject\blah\mine()
$a = new namespace\sub\cname(); // instantiates object of class MyProject\sub\cname

// PHP 7+ code
//use some\namespace\{ClassA, ClassB, ClassC as C};
//use function some\namespace\{fn_a, fn_b, fn_c};
//use const some\namespace\{ConstA, ConstB, ConstC};

function strlen($str)
{
    return \strlen($str) - 1;
}

/**************
 * ERRORS  (php.ini) and Exceptions
 * https://www.php.net/manual/en/errorfunc.configuration.php#ini.html-errors
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);  //NULL
ini_set('display_errors', 1); //html_errors, track_errors, log_errors

throw new Exception('Division by zero.');
try {} catch ( Exception $e) {} finally {echo "First finally.\n";}
class MyException extends Exception { }

class Exception extends Throwable {}

/*
 * generators (iterators)   inside function only
 */
while (false !== $line = fgets($fileHandle)) {
    yield $line; // : Generator
    //$data = (yield $key => $value);
}
//or
function f() {
    for ($i = $start; $i <= $limit; $i += $step) {
        yield $i; //=> return Generator(Iterator) object
        yield 2; //ajoute, etc...
        yield $id => $f+5; //etc...
        return $whatever;// //simply end the generator
    }
}


/****************
 * REFERENCE ( symbol table aliases )
 * creating *aliases* which are multiple names for the same object
 */
$var = "foo";
$ref1 =& $var; // new object that references $var
$ref2 =& $ref1; // references $var directly, not $ref1!!!!!
$ref2 = NULL; //remove all references

//EXEMPLE******** https://www.php.net/manual/en/language.references.unset.php
$a = "hihaha";
$c = "eita";
$b =& $a;
$b = $c;
echo $a; // shows "eita"

$a = "hihaha";
$b = &$a;
$a = null; //unset affects only one name and NULL affects the data,
echo $b; // shows nothing (both are set to null)

//OTHERS.... 
$a = 1;
$b =& $a; //same thing
$b = 2; 
echo "$a,$b\n"; // 2,2

$a = 1;
$b = new stdClass();
$b->x =& $a;

$a = 2;
echo "b->x: $b->x\n"; // 2

$a = 1;  $c = 2;
$b =& $a; // $b points to 1
$a =& $c; // $a points now to 2, but $b still to 1;
echo $a, " ", $b; // Output: 2 1

// 1: assign
//$a is not pointing to $b or vice versa. $a and $b are pointing to the same place. 
$a =& $b; //it means that $a and $b point to the same content. 

// 2: pass
function foo(&$var) {$var++;}
$a=5;
foo($a); //echo 6   

// 3: return by reference
function foo( &$var )  {  
    $var++; 
}
function &bar(){  
    $a = 5;  
    return $a; 
}
foo( bar() );

//ex2
function foo( &$var ) {
    $var++;
}
function &bar() {
    $a = 5;
    return $a;
}
foo( bar() );

//unset
$a = 1;
$b =& $a;
unset($a); //won't unset $b, just $a. 

//last
//global $var <===> $var =& $GLOBALS["var"];
//In an object method, $this is always a reference to the called object. 

gettype($var1) === gettype($var2); //to check


/********************
 * PREDEFINED VARIABLES
 */

/*
Superglobals — Superglobals are built-in variables that are always available in all scopes

$GLOBALS - References all variables available in global scope
$_SERVER - Server and execution environment information
$_GET - HTTP GET variables
$_POST - HTTP POST variables
$_FILES - HTTP File Upload variables
$_REQUEST - HTTP Request variables
     -> $_GET, $_POST and $_COOKIE. 
     ->  import_request_variables ( string $types [, string $prefix ] ) : bool
$_SESSION - Session variables
$_ENV - Environment variables
    ->  getenv ( string $varname [, bool $local_only = FALSE ] ) : string
    ->  getenv ( void ) : array
$_COOKIE - HTTP Cookies
$http_response_header - HTTP response headers   <->  get_headers() 
$argc - The number of arguments passed to script
$argv - Array of arguments passed to script
* 
*/


/***********************
 * Predefined exceptions
 *
    Exception (message,code,file,line)
        ->getMessage, getPrevious, getCode, getFile, getLine, getTrace, getTraceAsString, __toString, __clone
    ErrorException
        ->getSeverity
 
 
    Error
    ArgumentCountError ( is thrown when too few arguments are passed to a user-defined function or method. )
    ArithmeticError (is thrown when an error occurs while performing mathematical operations)
    AssertionError (is thrown when an assertion made via assert() fails. )
            assert() - Checks if assertion is FALSE
    DivisionByZeroError
    CompileError ( is thrown for some compilation errors, which formerly issued a fatal error. )
    ParseError (is thrown when an error occurs while parsing PHP code, such as when eval() is called. )
    TypeError (php7)

See also the SPL Exceptions (function reference)
    BadFunctionCallException, BadMethodCallException, DomainException, InvalidArgumentException, LengthException, LogicException
    OutOfBoundsException, OutOfRangeException, OverflowException, RangeException, RuntimeException, UnderflowException, UnexpectedValueException
*/

/***********************
 * Predefined interface
 *
    Traversable - Interface to detect if a class is traversable using foreach. ( cannot be implemented in PHP scripts )
    Iterator - objects that can be iterated themselves internally. (current, key, next, rewind, valid)
    IteratorAggregate - Interface to create an external Iterator. ( abstract public getIterator ( void ) : Traversable)
    Throwable (php7)
    ArrayAccess - offsetExists ( mixed $offset ) : bool
                 offsetGet ( mixed $offset ) : mixed
                 offsetSet ( mixed $offset , mixed $value ) : void
                 offsetUnset   ( mixed $offset ) : void
    Serializable
         abstract public serialize ( void ) : string
        abstract public unserialize ( string $serialized ) : void
    Closure (Class used to represent anonymous functions. )
         private __construct ( void )
        public static bind ( Closure $closure , object $newthis [, mixed $newscope = "static" ] ) : Closure
        public bindTo ( object $newthis [, mixed $newscope = "static" ] ) : Closure
        public call ( object $newthis [, mixed $... ] ) : mixed
        public static fromCallable ( callable $callable ) : Closure
        this class also has an __invoke method.
    Generator - returned from generators. cannot be instantiated via new.
)
 * 
 */

/********************
 * CONTEXT OPTIONS
 */
// stream_context_create([ array $options [, array $params ]] ) //: resource; //The context is created with 
// stream_context_set_option ( resource $stream_or_context , string $wrapper , string $option , mixed $value ) : bool // Options are set with
// stream_context_set_option ( resource $stream_or_context , array $options ) : bool
// stream_context_set_params ( resource $stream_or_context , array $params ) : bool // parameters with 

/*Socket context options - Socket context option listing
HTTP context options - HTTP context option listing
FTP context options - FTP context option listing
SSL context options - SSL context option listing
CURL context options - CURL context option listing
Phar context options - Phar context option listing
MongoDB context options - MongoDB context option listing
Context parameters - Context parameter listing
Zip context options */

//ex curl
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query(
                        array(
                            'var1' => 'some content',
                            'var2' => 'doh'
                        )
                    )
    )
);
$context = stream_context_create($opts);
$result = file_get_contents('http://example.com/submit.php', false, $context);


// create the context...
$context = stream_context_create(array(
                            'zip' => array(
                                'password' => 'secret',
                            ),
                        ));

// ...and use it to fetch the data
echo file_get_contents('zip://test.zip#test.txt', false, $context);


/***************
 * protocol and wrappers
 *
 *     file:// — Accessing local filesystem
    http:// — Accessing HTTP(s) URLs
    ftp:// — Accessing FTP(s) URLs
    php:// — Accessing various I/O streams
 *      php://stdin, stdout, stderr , input, output, fd (filedescriptor), filter (file_content...)
    zlib:// — Compression Streams
    data:// — Data (RFC 2397)
    glob:// — Find pathnames matching pattern
    phar:// — PHP Archive
    ssh2:// — Secure Shell 2
    rar:// — RAR
    ogg:// — Audio streams
    expect:// — Process Interaction Streams
 */
readfile("php://filter/resource=http://www.example.com"); //output
readfile("php://filter/read=string.toupper/resource=http://www.example.com");
file_put_contents("php://filter/write=string.rot13/resource=example.txt","Hello World");

/*
 * glob
 */
// Loop over all *.php files in ext/spl/examples/ directory
// and print the filename and its size
$it = new DirectoryIterator("glob://ext/spl/examples/*.php");
foreach($it as $f) {
    printf("%s: %.1FK\n", $f->getFilename(), $f->getSize()/1024);
}

/*
 * zip archive
 */
$fp = fopen('zip://./foo.zip#bar.txt', 'r'); 

/*
 * ftp
 */
ftp://example.com/pub/file.txt
//filesize(), filetype(), file_exists(), is_file(), and is_dir() elements only. As of PHP 5.1.0: filemtime(). 
    
/*
 * php
 * https://tools.ietf.org/html/rfc7231#section-4
 * 
 * 
+50

    What are these methods (PUT) and (DELETE) for...

There are a lot of words to spend to explain this, and I'm not skilled enough to do it, but as already posted, a quick recap of what the HTTP specification describes.

The protocol basically says this:

    use GET when you need to access a resource and retrieve data, and you don't have to modify or alter the state of this data.
    use POST when you need to send some data to the server. Ex. from a form to save these data somewhere.
    use HEAD when you need to access a resource and retrieve just the Headers from the response, without any resource data.
    use PUT when you need to replace the state of some data already existing on that system.
    use DELETE when you need to delete a resource (relative to the URI you've sent) on that system.
    use OPTIONS when you need to get the communication options from a resource, so for checking allowed methods for that resource. 
 *              Ex. we use it for CORS request and permissions rules.
 */
// Example to parse "PUT" requests
parse_str(file_get_contents('php://input'), $_PUT);
//<input name="_method" type="hidden" value="delete" />
//So from the application you're now able to recognize this as a DELETE request.

/*
 * ssh
 */
$session = ssh2_connect('example.com', 22);
ssh2_auth_pubkey_file($session, 'username', '/home/username/.ssh/id_rsa.pub',
                                            '/home/username/.ssh/id_rsa', 'secret');
$stream = fopen("ssh2.tunnel://$session/remote.example.com:1234", 'r');
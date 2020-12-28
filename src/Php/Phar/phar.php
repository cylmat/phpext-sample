<?php

ini_set('display_errors', 'on');
error_reporting(-1);

/**
 * PHAR
 */
$phar_filename = 'myphar2.phar';
if(file_exists($phar_filename)) unlink($phar_filename);
createPhar($phar_filename, 'ph');
`chmod a+x $phar_filename`;






function createPhar(string $phar_filename, string $alias=null)
{
    $phar = new Phar(__DIR__ . '/'.$phar_filename, null, $alias);
    $phar['gloshdir/master.php'] = "<?php echo 'called master'.PHP_EOL; ?>";
    $phar->buildFromDirectory(__DIR__ . '/phar');
    $phar->setMetadata(["Librairie"]);

    /**
     * MAKE IT
     */
    //$phar->startBuffering();
    //use for executable
    $stub = "#!/usr/bin/php\n" . $phar->createDefaultStub('input/cli.php'); //string of conteneur
    $stub = myOwnStub($phar_filename, 'public/web.php', 'p');

    $phar['index.php'] = '<?php echo "Hello Worldin"; ?>';
    $phar['index.phps'] = '<?php echo "Hello Worldou"; ?>';

    // set container
    $phar->setStub($stub);
    //$phar->stopBuffering();

    return $phar;
}

/*
 * Conteneur
 * 
 * <?php
 * Phar::mapPhar();
 *  ...
 * __HALT_COMPILER();
 */
function myOwnStub(string $phar_filename='itismyphar.phar', $file_entrypoint='index.php')
{
    //initialise le container 
    $a = "<?php Phar::mapPhar();
include 'phar://$phar_filename/$file_entrypoint';
__HALT_COMPILER();";
    return $a;
}

/*******************************
 * WEB STUB ONLY WITH VERSION 2
 ******************************/

function readPhar($phar_filename)
{
    Phar::loadPhar($phar_filename);
    echo file_get_contents('phar://'.$phar_filename);
}

function write()
{
    `sed -e 's/phar.readonly = On/phar.readonly = Off/' /etc/php/7.4/cli/php.ini -i`;
}

function readonly()
{
    `sed -e 's/phar.readonly = Off/phar.readonly = On/' /etc/php/7.4/cli/php.ini -i`;
}
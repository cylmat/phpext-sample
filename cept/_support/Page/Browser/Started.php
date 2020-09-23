<?php

namespace Page\Browser;

class Started
{
    // include url of current page
    public static $URL = 'docs/02-GettingStarted#Debugging';
    
    public $header = 'h1#getting-started';

    /**
     * @var \BrowserTester;
     */
    protected $browserTester;

    public function __construct(\BrowserTester $I)
    {
        $this->browserTester = $I;
    }

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    public function checkSyntax()
    {
        $I = $this->browserTester;
        $I->see("Syntax"); #different with PhpBrowser (exists on html source)
        $I->seeElement($this->header);
        $I->dontSee("Bad text in this page");
        $I->dontSeeElement('.error');
    }

    public function adminConnexion()
    {
        
    }
}
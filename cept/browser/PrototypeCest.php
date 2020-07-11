<?php

/**
 * phpbrowser api: https://codeception.com/docs/modules/PhpBrowser
 * webdriver: https://codeception.com/docs/modules/WebDriver
 */
class PrototypeCest
{
    public function _before(BrowserTester $I)
    {
        $I->amOnPage('/');
    }

    public function _inject()
    {
        
    }

    /**
     * ref: https://codeception.com/docs/03-BrowserTests
     */
    public function tryAccessLinks(BrowserTester $I)
    {
        $I->see('testing');
        #$I->pause();
        #$I->makeHtmlSnapshot();

        ### LINKS ###

        #[id,name,css,xpath,link,class] => 'text displayed'
        #link(text), button(value,name,text), image(alt)

        
        $I->tryToclick(["link" => "Codeception"]); #click on logo DOESNT WORK <a href>IMAGE + text</a>
        
        ### COOKIES ###

        $I->setCookie('auth', '123345');
        $I->grabCookie('auth');
        $I->seeCookie('auth');

        if ($I->isWebDriver()) {
            ### -WEBDRIVER- ONLY ###

            #$I->makeScreenshot(); 
            #$I->click("/html/body/div[2]/div/div/div/div/a[1]"); #link in the home page button in uppercase 

            // label displayed, not in html
            $I->click(["link" => "QUICK START"]); #link displayed in the home page, button in uppercase 
            #$I->click(["link" => "quickstart"]); #click on the top menu link
            #$I->click(["link" => "CODECEPTION_"]); #click on logo

        } else {
            ### BROWSER ###

            $I->click(["link" => "Quick Start"]); #link in the home page, button in uppercase 
            $I->click(["link" => "QuickStart"]); #click on the top menu link
            $I->click("A Complete Getting Started Guide");
        }
        
    }
    
    /**
     * ref: https://codeception.com/docs/03-BrowserTests
     */
    public function tryAccessSee(BrowserTester $I, \Page\Browser\Started $startedPage, \Step\Browser\Admin $I_from_step)
    {
        /**
        * Custom actor in BrowserTester
         * in: cept\_support\BrowserTester.php
         */
        $I->_customActor_seeThatInTitle('database testing');

        ### COMMENTS ###

        /*
            wantToTest($text)  
            wantTo($text) 
            execute($callable) 
            expectTo($prediction) 
            expect($prediction)
            amGoingTo($argumentation) 
            am($role) 
            lookForwardTo($achieveValue) 
            comment($description) 
        */
        $I->lookForwardTo('Test seeing');
        $I->amOnPage('docs/02-GettingStarted');
        $I->seeInTitle('02-GettingStarted');

        ### SEE ###
        
        $I->see("Syntax"); #different with PhpBrowser (exists on html source)
        $I->seeElement("#getting-started");
        $I->dontSee("Bad text in this page");
        $I->dontSeeElement('.error');

        /**
         * Custom generate:Page
         */
        $startedPage->checkSyntax(); #put all this validations into a pageobject

        /**
         * Custom generate:Stepobject
         */
        $I_from_step->validate();
        $I->seeInCurrentUrl('docs/02-GettingStarted');
        $text = $I->grabTextFrom('h1#getting-started');
        $api_key = $I->grabValueFrom('input[name=query]');
        //codecept_debug($I->customhelper_getCurrentUrl()); #with codecept --debug

        #CONDITIONAL
        #$I->canSeeInCurrentUrl('error/but/will/continue'); #maybe or not

        #SILENCE

        /*
        in Browser.suite.yml then "bin/codecept build"
        
        step_decorators:  
            - \Codeception\Step\TryTo 
         */
        $I->tryToClick('X', '.alert_popup_if_exists'); 
###        $I->seeInTitle('02-GettingStarted'); #error! because tryToClick?

        #$I->seeCheckboxIsChecked('#agree');
#        $I->seeInField(['name' => 'query'], '');
        $I->see('The Codeception Syntax');
        $I->see("Getting Started"); #different with PhpBrowser (exists on html source)
        $I->dontSeeInTitle('Login');
       
        $I->seeCurrentUrlEquals('/docs/02-GettingStarted');
        $I->seeCurrentUrlMatches('/(\d+)-Getting/');
        $I->seeInCurrentUrl('02-');
        $user_id = $I->grabFromCurrentUrl('/(\d+)-Getting/');

        /**
         * Loaded in Browserdriver.suite.yml 
         *      - \Helper\Browser
         * 
         * in: cept\_support\Helper\Browser.php
         *      return $this->getModule('WebDriver')->_getCurrentUri();
         */
        $url = $I->customhelper_validCurrentUrl(); 

        ### WEBDRIVER ###

        #$I->saveSessionSnapshot('login');  //Codeception\Lib\Interfaces\SessionSnapshot
        #$I->loadSessionSnapshot('login'); 

        #$I->wait(1);
        #$I->waitForElement(['css' => 'h1#getting-started'], 5);
        #$I->waitForElement("h1#getting-started", 5); #WebDriver only
        #$I->seeElement("h1#getting-started"); #WebDriver only, visible for user
    }
   

    /**
     * add use \Codeception\Lib\Actor\Shared\Friend; 
     * in cept\_support\BrowserTester.php
     */
    public function tryAccessMultipleWindows(BrowserTester $I)
    {
        return;
        ### MULTISESSION ###
        
        $client = $I->haveFriend('client');
        $client->does(function(BrowserTester $I) {
            $I->amOnPage('/docs/02-GettingStarted#Debugging');
            $I->fillField('query', 'data');
            #$I->click('Send');
            $I->see('Search', 'h1.page-title');
        });
    }
 
  
    /**
     * ref: https://codeception.com/docs/03-BrowserTests
     */
    public function tryAccessForms(BrowserTester $I)
    {
        $I->amOnPage("/docs/02-GettingStarted");

        ### FORMS ###

    #    $I->fillField('query', 'data'); // we can use input name or id
        #$I->selectOption('name','option');
        #$I->fillField('password', new \Codeception\Step\Argument\PasswordArgument('thisissecret'));
        #$I->click('Update');

        /*$I->performOn('.modal_windows', function(\Codeception\Module\WebDriver $I) {
            $I->see('Warning');
            $I->see('Are you sure you want to delete this?');
            $I->click('Yes');
        });*/

        // send 
        // $I->submitForm('#update_form', 
        //     array('user' => [
        //         'name' => 'Miles',
        //         'email' => 'Davis',
        //         'gender' => 'm',
        //         'submitButton' => 'Update'
        //     ])
        // , 'submitButton');
    }

    public function _failed(\BrowserTester $I)
    {
        // will be executed on test failure
    }
    
    public function _passed(\BrowserTester $I)
    {
        // will be executed when test is successful
    }
}


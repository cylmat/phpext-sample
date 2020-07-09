<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Browser extends \Codeception\Module
{
    public function customhelper_validCurrentUrl()
    {
        ###webdriver###

        #$elements = $this->getModule('WebDriver')->_findElements('#result');
        #$url = $this->getModule('WebDriver')->_getCurrentUri();
       
        #$this->assertTrue('');
        #$this->assertNotEmpty();

        #return $url;
    }
}

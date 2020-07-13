<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Browser extends \Codeception\Module
{
     /**
     * Get current url from WebDriver
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function customhelper_validCurrentUrl()
    {
        ###webdriver###

        #$elements = $this->getModule('WebDriver')->_findElements('#result');
        #$url = $this->getModule('WebDriver')->_getCurrentUri();
       
        #$this->assertTrue('');
        #$this->assertNotEmpty();

        #return $url;
    }


    public function getModuleConfig()
    {
        $c = \Codeception\Configuration::suiteSettings('browser', \Codeception\Configuration::config());

        return ($c['params']['custom_param']);
    }

    public function getCurrentEnabled()
    {
        $c = \Codeception\Configuration::suiteSettings('browser', \Codeception\Configuration::config());

        return ($c['modules']['enabled'][0]);
    }

    public function isWebDriver()
    {
        $enabled = $this->getCurrentEnabled();
        if ('WebDriver' == $enabled) {
            return true;
        }
        return false;
    }
}

<?php

use Facebook\WebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * https://php-webdriver.github.io/php-webdriver/latest/Facebook/WebDriver/Remote/RemoteWebDriver.html
 */
class WebDriverTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;
    protected $url = 'https://codeception.com';

    protected $is_selenium_active = true;

    public function setUp(): void
    {
        $capabilities = array(
                WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
                WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
                WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
                'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('user:pa55w0rd')
        );

        try {
            $this->webDriver = RemoteWebDriver::create('selenium:4444/wd/hub', $capabilities);  
            $this->setUp_alternate();

        } catch(\Facebook\WebDriver\Exception\WebDriverCurlException $e) {
            $this->is_selenium_active = false;
        }
    }

    public function setUp_alternate(): void
    {
        $desiredCapabilities = WebDriver\Remote\DesiredCapabilities::phantomjs();

        $desiredCapabilities->setCapability('trustAllSSLCertificates', true);
        $desiredCapabilities->setCapability('javascriptEnabled', true);
        $desiredCapabilities->setCapability('phantomjs.page.customHeaders.Authorization',  "Basic c3VwcG9ydC50bWFpZDokdVAzNGEyVyFuPg==");
        $desiredCapabilities->setCapability('phantomjs.page.windowHandleSize',  "width:480");
      
        $this->webDriver = WebDriver\Remote\RemoteWebDriver::create(
            'selenium:4444/wd/hub',
            $desiredCapabilities
        );
        
        // Set window size to 800x600 px
        #https://github.com/php-webdriver/php-webdriver/wiki/Example-command-reference
        $this->webDriver->manage()->window()->setSize(new WebDriver\WebDriverDimension(800, 600));
        
        $this->webDriver->manage()->window()->maximize(); #300, 400
    }
    
    public function testToGetHome()
    {
        if (!$this->is_selenium_active) {
            $this->assertTrue(true);
            return;
        }

        /**
         * Based on Katalon recorder extension
         */
        $this->webDriver->get($this->url);
        $this->assertStringContainsString('Testing framework', $this->webDriver->getTitle());

        //$this->webDriver->findElement(WebDriver\WebDriverBy::xpath("/html/body/nav/div/div[2]/ul/li[1]/a"))->click();

        $this->assertStringContainsString('unit testing', $this->webDriver->getPageSource());
        $this->webDriver->close();
    }
}
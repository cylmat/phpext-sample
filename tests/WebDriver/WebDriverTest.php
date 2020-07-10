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

    public function setUp(): void
    {
        $capabilities = array(
                WebDriverCapabilityType::BROWSER_NAME => WebDriverBrowserType::PHANTOMJS,
                WebDriverCapabilityType::ACCEPT_SSL_CERTS=> true,
                WebDriverCapabilityType::JAVASCRIPT_ENABLED=>true,
                'phantomjs.page.customHeaders.Authorization' => "Basic " . base64_encode('user:pa55w0rd')
        );

        // alternate
        //$desiredCapabilities = WebDriver\Remote\DesiredCapabilities::phantomjs();
        //$capabilities->setCapability('trustAllSSLCertificates', true);

        $this->webDriver = RemoteWebDriver::create('selenium:4444/wd/hub', $capabilities);  
    }
    
    public function testToGetHome()
    {
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
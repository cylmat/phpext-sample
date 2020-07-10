```
class AcceptdriverTester extends \Codeception\Actor
{
    use _generated\AcceptdriverTesterActions;
    /**
     * Define custom actions here
     */
    use \Codeception\Lib\Actor\Shared\Friend; 
    public function _customActor_seeThatInTitle($value)
    {
        return $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeInTitle', [$value]));
    }
}
```

```
namespace Step\Acceptdriver;
class Admin extends \AcceptdriverTester
{
    public function validate()
    {
        $I = $this;
        $I->seeInCurrentUrl('docs/02-GettingStarted');
        $text = $I->grabTextFrom('h1#getting-started');
    }
}
```

```
<?php
namespace Page\Acceptdriver;
class Started
{
    // include url of current page
    public static $URL = 'docs/02-GettingStarted#Debugging';
    public $header = 'h1#getting-started';
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
    /**
     * @var \AcceptdriverTester;
     */
    protected $acceptdriverTester;
    public function __construct(\AcceptdriverTester $I)
    {
        $this->acceptdriverTester = $I;
    }
    public function checkSyntax()
    {
        $I = $this->acceptdriverTester;
        $I->see("Syntax"); #different with PhpBrowser (exists on html source)
        $I->seeElement($this->header);
        $I->dontSee("Bad text in this page");
        $I->dontSeeElement('.error');
    }
}
```

```
<?php
namespace Page\Acceptance;
use \Codeception\Step\Argument\PasswordArgument;
class AdminPage
{
    // include url of current page
    public static $URL = 'https://crm-tmaid.preprod.imagesdefense.fr/index.php/admin/';
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
    public function connexion()
    {
        $I = $this->acceptanceTester;
        $I->amOnUrl(self::$URL);
        $I->fillField("login[username]", "francois.breard");
        $I->fillField("login[password]", new PasswordArgument('$uP34a2W!n>back'));
        //
        $I->click("Connexion");
       // $I->makeScreenshot();
        $I->click(['link'=>"fermer"]);
    }
    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }
}
```

```
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I
class Acceptdriver extends \Codeception\Module
{
    // HOOK: used after configuration is loaded
    public function _initialize()
    {
        
    }
    /**
     * Get current url from WebDriver
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function customhelper_getCurrentUrl()
    {
        // $this->getModule('WebDriver')->_reconfigure(array('url' => 'https://codeception.com'));
        // $this->getModule('WebDriver')->_restart();
        $url = $this->getModule('WebDriver')->_getCurrentUri();
        
        return $this->getModule('WebDriver')->_getCurrentUri();
    }
}
```

```
actor: AcceptdriverTester
step_decorators: 
  - \Codeception\Step\TryTo
modules:
    enabled:
      - \Helper\Acceptdriver
      - WebDriver:
          url: https://codeception.com
          browser: phantomjs
          host: sel
          port: 4444
          window_size: maximize #Initial window size. Set to maximize 
          capabilities: 
            #  acceptSslCerts: true
              trustAllSSLCertificates: true
              javascriptEnabled: true
              #phantomjs.page.customHeaders.Authorization:  "Basic c3VwcG9ydC50bWFpZDokdVAzNGEyVyFuPg==" #user:pass
     
      - REST:
          url: '%REST_URL%'
          depends: PhpBrowser
          part: Json
      - SOAP:
          endpoint: http://192.168.99.100:82/soaps/index/getBenchWsdl
          depends: PhpBrowser
```

```
actor: AcceptanceTester
modules:
    enabled:
        - \Helper\Acceptance
        - WebDriver:
            url: https://preprod.imagesdefense.fr
            browser: phantomjs
            host: sel
            port: 4444
            window_size: maximize #Initial window size. Set to maximize 
            capabilities: 
              #  acceptSslCerts: true
                trustAllSSLCertificates: true
                javascriptEnabled: true
                phantomjs.page.customHeaders.Authorization:  "Basic dmlwMTp2aXAx" #"Basic c3VwcG9ydC50bWFpZDokdVAzNGEyVyFuPg==" #user:pass
               
```

```
class SoapUnitTest extends \Codeception\Test\Unit
{
    /**
     * @var \LocalTester
     */
    protected $tester;
    
    protected function _before()
    {
    }
    protected function _after()
    {
    }
    // tests
    public function testSomeFeature()
    {
        $server = new Soap\Manager\ServerManager;
        $credential = [(object)['key'=>'Username','value'=>'u'],(object)['key'=>'Password','value'=>'p']];
        $server->Header($credential);
        $msg = $server->getMessage('alpha');
        $this->assertStringContainsString('Login', $msg);
       
    }
}
```
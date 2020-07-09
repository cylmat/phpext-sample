config
```
enabled:
        #- PhpBrowser:
        - WebDriver:
            url: https://user:pass@imagesdefense.fr
            #auth: [user', 'pass']
            browser: phantomjs
            host: 172.21.0.3
            port: 4444
            #window_size: false #false fro chrome
            #restart: true
            # capabilities:
            #     "goog:chromeOptions": # additional chrome options
        - Asserts
        - \Helper\Acceptance
    step_decorators: ~
```

```
<?php 
use Codeception\Step\Argument\PasswordArgument;
class SampleCest99
{
    /**
     * @before login
     * @after close
     * 
     * @example ["/api/", 200]
     * @example ["/api/protected", 401]
     */
    public function tryCentralPage(AcceptanceTester $I, \Codeception\Example $example)
    {
        $I->sendGET($example[0]);
        $I->seeResponseCodeIs($example[1]);

        $I->amOnPage('/3288065.html');
        $I->seeInSource("Centrale électrique de Kakanj");

        $I->inside();

        //click link
        $I->click('[Centrale électriqu...'); 
        $I->see('Pakula Jean-Pierre');

        /*$I->fillField('q', 'inserting');
        $I->click("Rechercher");*/

        $I->submitForm('#search_mini_form', [
            'q' => "inserting",
            'r' => new PasswordArgument('pass') 
        ]);
        $I->amOnPage('/catalogsearch/result/?q=inserting&display_type=list&avec_visuel=Oui');

        $I->see('Pyrotechnie');
        $I->see('N2004-263L02-0076');
    }

    /**
     * @group admin
     * 
     * @dataProvider pageProvider
     */
    public function tryErrorPage(AcceptanceTester $I, \Codeception\Example $example)
    {
        #error
        //$I->amOnPage('/nos-collections/theme/vie-des-armees/1579952.html');
        $I->amOnPage($example['url']);
        $I->see($example['title'], 'h1');
        $I->seeInTitle($example['title']);
    }

    protected function login(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Username', 'miles');
        $I->fillField('Password', 'davis');
        $I->click('Login');
    }

    /**
     * @ env firefox
     */
    protected function close()
    {

    } 

    protected function pageProvider()
    {
        return [
            ['url'=>"/", 'title'=>"Welcome"],
            ['url'=>"/info", 'title'=>"Info"],
            ['url'=>"/about", 'title'=>"About Us"],
            ['url'=>"/contact", 'title'=>"Contact Us"]
        ];
    }
}
```
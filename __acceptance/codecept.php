* CODECEPTION *
 wantToTest($text)  wantTo($text) execute($callable) expectTo($prediction) expect($prediction)
 amGoingTo($argumentation) am($role) lookForwardTo($achieveValue) comment($description) pause()

 amOnPage() fillField('Username','davert') click('Login') see('Hello, davert') etc...
 see() dontSee() $I->seeElement('.notice')  seeNumberOfElements(['css' => 'button.link'], 5)
 seeInCurrentUrl('/user/miles') seeCheckboxIsChecked('#agree') seeInField('user[name]', 'Miles') seeLink('Login');
 CONDIT° NO FAIL(config) 
    canSeeInCurrentUrl('/user/miles') canSeeCheckboxIsChecked('#agree') cantSeeInField('user[name]', 'Miles')
    (config:\Codeception\Step\TryTo)    $I->tryToClick('x', '.alert');  $I->tryToSeeElement('.alert')
 Comment: amGoingTo() expect() expectTo()
 $password = $I->grabTextFrom('#password'); $I->grabTextFrom("descendant::input/descendant::*[@id = 'password']");
 $I->setCookie('auth', '123345'); $I->grabCookie('auth'); $I->seeCookie('auth')
 seeInTitle() seeCurrentUrlEquals() seeCurrentUrlMatches() seeInCurrentUrl() $user_id = $I->grabFromCurrentUrl('~^/user/(\d+)/~');

 - WebDriver
 wait(3) $I->waitForElement('#agree_button', 30); // secs waitForElementVisible() etc...
 Session: $I->loadSessionSnapshot('login') saveSessionSnapshot('login')  Codeception\Lib\Interfaces\SessionSnapshot
 Helper Webdriver: _initializeSession  _closeSession  _restart  _capabilities 


* PHPSPEC *
    $this->prophet = new \Prophecy\Prophet; $user->reveal();
    $user = $this->prophet->prophesize()->willExtend('stdClass')->willImplement('Reader\ReaderInterface');
    $this->prophet->checkPredictions(); 

    Return() shouldBe() BeLike() BeApproximately()
    $this->shouldTrigger(E_USER_DEPRECATED)->duringSetStars(4); duringInstantiation()
        Throw->during('setRating', array(-3)); 
    HaveType() BeAnInstanceOf() Implement()

    hasSoundtrack() isSoundtrack() $this->shouldHaveSoundtrack(); shouldBeSoundtrack();
    shouldHaveCount(1);     shouldBeString();    shouldContain('Jane Smith');
    HaveKeyWithValue('k', 'v'); shouldIterateLike()
    houldHaveKey('v'); shouldIterateAs(new \ArrayIterator()) shouldYield(new \ArrayIterator())
    shouldStartIteratingAs() shouldContain() shouldStartWith() shouldMatch()

* PROPHECY *
    willExtend() willImplemen(t) willBeConstructedWith() reveal()
    addMethodProphecy() getMethodProphecies() makeProphecyMethodCall()
    findProphecyMethodCalls() checkProphecyMethodsPredictions()

    Argument::is($value) ::exact($value) ::type($typeOrClass) ::which($method, $value) 
        ::that(callback) ::any() ::cetera() ::containingString($value) - checks that the argument contains a specific string value
    CallPrediction or shouldBeCalled()  shouldNotBeCalled()  shouldBeCalledTimes($count)  should($callback) -



TIPS
```
CLASS
public function getwsdlAction($params=[2]): void
    {
        $autodiscover = new \Laminas\Soap\AutoDiscover();

        $autodiscover
            ->setClass('\Soaps\Manager\ServerManager' )
            ->setUri(\Soaps\Manager\ServerManager::$URL)
            ->setBindingStyle();
            
        header('Content-Type: text/xml');
        $wsdl = $autodiscover->generate();
        echo $wsdl->toXML();

    }

PHPSPEC
function it_can_get_wsdl()
    {
        ob_start();
     //  $p = (new \Prophecy\Prophet)->prophesize()->willExtend(IndexController::class)->reveal();
     //  $p->getwsdlAction()->will();

        
    $this->getwsdlAction()->shouldReturn(null); #error, no return at all

        $this->getwsdlAction()->shouldBeLike(null);
        $this->getwsdlAction()->shouldBeEqualTo(null);
        ob_end_clean();
    }
```
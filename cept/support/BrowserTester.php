<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class BrowserTester extends \Codeception\Actor
{
    use _generated\BrowserTesterActions;

    use \Codeception\Lib\Actor\Shared\Friend; 

    /**
     * Define custom actions here
     */
    function _customActor_seeThatInTitle($title)
    {
        $I = $this;
        
        $I->seeInTitle($title);
    }
}

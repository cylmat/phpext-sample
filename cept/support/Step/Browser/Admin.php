<?php

namespace Step\Browser;

class Admin extends \BrowserTester
{
    public function validate()
    {
        $I = $this;
        $I->seeInCurrentUrl('docs/02-GettingStarted');
        $text = $I->grabTextFrom('h1#getting-started');
    }

}
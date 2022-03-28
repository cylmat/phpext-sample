<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Auth\Index;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    protected Index $index;

    protected function setUp(): void
    {
        $this->index = new Index;
    }

    public function testBasic() 
    {
        $_SERVER['PHP_AUTH_USER'] = 'user';
        $_SERVER['PHP_AUTH_PW'] = 'pass';
        $_SESSION['delai'] = time();
        $this->index->basic();
        $this->expectOutputRegex('/auth ok/');
    }

    public function testDigest() 
    {
        $fake_response = '64049b9bfd4c431da1f14564281e72b2';
        
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PHP_AUTH_DIGEST'] = 'username="user", realm="Auth", nonce="c29hcDVlZjViMTRmZTJlODExLjg3Mzg2OTAz", uri="/soap/server/digest",'.
            'algorithm=MD5, response="'.$fake_response.'", opaque="xxxxxx", qop=auth, nc=xxxxxxx, cnonce="xxxxxxxx';
        
        $_SESSION['delai'] = time();

        $this->index->digest();
        $this->expectOutputRegex('/digest ok/');
    }
}

<?php

declare(strict_types=1);

namespace PU;

use PHPUnit\Framework\TestCase;

/*
 * - A stub is a class that *implements an API or interface** that a test cannot test easily directly on its own, 
 *      in order to make testing possible.
 * - A mock is a class that extends another class that the test is directly dependent on, 
 *      in order to change behaviors of that class to make testing easier.
 */
class PrototypeTest extends TestCase
{
    protected $stack = [];

    protected static $dbh;

    protected $backupStaticAttributesBlacklist = [
        'className' => ['attributeName']
    ];

    public static function setUpBeforeClass(): void
    {
        //fwrite(STDOUT, __METHOD__ . "\n");
        self::$dbh = new \PDO('sqlite::memory:');
    }

    protected function setUp(): void
    {
        array_push($this->stack, 'alpha');
    }

    protected function assertPreConditions(): void
    {
        
    }

    #for param1
    public function testStream()
    {
        $this->assertTrue(true);
        return ['trois'=>'alpha'];
    }

    #for param2
    public function testStream2()
    {
        $this->assertTrue(true);
        return 'return quatre fois';
    }

    #for both params
    public function streamProvider()
    {
        return [
            [['trois'=>'gamma'], 'quatre et deux'],
            [['trois'=>'epsilon'], 'quatre et cinq']
        ];
    }

    /**
     * @depends testStream 
     * @depends testStream2
     * 
     * @dataProvider streamProvider 
     */
    public function testExecute(array $stack, string $stack2)
    {
        $this->assertArrayHasKey('trois', $stack);
        $this->assertStringContainsString('quatre', $stack2);
        $this->assertSame('alpha', $this->stack[count($this->stack)-1]);

        // Output
        $this->expectOutputString('echoed');
        echo 'echoed';

        // Exceptions
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('E'); #contains
        throw new \InvalidArgumentException('There is an E in the message');
    }

    /**
     * Only ONE error or exception to test
     */
    public function testErrors()
    {
        // Errors
        //$this->ExpectNotice(); #notice
        //trigger_error('launch error', \E_USER_ERROR); #DOESNT WORK
        // Errors
        $this->ExpectError(); #notice, warning, error
        trigger_error('launch error', \E_USER_ERROR); #OK
    }

    /**
     * The practice of replacing an object with a test double that (optionally) returns configured return values is referred to as stubbing. 
     * You can use a stub to “replace a real component on which the SUT depends so that the test has a control point for the indirect inputs of the SUT
     */
    public function testStub()
    {
        // stub
        $stub = $this->createStub(SomeClassToBeStubbed::class);
         #NO ACCESS
        //$stub->method('noAccess')->willReturn('-impossible-'); #error
        
        // MEthod call
        $stub->method('doSomething')->willReturn(['stubbed return value 19']);
        $this->assertSame(['stubbed return value 19'], $stub->doSomething('input string value'));

        // MApping
        $map = [
            ['inputstring', 'returned map value'], #arg1, arg2, arg3, return
            ['inputstring2', 'returned2']
        ];

        $stub->method('doOtherThing')->will($this->returnValueMap($map));
        $this->assertSame('returned2', $stub->doOtherThing('inputstring2'));

        //stub2
        $stub2 = $this->createStub(SomeClassToBeStubbed::class);

        // Expect method
        $stub2->expects($this->any())->method('doSomething')->willReturn(['inside method call2']);
        $this->assertSame(['inside method call2'], $stub2->doSomething('any input'));
        $stub2->method('doOtherThing')->willReturnCallback(function($input){ return $input . ' called_back'; });
        $this->assertSame('56 called_back', $stub2->doOtherThing('56'));

        #has NOT to be called
        $stub2->expects($this->never())->method($this->anything());
    }

    // In SUT, System Under Test
    public function testMockBuilder()
    {
        // stub
        $stub = $this->getMockBuilder(SomeClassToBeStubbed::class)
                    ->disableOriginalConstructor()
                    ->disableOriginalClone()
                    ->disallowMockingUnknownTypes()
                    ->getMock();
        
        $stub->method('doOtherThing')->will($this->returnValue('troisieme'));
        $this->assertSame('troisieme', $stub->doOtherThing('true'));

        $stub = $this->getMockBuilder(SomeClassToBeStubbed::class)
                    ->disableOriginalConstructor()
                    ->disableOriginalClone()
                    ->disallowMockingUnknownTypes()
                    ->getMock();

        $stub->method('doOtherThing')->will($this->returnArgument(0));
        $this->assertSame('false', $stub->doOtherThing('false'));
    }

    /**
     * The practice of replacing an object with a test double that verifies expectations, for instance asserting that a method has been called, is referred to as mocking.
     * You can use a mock object “as an observation point that is used to verify the indirect outputs of the SUT as it is exercised.
     */
    public function testMock()
    {
        //mock
        $mockInvoked = $this->createMock(SmallClassInvoked::class);
        // invoke method

        $mockInvoked->expects($this->exactly(2)) #$this->once())
            ->method('calledMethod')
            ->with($this->equalTo('execute_both')); #arguments expected
        
        $class = new SomeClassCalling($mockInvoked);
        $class->doCallOutside('execute_both');

        //mock2
        $mockInvoked2 = $this->createMock(SmallClassInvoked::class);

        //try with diffents parameters
        $mockInvoked2->expects($this->exactly(1)) #$this->once())
            ->method('calledMethod')
            ->with($this->anything());  
        
        $class = new SomeClassCalling($mockInvoked2);
        $class->doCallOutside('any argument');
    }

    /**
     * complexe
     * see ref: https://phpunit.readthedocs.io/en/8.5/assertions.html?highlight=stringContains#assertthat
     */
    function testComplexMock()
    {
        $mock = $this->getMockBuilder(stdClass::class)
                    ->setMethods(['set', 'up'])
                    ->getMock();
        //setConstructorArgs(array $args): self
        //setMockClassName(string $name): self

        $mock->expects($this->exactly(2))
                ->method('set')
                ->with( #rules
                    $this->stringContains('Something'),
                    $this->isType('int'),
                    $this->callback(function($obj){
                        return is_callable([$obj, 'getName']) &&
                            $obj->getName() == 'My subject';
                    }));

                /*->withConsecutive(
                    [$this->equalTo('foo'), $this->greaterThan(0)],
                    [$this->equalTo('bar'), $this->greaterThan(0)]
                );*/

        $mock->set('Something up', 21, new class { function getName() {return 'My subject';} });
        $mock->set('Something down', 48, new class { function getName() {return 'My subject';} });

        /*
         * 2
         */
        $mock2 = $this->getMockBuilder(stdClass::class)
                    ->setMethods(['set', 'up'])
                    ->getMock();

        $mock2->expects($this->exactly(2))
                ->method('set')
                ->withConsecutive(
                    [$this->equalTo('up'), $this->greaterThan(0)],
                    [$this->equalTo('down'), $this->LessThan(0)]
                );

        $mock2->set('up', 21);
        $mock2->set('down', -48);
        //$mock2->set('third', 0); #error "was not expected to be called more than 2 times."
    }

    /*protected function onNotSuccessfulTest(\Throwable $t): void
    {
        fwrite(STDOUT, " unsuccessful\n");
        throw $t;
    }*/

    public static function tearDownAfterClass(): void
    {
        //file_put_contents('php://stdout', "\n" . __METHOD__ . " end\n");
        self::$dbh = null;
    }
}

class SomeClassToBeStubbed
{
    public function __construct(bool $isValid)
    {
        echo $isValid;
    }

    public function doSomething(string $param): array
    {
        // Do something.
        return [$param . ' added', $param . ' added2'];
    }

    public function doOtherThing(string $is): string
    {
        // Do something.
        return 'alpha';
    }

    private function noAccess(): void
    {
    }
}

class SomeClassCalling
{
    private $invokedClass;

    public function __construct(SmallClassInvoked $invokedClass)
    {
        $this->invokedClass = $invokedClass;
    }

    public function doCallOutside(string $params)
    {
        $this->invokedClass->calledMethod($params);
        // Do something.
        if ('execute_both' == $params) {
            $this->invokedClass->calledMethod($params);
        }
    }
}

class SmallClassInvoked
{
    function calledMethod(string $p): void
    {
        //send email
        echo $p . 'invoked!';
    }
}
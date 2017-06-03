<?php

namespace Leaveyou\Console\Tests\Input;

use Leaveyou\Console\Input;
use Leaveyou\Console\ParameterSet;
use Leaveyou\Console\Tests\ProtectedHelper;
use Leaveyou\Console\Tools\CommandLineParser;
use Leaveyou\Console\Tools\Help;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use ReflectionClass;

class __constructTest extends MockeryTestCase
{
    /**
     * @var MockInterface|Input
     */
    protected $class;

    /**
     * @var MockInterface|ParameterSet
     */
    protected $parameters;

    /**
     * @var MockInterface|CommandLineParser
     */
    protected $parser;

    /**
     * @var MockInterface|Help
     */
    protected $help;

    protected function callConstructor()
    {
        $reflectedClass = new ReflectionClass(Input::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($this->class, $this->parameters, $this->parser, $this->help);

    }

    public function __construct()
    {
        parent::__construct();

        $this->parameters = Mockery::mock(ParameterSet::class);
        $this->parser = Mockery::mock(CommandLineParser::class);
        $this->help = Mockery::mock(Help::class);
    }

    public function testParametersAreSet()
    {
        $this->parameters->shouldReceive("addParameter")->once()->andReturnNull();
        $this->class = new Input($this->parameters, $this->parser, $this->help);

        $accessibleClass = new ProtectedHelper($this->class);

        $this->assertEquals($accessibleClass->parameters, $this->parameters);
        $this->assertEquals($accessibleClass->parser, $this->parser);
        $this->assertEquals($accessibleClass->help, $this->help);
    }


}
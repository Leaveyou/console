<?php

namespace Leaveyou\Console;


use Leaveyou\Console\IncorrectImplementationException;

class Input
{
    /**
     * Storage for the parameters
     * @var ParameterSet
     */
    protected $parameters;

    /**
     * @var CommandLineParser
     */
    protected $parser;
    /**
     * Whether the console input has been parsed.
     * This resets every time you add a parameter
     * @var bool
     */
    protected $parsed = false;

    protected $parsedParameters = [];

    /**
     * @var Help
     */
    protected $help;

    /**
     * Input constructor.
     * @param ParameterSet      $parameters
     * @param CommandLineParser $parser
     * @param Help              $help
     */
    public function __construct(ParameterSet $parameters, CommandLineParser $parser, Help $help)
    {
        $this->parameters = $parameters;
        $this->parser = $parser;
        $this->help = $help;

        $this->setDefaultParameters();
    }

    private function setDefaultParameters()
    {
        $helpParameter = new Parameter(Parameter::OPTION_HELP);
        $helpParameter->setDescription("Shows this help message");
        $helpParameter->setType(Parameter::TYPE_FLAG);
        $this->parameters->addParameter($helpParameter);
    }

    public function addParameter(Parameter $parameter)
    {
        // mark that we have to re-parse the input
        $this->parsed = false;

        // add the parameter to parameter storage
        $this->parameters->addParameter($parameter);
    }

    public function getValue($parameterName)
    {
        if (!is_string($parameterName)) {
            throw new IncorrectImplementationException("Parameter name must be a string");
        }

        $this->parse();

        $parameter = $this->parameters->getByEitherName($parameterName);
        $parameterLongName = $parameter->getLongName();

        if (!isset($this->parsedParameters[$parameterLongName])) {
            return $parameter->getDefaultValue();
        }
        return $this->parsedParameters[$parameterLongName];
    }

    /**
     * Parse input according to defined parameters
     * @return bool
     */
    private function parse()
    {
        if ($this->parsed) {
            return true;
        }

        try {
            $this->parsedParameters = $this->parser->parse($this->parameters);
        } catch (IncorrectUsageException $e) {
            $help = $this->help->render($this->parameters, $e->getMessage());
            die($help);
        }

        $this->parsed = true;
        return true;
    }
}

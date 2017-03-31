<?php

namespace Leaveyou\Console;


class Input
{
    /**
     * Storage for the parameters
     * @var ParameterSet
     */
    protected $parameters;

    /**
     * Whether the console input has been parsed.
     * This resets every time you add a parameter
     * @var bool
     */
    protected $parsed = false;

    public function __construct(ParameterSet $parameters)
    {
        $this->parameters = $parameters;
    }

    public function addParameter(Parameter $parameter)
    {
        // mark that we have to re-parse the input
        $this->parsed = false;

        // add the parameter to parameter storage
        $this->parameters->addParameter($parameter);


    }

    public function getValue($parameterName, $default = false)
    {
        $this->parse();
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

        // todo: parse input

        $this->parsed = true;
        return true;
    }
}
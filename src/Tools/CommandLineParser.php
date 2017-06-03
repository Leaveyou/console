<?php

namespace Leaveyou\Console\Tools;


use Leaveyou\Console\Exceptions\IncorrectImplementationException;
use Leaveyou\Console\Exceptions\IncorrectUsageException;
use Leaveyou\Console\Parameter;
use Leaveyou\Console\ParameterSet;

class CommandLineParser
{
    protected $normalizer;

    public function __construct(ResultNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param ParameterSet $parameters
     * @return array
     */
    public function parse(ParameterSet $parameters)
    {
        $longOptions = [];
        $shortOptions = "";

        foreach ($parameters as $parameter) {
            $suffix = $this->getParameterSuffix($parameter);

            $longOptions[] = $this->getLongOption($parameter, $suffix);
            $shortOptions .= $this->getShortOption($parameter, $suffix);
        }

        /**
         * @link http://php.net/manual/en/function.getopt.php
         */
        $rawValues = getopt($shortOptions, $longOptions);

        if ($rawValues === false) {
            throw new IncorrectUsageException("You have managed to jam the console component. What input did you use?");
        }

        if (isset($rawValues[Parameter::OPTION_HELP])) {
            throw new IncorrectUsageException("Asked for help page...");
        }


        $values = $this->normalizer->normalize($parameters, $rawValues);
        return $values;
    }

    /**
     * @param Parameter $parameter
     * @return string
     */
    protected function getParameterSuffix(Parameter $parameter)
    {
        $parameterType = $parameter->getType();

        switch ($parameterType) {
            case Parameter::TYPE_MANDATORY:
                return ":";
                break;
            case Parameter::TYPE_OPTIONAL:
                return "::";
                break;
            case Parameter::TYPE_FLAG:
                return "";
                break;
            default:
                throw new IncorrectImplementationException("Parameter Type incorrect. This should not happen "
                    . "regardless of the implementation and is likely an issue in the module code.");
                break;
        }
    }

    protected function getLongOption(Parameter $parameter, $suffix)
    {
        $parameterLongName = $parameter->getLongName();
        return $parameterLongName . $suffix;
    }

    protected function getShortOption(Parameter $parameter, $suffix)
    {
        $parameterShortName = $parameter->getShortName();
        if ($parameterShortName) {

            return $parameterShortName . $suffix;
        }
        return "";
    }
}

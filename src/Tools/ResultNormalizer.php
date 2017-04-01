<?php

namespace Leaveyou\Console\Tools;


use Leaveyou\Console\Exceptions\IncorrectUsageException;
use Leaveyou\Console\Parameter;
use Leaveyou\Console\ParameterSet;

class ResultNormalizer
{
    public function normalize(ParameterSet $parameters, $rawValues)
    {
        $results = [];

        foreach ($parameters as $parameter) {
            $results[$parameter->getLongName()] = $this->normalizeParameter($parameter, $rawValues);
        }

        return $results;
    }

    /**
     * @param $rawValues
     * @param $parameter
     * @return array
     */
    private function getValuesForLongName(Parameter $parameter, $rawValues)
    {
        $longName = $parameter->getLongName();
        if (!isset($rawValues[$longName])) {
            return [];
        }
        return (array)$rawValues[$longName];
    }


    /**
     * @param $rawValues
     * @param $parameter
     * @return array
     */
    private function getValuesForShortName(Parameter $parameter, $rawValues)
    {
        $shortName = $parameter->getShortName();
        if (!isset($rawValues[$shortName])) {
            return [];
        }
        return (array)$rawValues[$shortName];
    }

    private function normalizeParameter(Parameter $parameter, $rawValues)
    {
        $longNameValues = $this->getValuesForLongName($parameter, $rawValues);
        $shortNameValues = $this->getValuesForShortName($parameter, $rawValues);

        $values = array_merge($longNameValues, $shortNameValues);
        $type = $parameter->getType();

        $numberOfValues = count($values);

        if ($type == Parameter::TYPE_MANDATORY) {
            if (!$numberOfValues) {
                throw new IncorrectUsageException("The \"--" . $parameter->getLongName() . "\" parameter is mandatory.");
            }
        }

        // if parameter is not mandatory and was omitted
        if (!$numberOfValues) {
            return $parameter->getDefaultValue();
        }

        // for flags we're interested in the number of occurrences ( -v -vv -vvv )
        if ($type == Parameter::TYPE_FLAG) {
            return $numberOfValues;
        }

        if ($type == Parameter::TYPE_OPTIONAL) {
            $emptyValues = array_search(false, $values, true);
            if ($emptyValues !== false) {
                throw new IncorrectUsageException("The \"--" . $parameter->getLongName() . "\" parameter is optional. No need to use it if empty.");
            }
        }

        $valueType = $parameter->getValueType();
        if ($valueType == Parameter::VALUE_STRING && $numberOfValues != 1) {
            throw new IncorrectUsageException("The \"--" . $parameter->getLongName() . "\" parameter can only be used once since the expected value must be a string.");
        }

        if ($numberOfValues == 1 && $valueType !== Parameter::VALUE_ARRAY) {
            return $values[0];
        }

        return $values;
    }
}
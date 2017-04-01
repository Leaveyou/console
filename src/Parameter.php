<?php

namespace Leaveyou\Console;

use Leaveyou\Console\Exceptions\IncorrectImplementationException;

class Parameter
{
    const TYPE_FLAG = "flag";
    const TYPE_OPTIONAL = "optional";
    const TYPE_MANDATORY = "mandatory";

    const VALUE_ARRAY = "array";
    const VALUE_STRING = "string";
    const VALUE_AUTO = "auto";

    const OPTION_HELP = "help";

    /**
     * Long name for reading two-hyphen parameters such as "--verbose".
     * The parameter length must be at least 2 to prevent confusion between short and long parameters
     * @var string
     */
    protected $longName;

    /**
     * One character name for reading one-hyphen parameters such as "-v"
     * @var string
     */
    protected $shortName = null;

    /**
     * Parameter description. Shown in help page.
     * @var string
     */
    protected $description = "This parameter doesn't have a description";

    /**
     * Type of the parameter
     * @var string
     */
    protected $type = self::TYPE_OPTIONAL;

    /**
     * The expected parameter value type:
     * @var string
     */
    protected $valueType = self::VALUE_AUTO;

    /**
     * @var mixed The default value when optional argument missing.
     */
    protected $defaultValue = false;

    /**
     * Static constructor useful for chaining
     *
     * @param $longName
     * @return Parameter
     */
    static public function create($longName)
    {
        return new self($longName);
    }

    /**
     * Parameter constructor.
     * @param string $longName
     * @throws IncorrectImplementationException
     */
    public function __construct($longName)
    {
        if (!is_string($longName) || !preg_match('#^[a-z0-9]{2,}$#i', $longName) ) {
            throw new IncorrectImplementationException('The "longName" parameter must be a non-empty string of at least 2 characters.');
        }

        $this->longName = $longName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $description
     * @return Parameter
     * @throws IncorrectImplementationException
     */
    public function setDescription($description)
    {
        if (!strlen($description)) {
            throw new IncorrectImplementationException('The "description" parameter must be a non-empty string.');
        }
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $shortName
     * @return Parameter
     * @throws IncorrectImplementationException
     */
    public function setShortName($shortName)
    {
        if ($shortName && !preg_match('#^[a-z0-9]$#i', $shortName)) {
            throw new IncorrectImplementationException('If present, the "shortName" parameter must be a single character. Only a-z, A-Z and 0-9 are allowed.');
        }
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * Sets the expected value type for the parameter
     *
     * @param string $valueType The expected value type:
     * self::RETURN_STRING - Returns a single value for the parameter. Throws IncorrectUsageException if parameter appears twice.
     * self::RETURN_ARRAY - Returns array of values even if parameter appears only once.
     * self::RETURN_AUTO - Returns a string if parameter appears once and an array if parameter appears multiple times.
     *
     * @return Parameter
     * @throws IncorrectImplementationException
     */
    public function setValueType($valueType)
    {
        if (!in_array($valueType, [self::VALUE_ARRAY, self::VALUE_STRING, self::VALUE_AUTO])) {
            throw new IncorrectImplementationException('The return type must be one of [Parameter::VALUE_ARRAY, Parameter::VALUE_STRING, Parameter::VALUE_AUTO]');
        }
        $this->valueType = $valueType;
        return $this;
    }

    /**
     * Sets the type of the parameter
     *
     * @param string $type Type of the parameter
     * self::TYPE_FLAG      - Parameters without value         --verbose -v -vv -vvv
     * self::TYPE_OPTIONAL  - Optional parameters with value   --optional=1970 -o=1970 -o1970 -o"1970"
     * self::TYPE_MANDATORY - Mandatory parameters with value  --required=1970 -r=1970 -r1970 -r"1970" --required 1970 -r 1970 -r "1970"
     *
     * @return Parameter
     * @throws IncorrectImplementationException
     */
    public function setType($type)
    {
        if (!in_array($type, [self::TYPE_FLAG, self::TYPE_OPTIONAL, self::TYPE_MANDATORY])) {
            throw new IncorrectImplementationException('The type must be one of [Parameter::TYPE_FLAG, Parameter::TYPE_OPTIONAL, Parameter::TYPE_MANDATORY]');
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     * @return Parameter
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }
}

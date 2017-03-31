<?php

namespace Leaveyou\Console;

class Parameter
{
    const TYPE_FLAG = 0x01;
    const TYPE_OPTIONAL = 0x02;
    const TYPE_MANDATORY = 0x03;

    /**
     * @var string
     */
    protected $longName;

    /**
     * @var string
     */
    protected $shortName;

    /**
     * @var string
     */
    protected $description;


    /**
     * Parameter constructor.
     * @param string $longName
     * @param string $description
     * @param int $type
     * @param string $shortName
     * @throws \InvalidArgumentException
     */
    public function __construct($longName, $description, $type, $shortName = null)
    {
        if (!is_string($longName) || strlen($longName) < 2 ) {
            throw new \InvalidArgumentException('The "longName" parameter must be a non-empty string of characters.');
        }

        if (!strlen($description)) {
            throw new \InvalidArgumentException('The "description" parameter must be a non-empty string.');
        }

        if ($shortName && !preg_match('#^[a-z0-9]$#i', $shortName)) {
            throw new \InvalidArgumentException('If present, the "shortName" parameter must be a single character. Only a-z, A-Z and 0-9 are allowed.');
        }

        if (!in_array($type, [self::TYPE_FLAG, self::TYPE_OPTIONAL, self::TYPE_MANDATORY])) {
            throw new \InvalidArgumentException('The "type" parameter must be one of [Parameter::TYPE_FLAG, Parameter::TYPE_OPTIONAL, Parameter::TYPE_MANDATORY]');
        }

        $this->longName = $longName;
        $this->description = $description;
        $this->type = $type;
        $this->shortName = $shortName;
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
}
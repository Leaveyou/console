# Console

A set of console components for parsing command line arguments

## Features:
* complex arguments recognition:
~~~
Parameters without value         --verbose -v -vv -vvv
Optional parameters with value   --optional=1970 -o=1970 -o1970 -o"1970"
Mandatory parameters with value  --required=1970 -r=1970 -r1970 -r"1970" --required 1970 -r 1970 -r "1970"
~~~
* Automatically generated help pages
~~~
$ php test.php --help
Asked for help page...
  -o,  --optional    Some example of an optional parameter
  -v,  --verbose     Whether verbose
       --account     This parameter doesn't have a description
       --mandatory   Mandatory parameter description. This should have one and only one value.
       --help        Shows this help message
~~~
* Dependency injection / container-ready
* Improves upon native php function `getopt()` shortcomings:
    * Treats `--version` and `-v` as the same parameter if defined as such.
    * Mandatory parameters are really MANDATORY
    * Optional parameters cannot have empty value
    * Allows to specify in advance if a parameter is a single string or a list of strings
    * Default values for optional parameters
    * @SOON: Support for trailing arbitrary data: `php x.php -abc [TRAILING] [DATA]` in PHP 5

## Usage

```php
<?php

/** class importing */
use Leaveyou\Console\Input;
use Leaveyou\Console\Parameter;
use Leaveyou\Console\ParameterSet;
use Leaveyou\Console\Tools\CommandLineParser;
use Leaveyou\Console\Tools\Help;
use Leaveyou\Console\Tools\ResultNormalizer;

/** composer autoloader */
require_once "../vendor/autoload.php";

$normalizer = new ResultNormalizer();
$cmdParser = new CommandLineParser($normalizer);
$helpGenerator = new Help();
$parameterSet = new ParameterSet();
$consoleInput = new Input($parameterSet, $cmdParser, $helpGenerator);

/** Define parameters */
$simpleParameter = new Parameter("simple");

$complexParameter = Parameter::create("complex")
    ->setType(Parameter::TYPE_MANDATORY)
    ->setDescription("Some example of a complex parameter")
    ->setShortName('c')
    ->setValueType(Parameter::VALUE_STRING);

/** Inject parameters */
$consoleInput->addParameter($simpleParameter);
$consoleInput->addParameter($complexParameter);

/** Read parameters */
$simple = $consoleInput->getValue('simple');
$complex = $consoleInput->getValue('complex');
```

Then just run ```php test.php --simple="sure thing" --complex "yes" --complex "no"```

Oups...
```
The "--complex" parameter can only be used once since the expected value must be a string.
  -c,  --complex     Some example of a complex parameter
       --simple      This parameter doesn't have a description
       --help        Shows this help message
```
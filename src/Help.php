<?php

namespace Leaveyou\Console;


class Help
{
    public function render(ParameterSet $parameters, $errorMessage = "")
    {
        $leftColumn = 5;
        $middleColumn = 15;
        $rightColumn = 30;

        $return = "";
        $return .= $errorMessage . PHP_EOL;

        foreach ($parameters as $parameter) {

            $text = (string)$parameter->getShortName();
            if ($text) {
                $text = "-" . $text . ",";
            }

            $return .= sprintf("% " . $leftColumn . "s", $text);


            $text = (string)$parameter->getLongName();
            if ($text) {
                $text = "  --" . $text . "";
            }

            $return .= sprintf("% -" . $middleColumn . "s ", $text);


            $return .= $parameter->getDescription() . PHP_EOL;
        }
        return $return;
    }
}
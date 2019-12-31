<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick\Analyzers;

use ProfoundInventions\Nitpick\AnalyzerOutput;
use ProfoundInventions\Nitpick\Error;
use ProfoundInventions\Nitpick\StaticAnalyzer;

class PsalmStaticAnalyzer implements StaticAnalyzer
{
    public function name(): string
    {
        return "psalm";
    }

    public function parse(string $analyzerOutput): AnalyzerOutput
    {
        if (strpos($analyzerOutput, "No errors found!") !== false) {
            return new AnalyzerOutput();
        }

        $errors = [];
        $lines = preg_split('/\r?\n/', $analyzerOutput, -1, PREG_SPLIT_NO_EMPTY);
        if ($lines === false) {
            return new AnalyzerOutput();
        }
        foreach ($lines as $line) {
            if (preg_match(
                '/ERROR.*(?<errorType>.*) - (?<path>.*):(?<lineNumber>\d+):\d+ - (?<message>.*)/',
                $line,
                $matches
            )) {
                $lineNumber = $matches['lineNumber'];
                $errors[] = new Error($matches['path'], (int)$lineNumber, $matches['message']);
            }
        }

        return new AnalyzerOutput(...$errors);
    }
}
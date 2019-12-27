<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick\PhpStan;

use ProfoundInventions\Nitpick\AnalyzerOutput;
use ProfoundInventions\Nitpick\Error;

class StaticAnalyzer implements \ProfoundInventions\Nitpick\StaticAnalyzer
{
    public function parse(string $analyzerOutput): AnalyzerOutput
    {
        // todo detect no errors

        $errors = [];
        $lines = preg_split('/\r?\n/', $analyzerOutput);
        $path = "";
        $cnt = count($lines);
        for ($lineIndex = 0; $lineIndex < $cnt; $lineIndex++) {
            $line = $lines[$lineIndex];
            if (strpos($line, "[ERROR] Found") !== false) {
                break;
            }

            if (preg_match('/^\s+Line \s*(.*)/', $line, $matches)) {
                $path = $matches[1];
            } elseif ($path !== "") {
                if (preg_match('/^\s+(\d+)\s+(.*)$/', $line, $matches)) {
                    [$lineNumber, $message] = [$matches[1], $matches[2]];
                    $nextIndex = $lineIndex + 1;

                    while ($nextIndex < $cnt &&
                        $this->isContinuationLine($lines[$nextIndex])
                    ) {
                        $message .= ' ' . trim($lines[$nextIndex]);
                        $nextIndex++;
                    }
                    $errors[] = new Error($path, (int)$lineNumber, $message);
                    $nextIndex--;
                    $lineIndex = $nextIndex;
                }
            }
        }

        return new AnalyzerOutput(...$errors);
    }

    private function isContinuationLine(string $line)
    {
        if (strlen($line) < 7) {
            return false;
        }
        for ($i = 0; $i < 7; $i++) {
            if (!ctype_space($line[$i])) {
                return false;
            }
        }
        return true;
    }

}
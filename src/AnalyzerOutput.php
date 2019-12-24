<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;

interface AnalyzerOutput
{
    public function compare(AnalyzerOutput $other): AnalyzerDiff;
}
<?php

namespace ProfoundInventions\Nitpick;

interface AnalyzerOutput
{
    public function compare(AnalyzerOutput $other): AnalyzerDiff;
}
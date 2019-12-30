<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;

interface StaticAnalyzer
{
    public function name(): string;

    public function parse(string $analyzerOutput): AnalyzerOutput;
}
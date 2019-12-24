<?php declare(strict_types=1);

namespace ProfoundInventions\Nitpick;

interface AnalyzerDiff
{
    /**
     * @return Error
     */
    public function errors(): array;
}
<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;

class AnalyzerDiff
{
    /**
     * @var Error[]
     */
    private $errors;

    /**
     * @return Error[]
     */
    public function errors(): array
    {
        return $this->errors;
    }

}
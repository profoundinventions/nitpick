<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;

class AnalyzerOutput
{
    /**
     * @var Error[]
     */
    private $errors = [];

    public function __construct(Error ...$errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return Error[]
     */
    public function errors(): array
    {
        return $this->errors;
    }

    public function compare(AnalyzerOutput $other): AnalyzerDiff
    {
        // TODO: Implement compare() method.
    }

}
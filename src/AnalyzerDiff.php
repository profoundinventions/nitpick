<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;

class AnalyzerDiff
{
    /**
     * @var Error[]
     */
    private $errors;

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

}
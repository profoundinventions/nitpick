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
        $newErrors = $this->sortErrors(...$other->errors());
        $previousErrors = $this->sortErrors(...$this->errors());

        $keyedErrors = [];
        array_walk($previousErrors, function(Error $error) use (&$keyedErrors) {
            $keyedErrors[$error->message()][$error->line()] = $error;
        });

        foreach ($newErrors as $key => $newError) {
            $message = $newError->message();
            if (key_exists($message, $keyedErrors) && count($keyedErrors[$message]) > 0) {
                array_shift($keyedErrors[$message]);
                unset($newErrors[$key]);
            }
        }

        return new AnalyzerDiff(...array_values($newErrors));
    }

    /**
     * @return Error[]
     */
    private function sortErrors(Error ...$errors): array {
        usort($errors, function(Error $a, Error $b) {
            $compare = $a->file() <=> $b->file();
            return $compare === 0 ? $a->line() <=> $b->line() : $compare;
        });
        return $errors;
    }
}
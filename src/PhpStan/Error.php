<?php declare(strict_types=1);

namespace ProfoundInventions\Nitpick\PhpStan;

class Error implements \ProfoundInventions\Nitpick\Error
{
    /**
     * @var string
     */
    private $file;
    /**
     * @var int
     */
    private $line;
    /**
     * @var string
     */
    private $message;

    public function __construct(string $file, int $line, string $message)
    {
        $this->file = $file;
        $this->line = $line;
        $this->message = $message;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function line(): int
    {
        return $this->line;
    }

    public function message(): string
    {
        return $this->message;
    }

}
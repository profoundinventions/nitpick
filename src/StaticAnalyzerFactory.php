<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;

use ProfoundInventions\Nitpick\PhpStan;

class StaticAnalyzerFactory
{
    /**
     * @var string
     */
    private $analyzer = PhpStan\StaticAnalyzer::class;

    /**
     * @var array<string, string>
     */
    private $analyzers = [
        'phpstan' => PhpStan\StaticAnalyzer::class
    ];

    public function __construct()
    {
    }

    public function pickAnalyzer(string $analyzer) : void {
        if (!key_exists($analyzer, $this->analyzers)) {
            throw new \RuntimeException("Invalid static analyzer!");
        }
        $this->analyzer = $this->analyzers[$analyzer];
    }

    public function build() : StaticAnalyzer
    {
        $analyzer = $this->analyzer;
        return new $analyzer;
    }
}
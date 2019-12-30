<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick;;

class StaticAnalyzerFactory
{
    /**
     * @var string
     */
    private $analyzer = Analyzers\PhpStanStaticAnalyzer::class;

    /**
     * @var array<string, string>
     */
    private $analyzers = [
        'phpstan' => Analyzers\PhpStanStaticAnalyzer::class
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
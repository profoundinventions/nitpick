<?php

namespace ProfoundInventions\Nitpick\Test\Analyzers;

use PHPUnit\Framework\TestCase;
use ProfoundInventions\Nitpick\Analyzers\PhpStanStaticAnalyzer;
use ProfoundInventions\Nitpick\Analyzers\PsalmStaticAnalyzer;

class PsalmStaticAnalyzerTest extends TestCase
{
    public function testParse() {
        $text = <<<'EOF'

ERROR: LoopInvalidation - src/Analyzers/PhpStanStaticAnalyzer.php:50:21 - Variable $lineIndex has already been assigned in a for/foreach loop
                    $lineIndex = $nextIndex;


ERROR: MoreSpecificReturnType - src/StaticAnalyzerFactory.php:30:31 - The declared return type 'ProfoundInventions\Nitpick\StaticAnalyzer' for ProfoundInventions\Nitpick\StaticAnalyzerFactory::build is more specific than the inferred return type 'object'
    public function build() : StaticAnalyzer


INFO: InvalidStringClass - src/StaticAnalyzerFactory.php:33:16 - String cannot be used as a class
        return new $analyzer;


ERROR: LessSpecificReturnStatement - src/StaticAnalyzerFactory.php:33:16 - The type 'object' is more general than the declared return type 'ProfoundInventions\Nitpick\StaticAnalyzer' for ProfoundInventions\Nitpick\StaticAnalyzerFactory::build
        return new $analyzer;


------------------------------
3 errors found
------------------------------
1 other issues found.
You can hide them with --show-info=false
------------------------------

Checks took 2.49 seconds and used 43.584MB of memory
Psalm was able to infer types for 94.9275% of the codebase
EOF;
        $analyzer = new PsalmStaticAnalyzer();
        $output = $analyzer->parse($text);
        $errors = $output->errors();
        $this->assertCount(3, $errors);

        $expected = "Variable \$lineIndex has already been assigned in a for/foreach loop";
        $this->assertEquals($expected, $errors[0]->message());
        $this->assertSame('src/Analyzers/PhpStanStaticAnalyzer.php', $errors[0]->file());
    }

    public function testParseReturnsEmptyWhenThereAreNoErrors() {
        $input = <<<EOD

------------------------------
No errors found!
------------------------------

Checks took 1.52 seconds and used 45.328MB of memory
Psalm was able to infer types for 94.9275% of the codebase
EOD;
        $analyzer = new PsalmStaticAnalyzer();
        $output = $analyzer->parse($input);
        $errors = $output->errors();
        $this->assertCount(0, $errors);
    }
}

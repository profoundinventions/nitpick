<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick\Test\PhpStan;

use PHPUnit\Framework\TestCase;
use ProfoundInventions\Nitpick\PhpStan\StaticAnalyzer;

class StaticAnalyzerTest extends TestCase
{
    public function testParse() {
        $text = <<<'EOF'
 ------ ---------------------------------------------------------------------------------
  Line   PhpStan/StaticAnalyzer.php
 ------ ---------------------------------------------------------------------------------
  12     Method ProfoundInventions\Nitpick\PhpStan\StaticAnalyzer::parse() should return
         ProfoundInventions\Nitpick\AnalyzerOutput but return statement is missing.
 ------ ---------------------------------------------------------------------------------

 ------ --------------------------------------------------------------------------------------------------
  Line   StaticAnalyzerF    actory.php
 ------ --------------------------------------------------------------------------------------------------
  9      Property ProfoundInventions\Nitpick\StaticAnalyzerFactory::$analyzer has no typehint specified.
  11     Property ProfoundInventions\Nitpick\StaticAnalyzerFactory::$analyzers has no typehint specified.
 ------ --------------------------------------------------------------------------------------------------
EOF;
        $analyzer = new StaticAnalyzer();
        $output = $analyzer->parse($text);
        $errors = $output->errors();
        $this->assertCount(3, $errors);

        $expected = implode(" ", [
            "Method ProfoundInventions\Nitpick\PhpStan\StaticAnalyzer::parse() should return",
            "ProfoundInventions\Nitpick\AnalyzerOutput but return statement is missing.",
        ]);
        $this->assertEquals($expected, $errors[0]->message());
    }
}
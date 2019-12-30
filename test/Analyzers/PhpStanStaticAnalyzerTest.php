<?php declare(strict_types = 1);

namespace ProfoundInventions\Nitpick\Test\Analyzers;

use PHPUnit\Framework\TestCase;
use ProfoundInventions\Nitpick\Analyzers\PhpStanStaticAnalyzer;

class PhpStanStaticAnalyzerTest extends TestCase
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
  Line   StaticAnalyzerFactory.php
 ------ --------------------------------------------------------------------------------------------------
  9      Property ProfoundInventions\Nitpick\StaticAnalyzerFactory::$analyzer has no typehint specified.
  11     Property ProfoundInventions\Nitpick\StaticAnalyzerFactory::$analyzers has no typehint specified.
 ------ --------------------------------------------------------------------------------------------------
EOF;
        $analyzer = new PhpStanStaticAnalyzer();
        $output = $analyzer->parse($text);
        $errors = $output->errors();
        $this->assertCount(3, $errors);

        $expected = implode(" ", [
            "Method ProfoundInventions\Nitpick\PhpStan\StaticAnalyzer::parse() should return",
            "ProfoundInventions\Nitpick\AnalyzerOutput but return statement is missing.",
        ]);
        $this->assertEquals($expected, $errors[0]->message());
    }

    public function testParseReturnsEmptyWhenThereAreNoErrors() {
        $input = <<<EOD
 [OK] No errors
EOD;
        $analyzer = new PhpStanStaticAnalyzer();
        $output = $analyzer->parse($input);
        $errors = $output->errors();
        $this->assertCount(0, $errors);
    }
}
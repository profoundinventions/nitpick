<?php

namespace ProfoundInventions\Nitpick\Test;

use PHPUnit\Framework\TestCase;
use ProfoundInventions\Nitpick\AnalyzerOutput;
use ProfoundInventions\Nitpick\Error;

class AnalyzerOutputTest extends TestCase
{
    public function testCompareIsEmptyWhenErrorsAreTheSame()
    {
        $firstErrors = [];
        $firstErrors[] = new Error('t.php', 1, "Test message");
        $firstErrors[] = new Error('t.php', 3, "Test message");
        $firstErrors[] = new Error('t.php', 5, "Test message");
        $firstErrors[] = new Error('t.php', 5, "Test message 2");

        $firstOutput = new AnalyzerOutput(...$firstErrors);

        $secondErrors = [];
        $secondErrors[] = new Error('t.php', 1, "Test message");
        $secondErrors[] = new Error('t.php', 3, "Test message");
        $secondErrors[] = new Error('t.php', 5, "Test message");
        $secondErrors[] = new Error('t.php', 5, "Test message 2");
        $secondOutput = new AnalyzerOutput(...$secondErrors);

        $diff = $firstOutput->compare($secondOutput);
        $this->assertCount(0, $diff->errors());
    }

    public function testCompareAddsLatestErrorWhenSameMessageOccurs()
    {
        $firstErrors = [];
        $firstErrors[] = new Error('t.php', 1, "Test message");
        $firstErrors[] = new Error('t.php', 5, "Test message");
        $firstErrors[] = new Error('t.php', 5, "Test message 2");

        $firstOutput = new AnalyzerOutput(...$firstErrors);

        $secondErrors = [];
        $secondErrors[] = new Error('t.php', 1, "Test message");
        $secondErrors[] = new Error('t.php', 3, "Test message");
        $secondErrors[] = new Error('t.php', 5, "Test message");
        $secondErrors[] = new Error('t.php', 5, "Test message 2");
        $secondOutput = new AnalyzerOutput(...$secondErrors);

        $diff = $firstOutput->compare($secondOutput);
        $errors = $diff->errors();
        $this->assertCount(1, $errors);
        $this->assertSame(5, $errors[0]->line());
        $this->assertSame('Test message', $errors[0]->message());
    }
}

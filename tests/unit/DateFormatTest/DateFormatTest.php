<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace Tests\unit\DateFormatTest;

use Codeception\Test\Unit;
use App\Core\Service\DateFormat;
use PHPUnit\Framework\Assert;

class DateFormatTest extends Unit
{
    use DateFormat;

    public function test(): void
    {
        $time = new \DateTimeImmutable('2018-12-31 13:05:21');
        $time = $this->dateFormat($time);
        Assert::assertEquals('Monday, 31-Dec-18 13:05:21 MSK', $time);
    }
}
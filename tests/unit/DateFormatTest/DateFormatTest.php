<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace Tests\unit\DateFormatTest;


use App\Core\Service\DateFormat;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class DateFormatTest extends TestCase
{
    use DateFormat;

    public function test() {
        $time = new \DateTimeImmutable('2018-12-31 13:05:21');
        $time = $this->dateFormat($time);
        Assert::assertEquals('Monday, 31-Dec-18 13:05:21 MSK', $time);
    }
}
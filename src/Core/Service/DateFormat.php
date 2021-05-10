<?php

/**
 * Author: SyntaxErrorLineNULL.
 */

declare(strict_types=1);

namespace App\Core\Service;


trait DateFormat
{
    /**
     * @param \DateTimeInterface $time
     * @return string
     */
    public function dateFormat(\DateTimeInterface $time): string
    {
        return $time->format('l, d-M-y H:i:s T');
    }
}
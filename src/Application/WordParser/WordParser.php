<?php

declare(strict_types=1);

namespace App\Application\WordParser;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
interface WordParser
{
    /**
     * @return string[]
     */
    public function parse(string $text): array;
}

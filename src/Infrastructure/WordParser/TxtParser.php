<?php

declare(strict_types=1);

namespace App\Infrastructure\WordParser;

use App\Application\WordParser\WordParser;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class TxtParser implements WordParser
{
    public function parse(string $text): array
    {
        \preg_match_all('/\pL+/u', $text, $matches);

        return $matches[0];
    }
}

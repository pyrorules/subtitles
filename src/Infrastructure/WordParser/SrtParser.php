<?php

declare(strict_types=1);

namespace App\Infrastructure\WordParser;

use App\Application\WordParser\WordParser;
use Benlipp\SrtParser\Parser;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class SrtParser implements WordParser
{
    public function parse(string $text): array
    {
        $parser = new Parser();
        $parser->loadString($text);

        $words = [[]];

        foreach ($parser->parse() as $caption) {
            preg_match_all('/\pL+/u', $caption->text, $matches);

            $words[] = $matches[0];
        }

        return \array_merge(...$words);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\WordParser;

use App\Infrastructure\WordParser\SrtParser;
use PHPUnit\Framework\TestCase;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
class SrtParserTest extends TestCase
{
    private const SRT_TEXT = <<<'EOD'
1
00:00:03,400 --> 00:00:06,177
In this lesson, we are going to
be talking about finance. And

2
00:00:06,177 --> 00:00:10,009
one of the most important aspects
of finance is interest.

3
00:00:10,009 --> 00:00:13,655
When I go to a bank or some
other lending institution
EOD;

    public function testReturnsWordsFromText()
    {
        $srtParser = new SrtParser();

        $this->assertSame(
            [
                'In',
                'this',
                'lesson',
                'we',
                'are',
                'going',
                'to',
                'be',
                'talking',
                'about',
                'finance',
                'And',
                'one',
                'of',
                'the',
                'most',
                'important',
                'aspects',
                'of',
                'finance',
                'is',
                'interest',
                'When',
                'I',
                'go',
                'to',
                'a',
                'bank',
                'or',
                'some',
                'other',
                'lending',
                'institution',
            ],
            $srtParser->parse(self::SRT_TEXT)
        );
    }
}

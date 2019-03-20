<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\WordParser;

use App\Infrastructure\WordParser\TxtParser;
use PHPUnit\Framework\TestCase;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
class TxtParserTest extends TestCase
{
    private const TXT_TEXT = <<<'EOD'
{9202}{9267}Buckley.
{9451}{9537}Dobrze się czujesz?
{9581}{9666}Pamiętam jak rodzicom błyszczały oczy.
{9670}{9741}Czuli ulgę.
EOD;

    public function testReturnsWordsFromText()
    {
        $txtParser = new TxtParser();

        $this->assertSame(
            [
                'Buckley',
                'Dobrze',
                'się',
                'czujesz',
                'Pamiętam',
                'jak',
                'rodzicom',
                'błyszczały',
                'oczy',
                'Czuli',
                'ulgę',
            ],
            $txtParser->parse(self::TXT_TEXT)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Application\Query;

use App\Application\Query\WordUsageForText;
use App\Application\Query\WordUsageForTextHandler;
use App\Application\WordParser\ParserRegistry;
use App\Application\WordParser\WordParser;
use PHPUnit\Framework\TestCase;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
class WordUsageForTextHandlerTest extends TestCase
{
    public function testReturnsCorrectWordUsageSorted()
    {
        $wordParser = $this->createMock(WordParser::class);

        $wordParser->method('parse')->willReturn(
            ['cat', 'fish', 'fish', 'dog', 'fish', 'cat', 'fish']
        );

        $parserRegistry = new ParserRegistry();
        $parserRegistry->add($wordParser, 'some_type');

        $handler = new WordUsageForTextHandler($parserRegistry);

        $result = $handler(new WordUsageForText('some_type', 'cat fish fish dog fish cat fish'));

        $this->assertCount(3, $result);

        $this->assertSame($result[0]->getWord(), 'fish');
        $this->assertSame($result[0]->getUsage(), 4);

        $this->assertSame($result[1]->getWord(), 'cat');
        $this->assertSame($result[1]->getUsage(), 2);

        $this->assertSame($result[2]->getWord(), 'dog');
        $this->assertSame($result[2]->getUsage(), 1);
    }
}

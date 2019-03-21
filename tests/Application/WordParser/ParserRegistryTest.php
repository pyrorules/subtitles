<?php

declare(strict_types=1);

namespace App\Tests\Application\WordParser;

use App\Application\WordParser\ParserRegistry;
use App\Application\WordParser\WordParser;
use PHPUnit\Framework\TestCase;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
class ParserRegistryTest extends TestCase
{
    /** @var ParserRegistry */
    private $parserRegistry;

    /** @var WordParser[] */
    private $parsers;

    protected function setUp()
    {
        $this->parserRegistry = new ParserRegistry();

        $this->parsers[] = $this->createMock(WordParser::class);
        $this->parsers[] = $this->createMock(WordParser::class);

        $this->parserRegistry->add($this->parsers[0], 'some_type');
        $this->parserRegistry->add($this->parsers[1], 'another_type');
    }

    /**
     * @dataProvider provideWordParserData
     */
    public function testRetrievesProperWordParser(string $type, int $expectedParserIndex)
    {
        $this->assertSame($this->parsers[$expectedParserIndex], $this->parserRegistry->getByType($type));
    }

    /**
     * @expectedException \App\Application\WordParser\ParserNotFoundException
     */
    public function testThrowsExceptionWhenNoParserExistsForGivenType()
    {
        $this->parserRegistry->getByType('some_non_existent_type');
    }

    public function provideWordParserData(): array
    {
        return [
            ['another_type', 1],
            ['some_type', 0],
        ];
    }
}

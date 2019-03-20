<?php

declare(strict_types=1);

namespace App\Application\WordParser;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class ParserRegistry
{
    /** @var WordParser[] */
    private $parsers;

    public function __construct()
    {
        $this->parsers = [];
    }

    public function add(WordParser $wordParser, string $type): void
    {
        $this->parsers[$type] = $wordParser;
    }

    /**
     * @throws ParserNotFoundException
     */
    public function getByType(string $type): WordParser
    {
        if (\array_key_exists($type, $this->parsers)) {
            return $this->parsers[$type];
        }

        throw ParserNotFoundException::createForType($type);
    }
}

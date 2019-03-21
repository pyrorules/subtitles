<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Application\Query\Model\WordUsage;
use App\Application\WordParser\ParserNotFoundException;
use App\Application\WordParser\ParserRegistry;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class WordUsageForTextHandler
{
    /** @var ParserRegistry */
    private $parserRegistry;

    public function __construct(ParserRegistry $parserRegistry)
    {
        $this->parserRegistry = $parserRegistry;
    }

    /**
     * @throws ParserNotFoundException
     *
     * @return WordUsage[]
     */
    public function __invoke(WordUsageForText $query): array
    {
        $wordParser = $this->parserRegistry->getByType($query->type());

        $usage = \array_count_values($wordParser->parse($query->text()));
        \arsort($usage);

        return \array_map(
            function (string $word, int $usage) {
                return new WordUsage($word, $usage);
            },
            \array_keys($usage),
            $usage
        );
    }
}

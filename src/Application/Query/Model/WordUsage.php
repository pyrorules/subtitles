<?php

declare(strict_types=1);

namespace App\Application\Query\Model;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class WordUsage
{
    /** @var string */
    private $word;

    /** @var int */
    private $usage;

    public function __construct(string $word, int $usage)
    {
        $this->word = $word;
        $this->usage = $usage;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getUsage(): int
    {
        return $this->usage;
    }
}

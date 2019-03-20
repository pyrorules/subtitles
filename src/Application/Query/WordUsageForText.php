<?php

declare(strict_types=1);

namespace App\Application\Query;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class WordUsageForText
{
    /** @var string */
    private $type;

    /** @var string */
    private $text;

    public function __construct(string $type, string $text)
    {
        $this->type = $type;
        $this->text = $text;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function text(): string
    {
        return $this->text;
    }
}

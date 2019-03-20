<?php

declare(strict_types=1);

namespace App\Application\WordParser;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
class ParserNotFoundException extends \Exception
{
    public static function createForType(string $type): self
    {
        return new self(\sprintf('Could not find a parser for `%s` type', $type));
    }
}

<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Application\WordParser\ParserRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
class WordParserPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ParserRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(ParserRegistry::class);

        $taggedServices = $container->findTaggedServiceIds('app.word_parser');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('add', [new Reference($id), $attributes['type']]);
            }
        }
    }
}

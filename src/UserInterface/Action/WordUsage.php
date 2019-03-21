<?php

declare(strict_types=1);

namespace App\UserInterface\Action;

use App\Application\Query\WordUsageForText;
use App\Application\WordParser\ParserNotFoundException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @author Wojciech Górski <pyro.rules@gmail.com>
 */
final class WordUsage extends AbstractController
{
    /** @var CommandBus */
    private $queryBus;

    public function __construct(CommandBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(Request $request, SessionInterface $session)
    {
        /** @var \App\Application\Query\Model\WordUsage[]|null $wordUsages */
        $wordUsages = null;

        /** @var UploadedFile $subtitlesFile */
        if ($subtitlesFile = $request->files->get('subtitles')) {
            $subtitlesFileHandle = $subtitlesFile->openFile('r');

            try {
                $wordUsages = $this->queryBus->handle(
                    new WordUsageForText(
                        \mb_strtolower($subtitlesFile->getClientOriginalExtension()),
                        $subtitlesFileHandle->fread($subtitlesFileHandle->getSize())
                    )
                );
            } catch (ParserNotFoundException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render(
            'word_usage.html.twig',
            [
                'wordUsages' => $wordUsages,
            ]
        );
    }
}

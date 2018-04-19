<?php

namespace App\Controllers\Web;

use App\RenderInterface;
use App\Services\CommandGenerator;
use Slim\Http\Response;
use Slim\Http\Request;
use Symfony\Component\Console\Application;

/**
 * Class PageController
 *
 * @property RenderInterface $render
 * @property CommandGenerator $commandGenerator
 * @property array $settings
 */
class PageController
{

    /**
     * @var RenderInterface
     */
    protected $render;

    /**
     * @var CommandGenerator
     */
    protected $commandGenerator;

    /**
     * @var array
     */
    protected $settings;

    /**
     * Page constructor.
     * @param RenderInterface $render
     * @param CommandGenerator $commandGenerator
     * @param array $settings
     */
    public function __construct(RenderInterface $render, CommandGenerator $commandGenerator, $settings)
    {
        $this->render = $render;
        $this->commandGenerator = $commandGenerator;
        $this->settings = $settings;
    }

    public function main(Request $request, Response $response, $args)
    {
        return $this->render->render($response, 'page/main.twig', [
            'command' => $this->commandGenerator->createCommand('hello'),
        ]);
    }

    public function hello(Request $request, Response $response, $args)
    {
        return $this->render->render($response, 'page/hello.twig', [
            'name' => $args['name'],
        ]);
    }
}
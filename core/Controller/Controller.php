<?php

namespace Core\Controller;

use App\SessionBlog\SessionBlog;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private FilesystemLoader $loader;
    protected Environment $twig;


    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/src/View');
        $this->twig = new Environment($this->loader, ['cache' => false]);
    }

    /**
     * @param string $template
     * @param array $data
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $template, array $data = [])
    {
        $data['userName'] = SessionBlog::get('name');
        $data['userIsAdmin'] = \App\Manager\UserManager::userIsAdmin();
        $data['notificationInvalidComment'] = \App\Manager\Notification::notificationInvalidComment();
        $data['userIsConnected'] = \App\Manager\UserManager::userIsConnected();
        echo $this->twig->render($template, $data);
    }

    /**
     * @param $uri
     * @return void
     */
    public function redirect($uri)
    {
        header("Location: $uri");
    }
}

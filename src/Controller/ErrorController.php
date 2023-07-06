<?php

namespace App\Controller;

use Core\Controller\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class ErrorController extends Controller
{
    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show403()
    {
        $this->render('403.twig');
    }
}

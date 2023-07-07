<?php

namespace Core\Router;

use Core\Http\Request;


class Router
{

    /**
     * @var array
     */
    private array $routes;


    /**
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;

    }


    /**
     * @param Request $request
     * @return void
     */
    public function run(Request $request): void
    {
        foreach ($this->routes as $route) {

            if ($route->matches($request)) {
                $route->callAction();
            }

        }

    }


}

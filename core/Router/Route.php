<?php

namespace Core\Router;

use Core\Http\Request;

class Route
{

    private string $path;
    private string $controllerName;

    private string $action;

    private array $params = [];

    private array $method;


    public function __construct(string $path, string $controllerName, string $action, array $method = [])
    {
        $this->path = $path;
        $this->controllerName = $controllerName;
        $this->action = $action;
        $this->method = $method;
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function matches(Request $request): bool
    {
        $matches = [];
        if (\preg_match($this->path, $request->getUri(), $matches)) {
            if (\count($matches) > 1) {
                \array_shift($matches);
                $this->params = $matches;
            }
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    public function callAction()
    {
        $controller = new $this->controllerName;
        $action = $this->action;
        $controller->$action($this->params);
    }

    /**
     * @return array
     */
    public function getMethod(): array
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

}
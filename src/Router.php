<?php


namespace BeeJee;

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use FastRoute\{Dispatcher, function simpleDispatcher};

class Router
{
    private $controller;
    private $method;
    private $routeData = [];
    private $routes = [];

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = include_once CONFIG_PATH . 'routes.php';
    }

    public function dispatch(): void
    {
        $dispatcher = simpleDispatcher($this->routes);
        $this->routeData = $dispatcher->dispatch($this->request->getMethod(), $this->request->getRequestUri());

        if($this->validate())
        {
            [$this->controller, $this->method] = explode('#', $this->routeData[1], 2);

            $controllerClass = $this->getNamespace() . $this->controller;

            if (!class_exists($controllerClass))
            {
                throw new RuntimeException("Controller class $controllerClass not found");
            }

            $controllerObject = new $controllerClass;

            if(!method_exists($controllerObject, $this->method))
            {
                throw new RuntimeException("Method $this->method not found");
            }

            call_user_func_array(array($controllerObject, $this->method), $this->routeData[2]);
        }
        else throw new RuntimeException("No route matches.");
    }

    private function validate()
    {
        return $this->routeData[0] === Dispatcher::FOUND;
    }

    private function getNamespace(): string
    {
        return CONTROLLERS_NAMESPACE;
    }
}
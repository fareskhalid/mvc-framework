<?php
namespace app\core;
use app\core\exceptions\NotFoundException;
use app\core\Request;
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException;
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        // if the callback is a function
        if (is_callable($callback)) {
            return call_user_func($callback);
        }
        // if the callback is an array [Class]
        if (is_array($callback)) {
            /** @var \app\core\Controller $controller */
            [$class, $method] = $callback;
            $controller = new $class();
            Application::$app->controller = $controller;
            $controller->action = $method;
            $class = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
            return call_user_func([$class, $method], $this->request, $this->response);
        }
    }

}
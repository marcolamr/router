<?php

namespace MarcolaMr\Router;

use \Closure;
use \Exception;
use Reflection;
use \ReflectionFunction;

class Router
{
    /** @var string */
    private string $url = "";

    /** @var string */
    private string $prefix = "";

    /** @var array */
    private array $routes = [];

    /** @var Request */
    private Request $request;

    /**
     * Construtor da classe
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Método responsável por definir uma rota de GET
     *
     * @param string $route
     * @param array $params
     */
    public function get(string $route, array $params = [])
    {
        return $this->addRoute("GET", $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     *
     * @param string $route
     * @param array $params
     */
    public function post(string $route, array $params = [])
    {
        return $this->addRoute("POST", $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     *
     * @param string $route
     * @param array $params
     */
    public function put(string $route, array $params = [])
    {
        return $this->addRoute("PUT", $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     *
     * @param string $route
     * @param array $params
     */
    public function delete(string $route, array $params = [])
    {
        return $this->addRoute("DELETE", $route, $params);
    }

    /**
     * Método responsável por executar a rota atual
     *
     * @return Response
     */
    public function run(): Response
    {
        try {
            $route = $this->getRoute();
            
            if (!isset($route["controller"])) {
                throw new Exception("A url não pôde ser processada", 500);
            }

            $args = [];

            $reflection = new ReflectionFunction($route["controller"]);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route["variables"][$name] ?? "";
            }
            
            return call_user_func_array($route["controller"], $args);
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Método responsável por retornar os dados da rota atual
     *
     * @return
     */
    private function getRoute()
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();
        
        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri, $matches)) {
                if (isset($methods[$httpMethod])) {
                    unset($matches[0]);

                    $keys = $methods[$httpMethod]["variables"];
                    $methods[$httpMethod]["variables"] = array_combine($keys, $matches);
                    $methods[$httpMethod]["variables"]["request"] = $this->request;

                    return $methods[$httpMethod];
                }

                throw new Exception("Método não implementado", 405);
            }
        }

        throw new Exception("Url não encontrada", 404);
    }

    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     *
     * @return string
     */
    private function getUri(): string
    {
        $uri = $this->request->getUri();
        
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);
    }

    /**
     * Método responsável por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    private function addRoute(string $method, string $route, array $params = []): void
    {
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params["controller"] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //Variáveis da Rota
        $params["variables"] = [];
        $patternVariable = "/{(.*?)}/";
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, "(.*?)", $route);
            $params["variables"] = $matches[1];
        }

        $patternRoute = "/^" . str_replace("/", "\/", $route) . "$/";

        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por definir o prefixo das rotas
     *
     * @return void
     */
    private function setPrefix(): void
    {
        $parseUrl = parse_url($this->url);
        
        $this->prefix = $parseUrl["path"] ?? "";
    }
}

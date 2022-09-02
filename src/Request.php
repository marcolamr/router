<?php

namespace MarcolaMr\Router;

class Request
{
    /** @var string */
    private string $httpMethod;

    /** @var string */
    private string $uri;

    /** @var array */
    private array $queryParams = [];

    /** @var array */
    private array $postVars = [];

    /** @var array */
    private array $headers = [];

    /**
     * Construtor da classe
     */
    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER["REQUEST_METHOD"] ?? "";
        $this->uri = $_SERVER["REQUEST_URI"] ?? "";
    }

    /**
     * Método responsável por retornar o método HTTP da requisição
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Método responsável por retornar a URI da requisição
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Método responsável por retornar os headers da requisição
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Método responsável por retornar os parâmetros da url
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Método responsável por retornar as variáveis post
     * @return array
     */
    public function getPostVars(): array
    {
        return $this->postVars;
    }
}

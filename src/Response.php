<?php

namespace MarcolaMr\Router;

class Response
{
    /** @var string */
    private int $httpCode = 200;

    /** @var array */
    private array $headers = [];

    /** @var string */
    private string $contentType = "text/html";

    /** @var mixed */
    private $content;

    /**
     * Construtor da classe
     *
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct(int $httpCode, $content, string $contentType = "text/html")
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     *
     * @return void
     */
    public function sendResponse(): void
    {
        $this->sendHeaders();
        
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

    /**
     * Método responsável por alterar o content type do response
     *
     * @param string $contentType
     * @return void
     */
    private function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
        $this->addHeader("Content-Type", $contentType);
    }

    /**
     * Método responsável or adicionar um registro no cabeçalho do response
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    private function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar a resposta para o navegador
     *
     * @return void
     */
    private function sendHeaders(): void
    {
        http_response_code($this->httpCode);

        foreach ($this->headers as $key => $value) {
            header($key . ": " . $value);
        }
    }
}

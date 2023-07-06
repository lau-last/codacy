<?php

namespace Core\Http;

final class Request
{


    private array $server;

    private ?array $post;


    public function __construct()
    {
        $this->server = $_SERVER;
        $this->post = $_POST;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    /**
     * @return array|null
     */
    public function getPost(): ?array
    {
        return $this->post;
    }


}
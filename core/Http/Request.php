<?php

namespace Core\Http;

final class Request
{

    /**
     * @var array
     */
    private array $server;

    /**
     * @var array|null
     */
    private ?array $post;


    /**
     *
     */
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

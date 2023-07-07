<?php

namespace App\Entity;

use Core\Entity\Hydrate;

abstract class ArticleEntity extends Hydrate
{

    /**
     * @var integer
     */
    protected int $id;

    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $head;

    /**
     * @var string
     */
    protected string $content;

    /**
     * @var string
     */
    protected string $date;

    /**
     * @var integer
     */
    protected int $userId;


    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;

    }


    /**
     * @param integer $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;

    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;

    }


    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;

    }


    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;

    }


    /**
     * @param string $head
     * @return $this
     */
    public function setHead(string $head): self
    {
        $this->head = $head;
        return $this;

    }


    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;

    }


    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;

    }


    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;

    }


    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;

    }


    /**
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->userId;

    }


    /**
     * @param integer $userId
     * @return $this
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;

    }


}

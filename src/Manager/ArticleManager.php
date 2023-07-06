<?php

namespace App\Manager;

use App\Entity\ArticleEntity;
use App\SessionBlog\SessionBlog;
use Core\QueryBuilder\Delete;
use Core\QueryBuilder\Insert;
use Core\QueryBuilder\Manager;
use Core\QueryBuilder\Select;
use Core\QueryBuilder\Update;
use Core\Session\Session;

final class ArticleManager extends ArticleEntity
{
    private string $author;

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return '/articles/' . $this->id;
    }

    /**
     * @return string
     */
    public function getExtract(): string
    {
        return \substr($this->content, 0, 250) . '...';
    }

    /**
     * @return array
     */
    public function getArticles(): array
    {
        $data = (new Manager())->fetchAll(
            (new Select('article AS a', ['a.id, a.title, a.head, a.content, a.date, u.name AS author']))
                ->join('user AS u ON a.user_id = u.id')
                ->orderBy('a.date DESC')
        );
        $articles = [];
        foreach ($data as $result) {
            $articles[] = new ArticleManager($result);
        }
        return $articles;
    }

    /**
     * @param $id
     * @return $this
     */
    public function getArticle($id): self
    {
        $dataArticle = (new Manager())->fetch(
            (new Select('article AS a', ['a.id, a.title, a.head, a.content, a.date, u.name AS author']))
                ->join('user AS u ON a.user_id = u.id')
                ->where('a.id = :id'),
            ['id' => $id[0]]
        );
        return new ArticleManager($dataArticle);
    }

    /**
     * @param array $input
     * @return void
     */
    public function createArticle(array $input)
    {
        $userId = SessionBlog::get('id');
        (new Manager())->queryExecute(
            new Insert('article', ['user_id', 'title', 'head', 'content']),
            [
                'user_id' => $userId,
                'title' => $input['title'],
                'head' => $input['head'],
                'content' => $input['content']
            ]
        );
    }

    /**
     * @param array $input
     * @param $id
     * @return void
     */
    public function updateArticle(array $input, $id)
    {
        $userId = SessionBlog::get('id');
        (new Manager())->queryExecute(
            (new Update('article'))
                ->set('title = :title, head = :head, content = :content, user_id = :user_id')
                ->where('id = :id'),
            [
                'title' => $input['title'],
                'head' => $input['head'],
                'content' => $input['content'],
                'user_id' => $userId,
                'id' => $id[0]
            ]
        );
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteArticle($id)
    {
        (new Manager())->queryExecute(
            (new Delete('article'))
                ->where('article.id = :id'),
            ['id' => $id[0]]
        );
    }
}

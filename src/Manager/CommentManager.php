<?php

namespace App\Manager;

use App\Entity\CommentEntity;
use App\SessionBlog\SessionBlog;
use Core\Http\Request;
use Core\QueryBuilder\Delete;
use Core\QueryBuilder\Insert;
use Core\QueryBuilder\Manager;
use Core\QueryBuilder\Select;
use Core\QueryBuilder\Update;
use Core\Session\Session;

final class CommentManager extends CommentEntity
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
     * @param $id
     * @return array
     */
    public function getCommentFromArticle($id): array
    {
        $dataComment = (new Manager())->fetchAll((
        new Select('comment AS c', ['c.id, c.content, c.validation, c.date, u.name AS author']))
            ->join('user AS u ON c.user_id = u.id')
            ->where('article_id = :article_id', 'c.validation = "valid"')
            ->orderBy('c.date DESC'), ['article_id' => $id[0]]);
        $comments = [];
        foreach ($dataComment as $result) {
            $comments[] = new CommentManager($result);
        }
        return $comments;
    }

    /**
     * @param array $input
     * @param int $articleId
     * @return void
     */
    public function createComment(array $input, int $articleId)
    {
        $userId = SessionBlog::get('id');
        (new Manager())->queryExecute(
            new Insert('comment', ['content', 'user_id', 'article_id']),
            [
                'content' => trim($input['comment']),
                'user_id' => $userId,
                'article_id' => $articleId
            ]
        );
    }

    /**
     * @return array
     */
    public function getAllComments(): array
    {
        $data = (new Manager())->fetchAll(
            (new Select('comment AS c', ['c.id, c.content, c.date, c.validation, u.name AS author']))
                ->join('user AS u ON c.user_id = u.id')
                ->where('c.validation = "invalid"')
        );
        $comment = [];
        foreach ($data as $res) {
            $comment[] = new CommentManager($res);
        }
        return $comment;
    }

    /**
     * @param $id
     * @return void
     */
    public function updateCommentSetValid($id)
    {
        (new Manager())->queryExecute(
            (new Update('comment AS c'))
                ->set('c.validation = "valid"')
                ->where('c.id = :id'),
            ['id' => $id[0]]
        );
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteComment($id)
    {
        (new Manager())->queryExecute(
            (new Delete('comment'))
                ->where('comment.id = :id'),
            ['id' => $id[0]]
        );
    }

}

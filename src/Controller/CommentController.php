<?php

namespace App\Controller;

use App\Manager\CommentManager;
use App\Manager\UserManager;
use Core\Controller\Controller;
use Core\Http\Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class CommentController extends Controller
{


    /**
     * @param array $articleId
     * @return void
     */
    public function postComment(array $articleId): void
    {
        $articleId = implode($articleId);
        $request = new Request();
        (new CommentManager())->createComment($request->getPost(), $articleId);
        $this->redirect("/articles/$articleId");

    }


    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showAll(): void
    {
        if (UserManager::userIsAdmin() === true) {
            $data = [];
            $data['comments'] = (new CommentManager())->getAllComments();
            $this->render('management-comment.twig', $data);
            return;
        }

        $this->redirect('/403');

    }


    /**
     * @param int $id
     * @return void
     */
    public function setValidComment(int $id): void
    {
        (new CommentManager())->updateCommentSetValid($id);
        $this->redirect('/comment-management');

    }


    /**
     * @param int $id
     * @return void
     */
    public function doDeleteComment(int $id): void
    {
        (new CommentManager())->deleteComment($id);
        $this->redirect('/comment-management');

    }


}

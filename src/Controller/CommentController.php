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
     * @param $articleId
     * @return void
     */
    public function postComment($articleId)
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
    public function showAll()
    {
        if (UserManager::userIsAdmin()) {

            $data['comments'] = (new CommentManager())->getAllComments();

            $this->render('management-comment.twig', $data);
            return;
        }
        $this->redirect('/403');
    }

    /**
     * @param $id
     * @return void
     */
    public function setValidComment($id)
    {
        (new CommentManager())->updateCommentSetValid($id);
        $this->redirect('/comment-management');
    }

    /**
     * @param $id
     * @return void
     */
    public function doDeleteComment($id)
    {
        (new CommentManager())->deleteComment($id);
        $this->redirect('/comment-management');
    }
}

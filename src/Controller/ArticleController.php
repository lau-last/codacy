<?php

namespace App\Controller;

use App\Manager\CommentManager;
use App\Manager\ArticleManager;
use App\Manager\UserManager;
use Core\Controller\Controller;
use Core\Http\Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class ArticleController extends Controller
{


    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showAll(): void
    {
        $data = [];
        $data['articles'] = (new ArticleManager())->getArticles();
        $data['notificationArticleManagement'] = \App\Manager\Notification::notificationArticleManagement();

        $this->render('show-all-articles.twig', $data);

    }


    /**
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        $data = [];
        $data['article'] = (new ArticleManager())->getArticle($id);
        $data['comments'] = (new CommentManager())->getCommentFromArticle($id);

        $this->render('show-article.twig', $data);

    }


    /**
     * @return void
     */
    public function postArticle(): void
    {
        $request = new Request();
        (new ArticleManager())->createArticle($request->getPost());
        $this->redirect('/articles');

    }


    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function modifyArticle(): void
    {
        if (UserManager::userIsAdmin() === true) {
            $data = [];
            $data['articles'] = (new ArticleManager())->getArticles();
            $data['notificationArticleManagement'] = \App\Manager\Notification::notificationArticleManagement();

            $this->render('management-article.twig', $data);
            return;
        }

        $this->redirect('/403');

    }


    /**
     * @param int $id
     * @return void
     */
    public function doModifyArticle(int $id): void
    {
        $request = new Request();
        (new ArticleManager())->updateArticle($request->getPost(), $id);
        $this->redirect('/article-management');

    }


    /**
     * @param int $id
     * @return void
     */
    public function doDeleteArticle(int $id): void
    {
        (new ArticleManager())->deleteArticle($id);
        $this->redirect('/article-management');

    }


}

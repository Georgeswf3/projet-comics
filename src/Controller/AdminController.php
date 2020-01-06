<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\User;
use App\Entity\FanArt;
use App\Form\FanArtType;
use App\Form\ArticleType;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    // vue page home administrateur
    public function homeAction(){
        return $this->render('');
    }

    // vue page home utilisateur lambda
    public function homeUser(){
        return $this->render('');
    }

    public function createFanArts(Request $request) {

        $fanart = new FanArt();
        $form = $this->createForm(FanArtType::class, $fanart);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $article = $form->getData();

        }
        return $this->render('admin/pages/admin-fanart-create.html.twig', ['fanartForm' => $form->createView(),]);


    }

    public function createArticles(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $article = $form->getData();

        }
        return $this->render("admin/pages/admin-article-create.html.twig", ["articleForm" => $form->createView()]);
    }
}
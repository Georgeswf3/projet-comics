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
        return $this->render('admin/pages/admin-home.html.twig');
    }

    // vue page home utilisateur lambda
    public function homeUser(){
        return $this->render('home.html.twig');
    }

    public function createFanArts(Request $request) {

        $fanArt = new FanArt();
        $form = $this->createForm(FanArtType::class, $fanArt);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $fanArt = $form->getData();
            $image = $form['fan_art_sketch']->getData();
            if ($image){
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName."-".uniqid().'.'.$image->getExtension();
                $image->move($this->getParameter('uploaded-images'), $newUniqueFileName);
                $fanArt->setFanArtSketch($newUniqueFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fanArt);
            $entityManager->flush();
            return $this->redirectToRoute('admin_home');

        }
        return $this->render('admin/pages/admin-fanart-create.html.twig', ['fanArtForm' => $form->createView(),]);

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
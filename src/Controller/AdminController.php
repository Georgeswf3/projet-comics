<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\User;
use App\Entity\FanArt;
use App\Form\FanArtType;
use App\Form\ArticleType;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    // vue page home administrateur
    private $articleRepo;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepo = $articleRepository;
    }

    public function homeAction(){
        return $this->render('admin/pages/admin-home.html.twig');
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

        if ($form->isSubmitted()){
            $article = $form->getData();
            $article->setIsConfirmed(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute("articles");
        }
        return $this->render("admin/pages/admin-article-create.html.twig", ["articleForm" => $form->createView()]);
    }
    public function updateArticles(Request $request, $id)
    {
        $article = $this->articleRepo->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $article = $form->getData();

//            $actualTitle = $article->getTitle();
//            //récupérer mon user dans la BDD
//            $author = $this->articleRepo->findOneBy($id);
//            $article->setAuthor($author);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute("articles");
        }
        return $this->render('admin/pages/admin-article-update.html.twig', ["articleUpdateForm" => $form->createView()]);
    }
}
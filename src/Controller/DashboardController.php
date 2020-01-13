<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Editor;
use App\Form\ArticleType;
use App\Form\EditorType;
use App\Form\FanArtType;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\FanArtRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\AsciiSlugger;

class DashboardController extends AbstractController
{
    private $userRepository;
    private $articleRepository;
    private $fanArtRepository;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, FanArtRepository $fanArtRepository)
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->fanArtRepository = $fanArtRepository;
    }


    public function homeAction(Request $request, Security $security, Article $id)
    {
        $article = $this->userRepository->findBy(['id' => $id->getUserId()]);
        $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
        return $this->render('home.html.twig', ["user" => $user, "article" => $article]);
    }

    public function articleCreate(Request $request, Security $security)
    {
        $slugger = new AsciiSlugger();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $article = $form->getData();
            $actualTitle = $article->getArticleTitle();
            $slug = strtolower($slugger->slug($actualTitle));
            $article->setSlug($slug);
            //récupérer mon user dans la BDD
            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $article->setUserId($user);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render("dashboard/pages/dashboard_create_article.html.twig", ["articleForm" => $form->createView()]);
    }

    public function articleUpdate(Request $request,Security $security, $id)
    {
        $article = $this->articleRepository->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $article = $form->getData();
            $author = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $article->setAuthor($author);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('articles');
        }
        return $this->render('dashboard/pages/dashboard_update_article.html.twig', ['articleUpdateForm' => $form->createView()]);
    }

    public function fanArtsCreate()
    {
    }

    public function fanArtsUpdate(Request $request, $id)
    {
        $fanArt = $this->fanArtRepository->find($id);
        $form = $this->createForm(FanArtType::class, $fanArt);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $fanArt = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fanArt);
            $entityManager->flush();
            return $this->redirectToRoute('fanArts');
        }
        return $this->render('dashboard/pages/dashboard_update_fanArt.html.twig', ['fanArtUpdateForm' => $form->createView()]);
    }

    public function userUpdate(Request $request, Security $security)
    {
        $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user = $form->getData();
            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/pages/dashboard_update_user.html.twig', ['userUpdateForm' => $form->createView()]);
    }

    public function editorsCreate(Request $request)
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $editor = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editor);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render("dashboard/pages/dashboard_create_editor.html.twig", ["editorForm" => $form->createView()]);

    }

    public function editorsUpdate()
    {
    }

    public function jobsCreate()
    {
    }

    public function jobsUpdate()
    {
    }

    public function authorsCreate()
    {
    }

    public function authorsUpdate()
    {
    }

}
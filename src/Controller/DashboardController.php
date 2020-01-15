<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Editor;
use App\Entity\FanArt;
use App\Entity\Job;
use App\Entity\Author;
use App\Form\ArticleAdminType;
use App\Form\ArticleType;
use App\Form\AuthorType;
use App\Form\EditorType;
use App\Form\FanArtAdminType;
use App\Form\FanArtType;
use App\Form\JobType;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
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
    private $authorRepository;

    public function __construct(UserRepository $userRepository, ArticleRepository $articleRepository, FanArtRepository $fanArtRepository, AuthorRepository $authorRepository)
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->fanArtRepository = $fanArtRepository;
        $this->authorRepository = $authorRepository;
    }


    public function homeAction(Request $request, Security $security, Article $id)
    {
        $articles = $this->articleRepository->findBy(['id' => $id->getUserId()]);
        $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);



        return $this->render('home.html.twig', ["user" => $user, "article" => $articles]);
    }

    public function articleCreate(Request $request, Security $security)
    {
        $slugger = new AsciiSlugger();
        $article = new Article();
        $isAdmin = in_array('ROLE_ADMIN',  $security->getUser()->getRoles());

        if($isAdmin) {
            $form = $this->createForm(ArticleAdminType::class, $article);
        } else {
            $form = $this->createForm(ArticleType::class, $article);
        }

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $article = $form->getData();
            if($isAdmin) {
                $article->setIsConfirmed(true);
            }
            $actualTitle = $article->getArticleTitle();
            $slug = strtolower($slugger->slug($actualTitle));
            $article->setSlug($slug);

            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $article->setUserId($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }

        return $this->render("dashboard/pages/dashboard_create_article.html.twig", ["articleForm" => $form->createView(), "article" => $article]);
    }

    public function articleUpdate(Request $request,Security $security, $id)
    {
        $slugger = new AsciiSlugger();
        $article = $this->articleRepository->find($id);
        $isAdmin = in_array('ROLE_ADMIN',  $security->getUser()->getRoles());

        if($isAdmin) {
            $form = $this->createForm(ArticleAdminType::class, $article);
        } else {
            $form = $this->createForm(ArticleType::class, $article);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $article = $form->getData();
            if($isAdmin) {
                $article->setIsConfirmed(true);
            }
            $actualTitle = $article->getArticleTitle();
            $slug = strtolower($slugger->slug($actualTitle));
            $article->setSlug($slug);
            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $article->setUserId($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/pages/dashboard_update_article.html.twig', ['articleUpdateForm' => $form->createView()]);
    }

    public function fanArtsCreate(Request $request, Security $security)
    {
        $slugger = new AsciiSlugger();
        $fanart = new FanArt();
        $isAdmin = in_array('ROLE_ADMIN',  $security->getUser()->getRoles());

        if($isAdmin) {
            $form = $this->createForm(FanArtAdminType::class, $fanart);
        } else {
            $form = $this->createForm(FanArtType::class, $fanart);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $fanart = $form->getData();
            if($isAdmin) {
                $fanart->setIsConfirmed(true);
            }
            $actualTitle = $fanart->getFanArtTitle();
            $slug = strtolower($slugger->slug($actualTitle));
            $fanart->setSlug($slug);
            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $fanart->setUserId($user);

            $image = $form['fan_art_sketch']->getData();
            if ($image){
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName.'-'.uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('uploaded-images'), $newUniqueFileName);
                $fanart->setFanArtSketch($newUniqueFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fanart);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('dashboard/pages/dashboard_create_fanArt.html.twig',['FanArtForm' =>$form->createView()]);
    }

    public function fanArtsUpdate(Request $request, Security $security, $id)
    {
        $slugger = new AsciiSlugger();
        $fanArt = $this->fanArtRepository->find($id);
        $isAdmin = in_array('ROLE_ADMIN',  $security->getUser()->getRoles());

        if($isAdmin) {
            $form = $this->createForm(FanArtAdminType::class, $fanArt);
        } else {
            $form = $this->createForm(FanArtType::class, $fanArt);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $fanArt = $form->getData();
            if($isAdmin) {
                $fanArt->setIsConfirmed(true);
            }
            $actualTitle = $fanArt->getFanArtTitle();
            $slug = strtolower($slugger->slug($actualTitle));
            $fanArt->setSlug($slug);
            $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
            $fanArt->setUserId($user);

            $image = $form['fan_art_sketch']->getData();
            if ($image){
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName.'-'.uniqid().'.'.$image->guessExtension();
                $image->move($this->getParameter('uploaded-images'), $newUniqueFileName);
                $fanArt->setFanArtSketch($newUniqueFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fanArt);
            $entityManager->flush();
            return $this->redirectToRoute('home');
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
            return $this->redirectToRoute("dashboard_fanArts_create");
        }
        return $this->render("dashboard/pages/dashboard_create_editor.html.twig", ["editorForm" => $form->createView()]);

    }

    public function jobsCreate(Request $request)
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $job = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);
            $entityManager->flush();
            return $this->redirectToRoute("dashboard_authors_create");
        }
        return $this->render("dashboard/pages/dashboard_create_job.html.twig", ["jobForm" => $form->createView()]);
    }

    public function authorsCreate(Request $request)
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $author = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('dashboard_articles_create');
        }
        return $this->render('dashboard/pages/dashboard_create_authors.html.twig', ["authorForm" => $form->createView()]);
    }

}
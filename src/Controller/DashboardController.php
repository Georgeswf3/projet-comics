<?php


namespace App\Controller;


use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Editor;
use App\Entity\Job;
use App\Form\ArticleType;
use App\Form\AuthorType;
use App\Form\EditorType;
use App\Form\JobType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\AsciiSlugger;

class DashboardController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function homeAction(Request $request,Security $security)
    {
        $user = $this->userRepository->findOneBy(['email' => $security->getUser()->getUsername()]);
        return $this->render('home.html.twig', ["user" => $user]);
    }

    public function articleCreate(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute("dashboard_home");
        }

        return $this->render("dashboard/pages/dashboard_create_article.html.twig", ["articleForm" => $form->createView()]);
    }

    public function articleUpdate()
    {
    }

    public function fanArtsCreate()
    {
    }

    public function fanArtsUpdate()
    {
    }

    public function userUpdate()
    {
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
            return $this->redirectToRoute("dashboard_home");
        }
        return $this->render("dashboard/pages/dashboard_create_editor.html.twig", ["editorForm" => $form->createView()]);

    }

    public function editorsUpdate()
    {
    }

    public function jobsCreate(Request $request)
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $job = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);
            $entityManager->flush();
            return $this->redirectToRoute("dashboard_home");
        }

        return $this->render("dashboard/pages/dashboard_create_job.html.twig", ["jobForm" => $form->createView()]);

    }

    public function jobsUpdate()
    {
    }

    public function authorsCreate(Request $request)
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $author = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute("dashboard_home");
        }
        return $this->render("dashboard/pages/dashboard_create_authors.html.twig", ["authorForm" => $form->createView()]);

    }

    public function authorsUpdate()
    {
    }

}
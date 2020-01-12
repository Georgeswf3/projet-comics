<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
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
        $slugger = new AsciiSlugger();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $article = $form->getData();
            $actualTitle = $article->getTitle();
            $slug = strtolower($slugger->slug($actualTitle));
            $article->setSlug($slug);

//            $image = $form['image']->getData();
//            if($image){
//                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
//                $newUniqueFileName = $originalFileName."-".uniqid().'.'.$image->guessExtension();
//                $image->move($this->getParameter('uploaded-images'), $newUniqueFileName);
//                $article->setImage($newUniqueFileName);
//            }

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

    public function editorsCreate()
    {
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
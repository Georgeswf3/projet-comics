<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\FanArt;
use App\Form\CommentArticleType;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    private $articleRepo;
    private $userRepo;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->articleRepo = $articleRepository;
        $this->userRepo = $userRepository;
    }

    public function createUsers(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user = $form->getData();
            $user->setRoles(['ROLE_USER']);
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $image = $form['avatar_image']->getData();
            if ($image) {
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName . "-" . uniqid() . "." . $image->guessExtension();
                $image->move($this->getParameter('uploaded-images'), $newUniqueFileName);
                $user->setAvatarImage($newUniqueFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("profile_home");
        }
        return $this->render('admin/pages/admin-users-create.html.twig', ['userForm' => $form->createView(),]);
    }
    public function article(Request $request, $id){

        $article = new Article();
        $comment = new Comment();
        $article = $this->articleRepo->findOneBy(['id'=>$id]);

        $formArticleComment = $this->createForm(CommentArticleType::class, $comment);
        $formArticleComment->handleRequest($request);

        if ($formArticleComment->isSubmitted()){
            $comment = $formArticleComment->getData();
            $comment->setIsConfirmed(true);
            $comment->setArticleId($article);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
//            return $this->redirectToRoute("article");
        }
        return $this->render('pages/article.html.twig', ['article'=>$article,'commentArticleForm' => $formArticleComment->createView(),]);
    }

    public function fanArt(Request $request){

        $comment = new Comment();
        $formFanArtComment = $this->createForm(CommentFanArtType::class, $comment);
        $formFanArtComment->handleRequest($request);

        if ($formFanArtComment->isSubmitted()){
            $comment = $formFanArtComment->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute("fanArt");
        }
        return $this->render('pages/fanart.html.twig', ['commentFanArtForm' => $formFanArtComment->createView(),]);
    }

    public function index(){
        return $this->render('home.html.twig');
    }

    public function articles(){
        return $this->render('pages/articles.html.twig');
    }

    public function fanArts(){
        return $this->render('pages/fanarts.html.twig');
    }

// vue page home utilisateur lambda

    public function homeAction(Request $request, Security $security){

            $user = $this->userRepo->findOneBy(['email' => $security->getUser()->getUsername()]);
            return $this->render('home.html.twig', ["user" => $user]);}


}
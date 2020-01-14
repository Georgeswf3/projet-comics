<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\FanArt;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CommentArticleType;
use App\Form\CommentFanArtType;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\FanArtRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;


class PublicController extends AbstractController
{
    private $articleRepo;
    private $fanArtRepo;
    private $commentRepo;
    private $userRepo;


    public function __construct(ArticleRepository $articleRepository, FanArtRepository $fanArtRepository, CommentRepository $commentRepository, UserRepository $userRepository)
    {
        $this->articleRepo = $articleRepository;
        $this->fanArtRepo = $fanArtRepository;
        $this->commentRepo = $commentRepository;
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        return $this->render('home.html.twig');
    }



    public function articles()
    {
        $articles = $this->articleRepo->findAll();
        return $this->render('pages/articles.html.twig', ["articles" => $articles]);
        $articles = $this->articleRepo->findPaginatedArticles($from);

    }

    public function article(Request $request, $slug)
    {
        $article = $this->articleRepo->findOneBy(["slug" => $slug]);
        $comment = new Comment();
        $form = $this->createForm(CommentArticleType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $comment = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }
        return $this-> render('pages/article.html.twig', ["article" => $article, "commentForm" => $form -> createView()]);
    }

    public function fanArts(Request $request)
    {
        $from = $request->query->get("from");
        $fanArts = $this->fanArtRepo->findPaginatedFanArts($from);
        return $this->render('pages/fanarts.html.twig', ["fanArts" => $fanArts, "from" => $from]);
    }

    public function fanArt(Request $request, Security $security, $slug)
    {
        $fanArt = $this->fanArtRepo->findOneBy(["slug" => $slug]);
        $comments = $this->commentRepo->findBy(["fan_art" => $fanArt]);

        $comment = new Comment();
        $form = $this->createForm(CommentFanArtType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $comment = $form->getData();
            $user = $this->userRepo->findOneBy(['email' => $security->getUser()->getUsername()]);
            $comment->setUserId($user);
            $comment->setFanArtId($fanArt);
            $comment->getId();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('fanArt', ['slug' => $fanArt->getSlug()]);
        }

        return $this->render('pages/fanart.html.twig', ["fanArt" => $fanArt, "comments" => $comments, 'commentForm' => $form->createView()]);
    }

    public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $user = $form->getData();
            $user->setRoles(['ROLE_USER']);
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $image = $form['avatar_image']->getData();
            if ($image){
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName."-".uniqid().".".$image->guessExtension();
                $image->move($this->getParameter('uploaded-images'),$newUniqueFileName);
                $user->setAvatarImage($newUniqueFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('pages/signup.html.twig', ['userForm'=>$form->createView()]);
    }



}
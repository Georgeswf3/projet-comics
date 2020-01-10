<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\ArticleRepository;
use App\Repository\FanArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PublicController extends AbstractController
{
    private $articleRepo;
    private $fanArtRepo;

    public function __construct(ArticleRepository $articleRepository, FanArtRepository $fanArtRepository)
    {
        $this->articleRepo = $articleRepository;
        $this->fanArtRepo = $fanArtRepository;

    }

    public function index()
    {
        return $this->render('home.html.twig');
    }



    public function articles()
    {
        $articles = $this->articleRepo->findAll();
        return $this->render('pages/articles.html.twig', ["articles" => $articles]);

    }

    public function article($id)
    {
    }

    public function fanArts()
    {
        $fanArts = $this->fanArtRepo->findAll();
        return $this->render('pages/fanarts.html.twig', ["fanArts" => $fanArts]);
    }

    public function fanArt($id)
    {
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
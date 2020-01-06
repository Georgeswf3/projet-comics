<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentArticleType;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{

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

    public function index(){
        return $this->render('home.html.twig');
    }

    public function articles(Request $request){

        $comment = new Comment();
        $formComment = $this->createForm(CommentArticleType::class, $comment);
        $formComment->handleRequest($request);
    }
}
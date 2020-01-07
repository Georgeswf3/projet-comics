<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    private $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }


// vue page home utilisateur lambda
    public function homeAction(Request $request, Security $security){

        if ($security->getUser()){
        $user = $this->userRepo->findOneBy(['email' =>$security->getUser()->getUsername()]);}
        else{
            $user = null;
        }
        return $this->render('user_home.html.twig', ["user" => $user]);
    }
}
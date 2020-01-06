<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    // vue page home administrateur
    public function homeAction(){
        return $this->render('');
    }

    // vue page home utilisateur lambda
    public function homeUser(){
        return $this->render('');
    }



}
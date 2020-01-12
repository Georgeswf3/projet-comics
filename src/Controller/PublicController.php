<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\FanArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    public function fanArt($slug)
    {
        $fanArt = $this->fanArtRepo->findOneBy(["slug" => $slug]);
        return $this->render('pages/fanart.html.twig', ["fanArt" => $fanArt]);
    }

    public function signup()
    {
    }



}
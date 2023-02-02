<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_index')]
    public function index(ArticlesRepository $artRepo): Response
    {
        //recupérer les articles 
        $articles =$artRepo->findAll();
        // 'articles' = variable coté twig (vue)
        // $articles =variable coté controller
        return $this->render('blog/index.html.twig', [
            'articles'=>$articles,
        ]);
    }
    #[Route('/blog/{id}',name:'blog_detail_art')]
    public function showArticle(Articles $article){
        return $this->render('blog/detail_art.html.twig',[
            'article'=>$article,
        ]);
    }
}

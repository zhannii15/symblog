<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Articles;
use App\Form\CommentType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function showArticle(Articles $article,Request $req,EntityManagerInterface $em){
        $comment= new Comment();
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);
        if ($form->isSubmitted()&&$form->isValid()){
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $em->persist($comment);
            $em->flush();
        }
        

        return $this->render('blog/detail_art.html.twig',[
            'article'=>$article,
            'formCom'=>$form->createView(),
        ]);
    }
}

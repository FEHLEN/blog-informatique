<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;

class HomeController extends AbstractController
{
    private $repoArticle;
    private $repoCategory;
    public function __construct(ArticleRepository $repoArticle,
    CategoryRepository $repoCategory){
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
       
        $articles = $this->repoArticle->findAll();
        //dd($articles);
        $categories = $this->repoCategory->findAll();

        return $this->render("home/index.html.twig",[
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
     /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        if(!$article){
            return $this->redirectToRoute('home');
        }
        
        return $this->render("show/index.html.twig",[
            'article' => $article,
        ]);
    }

     /**
     * @Route("show/byCategory/{id}", name="byCategory")
     */
    public function showByCategory(?Category $category): Response
    {
        if($category){
            $articles = $category->getArticles()->getValues();
        }else{
            return $this->redirectToRoute('home');
        }
       //dd($articles);
       
        $categories = $this->repoCategory->findAll();
        return $this->render("show/byCategory/index.html.twig", [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}

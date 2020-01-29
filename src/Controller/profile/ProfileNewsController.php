<?php


namespace App\Controller\profile;


use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileNewsController extends AbstractController
{

    /**
     * @Route("/", name="profile_news_index")
     * @param NewsRepository $repository
     * @return Response
     */
    public function index(NewsRepository $repository){
        $news = $repository->findAll();
        return $this->render('Profile/news/index.html.twig', [
            'news' => $news
        ]);
    }
}
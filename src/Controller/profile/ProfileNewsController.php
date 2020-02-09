<?php

namespace App\Controller\profile;

use App\Entity\News;
use App\Entity\Picture;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileNewsController extends AbstractController
{
    /**
     * @Route("/news/{id}", name="news")
     * @param News $new
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function index(News $new,NewsRepository $newsRepository)
    {
        $picture = $new->getCity()->getPicture()[0];
        $picture = $picture->getFilename();
        $newss = $newsRepository->findAll();
        return $this->render('profile/news/index.html.twig', [
            'news' => $newss,
            'picture' =>$picture
        ]);
    }
}

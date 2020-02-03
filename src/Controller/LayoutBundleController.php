<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LayoutBundleController extends AbstractController
{
    public function leftMenuAction(CountryRepository $countryRepository)
    {
        $countries = $countryRepository->findAll();
        return $this->render('layout/_sidebar_left.html.twig',[
            'countries' => $countries
        ]);
    }

    public function rightMenuAction(CityRepository $cityRepository, NewsRepository $newsRepository)
    {
        $news = $newsRepository->findAll();
        return $this->render('layout/_sidebar_right.html.twig',[
            'news' => $news,
        ]);
    }
}

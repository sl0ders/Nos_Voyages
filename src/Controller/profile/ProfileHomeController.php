<?php

namespace App\Controller\profile;

use App\Data\SearchData;
use App\Form\SearchType;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\NewsRepository;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileHomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param CountryRepository $countryRepository
     * @param NewsRepository $newsRepository
     * @param Request $request
     * @param PictureRepository $pictureRepository
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function index(CountryRepository $countryRepository,NewsRepository $newsRepository, Request $request, pictureRepository $pictureRepository ,AuthenticationUtils $authenticationUtils)
    {
        $news = $newsRepository->findAll();
        $countries = $countryRepository->findAll();
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $pictures = $pictureRepository->findSearch($data);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('homepage.html.twig', [
            'lastUsername' => $lastUsername,
            '$error' => $error,
            'form' => $form->createView(),
            'pictures' => $pictures,
            'news' => $news,
            'countries' => $countries
        ]);
    }
}

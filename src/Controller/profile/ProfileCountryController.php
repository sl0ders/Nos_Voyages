<?php

namespace App\Controller\profile;

use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ProfileCountryController extends AbstractController
{
    /**
     * @Route("/{name}/index", name="country_index", methods={"GET"})
     * @param CityRepository $cityRepository
     * @param Country $country
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function index(CityRepository $cityRepository, Country $country, CountryRepository $countryRepository): Response
    {
        $cities = $cityRepository->findBy(['country' => $country]);
        $country = $countryRepository->find($country);
        return $this->render('Profile/city/index.html.twig', [
            'cities' => $cities,
            'country' => $country,
        ]);
    }
}

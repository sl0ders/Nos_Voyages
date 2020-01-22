<?php

namespace App\Controller\profile;

use App\Entity\Pays;
use App\Repository\CityRepository;
use App\Repository\PaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ProfilePaysController extends AbstractController
{
    /**
     * @Route("/{name}/index", name="pays_index", methods={"GET"})
     * @param CityRepository $cityRepository
     * @param Pays $pays
     * @param PaysRepository $paysRepository
     * @return Response
     */
    public function index(CityRepository $cityRepository, Pays $pays, PaysRepository $paysRepository): Response
    {
        $cities = $cityRepository->findBy(['pays' => $pays]);
        $pays = $paysRepository->find($pays);
        return $this->render('Profile/city/index.html.twig', [
            'cities' => $cities,
            'pays' => $pays,
        ]);
    }
}

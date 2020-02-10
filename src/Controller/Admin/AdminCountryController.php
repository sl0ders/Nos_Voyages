<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Entity\Country;
use App\Form\CityType;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/country")
 */
class AdminCountryController extends AbstractController
{
    /**
     * @Route("/", name="admin_country_index", methods={"GET","POST"})
     * @param Request $request
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function index(Request $request, CountryRepository $countryRepository): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('admin_picture_index');
        }

        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $country->setMap('img/' . $country->getName() . '_map.png');
            $country->setSmallPng('img/' . $country->getName() . '_logo.png');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($country);
            $entityManager->flush();
            return $this->redirectToRoute('admin_country_index');
        }

        return $this->render('Admin/country/index.html.twig', [
            'countries' => $countryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_country_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $country = new Country();

        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        return $this->render('Admin/country/new.html.twig', [
            'country' => $country,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin_country_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Country $country
     * @return Response
     */
    public function edit(Request $request, Country $country): Response
    {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_country_index');
        }

        return $this->render('Admin/country/edit.html.twig', [
            'country' => $country,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_country_delete", methods={"DELETE"})
     * @param Request $request
     * @param Country $country
     * @return Response
     */
    public function delete(Request $request, Country $country): Response
    {
        if ($this->isCsrfTokenValid('delete' . $country->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($country->getCities() as $city) {
                $entityManager->remove($city);
            }
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_country_index');
    }

    public function search()
    {

    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Entity\Country;
use App\Form\CityType;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use App\Services\CreateFileServices;
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
     * @param CreateFileServices $createFileServices
     * @return Response
     */
    public function index(Request $request, CountryRepository $countryRepository, CreateFileServices $createFileServices): Response
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
            // determine a final path of both file in parameters
            $path = $this->getParameter("country_path");
            // retrieve of map en icon image
            $fileMap = $form["map"]->getData();
            $fileSmallPng = $form["smallPng"]->getData();
            // retrieve name of this country
            $countryName = $form['name']->getData();
            //the function fileMap create a new file
            $newMapPath = $createFileServices->fileMap($fileMap, $countryName, $path);
            $newSmallPngPath = $createFileServices->fileMap($fileSmallPng, $countryName, $path);
            $country->setMap($newMapPath);
            $country->setSmallPng($newSmallPngPath);
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

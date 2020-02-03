<?php

namespace App\Controller\profile;

use App\Entity\City;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Form\CityType;
use App\Form\CommentType;
use App\Repository\CityRepository;
use App\Repository\PictureRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{country}")
 */
class ProfilePictureController extends AbstractController
{
    /**
     * @Route("/{city}", name="profile_picture_index")
     * @param PictureRepository $pictureRepository
     * @param City $city
     * @param CityRepository $cityRepository
     * @return Response
     */
    public function index(PictureRepository $pictureRepository, $city, CityRepository $cityRepository): Response
    {
        $city = $cityRepository->findOneBy(['name' => $city]);
        $pictures = $pictureRepository->findBy(['city' => $city]);
        return $this->render('Profile/picture/index.html.twig', [
            'pictures' => $pictures,
        ]);
    }

    /**
     * @Route("/{city}/picture/{id}", name="profile_picture_show")
     * @param Picture $picture
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function show(Picture $picture, Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $comment->setCreatedAt(new DateTime);
            $comment->setAuthor($user);
            $comment->setEnabled(false);
            $comment->setPicture($picture);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('profile_picture_show', [
                'id' => $picture->getId(),
                'country' => $picture->getCountry(),
                'city' => $picture->getCity()
            ]);

        }
        return $this->render('Profile/picture/show.html.twig', [
            'picture' => $picture,
            'form' => $form->createView()
        ]);
    }
}

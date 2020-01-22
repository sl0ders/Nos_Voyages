<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Form\PictureEditType;
use App\Form\PictureNewType;
use App\Repository\PictureRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController
{
    /**
     * @Route("/", name="admin_picture_index", methods={"GET","POST"})
     * @param PictureRepository $pictureRepository
     * @return Response
     */
    public function index(PictureRepository $pictureRepository): Response
    {
        return $this->render('Admin/picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_picture_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureNewType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($picture);
            $picture->setLink('img/pictures/'.$picture->getFilename());
            $entityManager->flush();

            return $this->redirectToRoute('admin_picture_index');
        }

        return $this->render('Admin/picture/_form_new.html.twig', [
            'picture' => $picture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_picture_show", methods={"GET","POST"})
     * @param Picture $picture
     * @return Response
     */
    public function show(Picture $picture): Response
    {
        return $this->render('Admin/picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_picture_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Picture $picture
     * @return Response
     */
    public function edit(Request $request, Picture $picture): Response
    {
        $form = $this->createForm(PictureEditType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture->setCity($picture->getCity());
            $picture->setPays($picture->getPays());
            $picture->setLink($picture->getFilename());
            $picture->setDayOfTaking($picture->getDayOfTaking());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_picture_index');
        }

        return $this->render('Admin/picture/_form_edit.html.twig', [
            'picture' => $picture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_picture_delete", methods={"DELETE"})
     * @param Request $request
     * @param Picture $picture
     * @return Response
     */
    public function delete(Request $request, Picture $picture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_picture_index');
    }
}

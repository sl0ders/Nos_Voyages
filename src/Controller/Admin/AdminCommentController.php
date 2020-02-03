<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Form\CommentAdminType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/comment")
 */
class AdminCommentController extends AbstractController
{
    /**
     * @Route("/", name="admin_comment_index", methods={"GET"})
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_comment_edit", methods={"GET","POST"})
     * @param $comment
     * @param Request $request
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function edit(Comment $comment, Request $request, CommentRepository $commentRepository): Response
    {
        if ($_POST['report']) {
            $comment->setEnabled(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('admin_comment_index');
        }
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_comment_delete", methods={"DELETE"})
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_comment_index');
    }

    public function report()
    {

    }
}

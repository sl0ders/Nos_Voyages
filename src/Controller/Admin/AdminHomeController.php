<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * * @Route("/admin/home")
 */
class AdminHomeController extends AbstractController
{
    /**
     * @Route("/", name="admin_home")
     */
    public function index()
    {
        return $this->render('Admin/home.html.twig', [
            'controller_name' => 'AdminHomeController',
        ]);
    }
}

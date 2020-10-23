<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminMenusController extends AbstractController
{
    /**
     * @Route("/admin/menus", name="admin_menus")
     */
    public function index()
    {
        return $this->render('admin/adminMenus.html.twig', [
            'controller_name' => 'AdminMenusController',
        ]);
    }
}

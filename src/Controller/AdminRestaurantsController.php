<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminRestaurantsController extends AbstractController
{
    /**
     * @Route("/admin/restaurants", name="admin_restaurants")
     */
    public function index()
    {
        return $this->render('admin/adminRestaurants.html.twig', [
            'controller_name' => 'AdminRestaurantsController',
        ]);
    }
}

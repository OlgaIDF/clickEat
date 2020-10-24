<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminRestaurantsController extends AbstractController
{
    /**
     * @Route("/admin/restaurants", name="admin_restaurants")
     */
    public function index(RestaurantsRepository $restaurantsRepository)
    {
        $restaurants = $restaurantsRepository->findAll();

        return $this->render('admin/adminRestaurants.html.twig', [
            'restaurants' => $restaurants,
        ]);
}
}
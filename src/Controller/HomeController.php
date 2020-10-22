<?php

namespace App\Controller;

use App\Repository\MenusRepository;
use App\Repository\RestaurantsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RestaurantsRepository $restaurantsRepository, MenusRepository $menusRepository)
    {
        $restaurants = $restaurantsRepository->findAll();
        $menus = $menusRepository->findAll();
        
        
       

        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurants,
            'menus' => $menus,
            
        ]);
    }
}


<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Form\RestaurantType;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
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

/**
     * @Route("/admin/restaurants/create", name="restaurant_create")
     */
    public function createRestaurant(Request $request){
        $restaurant=new Restaurants();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            
            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($restaurant);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le restaurant a bien été modifiée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
                return $this->redirectToRoute('admin_restaurants');
            }
        
return $this->render('admin/adminRestaurantsForm.html.twig', [
            'formulaireRestaurant' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/admin/restaurants/update-{id}", name="restaurant_update")
     */
    public function updateRestaurant(RestaurantsRepository $restaurantsRepository, $id, Request $request)
    {
        $restaurant = $restaurantsRepository->find($id);
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($restaurant);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le restaurant a bien été modifiée'
                );
                
                return $this->redirectToRoute('admin_restaurants');
            }
            return $this->render('admin/adminRestaurantsForm.html.twig', [
                'formulaireRestaurant' => $form->createView()
            ]);
    }

    /**
     * @Route("/admin/restarants/delete-{id}", name="restaurant_delete")
     */
    public function deleteRestaurant(RestaurantsRepository $restaurantsRepository, $id)
    {
        $restaurant = $restaurantsRepository->find($id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($restaurant);
        $manager->flush();

        $this->addFlash(
            'success',
            'La restaurant a bien été supprimée'
        );

       

        return $this->redirectToRoute('admin_restaurants');
    }

}
<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Form\RestaurantType;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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

        // récupèrer les informations de l'img
        $imgResto = $form['img_resto']->getData();

        if($form->isSubmitted()){
            
            if($form->isValid()){

                $nomImgResto = md5(uniqid()); // nom unique
                $extensionImgResto = $imgResto->guessExtension(); // récupérer l'extension du picto
                $newNomImgResto = $nomImgResto . '.' . $extensionImgResto; // recomposer un nom du picto

                try { // on tente d'importer l'image


                    $imgResto->move(
                        $this->getParameter('dossier_photos_restaurants'),
                        $newNomImgResto
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation d\'image'
                    );
                }

                $restaurant->setImgResto($newNomImgResto); // nom pour la base de données
                
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

        // récupérer nom et chemin img1
        $oldNomImgResto = $restaurant->getImgResto();
        $oldCheminImgResto = $this->getParameter('dossier_photos_restaurants').'/'.$oldNomImgResto;

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        $imgResto = $form['img_resto']->getData();

        if($form->isSubmitted() && $form->isValid()){

            // supprimer ancienne picto
            if ($oldNomImgResto != null) {
                unlink($oldCheminImgResto);
            }


            $nomImgResto = md5(uniqid()); // nom unique
            $extensionImgResto = $imgResto->guessExtension(); // récupérer l'extension du picto
            $newNomImgResto = $nomImgResto . '.' . $extensionImgResto; // recomposer un nom du picto

            try { // on tente d'importer le picto                                      
                $imgResto->move(
                    $this->getParameter('dossier_photos_restaurants'),
                    $newNomImgResto
                );
            } catch (FileException $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue lors de l\'importation d\'image'
                );
            }

            $restaurant->setImgResto($newNomImgResto); // nom pour la base de données

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

        // récupérer le nom et le chemin de l'image à supprimer
        $nomImgResto = $restaurant->getImgResto();
        $cheminImgResto = $this->getParameter('dossier_photos_restaurants') . '/' . $nomImgResto;

        // supprimer img1
        if ($nomImgResto != null) {
            unlink($cheminImgResto);
        }
        
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
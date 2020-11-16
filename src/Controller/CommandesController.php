<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Service\Cart\CartService;
use App\Repository\UserRepository;
use App\Repository\MenusRepository;
use App\Repository\CommandesRepository;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandesController extends AbstractController
{
    /**
     * @Route("/commandes", name="commandes")
   
     */
    
public function creerCommandes(SessionInterface $session, CartService $cartService, MenusRepository $menusRepository, UserRepository $userRepository)
{

    $panier = $session ->get('panier', []);
    $panierWithData = [];

    foreach ($panier as $id => $quantity) {
        $panierWithData[] =[
            
            'menu'=> $menusRepository -> find($id),
            
            'quantity'=>$quantity
        ];
    }
    $commande = new Commandes;
    $commande->setDate(new \DateTime('now'));
    $commande->setReference(0);
    $commande->setValider(0);
    $commande->setMenus($panierWithData);
       
    $commande->setTotal($cartService ->getTotal());
    $commande->setUtilisateur($this->getUser());

  
    $manager = $this->getDoctrine()->getManager();
    $manager->persist($commande);
    $manager->flush();
    

    

    

   $session->invalidate();

$this->addFlash(
        'success',
        'Le restaurant a bien été modifiée'
    );
  return $this->redirectToRoute('home');
  
 }

  /**
     * @Route("/commandes/gestion", name="commandes_gestion")
     */

 public function index(RestaurantsRepository $restaurantsRepository, CommandesRepository $commandesRepository, UserRepository $userRepository)
    {
        $commandes= $commandesRepository->findAll();
       

      //dd($commandes);
        

        return $this->render('commandes/commandesGestion.html.twig', [


           
            'commandes' => $commandes,
            
            
        ]);
}






}

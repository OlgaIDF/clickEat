<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandeType;
use App\Service\Cart\CartService;
use App\Repository\UserRepository;
use App\Repository\MenusRepository;
use App\Repository\CommandesRepository;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/commandes/gestion/update-{id}", name="commande_update")
     */
    public function updateCommande(CommandesRepository $commandesRepository, $id, Request $request)
    {
        $commande = $commandesRepository->find($id);

        
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

       

        if($form->isSubmitted() && $form->isValid()){

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($commande);
                $manager->flush();
                //dd($commande);
                $this->addFlash(
                    'success',
                    'Le commande a bien été modifiée'
                );
                
                return $this->redirectToRoute('commandes_gestion');
            }
            return $this->render('commandes/commandesEdit.html.twig', [
                'formulaireCommande' => $form->createView()
            ]);
    }

    /**
     * @Route("/commandes/gestion/delete-{id}", name="commande_delete")
     */
    public function deleteCommande(CommandesRepository $commandesRepository, $id)
    {
        $commande= $commandesRepository->find($id);

       
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($commande);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le commande a bien été supprimée'
        );

       

        return $this->redirectToRoute('commandes_gestion');
    }



  /**
     * @Route("/commandes/email", name="commandes_email")
     */

    public function createEmail(CommandesRepository $commandesRepository, \Swift_Mailer $mailer)
    {
        $commandes= $commandesRepository->findAll();
      
      $mail = (new \Swift_Message('Facturation'))
      ->setFrom('olha.idf@gmail.com')
      ->setTo($commandes['utilisateur.email'])
      ->setBody(
          $this->renderView(
              'commandes/email.html.twig'), 
              'text/html'
          
      );
  $mailer->send($mail);
  $this->addFlash(
      'success',
      'Votre message a bien été envoyé'
  );
  return $this->redirectToRoute('home');
}


}

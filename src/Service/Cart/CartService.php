<?php

namespace App\Service\Cart;

use App\Entity\Commandes;
use App\Repository\MenusRepository;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{

      protected $session;
      protected $menusRepository;
      public function __construct(SessionInterface $session, MenusRepository $menusRepository)
      {
         $this ->session = $session;
         $this ->menusRepository = $menusRepository;
         
      }

   public function add($id){
      $panier = $this ->session ->get('panier', []);
      if(!empty($panier[$id])){
          $panier[$id]++;
      }else{ $panier[$id]=1;}
     
      $this ->session->set('panier', $panier);
   }
   public function delete($id){

      $panier =  $this ->session ->get('panier', []);
        if(array_key_exists($id, $panier)) {
            unset($panier[$id]);
        }
       
        $this ->session->set('panier', $panier);
   }
   public function getFullCart() : array {
      
      $panier = $this ->session ->get('panier', []);

      $panierWithData = [];

      foreach ($panier as $id => $quantity) {
          $panierWithData[] =[
              'menu'=> $this ->menusRepository -> find($id),
              'quantity'=>$quantity
          ];
      }
      return $panierWithData;
   }
   public function getTotal() : float {
      $total=0;
      
       foreach ($this->getFullCart() as $item) {
          
           $total+= $item['menu']-> getPrix() * $item['quantity'];
       }
       $this ->session->set('total', $total);
       return $total;
 }
       



}

  





?>
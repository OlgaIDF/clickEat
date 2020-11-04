<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use App\Repository\MenusRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
     {         
            return $this->render('cart/cart.html.twig', [
            'items' => $cartService ->getFullCart(),
            'total' => $cartService ->getTotal()
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add(CartService $cartService, $id ){
                
       $cartService->add($id);
        return $this->redirectToRoute("cart_index");
       
    }

     /**
     * @Route("/panier/delete/{id}", name="cart_delete")
     */
    public function delete(CartService $cartService, $id ){
        $cartService->delete($id);
        
        return $this->redirectToRoute("cart_index");
        
       


    }
}
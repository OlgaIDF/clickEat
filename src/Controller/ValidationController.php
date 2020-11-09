<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidationController extends AbstractController
{
    /**
     * @Route("/users/panier/validation", name="validation")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('cart/validation.html.twig', [
            'users' => $users,
        ]);
    }
}

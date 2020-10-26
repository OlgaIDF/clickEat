<?php

namespace App\Controller;

use App\Repository\MenusRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMenusController extends AbstractController
{
    /**
     * @Route("/admin/menus", name="admin_menus")
     */
    public function index(MenusRepository $menusRepository)
    {
        $menus= $menusRepository->findAll();

        return $this->render('admin/adminMenus.html.twig', [
            'menus' => $menus,
        ]);
}
}

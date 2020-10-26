<?php

namespace App\Controller;

use App\Entity\Menus;
use App\Form\MenuType;
use App\Repository\MenusRepository;
use Symfony\Component\HttpFoundation\Request;
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
/**
     * @Route("/admin/menus/create", name="menu_create")
     */
    public function createMenu(Request $request){
        $menu = new Menus();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            
            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($menu);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le menu a bien été modifiée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
                return $this->redirectToRoute('admin_menus');
            }
        
return $this->render('admin/adminMenusForm.html.twig', [
            'formulaireMenu' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/admin/menus/update-{id}", name="menu_update")
     */
    public function updateMenu(MenusRepository $menusRepository, $id, Request $request)
    {
        $menu = $menusRepository->find($id);
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($rmenu);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le menu a bien été modifiée'
                );
                
                return $this->redirectToRoute('admin_menus');
            }
            return $this->render('admin/adminMenusForm.html.twig', [
                'formulaireMenu' => $form->createView()
            ]);
    }

    /**
     * @Route("/admin/menus/delete-{id}", name="menu_delete")
     */
    public function deleteMenu(MenusRepository $menusRepository, $id)
    {
        $menu= $menusRepository->find($id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($menu);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le menu a bien été supprimée'
        );

       

        return $this->redirectToRoute('admin_menus');
    }

}

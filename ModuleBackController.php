<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleBackController extends AbstractController
{
    /**
     * @Route("/BUG", name="home")
     */
    public function index(): Response
    {
        return $this->render('back/baseBackend.html.twig');
    }
    /**
     * @Route("/BUG/Categorie", name="categorierRoute")
     */
    public function table(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
}

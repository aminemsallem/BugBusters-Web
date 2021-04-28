<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    /**
     * @Route("/template", name="template")
     */
    public function index(): Response
    {
        return $this->render('template/index.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/backoffice", name="main")
     */
    public function back(): Response
    {
        return $this->render('back.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @Route("/front", name="front")
     */
    public function front(): Response
    {
        return $this->render('content1.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
}

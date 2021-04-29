<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Form\OeuvreType;
use App\Repository\OeuvreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oeuvre")
 */
class OeuvreController extends AbstractController
{
    /**
     * @Route("/", name="oeuvre_index", methods={"GET","POST"})
     */
    public function index(OeuvreRepository $oeuvreRepository, Request $requette, PaginatorInterface $paginator): Response
    {
        $AllOeuvre = $oeuvreRepository->findAll();
        if(isset($_POST['submit_search']) && ($requette->isMethod('POST')))
        {

//            $AllOeuvresss = $oeuvreRepository->search($_GET['search']);
            $get_search = $requette->get('saisi_search');
            $AllOeuvre = $oeuvreRepository->search($get_search);

            $AllOeuvresss = $paginator->paginate(
                $AllOeuvre,
                $requette->query->getInt('page',1),2);
        }
        else{
            $this->redirectToRoute('oeuvre_index');
        }

//        $oeuvres  = $this->get('knp_paginator')->paginate(
//            $oeuvreRepository->findAll(),
//            $requette->query->get('p', 1)/*le numéro de la page à afficher*/,
//            1/*nbre d'éléments par page*/
//        );
        $AllOeuvresss = $paginator->paginate(
            $AllOeuvre,
            $requette->query->getInt('page',1),2);
        return $this->render('oeuvre/index.html.twig', [
            'oeuvres' => $AllOeuvresss,
        ]);
    }

    /**
     * @Route("/new", name="oeuvre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $oeuvre = new Oeuvre();
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagefile=$oeuvre->getImageFile();
//            $image=md5(uniqid()).'.'.$imagefile->guessExtension();
            $entityManager = $this->getDoctrine()->getManager();
//            $oeuvre->setImage($image);
            $entityManager->persist($oeuvre);
            $entityManager->flush();

            return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_show", methods={"GET"})
     */
    public function show(Oeuvre $oeuvre): Response
    {
        return $this->render('oeuvre/show.html.twig', [
            'oeuvre' => $oeuvre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="oeuvre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Oeuvre $oeuvre): Response
    {
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_delete", methods={"POST"})
     */
    public function delete(Request $request, Oeuvre $oeuvre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oeuvre);
            $entityManager->flush();

        }

        return $this->redirectToRoute('oeuvre_index');
    }


    /**
     * @Route("/trier", name="oeuvre_trier", methods={"GET"})
     */
    public function trierC(OeuvreRepository $oeuvreRepository): Response
    {
        return $this->render('oeuvre/index.html.twig', [
            'oeuvre' => $oeuvreRepository->trier(),
        ]);
    }
     /**
     * @Route("/search", name="oeuvre_search", methods={"GET"})
     */

    public function search(OeuvreRepository $oeuvreRepository): Response
    {
        if(isset($_GET['search']))
        {

            $oeuvresearchs = $oeuvreRepository->search($_GET['search']);
        }
        else{
            $this->redirectToRoute('oeuvre_index');
        }
        return $this->render('oeuvre/index.html.twig', [
            'oeuvre' => $oeuvresearchs,
        ]);
    }
}

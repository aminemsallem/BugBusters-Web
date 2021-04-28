<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\AjoutercategorieType;
use App\Form\ModifiercategorieType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/ajoutercategories", name="ajoutercategories")
     * @param Request $request
     * @param $flashy
     * @return Response
     */
    public function ajoutercategorie (Request $request ,FlashyNotifier $flashy): response
    {
        $categorie = new Categorie();
        $form = $this->createForm(AjoutercategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            $flashy->success('votre commentaire est ajouté avec succès !' );

            return $this->redirectToRoute('les categories'); //route de de la template de l'affichage pour faire un lien avec ajouter
        }

        return $this->render(
            'categorie/ajoutercategorie.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/suprimercategorie/{id}", name="suprimercategorie")
     */

    public function suprimer ($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('App\Entity\Categorie')->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException(
                'There are no articles with the following id: ' . $id
            );
        }

        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('les categories');


    }
    /**
     * @Route("/affichertablecategorie", name="les categories")
     */

    public function afiichage()
    {
        $categorie = $this->getDoctrine()->getRepository('App\Entity\Categorie')->findAll();

        return $this->render('categorie/categorie.html.twig', ['categorie' => $categorie ,
        ]);

    }
    /**
     * @Route("/modifiercategorie/{id}", name="modifiercategorie")
     */
    public function modifier1(Request $request, $id, FlashyNotifier $flashy): response
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('App\Entity\Categorie')->find($id);


        if (!$categorie) {
            throw $this->createNotFoundException(
                'There are no formation with the following id: ' . $id
            );
        }

        $form = $this->createForm(ModifiercategorieType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $flashy->success('votre categorie est modifié avec succès !' );

            return $this->redirectToRoute('les categories');


        }

        return $this->render(
            'categorie/modifiercategorie.html.twig',
            array('form' => $form->createView())
        );
    }
}

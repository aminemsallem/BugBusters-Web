<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\AjouterCommentaireType;
use App\Form\ModifiercommentaireType;
use App\Form\ModifierevenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    /**
     * @Route("/ajoutercommentaire/{id}", name="commentaire")
     */
    public function ajoutercommantaire(request $request,EvenementRepository $repository,$id,FlashyNotifier $flashy)
    {
        $evenement = $repository->find($id);
        $comment=new Commentaire();
        $form=$this->createForm(AjouterCommentaireType::class,$comment);


        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $comment->setDate(new \DateTime());
            $comment->setIdevenement($evenement);

            $em=$this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            $flashy->success('votre commentaire est ajouté avec succès !' );

            return $this->redirect('/ajoutercommentaire/'.$id);
        }



        //return $this->redirectToRoute('les_formateurs'); //route de de la template de l'affichage pour faire un lien avec ajouter



        return $this->render('commentaire/ajoutercommentaire.html.twig', [
            'evenement' => $evenement,
            'comment'=>$form->createView(),

        ]);




    }


}

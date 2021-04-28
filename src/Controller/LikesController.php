<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Publicite;
use App\Form\LikesType;
use App\Repository\LikesRepository;
use App\Repository\PubliciteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/likes")
 */
class LikesController extends AbstractController
{
    /**
     * @Route("/", name="likes_index", methods={"GET"})
     */
    public function index(LikesRepository $likesRepository): Response
    {
        return $this->render('likes/index.html.twig', [
            'likes' => $likesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="likes_new", methods={"GET","POST"})
     */
    public function new(Request $request , Publicite $publicite , PubliciteRepository $publiciteRepository): Response
    {
        $like = new Likes();

            $like->setUserid("1");
            $like->setEtat("1");
            $like->getPubfk($publicite);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($like);
            $entityManager->flush();

        return $this->render('publicite/index.html.twig', [
            'publicites' => $publiciteRepository->findAll(),
        ]);

    }
    /**
     * @Route("/{id}/newd", name="dislikes_new", methods={"GET","POST"})
     */
    public function newdis(Request $request , Publicite $publicite , PubliciteRepository $publiciteRepository): Response
    {
        $like = new Likes();

        $like->setUserid("1");
        $like->setEtat("-1");
        $like->getPubfk($publicite);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();

        return $this->render('publicite/index.html.twig', [
            'publicites' => $publiciteRepository->findAll(),
        ]);

    }

    /**
     * @Route("/{id}", name="likes_show", methods={"GET"})
     */
    public function show(Likes $like): Response
    {
        return $this->render('likes/show.html.twig', [
            'like' => $like,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="likes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Likes $like): Response
    {
        $form = $this->createForm(LikesType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('likes_index');
        }

        return $this->render('likes/edit.html.twig', [
            'like' => $like,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/count", name="likes_count", methods={"GET"})
     */
    public function likecount(LikesRepository $likesRepository): Response
    {
        return $this->render('likes/index.html.twig', [
            'likes' => $likesRepository->findAll(),
        ]);
    }



    /**
     * @Route("/{id}", name="likes_delete", methods={"POST"})
     */
    public function delete(Request $request, Likes $like): Response
    {
        if ($this->isCsrfTokenValid('delete'.$like->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($like);
            $entityManager->flush();
        }

        return $this->redirectToRoute('likes_index');
    }
}

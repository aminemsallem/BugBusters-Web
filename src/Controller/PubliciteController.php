<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Publicite;
use App\Form\CommentType;
use App\Form\PubliciteType;
use App\Repository\CommentRepository;
use App\Repository\PubliciteRepository;
use App\Services\QrcodeService;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
/**
 * @Route("/publicite")
 */
class PubliciteController extends AbstractController
{
    /**
     * @Route("/", name="publicite_index", methods={"GET"})
     */
    public function indeçx(PubliciteRepository $publiciteRepository): Response
    {
        return $this->render('publicite/index.html.twig', [
            'publicites' => $publiciteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/imp", name="publicite_imp", methods={"GET"})
     */
    public function imp(PubliciteRepository $publiciteRepository): Response
    {

        return $this->render('publicite/imp.html.twig', [
            'publicites' => $publiciteRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="publicite_new", methods={"GET","POST"})
     */
    public function new(Request $request , FlashyNotifier $flashy): Response
    {
        $publicite = new Publicite();
        $publicite->setDate(date('Y-m-d'));
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicite);
            $entityManager->flush();

            $flashy->success('Publicite ajoute avec succee');
            return $this->redirectToRoute('publicite_index');
        }

        return $this->render('publicite/new.html.twig', [
            'publicite' => $publicite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicite_show", methods={"GET","POST"})
     */

    public function show(Publicite $publicite , Request $request , CommentRepository $commentRepository , QrcodeService $qrcodeService): Response
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $qrCode = $qrcodeService->qrcode($publicite);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPublicite($publicite);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('publicite/show.html.twig', [
            'comment' => $comment,
            'publicite' => $publicite,
            'form' => $form->createView(),
            'comments' => $commentRepository->findAll(),
            'qrCode' => $qrCode


        ]);

    }


    /**
     * @Route("/{id}/edit", name="publicite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publicite $publicite): Response
    {
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicite_index');
        }

        return $this->render('publicite/edit.html.twig', [
            'publicite' => $publicite,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/ajax_search", name="ajax_search", methods={"GET"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('p');
        var_dump($requestString);
        $posts =  $em->getRepository(Publicite::class)->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Not found  ";
        } else {
            var_dump($posts);
            //$result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getPubnom()];

        }
        return $realEntities;
    }







    /**
     * @Route("/{id}", name="publicite_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicite $publicite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publicite_index');
    }


}

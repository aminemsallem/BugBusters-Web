<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Evenement;
use App\Form\ModifierevenementType;
use App\Form\SearchForm;
use App\Repository\FormationRepository;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutEvenementType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }


    /**
     * @Route("/ajoutevenement", name="ajoutevenement")
     */
    public function createEvenement(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm(AjoutEvenementType::class, $evenement);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $file=$evenement->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $evenement = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $evenement->setImage($filename);

            $em->persist($evenement);
            $em->flush();

           return $this->redirectToRoute('showevenement' );

        }

        return $this->render(
            'evenement/ajoutevenement.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/showevenement", name="showevenement")
     */
    public function showEvenement()
    {
        $evenements = $this->getDoctrine()
            ->getRepository('App\Entity\Evenement')
            ->findAll();

        return $this->render(
            'evenement/show.html.twig',
            array('evenements' => $evenements)
        );
    }

    /**
     * @Route("/deleteevenement/{id}", name="deleteevenement")
     */
    public function deleteEvenement(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('App\Entity\Evenement')->find($id);

        if (!$evenement) {
            throw $this->createNotFoundException(
                'There are no evenement with the following id: ' . $id
            );
        }

        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute('showevenement');
    }

    /**
     * @Route("/updateevenement/{id}", name="updateevenement")
     */
    public function updateEvenement(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('App\Entity\Evenement')->find($id);

        if (!$evenement) {
            throw $this->createNotFoundException(
                'There are no articles with the following id: ' . $id
            );
        }

        $form = $this->createForm(ModifierevenementType::class, $evenement);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $file=$evenement->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            //$evenement = $form->getData();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $evenement->setImage($filename);

            $em->flush();
            return $this->redirectToRoute('showevenement');
        }

        return $this->render(
            'evenement/modifier.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/frontformation", name="frontformation")
     */

    public function afiichagefront(EvenementRepository $repository, Request $request)
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $formations = $repository->findSearch($data);

        foreach ($formations as $a ) {
            $data="".PHP_EOL;
            $data = $data . $a->getNom().PHP_EOL;
            $data = $data . $a->getPrix().PHP_EOL;

            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data('formation: '.$data)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->labelText('Scanner le ticket')
                ->labelFont(new NotoSans(20))
                ->labelAlignment(new LabelAlignmentCenter())
                ->build();
            header('Content-Type: '.$result->getMimeType());

            $result->saveToFile($this->getParameter('images_directory').'/'.$a->getId().$a->getNom().'.png');
        }



        return $this->render('formation/formationsfront.html.twig', [
            'formations' => $formations,
            'form' => $form->createView()

        ]);


    }


}

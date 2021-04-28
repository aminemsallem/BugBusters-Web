<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Evenement;
use App\Form\ModifierevenementType;
use App\Form\SearchForm;
use App\Repository\EvenementRepository;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AjoutEvenementType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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
    public function createEvenement(Request $request,FlashyNotifier $flashy)
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
            $flashy->success('votre evenement est ajouté avec succès !' );


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
    public function deleteEvenement(int $id, FlashyNotifier $flashy): Response
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
        $flashy->success('votre evenement est supprimé avec succès !' );


        return $this->redirectToRoute('showevenement');
    }

    /**
     * @Route("/updateevenement/{id}", name="updateevenement")
     */
    public function updateEvenement(Request $request, $id,FlashyNotifier $flashy)
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
            $file=$evenement->GetImage();
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
            $flashy->success('votre evenement est modifié avec succès !' );
            return $this->redirectToRoute('showevenement');
        }

        return $this->render(
            'evenement/modifier.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/AfficherEvenementFront", name="AfficherEvenementFront")
     */
    public function AfficherEvenementFront(EvenementRepository $repository, Request $request)
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $evenement = $repository->findSearch($data);

        foreach ($evenement as $a ) {
            $data = "" . PHP_EOL;
            $data = $data . $a->getNom() . PHP_EOL;
            $data = $data . $a->getNbrParticipant() . PHP_EOL;


            //$writer = new PngWriter();

            $qrCode = $result =Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data('L"evenement: '.$data)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                //->ForegroundColor(new Color(0, 0, 0))
                //->BackgroundColor(new Color(255, 255, 255))
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->labelText('Scanner le ticket')
                ->labelFont(new NotoSans(20))
                ->labelAlignment(new LabelAlignmentCenter())
                ->build();
            header('Content-Type: '.$result->getMimeType());

            // Create generic logo
            //$logo = Logo::create($this->getParameter('images_directory').'/')

            //$logo = Logo::create(__DIR__.'/assets/symfony.png')
             //   ->setResizeToWidth(50);

            // Create generic label
           // $label = Label::create('hiiii')
              //  ->setTextColor(new Color(255, 0, 0))

           $result->saveToFile($this->getParameter('images_directory').'/'.$a->getId().$a->getNom().'.png');
           // $response = new QrCodeResponse($result);
            //$result = $writer->write($qrCode, $logo, $label);

        }



        return $this->render('evenement/afficherFront.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView()

        ]);

//        $evenement = $repository->findAll();
//        return $this->render('evenement/afficherFront.html.twig', [
//            'evenement' => $evenement
//        ]);
    }

    /**
     * @Route("/searchevenement ", name="searchevenement")
     */
    public function searchEvenement(Request $request, EvenementRepository $repository, NormalizerInterface $Normalizer)
    {

        $requestString = $request->get('searchValue');
        if(strlen($requestString)==0)
        {
            $evenement = $repository->findAll();
        }
        else
        {
            $evenement = $repository->findEvenementByid($requestString);
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($evenement, 'json',[
            'ignored_attributes' => [''],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);


        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;

    }



}

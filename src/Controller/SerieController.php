<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/serie", name="serie_list")
     */
    public function list()
    {
        //@todo : recuperer les series en bdd

        $repo = $this->getDoctrine()->getRepository(Serie::class);
        $series = $repo->findGoodSeries();

        return $this->render('serie/list.html.twig', [
            "series" => $series,
        ]);
    }

    /**
     * @Route("/serie/{id}", name="serie_detail"
     *          ,requirements={"id": "\d+"},
     *          methods={"GET"})
     */
    public function detail($id, Request $request)
    {
        //@todo : recuperer la serie en bdd

        $repo = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repo->findOneById($id);

        if (empty ($serie))
        {
            throw $this->createNotFoundException("This serie do not exists!");
        }

        return $this->render('serie/detail.html.twig',[
            'serie' => $serie,
        ]);
    }

    /**
     * @Route("/serie/add", name="serie_add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        //@todo : traiter le formulaire
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());
        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);

        if($serieForm->isSubmitted() && $serieForm->isValid()) {
           $em->persist($serie);
           $em->flush();
           $this->addFlash('success', 'This serie was added !');
           return $this->redirectToRoute('serie_detail',[
               'id' => $serie->getId()
           ]);
        }
        return $this->render('serie/add.html.twig', [
            'serieForm' => $serieForm->createView()
        ]);
    }

    /**
     * @Route("/serie/delete/{id}", name="serie_delete", requirements={"id":"\d+"})
     */
    public function delete($id, EntityManagerInterface $em)
    {
        $repo = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $repo->find($id);

        $em->remove($serie);
        $em->flush();

        $this->addFlash('success', "The serie as been deleted!");
        return $this->redirectToRoute('home');
    }
}

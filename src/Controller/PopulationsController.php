<?php

namespace App\Controller;

use App\Entity\TPopulations;
use App\Form\TPopulationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/populations")
 */
class PopulationsController extends AbstractController
{
    /**
     * @Route("/", name="app_populations_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tPopulations = $entityManager
            ->getRepository(TPopulations::class)
            ->findAll();

        return $this->render('populations/index.html.twig', [
            't_populations' => $tPopulations,
        ]);
    }

    /**
     * @Route("/new", name="app_populations_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tPopulation = new TPopulations();
        $form = $this->createForm(TPopulationsType::class, $tPopulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tPopulation);
            $entityManager->flush();

            return $this->redirectToRoute('app_populations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('populations/new.html.twig', [
            't_population' => $tPopulation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_populations_show", methods={"GET"})
     */
    public function show(TPopulations $tPopulation): Response
    {
        return $this->render('populations/show.html.twig', [
            't_population' => $tPopulation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_populations_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TPopulations $tPopulation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TPopulationsType::class, $tPopulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_populations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('populations/edit.html.twig', [
            't_population' => $tPopulation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_populations_delete", methods={"POST"})
     */
    public function delete(Request $request, TPopulations $tPopulation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tPopulation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tPopulation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_populations_index', [], Response::HTTP_SEE_OTHER);
    }
}

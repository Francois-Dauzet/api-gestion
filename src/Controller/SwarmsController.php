<?php

namespace App\Controller;

use App\Entity\TSwarms;
use App\Form\TSwarmsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/swarms")
 */
class SwarmsController extends AbstractController
{
    /**
     * @Route("/", name="app_swarms_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tSwarms = $entityManager
            ->getRepository(TSwarms::class)
            ->findAll();

        return $this->render('swarms/index.html.twig', [
            't_swarms' => $tSwarms,
        ]);
    }

    /**
     * @Route("/new", name="app_swarms_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tSwarm = new TSwarms();
        $form = $this->createForm(TSwarmsType::class, $tSwarm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tSwarm);
            $entityManager->flush();

            return $this->redirectToRoute('app_swarms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('swarms/new.html.twig', [
            't_swarm' => $tSwarm,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_swarms_show", methods={"GET"})
     */
    public function show(TSwarms $tSwarm): Response
    {
        return $this->render('swarms/show.html.twig', [
            't_swarm' => $tSwarm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_swarms_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TSwarms $tSwarm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TSwarmsType::class, $tSwarm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_swarms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('swarms/edit.html.twig', [
            't_swarm' => $tSwarm,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_swarms_delete", methods={"POST"})
     */
    public function delete(Request $request, TSwarms $tSwarm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tSwarm->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tSwarm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_swarms_index', [], Response::HTTP_SEE_OTHER);
    }
}

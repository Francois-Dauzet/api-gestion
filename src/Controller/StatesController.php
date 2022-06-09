<?php

namespace App\Controller;

use App\Entity\TStates;
use App\Form\TStatesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/states")
 */
class StatesController extends AbstractController
{
    /**
     * @Route("/", name="app_states_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tStates = $entityManager
            ->getRepository(TStates::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('states/index.html.twig', [
            't_states' => $tStates,
        ]);
    }

    /**
     * @Route("/new", name="app_states_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tState = new TStates();
        $form = $this->createForm(TStatesType::class, $tState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tState->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tState);
            $entityManager->flush();

            return $this->redirectToRoute('app_states_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('states/new.html.twig', [
            't_state' => $tState,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_states_show", methods={"GET"})
     */
    public function show(TStates $tState): Response
    {
        return $this->render('states/show.html.twig', [
            't_state' => $tState,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_states_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TStates $tState, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TStatesType::class, $tState);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_states_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('states/edit.html.twig', [
            't_state' => $tState,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_states_delete", methods={"POST"})
     */
    public function delete(Request $request, TStates $tState, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tState->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tState);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_states_index', [], Response::HTTP_SEE_OTHER);
    }
}

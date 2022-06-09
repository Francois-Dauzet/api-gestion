<?php

namespace App\Controller;

use App\Entity\TNotes;
use App\Form\TNotesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hives/notes")
 */
class HivesNotesController extends AbstractController
{
    /**
     * @Route("/", name="app_hives_notes_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tNotes = $entityManager
            ->getRepository(TNotes::class)
            ->findAll();

        return $this->render('hives_notes/index.html.twig', [
            't_notes' => $tNotes,
        ]);
    }

    /**
     * @Route("/new", name="app_hives_notes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tNote = new TNotes();
        $form = $this->createForm(TNotesType::class, $tNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tNote);
            $entityManager->flush();

            return $this->redirectToRoute('app_hives_notes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hives_notes/new.html.twig', [
            't_note' => $tNote,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_hives_notes_show", methods={"GET"})
     */
    public function show(TNotes $tNote): Response
    {
        return $this->render('hives_notes/show.html.twig', [
            't_note' => $tNote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_hives_notes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TNotes $tNote, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TNotesType::class, $tNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hives_notes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hives_notes/edit.html.twig', [
            't_note' => $tNote,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_hives_notes_delete", methods={"POST"})
     */
    public function delete(Request $request, TNotes $tNote, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tNote->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tNote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hives_notes_index', [], Response::HTTP_SEE_OTHER);
    }
}

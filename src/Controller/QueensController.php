<?php

namespace App\Controller;

use App\Entity\TQueens;
use App\Form\TQueensType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/queens")
 */
class QueensController extends AbstractController
{
    /**
     * @Route("/", name="app_queens_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tQueens = $entityManager
            ->getRepository(TQueens::class)
            ->findAll();

        return $this->render('queens/index.html.twig', [
            't_queens' => $tQueens,
        ]);
    }

    /**
     * @Route("/new", name="app_queens_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tQueen = new TQueens();
        $form = $this->createForm(TQueensType::class, $tQueen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tQueen);
            $entityManager->flush();

            return $this->redirectToRoute('app_queens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('queens/new.html.twig', [
            't_queen' => $tQueen,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_queens_show", methods={"GET"})
     */
    public function show(TQueens $tQueen): Response
    {
        return $this->render('queens/show.html.twig', [
            't_queen' => $tQueen,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_queens_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TQueens $tQueen, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TQueensType::class, $tQueen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_queens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('queens/edit.html.twig', [
            't_queen' => $tQueen,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_queens_delete", methods={"POST"})
     */
    public function delete(Request $request, TQueens $tQueen, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tQueen->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tQueen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_queens_index', [], Response::HTTP_SEE_OTHER);
    }
}

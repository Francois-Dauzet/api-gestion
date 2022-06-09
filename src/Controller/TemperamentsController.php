<?php

namespace App\Controller;

use App\Entity\TTemperaments;
use App\Form\TTemperamentsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/temperaments")
 */
class TemperamentsController extends AbstractController
{
    /**
     * @Route("/", name="app_temperaments_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tTemperaments = $entityManager
            ->getRepository(TTemperaments::class)
            ->findAll();

        return $this->render('temperaments/index.html.twig', [
            't_temperaments' => $tTemperaments,
        ]);
    }

    /**
     * @Route("/new", name="app_temperaments_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tTemperament = new TTemperaments();
        $form = $this->createForm(TTemperamentsType::class, $tTemperament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tTemperament);
            $entityManager->flush();

            return $this->redirectToRoute('app_temperaments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('temperaments/new.html.twig', [
            't_temperament' => $tTemperament,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_temperaments_show", methods={"GET"})
     */
    public function show(TTemperaments $tTemperament): Response
    {
        return $this->render('temperaments/show.html.twig', [
            't_temperament' => $tTemperament,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_temperaments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TTemperaments $tTemperament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TTemperamentsType::class, $tTemperament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_temperaments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('temperaments/edit.html.twig', [
            't_temperament' => $tTemperament,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_temperaments_delete", methods={"POST"})
     */
    public function delete(Request $request, TTemperaments $tTemperament, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tTemperament->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tTemperament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_temperaments_index', [], Response::HTTP_SEE_OTHER);
    }
}

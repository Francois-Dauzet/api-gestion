<?php

namespace App\Controller;

use App\Entity\TBreeds;
use App\Form\TBreedsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/breeds")
 */
class BreedsController extends AbstractController
{
    /**
     * @Route("/", name="app_breeds_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tBreeds = $entityManager
            ->getRepository(TBreeds::class)
            ->findAll();

        return $this->render('breeds/index.html.twig', [
            't_breeds' => $tBreeds,
        ]);
    }

    /**
     * @Route("/new", name="app_breeds_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tBreed = new TBreeds();
        $form = $this->createForm(TBreedsType::class, $tBreed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tBreed);
            $entityManager->flush();

            return $this->redirectToRoute('app_breeds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('breeds/new.html.twig', [
            't_breed' => $tBreed,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_breeds_show", methods={"GET"})
     */
    public function show(TBreeds $tBreed): Response
    {
        return $this->render('breeds/show.html.twig', [
            't_breed' => $tBreed,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_breeds_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TBreeds $tBreed, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TBreedsType::class, $tBreed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_breeds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('breeds/edit.html.twig', [
            't_breed' => $tBreed,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_breeds_delete", methods={"POST"})
     */
    public function delete(Request $request, TBreeds $tBreed, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tBreed->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tBreed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_breeds_index', [], Response::HTTP_SEE_OTHER);
    }
}

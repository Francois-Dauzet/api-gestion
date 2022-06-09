<?php

namespace App\Controller;

use App\Entity\TDiseases;
use App\Form\TDiseasesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/diseases")
 */
class DiseasesController extends AbstractController
{
    /**
     * @Route("/", name="app_diseases_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tDiseases = $entityManager
            ->getRepository(TDiseases::class)
            ->findAll();

        return $this->render('diseases/index.html.twig', [
            't_diseases' => $tDiseases,
        ]);
    }

    /**
     * @Route("/new", name="app_diseases_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tDisease = new TDiseases();
        $form = $this->createForm(TDiseasesType::class, $tDisease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tDisease);
            $entityManager->flush();

            return $this->redirectToRoute('app_diseases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diseases/new.html.twig', [
            't_disease' => $tDisease,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_diseases_show", methods={"GET"})
     */
    public function show(TDiseases $tDisease): Response
    {
        return $this->render('diseases/show.html.twig', [
            't_disease' => $tDisease,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_diseases_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TDiseases $tDisease, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TDiseasesType::class, $tDisease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_diseases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diseases/edit.html.twig', [
            't_disease' => $tDisease,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_diseases_delete", methods={"POST"})
     */
    public function delete(Request $request, TDiseases $tDisease, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tDisease->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tDisease);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_diseases_index', [], Response::HTTP_SEE_OTHER);
    }
}

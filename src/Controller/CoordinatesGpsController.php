<?php

namespace App\Controller;

use App\Entity\TCoordinatesGps;
use App\Form\TCoordinatesGpsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coordinates/gps")
 */
class CoordinatesGpsController extends AbstractController
{
    /**
     * @Route("/", name="app_coordinates_gps_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tCoordinatesGps = $entityManager
            ->getRepository(TCoordinatesGps::class)
            ->findAll();

        return $this->render('coordinates_gps/index.html.twig', [
            't_coordinates_gps' => $tCoordinatesGps,
        ]);
    }

    /**
     * @Route("/new", name="app_coordinates_gps_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tCoordinatesGp = new TCoordinatesGps();
        $form = $this->createForm(TCoordinatesGpsType::class, $tCoordinatesGp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tCoordinatesGp);
            $entityManager->flush();

            return $this->redirectToRoute('app_coordinates_gps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coordinates_gps/new.html.twig', [
            't_coordinates_gp' => $tCoordinatesGp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_coordinates_gps_show", methods={"GET"})
     */
    public function show(TCoordinatesGps $tCoordinatesGp): Response
    {
        return $this->render('coordinates_gps/show.html.twig', [
            't_coordinates_gp' => $tCoordinatesGp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_coordinates_gps_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TCoordinatesGps $tCoordinatesGp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TCoordinatesGpsType::class, $tCoordinatesGp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_coordinates_gps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coordinates_gps/edit.html.twig', [
            't_coordinates_gp' => $tCoordinatesGp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_coordinates_gps_delete", methods={"POST"})
     */
    public function delete(Request $request, TCoordinatesGps $tCoordinatesGp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tCoordinatesGp->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tCoordinatesGp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_coordinates_gps_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\TMateriels;
use App\Form\TMaterielsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/materials")
 */
class MaterialsController extends AbstractController
{
    /**
     * @Route("/", name="app_materials_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tMateriels = $entityManager
            ->getRepository(TMateriels::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('materials/index.html.twig', [
            't_materiels' => $tMateriels,
        ]);
    }

    /**
     * @Route("/new", name="app_materials_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tMateriel = new TMateriels();
        $form = $this->createForm(TMaterielsType::class, $tMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tMateriel->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tMateriel);
            $entityManager->flush();

            return $this->redirectToRoute('app_materials_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materials/new.html.twig', [
            't_materiel' => $tMateriel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_materials_show", methods={"GET"})
     */
    public function show(TMateriels $tMateriel): Response
    {
        return $this->render('materials/show.html.twig', [
            't_materiel' => $tMateriel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_materials_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TMateriels $tMateriel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TMaterielsType::class, $tMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_materials_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materials/edit.html.twig', [
            't_materiel' => $tMateriel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_materials_delete", methods={"POST"})
     */
    public function delete(Request $request, TMateriels $tMateriel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tMateriel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tMateriel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_materials_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\TTypes;
use App\Form\TTypesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/types")
 */
class TypesController extends AbstractController
{
    /**
     * @Route("/", name="app_types_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tTypes = $entityManager
            ->getRepository(TTypes::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('types/index.html.twig', [
            't_types' => $tTypes,
        ]);
    }

    /**
     * @Route("/new", name="app_types_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tType = new TTypes();
        $form = $this->createForm(TTypesType::class, $tType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tType->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tType);
            $entityManager->flush();

            return $this->redirectToRoute('app_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types/new.html.twig', [
            't_type' => $tType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_types_show", methods={"GET"})
     */
    public function show(TTypes $tType): Response
    {
        return $this->render('types/show.html.twig', [
            't_type' => $tType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_types_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TTypes $tType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TTypesType::class, $tType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types/edit.html.twig', [
            't_type' => $tType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_types_delete", methods={"POST"})
     */
    public function delete(Request $request, TTypes $tType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_types_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\THives;
use App\Form\THivesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/hives")
 */
class HivesController extends AbstractController
{
    /**
     * @Route("/", name="app_hives_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tHives = $entityManager
            ->getRepository(THives::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('hives/index.html.twig', [
            't_hives' => $tHives,
        ]);
    }

    /**
     * @Route("/new", name="app_hives_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tHive = new THives();
        $form = $this->createForm(THivesType::class, $tHive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tHive->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tHive);
            $entityManager->flush();

            return $this->redirectToRoute('app_hives_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hives/new.html.twig', [
            't_hive' => $tHive,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_hives_show", methods={"GET"})
     */
    public function show(THives $tHive): Response
    {
        return $this->render('hives/show.html.twig', [
            't_hive' => $tHive,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_hives_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, THives $tHive, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(THivesType::class, $tHive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hives_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hives/edit.html.twig', [
            't_hive' => $tHive,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_hives_delete", methods={"POST"})
     */
    public function delete(Request $request, THives $tHive, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tHive->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tHive);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hives_index', [], Response::HTTP_SEE_OTHER);
    }
}

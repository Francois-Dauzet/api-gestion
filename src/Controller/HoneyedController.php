<?php

namespace App\Controller;

use App\Entity\THoneyed;
use App\Form\THoneyedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/honeyed")
 */
class HoneyedController extends AbstractController
{
    /**
     * @Route("/", name="app_honeyed_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tHoneyeds = $entityManager
            ->getRepository(THoneyed::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('honeyed/index.html.twig', [
            't_honeyeds' => $tHoneyeds,
        ]);
    }

    /**
     * @Route("/new", name="app_honeyed_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tHoneyed = new THoneyed();
        $form = $this->createForm(THoneyedType::class, $tHoneyed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tHoneyed->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tHoneyed);
            $entityManager->flush();

            return $this->redirectToRoute('app_honeyed_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('honeyed/new.html.twig', [
            't_honeyed' => $tHoneyed,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_honeyed_show", methods={"GET"})
     */
    public function show(THoneyed $tHoneyed): Response
    {
        return $this->render('honeyed/show.html.twig', [
            't_honeyed' => $tHoneyed,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_honeyed_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, THoneyed $tHoneyed, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(THoneyedType::class, $tHoneyed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_honeyed_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('honeyed/edit.html.twig', [
            't_honeyed' => $tHoneyed,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_honeyed_delete", methods={"POST"})
     */
    public function delete(Request $request, THoneyed $tHoneyed, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tHoneyed->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tHoneyed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_honeyed_index', [], Response::HTTP_SEE_OTHER);
    }
}

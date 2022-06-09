<?php

namespace App\Controller;

use App\Entity\TFormats;
use App\Form\TFormatsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formats")
 */
class FormatsController extends AbstractController
{
    /**
     * @Route("/", name="app_formats_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tFormats = $entityManager
            ->getRepository(TFormats::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('formats/index.html.twig', [
            't_formats' => $tFormats,
        ]);
    }

    /**
     * @Route("/new", name="app_formats_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tFormat = new TFormats();
        $form = $this->createForm(TFormatsType::class, $tFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tFormat->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tFormat);
            $entityManager->flush();

            return $this->redirectToRoute('app_formats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formats/new.html.twig', [
            't_format' => $tFormat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_formats_show", methods={"GET"})
     */
    public function show(TFormats $tFormat): Response
    {
        return $this->render('formats/show.html.twig', [
            't_format' => $tFormat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_formats_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TFormats $tFormat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TFormatsType::class, $tFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formats/edit.html.twig', [
            't_format' => $tFormat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_formats_delete", methods={"POST"})
     */
    public function delete(Request $request, TFormats $tFormat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tFormat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tFormat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formats_index', [], Response::HTTP_SEE_OTHER);
    }
}

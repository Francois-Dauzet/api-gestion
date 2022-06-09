<?php

namespace App\Controller;

use App\Entity\TApiaries;
use App\Form\TApiariesType;
use App\Entity\TUserAccount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user/apiaries")
 */
class ApiariesController extends AbstractController
{
    /**
     * @Route("/", name="app_apiaries_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $tApiaries = $entityManager
            ->getRepository(TApiaries::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('apiaries/index.html.twig', [
            't_apiaries' => $tApiaries,
        ]);
    }

    /**
     * @Route("/new", name="app_apiaries_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tApiary = new TApiaries();
        $form = $this->createForm(TApiariesType::class, $tApiary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tApiary->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tApiary);
            $entityManager->flush();

            return $this->redirectToRoute('app_apiaries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apiaries/new.html.twig', [
            't_apiary' => $tApiary,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_apiaries_show", methods={"GET"})
     */
    public function show(TApiaries $tApiary): Response
    {
        return $this->render('apiaries/show.html.twig', [
            't_apiary' => $tApiary,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_apiaries_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TApiaries $tApiary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TApiariesType::class, $tApiary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_apiaries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apiaries/edit.html.twig', [
            't_apiary' => $tApiary,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_apiaries_delete", methods={"POST"})
     */
    public function delete(Request $request, TApiaries $tApiary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tApiary->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tApiary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_apiaries_index', [], Response::HTTP_SEE_OTHER);
    }
}

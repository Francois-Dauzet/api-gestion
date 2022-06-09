<?php

namespace App\Controller;

use App\Entity\TCategories;
use App\Form\TCategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categories")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="app_categories_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tCategories = $entityManager
            ->getRepository(TCategories::class)
            ->findBy([
                "fkUser" => $this->getUser() /// Récupère l'utilisateur connecter
            ]);

        return $this->render('categories/index.html.twig', [
            't_categories' => $tCategories,
        ]);
    }

    /**
     * @Route("/new", name="app_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tCategory = new TCategories();
        $form = $this->createForm(TCategoriesType::class, $tCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tCategory->setFkUser($this->getUser()); /// Récupère l'id de l'utilisateur en cours

            $entityManager->persist($tCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/new.html.twig', [
            't_category' => $tCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_categories_show", methods={"GET"})
     */
    public function show(TCategories $tCategory): Response
    {
        return $this->render('categories/show.html.twig', [
            't_category' => $tCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TCategories $tCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TCategoriesType::class, $tCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/edit.html.twig', [
            't_category' => $tCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, TCategories $tCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}

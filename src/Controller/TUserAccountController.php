<?php

namespace App\Controller;

use App\Entity\TUserAccount;
use App\Entity\TUserInfoPhone;
use App\Form\TUserAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/dashboard")
 */
class TUserAccountController extends AbstractController
{
    /**
     * @Route("/", name="app_t_user_account_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tUserAccounts = $entityManager
            ->getRepository(TUserAccount::class)
            ->findAll();
        /// Rendu du fichier twig
        return $this->render('t_user_account/index.html.twig', [
            't_user_accounts' => $tUserAccounts, /// Stockage dans un tableau associatif
        ]);
    }

    /**
     * @Route("/new", name="app_t_user_account_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tUserAccount = new TUserAccount();
        $form = $this->createForm(TUserAccountType::class, $tUserAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tUserAccount);
            $entityManager->flush();

            return $this->redirectToRoute('app_t_user_account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('t_user_account/new.html.twig', [
            't_user_account' => $tUserAccount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_t_user_account_show", methods={"GET"})
     */
    public function show(TUserAccount $tUserAccount): Response
    {
        return $this->render('t_user_account/show.html.twig', [
            't_user_account' => $tUserAccount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_t_user_account_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TUserAccount $tUserAccount, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TUserAccountType::class, $tUserAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_t_user_account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('t_user_account/edit.html.twig', [
            't_user_account' => $tUserAccount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_t_user_account_delete", methods={"POST"})
     */
    public function delete(Request $request, TUserAccount $tUserAccount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tUserAccount->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tUserAccount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_t_user_account_index', [], Response::HTTP_SEE_OTHER);
    }
}

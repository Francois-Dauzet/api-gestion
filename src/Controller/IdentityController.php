<?php

namespace App\Controller;

use App\Entity\TUsersInfoIdentity;
use App\Form\TUsersInfoIdentityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/identity")
 */
class IdentityController extends AbstractController
{
    /**
     * @Route("/", name="app_identity_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser(); /// Récupère l'utilisateur connecter

        $tUsersInfoIdentity = $entityManager
            ->getRepository(TUsersInfoIdentity::class)
            ->find($user->getId()); /// Récupère l'id de l'utilisateur connecter

        return $this->render('identity/index.html.twig', [
            't_users_info_identity' => $tUsersInfoIdentity,
        ]);
    }

    /**
     * @Route("/new", name="app_identity_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tUsersInfoIdentity = new TUsersInfoIdentity();
        $form = $this->createForm(TUsersInfoIdentityType::class, $tUsersInfoIdentity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tUsersInfoIdentity->setUserIdIdentityAccount($this->getUser()); /// Récupère l'id de l'utilisateur connecter

            $entityManager->persist($tUsersInfoIdentity);
            $entityManager->flush();

            return $this->redirectToRoute('app_identity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('identity/new.html.twig', [
            't_users_info_identity' => $tUsersInfoIdentity,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdIdentityAccount}", name="app_identity_show", methods={"GET"})
     */
    public function show(TUsersInfoIdentity $tUsersInfoIdentity): Response
    {
        return $this->render('identity/show.html.twig', [
            't_users_info_identity' => $tUsersInfoIdentity,
        ]);
    }

    /**
     * @Route("/{userIdIdentityAccount}/edit", name="app_identity_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TUsersInfoIdentity $tUsersInfoIdentity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TUsersInfoIdentityType::class, $tUsersInfoIdentity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_identity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('identity/edit.html.twig', [
            't_users_info_identity' => $tUsersInfoIdentity,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdIdentityAccount}", name="app_identity_delete", methods={"POST"})
     */
    public function delete(Request $request, TUsersInfoIdentity $tUsersInfoIdentity, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tUsersInfoIdentity->getUserIdIdentityAccount(), $request->request->get('_token'))) {
            $entityManager->remove($tUsersInfoIdentity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_identity_index', [], Response::HTTP_SEE_OTHER);
    }
}

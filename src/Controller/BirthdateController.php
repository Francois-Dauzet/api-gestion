<?php

namespace App\Controller;

use App\Entity\TUserInfoBirthdate;
use App\Form\TUserInfoBirthdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/birthdate")
 */
class BirthdateController extends AbstractController
{
    /**
     * @Route("/", name="app_birthdate_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser(); /// Récupère l'utilisateur connecter

        $tUserInfoBirthdate = $entityManager

            ->getRepository(TUserInfoBirthdate::class)
            ->find($user->getId()); /// Récupère l'id de l'utilisateur connecter
        // dump($tUserInfoBirthdate); /// Vérification des données

        return $this->render('birthdate/index.html.twig', [
            't_user_info_birthdate' => $tUserInfoBirthdate,
        ]);
    }

    /**
     * @Route("/new", name="app_birthdate_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tUserInfoBirthdate = new TUserInfoBirthdate();
        $form = $this->createForm(TUserInfoBirthdateType::class, $tUserInfoBirthdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tUserInfoBirthdate->setUserIdBirthdateAccount($this->getUser()); /// Récupère l'id de l'utilisateur connecter

            $entityManager->persist($tUserInfoBirthdate);
            $entityManager->flush();

            return $this->redirectToRoute('app_birthdate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('birthdate/new.html.twig', [
            't_user_info_birthdate' => $tUserInfoBirthdate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdBirthdateAccount}", name="app_birthdate_show", methods={"GET"})
     */
    public function show(TUserInfoBirthdate $tUserInfoBirthdate): Response
    {
        return $this->render('birthdate/show.html.twig', [
            't_user_info_birthdate' => $tUserInfoBirthdate,
        ]);
    }

    /**
     * @Route("/{userIdBirthdateAccount}/edit", name="app_birthdate_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TUserInfoBirthdate $tUserInfoBirthdate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TUserInfoBirthdateType::class, $tUserInfoBirthdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_birthdate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('birthdate/edit.html.twig', [
            't_user_info_birthdate' => $tUserInfoBirthdate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdBirthdateAccount}", name="app_birthdate_delete", methods={"POST"})
     */
    public function delete(Request $request, TUserInfoBirthdate $tUserInfoBirthdate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tUserInfoBirthdate->getUserIdBirthdateAccount(), $request->request->get('_token'))) {
            $entityManager->remove($tUserInfoBirthdate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_birthdate_index', [], Response::HTTP_SEE_OTHER);
    }
}

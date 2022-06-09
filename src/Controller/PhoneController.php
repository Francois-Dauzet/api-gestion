<?php

namespace App\Controller;

use App\Entity\TUserAccount;
use App\Entity\TUserInfoPhone;
use App\Form\TUserInfoPhoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/phone")
 */
class PhoneController extends AbstractController
{
    /**
     * @Route("/", name="app_phone_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser(); /// Récupère l'utilisateur connecter

        $tUserInfoPhone = $entityManager

            ->getRepository(TUserInfoPhone::class)
            ->find($user->getId()); /// Récupère l'id de l'utilisateur connecter
        // dump($tUserInfoPhone); /// Vérification des données

        return $this->render('phone/index.html.twig', [
            't_user_info_phone' => $tUserInfoPhone,
        ]);
    }

    /**
     * @Route("/new", name="app_phone_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tUserInfoPhone = new TUserInfoPhone();

        $form = $this->createForm(TUserInfoPhoneType::class, $tUserInfoPhone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tUserInfoPhone->setUserIdPhoneAccount($this->getUser()); /// Récupère l'id de l'utilisateur connecter

            $entityManager->persist($tUserInfoPhone);
            $entityManager->flush();

            return $this->redirectToRoute('app_phone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phone/new.html.twig', [
            't_user_info_phone' => $tUserInfoPhone,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdPhoneAccount}", name="app_phone_show", methods={"GET"})
     */
    public function show(TUserInfoPhone $tUserInfoPhone): Response
    {

        return $this->render('phone/show.html.twig', [
            't_user_info_phone' => $tUserInfoPhone,
        ]);
    }

    /**
     * @Route("/{userIdPhoneAccount}/edit", name="app_phone_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TUserInfoPhone $tUserInfoPhone, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TUserInfoPhoneType::class, $tUserInfoPhone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->flush();

            return $this->redirectToRoute('app_phone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phone/edit.html.twig', [
            't_user_info_phone' => $tUserInfoPhone,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdPhoneAccount}", name="app_phone_delete", methods={"POST"})
     */
    public function delete(Request $request, TUserInfoPhone $tUserInfoPhone, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tUserInfoPhone->getUserIdPhoneAccount(), $request->request->get('_token'))) {
            $entityManager->remove($tUserInfoPhone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_phone_index', [], Response::HTTP_SEE_OTHER);
    }
}

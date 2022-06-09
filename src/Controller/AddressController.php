<?php

namespace App\Controller;

use App\Entity\TUsersInfoAddress;
use App\Form\TUsersInfoAddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/address")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="app_address_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); /// Récupère l'utilisateur connecter

        $tUsersInfoAddress = $entityManager
            ->getRepository(TUsersInfoAddress::class)
            ->find($user->getId()); /// Récupère l'id de l'utilisateur connecter

        return $this->render('address/index.html.twig', [
            't_users_info_address' => $tUsersInfoAddress,
        ]);
    }

    /**
     * @Route("/new", name="app_address_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tUsersInfoAddress = new TUsersInfoAddress();
        $form = $this->createForm(TUsersInfoAddressType::class, $tUsersInfoAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tUsersInfoAddress->setUserIdAddressAccount($this->getUser()); /// Récupère l'id de l'utilisateur connecter

            $entityManager->persist($tUsersInfoAddress);
            $entityManager->flush();

            return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/new.html.twig', [
            't_users_info_address' => $tUsersInfoAddress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdAddressAccount}", name="app_address_show", methods={"GET"})
     */
    public function show(TUsersInfoAddress $tUsersInfoAddress): Response
    {
        return $this->render('address/show.html.twig', [
            't_users_info_address' => $tUsersInfoAddress,
        ]);
    }

    /**
     * @Route("/{userIdAddressAccount}/edit", name="app_address_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TUsersInfoAddress $tUsersInfoAddress, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TUsersInfoAddressType::class, $tUsersInfoAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/edit.html.twig', [
            't_users_info_address' => $tUsersInfoAddress,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{userIdAddressAccount}", name="app_address_delete", methods={"POST"})
     */
    public function delete(Request $request, TUsersInfoAddress $tUsersInfoAddress, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tUsersInfoAddress->getUserIdAddressAccount(), $request->request->get('_token'))) {
            $entityManager->remove($tUsersInfoAddress);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
    }
}

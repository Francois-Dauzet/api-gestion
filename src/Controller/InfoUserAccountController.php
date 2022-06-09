<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoUserAccountController extends AbstractController
{
    /**
     * @Route("/user/info/account", name="app_user_info_account")
     */
    public function index(): Response
    {
        return $this->render('info_user_account/index.html.twig', [
            'controller_name' => 'InfoUserAccountController',
        ]);
    }
}

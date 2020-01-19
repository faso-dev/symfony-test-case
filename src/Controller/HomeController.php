<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/auth", name="app_auth")
     * @IsGranted("ROLE_USER")
     */
    public function auth()
    {
        return $this->render('home/auth.html.twig');
    }

    /**
     * @Route("/dashboard", name="app_auth_admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function dashboard()
    {
        return $this->render('home/admin.html.twig');
    }

    /**
     * @Route("/mail", name="app_mail")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function mail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello','Hello'))
            ->setFrom('noreply@faso-dev')
            ->setTo('admin@faso-dev');
        $mailer->send($message);
        return new Response('Envoie de mail');
    }
}

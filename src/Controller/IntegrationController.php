<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page", name="integration_")
 */
class IntegrationController extends AbstractController
{
    /**
     * @Route("/devbook", name="index")
     */
    public function index(): Response
    {
        return $this->render('integration/index.html.twig');
    }
}

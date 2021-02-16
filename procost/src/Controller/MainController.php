<?php

namespace App\Controller;

use App\Entity\Src\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use App\Repository\Src\Store\ProductRepository;
use App\Service\ContactMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct()
    {

    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        return $this->render('main/home.html.twig', []);
    }
}

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

class PlugController extends AbstractController
{
    public function __construct()
    {

    }

    /**
     * @Route("/project/plug/{id}", name="plug_project")
     * @param int $id
     * @return Response
     */
    public function plugProject(int $id): Response
    {
        return $this->render('plug/project.html.twig', []);
    }

    /**
     * @Route("/employ/plug/{id}", name="plug_employ")
     * @param int $id
     * @return Response
     */
    public function plugEmploy(int $id): Response
    {
        return $this->render('plug/employ.html.twig', []);
    }
}

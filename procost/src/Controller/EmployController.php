<?php

namespace App\Controller;

use App\Entity\Employ;
use App\Form\EmployType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("/employ", name="list_employ")
     */
    public function listEmploy(): Response
    {
        return $this->render('employ/list.html.twig', []);
    }

    /**
     * @Route("/employ/edit", name="create_employ",methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function createEmploy(Request $request): Response
    {
        $employ = new Employ();
        $form = $this->createForm(EmployType::class, $employ);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('list_employ');
        }
        return $this->render('employ/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employ/edit/{id}", name="modify_employ")
     */
    public function modifyEmploy(): Response
    {
        return $this->render('employ/edit.html.twig', []);
    }


    /**
     * @Route("/employ/show/{id}", name="show_employ")
     * @param int $id
     * @return Response
     */
    public function plugEmploy(int $id): Response
    {
        return $this->render('employ/show.html.twig', []);
    }
}

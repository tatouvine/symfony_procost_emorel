<?php

namespace App\Controller;

use App\Entity\Employ;
use App\Form\EmployType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EditingController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/project/edit", name="create_project")
     */
    public function createProject(): Response
    {
        return $this->render('edit/project.html.twig', []);
    }

    /**
     * @Route("/project/edit/{id}", name="modify_project")
     * @param int $id
     * @return Response
     */
    public function modifyProject(int $id): Response
    {
        return $this->render('edit/project.html.twig', []);
    }


    /**
     * @Route("/job/edit", name="create_job")
     */
    public function createJob(): Response
    {
        return $this->render('edit/job.html.twig', []);
    }

    /**
     * @Route("/job/edit/{id}", name="modify_job")
     */
    public function modifyJob(): Response
    {
        return $this->render('edit/job.html.twig', []);
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
            return $this->redirectToRoute('modify_employ');
        }
        return $this->render('edit/employ.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employ/edit/{id}", name="modify_employ")
     */
    public function modifyEmploy(): Response
    {
        return $this->render('edit/employ.html.twig', []);
    }
}

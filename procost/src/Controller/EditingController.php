<?php

namespace App\Controller;

use App\Entity\Employ;
use App\Entity\Job;
use App\Entity\Project;
use App\Form\EmployType;
use App\Form\JobType;
use App\Form\ProjectType;
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
     * @param Request $request
     * @return Response
     */
    public function createProject(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('list_project');
        }
        return $this->render('edit/project.html.twig', [
            'form' => $form->createView()
        ]);

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
     * @param Request $request
     * @return Response
     */
    public function createJob(Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('list_job');
        }
        return $this->render('edit/job.html.twig', [
            'form' => $form->createView()
        ]);
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
            return $this->redirectToRoute('list_employ');
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

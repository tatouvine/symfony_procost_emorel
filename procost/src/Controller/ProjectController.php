<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Src\Contact;
use App\Form\ContactType;
use App\Form\ProjectType;
use App\Manager\ContactManager;
use App\Repository\JobRepository;
use App\Repository\Src\Store\ProductRepository;
use App\Service\ContactMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private JobRepository $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * @Route("/project", name="list_project")
     */
    public function listProject(): Response
    {
        return $this->render('project/list.html.twig', []);
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
        return $this->render('project/edit.html.twig', [
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
        return $this->render('project/edit.html.twig', []);
    }


    /**
     * @Route("/project/show/{id}", name="plug_project")
     * @param int $id
     * @return Response
     */
    public function plugProject(int $id): Response
    {
        return $this->render('project/show.html.twig', []);
    }

}

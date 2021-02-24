<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\JobType;
use App\Form\ProjectType;
use App\Manager\ProjectManager;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private ProjectRepository $projectRepository;
    private ProjectManager $projectManager;

    public function __construct(ProjectRepository $projectRepository, ProjectManager $projectManager)
    {
        $this->projectRepository = $projectRepository;
        $this->projectManager = $projectManager;
    }

    /**
     * @Route("/project", name="list_project")
     */
    public function listProject(): Response
    {
        $projects = $this->projectRepository->findAll();
        return $this->render('project/list.html.twig', ['projects' => $projects]);
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
            $this->projectManager->save($project);
            $this->addFlash('success', 'Project is create');
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
    public function modifyProject(Request $request, int $id): Response
    {
        $project = $this->projectRepository->find($id);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectManager->update();
            $this->addFlash('success', 'Project is modify');
            return $this->redirectToRoute('list_project');
        }
        return $this->render('project/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/project/show/{id}", name="plug_project")
     * @param int $id
     * @return Response
     */
    public function plugProject(int $id): Response
    {
        $project = $this->projectRepository->find($id);
        return $this->render('project/show.html.twig', [
            'project' => $project
        ]);
    }

    /**
     * @Route("/project/push/{id}", name="push_project")
     * @param int $id
     * @return Response
     */
    public function pushProject(int $id): Response
    {
        $project = $this->projectRepository->find($id);
        $project->setDeliveyDate(new \DateTime());
        $this->projectManager->update();
        $this->addFlash('success', 'Project is delivey');
        return $this->redirectToRoute('list_project');
    }

}

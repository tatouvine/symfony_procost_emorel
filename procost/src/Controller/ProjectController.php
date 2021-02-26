<?php

namespace App\Controller;

use App\Entity\ManagementWorkingHours;
use App\Entity\Project;
use App\Form\AddTimeInProjectType;
use App\Form\ProjectType;
use App\Manager\AddTimeManager;
use App\Manager\ProjectManager;
use App\Repository\ManagementWorkingHoursRepository;
use App\Repository\ProjectRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private ProjectRepository $projectRepository;
    private ProjectManager $projectManager;
    private ManagementWorkingHoursRepository $managementWorkingHoursRepository;
    private AddTimeManager $addTimeManager;

    public function __construct(ProjectRepository $projectRepository,
                                ProjectManager $projectManager,
                                ManagementWorkingHoursRepository $managementWorkingHoursRepository,
                                AddTimeManager $addTimeManager)
    {
        $this->projectRepository = $projectRepository;
        $this->projectManager = $projectManager;
        $this->managementWorkingHoursRepository = $managementWorkingHoursRepository;
        $this->addTimeManager = $addTimeManager;
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
    public function showProject(Request $request, int $id): Response
    {
        $project = $this->projectRepository->find($id);
        $infoPersonneOnProejcts = $this->managementWorkingHoursRepository->findValuePersonByProject($id);
        $infoCostProject = $this->managementWorkingHoursRepository->findPersonneHaveWorkByProject($id);

        if ($project->getDeliveryDate() === null) {
            $addTime = new ManagementWorkingHours();
            $addTime->setProject($project);
            $form = $this->createForm(AddTimeInProjectType::class, $addTime);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addTimeManager->save($addTime);
                $this->addFlash('success', 'you have added an employee to the project');
                return $this->render('project/show.html.twig', [
                    'project' => $project,
                    'infoPersonneOnProejcts' => $infoPersonneOnProejcts,
                    'infoCostProject' => $infoCostProject,
                    'form' => $form->createView()
                ]);
            }


            return $this->render('project/show.html.twig', [
                'project' => $project,
                'infoPersonneOnProejcts' => $infoPersonneOnProejcts,
                'infoCostProject' => $infoCostProject,
                'form' => $form->createView()
            ]);
        } else {
            return $this->render('project/show.html.twig', [
                'project' => $project,
                'infoPersonneOnProejcts' => $infoPersonneOnProejcts,
                'infoCostProject' => $infoCostProject
            ]);
        }

    }

    /**
     * @Route("/project/push/{id}", name="push_project")
     * @param int $id
     * @return Response
     */
    public function pushProject(int $id): Response
    {
        $project = $this->projectRepository->find($id);
        $project->setDeliveryDate(new DateTime());
        $this->projectManager->update();
        $this->addFlash('success', 'Project is delivey');
        return $this->redirectToRoute('list_project');
    }

}
/**
 *   $hourlists = $this->managementWorkingHoursRepository->findAllValue($id);
 * $employ = $this->employRepository->find($id);
 *
 *
 * $addTime = new ManagementWorkingHours();
 * $addTime->setEmploy($hourlists[0]->getEmploy());
 * $form = $this->createForm(AddTimeType::class, $addTime);
 * $form->handleRequest($request);
 * if ($form->isSubmitted() && $form->isValid()) {
 * $this->addTimeManager->save($addTime);
 * $this->addFlash('success', 'You added time to the project');
 * return $this->render('employ/show.html.twig', [
 * 'employ' => $hourlists[0]->getEmploy(),
 * 'hourlists' => $hourlists,
 * 'form' => $form->createView()
 * ]);
 * }
 *
 * return $this->render('employ/show.html.twig', [
 * 'employ' => $employ,
 * 'hourlists' => $hourlists,
 * 'form' => $form->createView()
 * ]);
 * }
 */

<?php

namespace App\Controller;

use App\Entity\Employ;
use App\Entity\ManagementWorkingHours;
use App\Form\AddTimeType;
use App\Form\EmployType;
use App\Manager\AddTimeManager;
use App\Manager\EmployManager;
use App\Repository\EmployRepository;
use App\Repository\ManagementWorkingHoursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployController extends AbstractController
{
    private EmployRepository $employRepository;
    private EmployManager $employManager;
    private ManagementWorkingHoursRepository $managementWorkingHoursRepository;
    private AddTimeManager $addTimeManager;

    public function __construct(EmployRepository $employRepository,
                                EmployManager $employManager,
                                ManagementWorkingHoursRepository $managementWorkingHoursRepository,
                                AddTimeManager $addTimeManager)
    {
        $this->employRepository = $employRepository;
        $this->employManager = $employManager;
        $this->managementWorkingHoursRepository = $managementWorkingHoursRepository;
        $this->addTimeManager = $addTimeManager;
    }

    /**
     * @Route("/employ", name="list_employ")
     */
    public function listEmploy(): Response
    {
        $employs = $this->employRepository->findAll();
        return $this->render('employ/list.html.twig', ['employs' => $employs]);
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
            $this->employManager->save($employ);
            $this->addFlash('success', 'Employ is create');
            return $this->redirectToRoute('list_employ');
        }
        return $this->render('employ/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employ/edit/{id}", name="modify_employ")
     */
    public function modifyEmploy(Request $request, int $id): Response
    {
        $employ = $this->employRepository->find($id);
        $form = $this->createForm(EmployType::class, $employ);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->employManager->update();
            $this->addFlash('success', 'Employ is update');
            return $this->redirectToRoute('list_employ');
        }
        return $this->render('employ/edit.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/employ/show/{id}", name="show_employ")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function showEmploy(Request $request, int $id): Response
    {
        $hourlists = $this->managementWorkingHoursRepository->findAllValue($id);
        $employ = $this->employRepository->find($id);


        $addTime = new ManagementWorkingHours();
        $addTime->setEmploy($hourlists[0]->getEmploy());
        $form = $this->createForm(AddTimeType::class, $addTime);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addTimeManager->save($addTime);
            $this->addFlash('success', 'You added time to the project');
            return $this->render('employ/show.html.twig', [
                'employ' => $employ,
                'hourlists' => $hourlists,
                'form' => $form->createView()
            ]);
        }

        return $this->render('employ/show.html.twig', [
            'employ' => $employ,
            'hourlists' => $hourlists,
            'form' => $form->createView()
        ]);
    }
}

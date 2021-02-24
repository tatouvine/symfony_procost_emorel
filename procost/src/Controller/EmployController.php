<?php

namespace App\Controller;

use App\Entity\Employ;
use App\Form\EmployType;
use App\Form\JobType;
use App\Manager\EmployManager;
use App\Repository\EmployRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployController extends AbstractController
{
    private EmployRepository $employRepository;
    private EmployManager $employManager;

    public function __construct(EmployRepository $employRepository, EmployManager $employManager)
    {
        $this->employRepository = $employRepository;
        $this->employManager = $employManager;
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
            $this->addFlash('success','Employ is create');
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
            $this->addFlash('success','Employ is update');
            return $this->redirectToRoute('list_employ');
        }
        return $this->render('employ/edit.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/employ/show/{id}", name="show_employ")
     * @param int $id
     * @return Response
     */
    public function plugEmploy(int $id): Response
    {
        $employ = $this->employRepository->find($id);
        return $this->render('employ/show.html.twig', [
            'employ' => $employ
        ]);
    }
}

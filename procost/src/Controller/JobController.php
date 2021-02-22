<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    private JobRepository $jobRepository;
    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository=$jobRepository;
    }

    /**
     * @Route("/job", name="list_job")
     */
    public function listJob(): Response
    {
        $jobs = $this->jobRepository->findAll();
        return $this->render('job/list.html.twig', ['jobs' => $jobs]);
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
        return $this->render('job/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/job/edit/{id}", name="modify_job")
     */
    public function modifyJob(): Response
    {
        return $this->render('job/edit.html.twig', []);
    }
}

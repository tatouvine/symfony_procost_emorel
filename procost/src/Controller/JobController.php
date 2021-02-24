<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Manager\JobManager;
use App\Repository\JobRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    private JobRepository $jobRepository;
    private JobManager $jobManager;

    public function __construct(JobRepository $jobRepository, JobManager $jobManager)
    {
        $this->jobRepository = $jobRepository;
        $this->jobManager = $jobManager;
    }

    /**
     * @Route("/job", name="list_job")
     */
    public function listJob(): Response
    {
        $jobs = $this->jobRepository->findAllJobAndPosibilityToDelete();
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
            $this->jobManager->save($job);
            $this->addFlash('success','Job is create');
            return $this->redirectToRoute('list_job');
        }
        return $this->render('job/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/job/edit/{id}", name="modify_job")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function modifyJob(Request $request, int $id): Response
    {
        $job = $this->jobRepository->find($id);
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->jobManager->update();
            $this->addFlash('success','Job is update');
            return $this->redirectToRoute('list_job');
        }
        return $this->render('job/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route("/job/delete/{id}", name="delete_job")
     */
    public function deleteJob(Request $request, int $id): Response
    {
        $job = $this->jobRepository->find($id);
        $this->jobManager->delete($job);
        return $this->redirectToRoute('list_job');
    }
}

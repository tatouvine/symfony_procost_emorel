<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\User;
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
     * @Route("/job/{page?1}", name="list_job",requirements={"page" = "\d+"},methods={"GET"} )
     * @param int|null $page
     * @return Response
     */
    public function listJob(?int $page = 1): Response
    {
        if ($this->getUser() instanceof User) {
            $jobs = $this->jobRepository->findAllJobAndPosibilityToDelete($page);
            $countPage = ceil($this->jobRepository->countJob()[1] / 10);
            return $this->render('job/list.html.twig', [
                'jobs' => $jobs,
                'countPage' => $countPage,
                'actualyPage' => $page,
                'url' => '/job/'
            ]);
        }
        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/job/edit", name="create_job")
     * @param Request $request
     * @return Response
     */
    public function createJob(Request $request): Response
    {
        if ($this->getUser() instanceof User) {
            if ($this->isGranted('ROLE_ADMIN') === true) {
                $job = new Job();
                $form = $this->createForm(JobType::class, $job);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $this->jobManager->save($job);
                    $this->addFlash('success', 'Job is create');
                    return $this->redirectToRoute('list_job');
                }
                return $this->render('job/edit.html.twig', [
                    'form' => $form->createView()
                ]);
            } else {
                return $this->redirectToRoute('list_job');
            }
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/job/edit/{id}", name="modify_job")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function modifyJob(Request $request, int $id): Response
    {
        if ($this->getUser() instanceof User) {
            if ($this->isGranted('ROLE_ADMIN') === true) {
                $job = $this->jobRepository->find($id);
                $form = $this->createForm(JobType::class, $job);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $this->jobManager->update();
                    $this->addFlash('success', 'Job is update');
                    return $this->redirectToRoute('list_job');
                }
                return $this->render('job/edit.html.twig', [
                    'form' => $form->createView()
                ]);
            } else {
                return $this->redirectToRoute('list_job');
            }
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route("/job/delete/{id}", name="delete_job")
     */
    public function deleteJob(Request $request, int $id): Response
    {
        if ($this->getUser() instanceof User) {
            if ($this->isGranted('ROLE_ADMIN') === true) {
                $job = $this->jobRepository->find($id);
                $this->jobManager->delete($job);
            }
            return $this->redirectToRoute('list_job');
        }
        return $this->redirectToRoute('app_login');
    }
}

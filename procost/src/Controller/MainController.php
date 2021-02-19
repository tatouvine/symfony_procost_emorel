<?php

namespace App\Controller;

use App\Entity\Src\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use App\Repository\JobRepository;
use App\Repository\Src\Store\ProductRepository;
use App\Service\ContactMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private JobRepository $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        return $this->render('main/home.html.twig', []);
    }

    /**
     * @Route("/project", name="list_project")
     */
    public function listProject(): Response
    {
        return $this->render('list/project.html.twig', []);
    }

    /**
     * @Route("/employ", name="list_employ")
     */
    public function listEmploy(): Response
    {
        return $this->render('list/employ.html.twig', []);
    }

    /**
     * @Route("/job", name="list_job")
     */
    public function listJob(): Response
    {
        $jobs = $this->jobRepository->findAll();
        return $this->render('list/job.html.twig', ['jobs' => $jobs]);
    }
}

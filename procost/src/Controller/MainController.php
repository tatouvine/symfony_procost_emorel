<?php

namespace App\Controller;

use App\Repository\EmployRepository;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private JobRepository $jobRepository;
    private EmployRepository $employRepository;

    public function __construct(JobRepository $jobRepository, EmployRepository $employRepository)
    {
        $this->jobRepository = $jobRepository;;
        $this->employRepository = $employRepository;
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        $findLengthEmploy = $this->employRepository->findlengthEmploys()[1];
        return $this->render('main/home.html.twig', [
            'findLengthEmploy' => $findLengthEmploy
        ]);
    }

}

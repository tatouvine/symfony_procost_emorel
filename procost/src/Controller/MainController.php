<?php

namespace App\Controller;

use App\Repository\EmployRepository;
use App\Repository\JobRepository;
use App\Repository\ManagementWorkingHoursRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private JobRepository $jobRepository;
    private EmployRepository $employRepository;
    private ProjectRepository $projectRepository;
    private ManagementWorkingHoursRepository $managementWorkingHoursRepository;

    public function __construct(JobRepository $jobRepository,
                                EmployRepository $employRepository,
                                ProjectRepository $projectRepository,
                                ManagementWorkingHoursRepository $managementWorkingHoursRepository)
    {
        $this->jobRepository = $jobRepository;;
        $this->employRepository = $employRepository;
        $this->projectRepository = $projectRepository;
        $this->managementWorkingHoursRepository = $managementWorkingHoursRepository;
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        $findLengthEmploy = $this->employRepository->findlengthEmploys()[1];
        $projects = $this->projectRepository->findTotalCostByProject();
        $productionTimes = $this->managementWorkingHoursRepository->findFiveLastCreateInformation();
        $countProjectFinish = $this->projectRepository->projectCountFinish()[1];
        $countProjectNotFinish = $this->projectRepository->projectCountNotFinish()[1];
        $countHours = $this->managementWorkingHoursRepository->countHours();
        $bestEmploy = $this->managementWorkingHoursRepository->bestEmploy();
        $deliveryRate = ($countProjectFinish / ($countProjectFinish + $countProjectNotFinish)) * 100;
        $profitable = $this->calculateProfitability($this->projectRepository->projectListFinish());
        return $this->render('main/home.html.twig', [
            'findLengthEmploy' => $findLengthEmploy,
            'projects' => $projects,
            'productionTimes' => $productionTimes,
            'countProjectFinish' => $countProjectFinish,
            'countProjectNotFinish' => $countProjectNotFinish,
            'countHours' => $countHours,
            'bestEmploy' => $bestEmploy,
            'deliveryRate' => $deliveryRate,
            'profitable' => $profitable
        ]);
    }

    private function calculateProfitability($projects)
    {
        $total = 0;
        $costs = 0;
        $allPrice = 0;
        foreach ($projects as &$value) {
            if ($value['total'] === null) {
                $value['total'] = 0;
            } else {
                $value['total'] = intval($value['total']);
            }
            $costs += $value['total'];
            $allPrice += $value['project']->getPrice();
        }
        $total = ($allPrice*100)/$costs;
        return ($total);
    }
}

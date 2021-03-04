<?php

namespace App\Controller;

use App\Entity\Employ;
use App\Entity\ManagementWorkingHours;
use App\Entity\User;
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
     * @Route("/employ/{page?1}", name="list_employ", requirements={"page" = "\d+"},methods={"GET"})
     * @param int|null $page
     * @return Response
     */
    public function listEmploy(?int $page = 1): Response
    {
        if ($this->getUser() instanceof User) {

            $countPage = ceil($this->employRepository->countEmploys()[1] / 10);
            $employs = $this->employRepository->findEmployByPage($page);
            return $this->render('employ/list.html.twig', [
                'employs' => $employs,
                'countPage' => $countPage,
                'actualyPage' => $page,
                'url' => '/employ/'
            ]);
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/employ/edit", name="create_employ",methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function createEmploy(Request $request): Response
    {
        if ($this->getUser() instanceof User) {

            if ($this->isGranted('ROLE_ADMIN') === true) {

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

            } else {

                return $this->redirectToRoute('list_employ');
            }
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/employ/edit/{id}", name="modify_employ")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function modifyEmploy(Request $request, int $id): Response
    {
        if ($this->getUser() instanceof User) {

            if ($this->getUser()->getEmploy()->getId() === $id) {

                $employ = $this->employRepository->find($id);
                $form = $this->createForm(EmployType::class, $employ);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $this->employManager->update();
                    $this->addFlash('success', 'Employ is update');
                    return $this->redirectToRoute('list_employ');
                }
                return $this->render('employ/edit.html.twig', ['form' => $form->createView()]);

            } else {

                return $this->redirectToRoute('list_employ');
            }
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/employ/show/{id}/{page?1}", name="show_employ")
     * @param Request $request
     * @param int $id
     * @param int|null $page
     * @return Response
     */
    public function showEmploy(Request $request, int $id, ?int $page): Response
    {
        if ($this->getUser() instanceof User) {

            if ($this->isGranted('ROLE_ADMIN') === true || $this->getUser()->getEmploy()->getId() === $id) {

                $hourlists = $this->managementWorkingHoursRepository->findAllValue($id, $page);
                $employ = $this->employRepository->find($id);
                $url = '/employ/show/' . $id . '/';
                $countPage = ceil($this->managementWorkingHoursRepository->countLineByEmploy($id)[1] / 5);


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
                        'form' => $form->createView(),
                        'countPage' => $countPage,
                        'actualyPage' => $page,
                        'url' => $url
                    ]);
                }
                return $this->render('employ/show.html.twig', [
                    'employ' => $employ,
                    'hourlists' => $hourlists,
                    'form' => $form->createView(),
                    'countPage' => $countPage,
                    'actualyPage' => $page,
                    'url' => $url
                ]);

            } else {

                return $this->redirectToRoute('list_employ');
            }
        }
        return $this->redirectToRoute('app_login');
    }

}

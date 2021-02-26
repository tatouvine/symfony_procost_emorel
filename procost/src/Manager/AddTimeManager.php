<?php

namespace App\Manager;

use App\Entity\ManagementWorkingHours;
use App\Event\ManagementWorkingHoursCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class AddTimeManager
{

    private EntityManagerInterface $em;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $em,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function save(ManagementWorkingHours $managementWorkingHours): void
    {
        $this->em->persist($managementWorkingHours);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new ManagementWorkingHoursCreated($managementWorkingHours));
    }
}

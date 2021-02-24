<?php

namespace App\Manager;

use App\Entity\Employ;
use App\Event\EmployCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class EmployManager
{

    private EntityManagerInterface $em;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $em,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function save(Employ $employ): void
    {
        $this->em->persist($employ);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new EmployCreated($employ));
    }

    public function update()
    {
        $this->em->flush();
    }

    public function delete(Employ $employ)
    {
        $this->em->remove($employ);
        $this->em->flush();
    }
}

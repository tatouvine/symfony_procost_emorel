<?php

namespace App\DataFixtures;

use App\Entity\Employ;
use App\Entity\Job;
use App\Entity\ManagementWorkingHours;
use App\Entity\Project;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->createJobs();
        $this->createEmploy();
        $this->createProject();
        $this->createWorkingHours();
        $manager->flush();
    }

    private function createJobs()
    {
        $jobs = [
            ['Dev Java'],
            ['Dev JS'],
            ['Dev PHP'],
            ['Web designer'],
            ['SEO Manager'],
        ];
        foreach ($jobs as $key => [$name]) {
            $job = (new Job())->setName((string)$name);
            $this->manager->persist($job);
            $this->addReference(Job::class . $key, $job);
        }
    }

    private function createEmploy()
    {
        $employs = [
            ['Erwin', 'Morel', 'erwin.morel@laposte.net', '500'],
            ['Mathieu', 'Tesla', 'a.b@gmail.com', '400'],
            ['Pierre', 'Apptel', 'c.d@gmail.com', '300'],
            ['Richard', 'Pausni', 'e.f@gmail.com', '150'],
            ['Ahmid', 'Aorel', 'g.h@gmail.com', '1200'],

        ];
        foreach ($employs as $key => $value) {
            $job = $this->getReference(Job::class . random_int(0, 4));
            $employ = (new Employ())
                ->setFirstName((string)$value[0])
                ->setLastName($value[1])
                ->setEmail($value[2])
                ->setHourlyCost($value[3])
                ->setHiringDate(new DateTime())
                ->setJob($job);

            $this->manager->persist($employ);
            $this->addReference(Employ::class . $key, $employ);
        }
    }

    private function createProject()
    {
        $projets = [
            ['Project1', 'blablablablablabla', '500000', new DateTime()],
            ['Project2', 'aaaaaaaaaaaaaaa', '500000', new DateTime()],
            ['Project3', 'bbbbbbbbbbbbbbbbbbbbbb', '500000', new DateTime()],
            ['Project4', 'ccccccccccccccccc', '500000', new DateTime()],
            ['Project5', 'ddddddddddddddddddd', '500000', new DateTime()],
            ['Project6', 'eeeeeeeeeeeeeeeeee', '500000', new DateTime()],
            ['Project7', 'ffffffffffffffffffff', '500000', new DateTime()],
            ['Project8', 'ggggggggggggggggg', '500000', new DateTime()],
            ['Project9', 'hhhhhhhhhhhhh', '500000', new DateTime()],
        ];
        foreach ($projets as $key => $value) {
            $project = (new Project())
                ->setName((string)$value[0])
                ->setDescription($value[1])
                ->setPrice($value[2])
                ->setCreationDate($value[3]);

            $this->manager->persist($project);
            $this->addReference(Project::class . $key, $project);
        }
    }

    private function createWorkingHours()
    {
        $WorkingHours = [
            ['4'], ['2'], ['7'], ['8'], ['9'], ['5'],
            ['6'], ['1'], ['5'], ['4'], ['3'], ['7'],
            ['8'], ['9'], ['5'], ['10'],
        ];
        foreach ($WorkingHours as $key => [$value]) {
            $project = (new ManagementWorkingHours())
                ->setEmploy($this->getReference(Employ::class . random_int(0, 4)))
                ->setProject($this->getReference(Project::class . random_int(0, 8)))
                ->setHours($value);
            $this->manager->persist($project);
            $this->addReference(ManagementWorkingHours::class . $key, $project);
        }
    }
}

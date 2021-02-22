<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->createJobs();
        $manager->flush();
    }

    private function createJobs()
    {
        $Jobs = [
            ['Dev Java'],
            ['Dev JS'],
            ['Dev PHP'],
            ['Web designer'],
            ['SEO Manager'],
        ];
        foreach ($Jobs as $key => [$name]) {
            $job = (new Job())->setName((string)$name);
            $this->manager->persist($job);
            $this->addReference(Job::class . $key, $job);
        }
    }
    function blabla(){

    }
}

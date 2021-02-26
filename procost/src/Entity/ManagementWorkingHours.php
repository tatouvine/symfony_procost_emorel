<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManagementWorkingHoursRepository")
 * @ORM\Table(name="ManagementWorkingHours")
 */
class ManagementWorkingHours
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Project", inversedBy="hourList")
     * @ORM\JoinColumn (nullable=false,name="project_id")
     */
    private $project;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Employ" , inversedBy="hourList")
     * @ORM\JoinColumn (nullable=false,name="employ_id")
     */
    private $employ;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $hours;

    /**
     * @ORM\Column (type="datetime")
     */
    private DateTime $creationDate;

    public function __construct()
    {
        $this->creationDate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ManagementWorkingHours
    {
        $this->id = $id;
        return $this;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject($project): ManagementWorkingHours
    {
        $this->project = $project;
        return $this;
    }

    public function getEmploy()
    {
        return $this->employ;
    }

    public function setEmploy($employ): ManagementWorkingHours
    {
        $this->employ = $employ;
        return $this;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setHours($hours): ManagementWorkingHours
    {
        $this->hours = $hours;
        return $this;
    }

    public function getcreationDate()
    {
        return $this->creationDate;
    }

    public function setcreationDate($creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }
}

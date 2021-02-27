<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployRepository")
 * @ORM\Table(name="employ")
 */
class Employ
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @ORM\Column(type="string",length=255)
     */
    private ?string $firstName;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @ORM\Column(type="string",length=255)
     */
    private ?string $lastName;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Email (message="L'email {{ value }} n'est pas valide")
     * @ORM\Column(type="string",length=255)
     */
    private ?string $email;
    /**
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="employs")
     * @ORM\JoinColumn(nullable=false,name="job_id")
     */
    private $job;
    /**
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @ORM\Column(type="string",length=255)
     */
    private $hourlyCost;
    /**
     * @var DateTime
     * @Assert\Type(type="\DateTimeInterface")
     * @ORM\Column(type="datetime")
     */
    private DateTime $hiringDate;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ManagementWorkingHours",mappedBy="employ")
     */
    private $hourList;


    public function __construct()
    {
        $this->hiringDate = new DateTime();
        $this->lastName = null;
        $this->job = null;
        $this->firstName = null;
        $this->email = null;
        $this->hourlyCost = null;
        $this->hourList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Employ
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): string
    {

        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Employ
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Employ
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Employ
    {
        $this->email = $email;
        return $this;
    }

    public function getJob()
    {
        return $this->job;
    }

    public function setJob($job): Employ
    {
        $this->job = $job;
        return $this;
    }

    public function getHourlyCost()
    {
        return $this->hourlyCost;
    }

    public function setHourlyCost($hourlyCost): Employ
    {
        $this->hourlyCost = $hourlyCost;
        return $this;
    }

    public function getHiringDate(): DateTime
    {
        return $this->hiringDate;
    }

    public function setHiringDate($hiringDate): Employ
    {
        $this->hiringDate = $hiringDate;
        return $this;
    }

    public function getHourList(): Collection
    {
        return $this->hourList;
    }

    public function addOneInHourList(ManagementWorkingHours $value): self
    {
        if (!$this->hourList->contains($value)) {
            $this->hourList[] = $value;
            $value->setEmploy($this);
        }
        return $this;
    }

    public function removeOneInHourList(ManagementWorkingHours $value): self
    {
        if ($this->hourList->contains($value)) {
            $this->hourList->removeElement($value);
            if ($value->getEmploy() === $this) {
                $value->setEmploy(null);
            }
        }
        return $this;
    }


}

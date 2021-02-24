<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project
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
    private ?string $name;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @ORM\Column(type="text")
     */
    private ?string $description;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @ORM\Column(type="string",length=255)
     */
    private ?string $price;
    /**
     * @var DateTime
     * @Assert\Type(type="\DateTimeInterface")
     * @ORM\Column(type="datetime")
     */
    private DateTime $creationDate;
    /**
     * @var DateTime
     * @Assert\Type(type="\DateTimeInterface")
     * @ORM\Column(type="datetime",nullable=true)
     */
    private ?DateTime $deliveyDate;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ManagementWorkingHours",mappedBy="project")
     */
    private $hourList;

    public function __construct()
    {
        $this->name = null;
        $this->price = null;
        $this->description = null;
        $this->creationDate = new DateTime();
        $this->deliveyDate = null;
        $this->projectDeliver = false;
        $this->hourList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Project
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Project
     */
    public function setName(?string $name): Project
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Project
     */
    public function setDescription(?string $description): Project
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     * @return Project
     */
    public function setPrice(?string $price): Project
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param DateTime $creationDate
     * @return Project
     */
    public function setCreationDate(DateTime $creationDate): Project
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDeliveyDate(): ?DateTime
    {
        return $this->deliveyDate;
    }

    /**
     * @param DateTime $deliveyDate
     * @return Project
     */
    public function setDeliveyDate(DateTime $deliveyDate): Project
    {
        $this->deliveyDate = $deliveyDate;
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

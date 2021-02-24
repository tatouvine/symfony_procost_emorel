<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 * @ORM\Table(name="job")
 */
class Job
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
     * @Assert\NotBlank(message="Ce champ ne peut pas etre vide")
     * @ORM\Column(type="string",length=255)
     */
    private ?string $name;

    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Employ",mappedBy="job")
     */
    private $employs;

    public function __construct()
    {
        $this->name = null;
        $this->id = null;
        $this->employs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Job
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

    /**.
     * @param string|null $name
     * @return Job
     */
    public function setName(?string $name): Job
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection|Employ[]
     */
    public function getEmploys(): Collection
    {
        return $this->employs;
    }

    public function addEmploy(Employ $employ): self
    {
        if (!$this->employs->contains($employ)) {
            $this->employs[] = $employ;
            $employ->setJob($this);
        }
        return $this;
    }

    public function removeEmploy(Employ $employ): self
    {
        if ($this->employs->contains($employ)) {
            $this->employs->removeElement($employ);
            if ($employ->getJob() === $this) {
                $employ->setJob(null);
            }
        }
        return $this;
    }
}

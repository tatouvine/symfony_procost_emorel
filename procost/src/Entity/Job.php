<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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

    public function __construct()
    {
        $this->name = null;
        $this->id = null;
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


}

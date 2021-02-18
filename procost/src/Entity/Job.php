<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Job
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut pas etre vide")
     */
    private ?string $name;

    public function __construct()
    {
        $this->name = null;
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

<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class Employ
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $firstName;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $lastName;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $email;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\Email (message="L'email {{ value }} n'est pas valide")
     */
    private ?string $job;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $hourlyCost;
    /**
     * @var DateTime
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     * @Assert\DateTime(message="Ce n'est pas une date conforme")
     */
    private DateTime $hiringDate;

    public function __construct()
    {
        $this->hiringDate = new DateTime();
        $this->lastName = null;
        $this->job = null;
        $this->firstName = null;
        $this->email = null;
        $this->hourlyCost = null;
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

    public function getJob(): string
    {
        return $this->job;
    }

    public function setJob(?string $job): Employ
    {
        $this->job = $job;
        return $this;
    }

    public function getHourlyCost(): string
    {
        return $this->hourlyCost;
    }

    public function setHourlyCost(?string $hourlyCost): Employ
    {
        $this->hourlyCost = $hourlyCost;
        return $this;
    }

    public function getHiringDate(): DateTime
    {
        return $this->hiringDate;
    }

    public function setHiringDate($hiringDate): void
    {
        $this->hiringDate = $hiringDate;
    }

}

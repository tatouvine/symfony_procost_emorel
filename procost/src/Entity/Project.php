<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class Project
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $name;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $description;
    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champ ne peut être vide")
     */
    private ?string $price;
    /**
     * @var DateTime
     * @Assert\Type(type="\DateTimeInterface")
     */
    private DateTime $creationDate;
    /**
     * @var DateTime
     * @Assert\Type(type="\DateTimeInterface")
     */
    private DateTime $deliveyDate;

    public function __construct()
    {
        $this->name = null;
        $this->price = null;
        $this->description = null;
        $this->creationDate = new DateTime();
        $this->deliveyDate = new  DateTime();
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
    public function getDeliveyDate(): DateTime
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

}

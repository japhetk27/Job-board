<?php

namespace App\Entity;

use App\Repository\EmailBodyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmailBodyRepository::class)]
class EmailBody
{
    public function __toString()
    {
        return $this->getPerson();
    }


    #[ORM\OneToMany(targetEntity:JobApplications::class, mappedBy:"email_body", cascade:["persist", "remove"])]
    private $jobapplications;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: People::class)]
    #[ORM\JoinColumn(name: "person", referencedColumnName: "id")]
    private ?People $person = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Advertisements::class)]
    #[ORM\JoinColumn(name: "advertisements", referencedColumnName: "id")]
    private ?Advertisements $advertisements = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?People
    {
        return $this->person;
    }

    public function setPerson(?People $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAdvertisements(): ?Advertisements
    {
        return $this->advertisements;
    }

    public function setAdvertisements(?Advertisements $advertisements): static
    {
        $this->advertisements = $advertisements;

        return $this;
    }
}

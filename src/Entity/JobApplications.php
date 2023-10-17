<?php

namespace App\Entity;

use App\Repository\JobApplicationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobApplicationsRepository::class)]
class JobApplications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Advertisements::class)]
    #[ORM\JoinColumn(name: "ad", referencedColumnName: "id")]
    private ?Advertisements $ad= null;

    #[ORM\ManyToOne(targetEntity: EmailBody::class)]
    #[ORM\JoinColumn(name: "email_body", referencedColumnName: "id")]
    private ?EmailBody $email_body= null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $application_date = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $status = null;

    #[ORM\Column]
    private ?bool $email_sent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAd(): ?Advertisements
    {
        return $this->ad;
    }

    public function setAd(?Advertisements $ad): static
    {
        $this->ad = $ad;

        return $this;
    }

    public function getEmailBody(): ?EmailBody
    {
        return $this->email_body;
    }

    public function setEmailBody(EmailBody $email_body): static
    {
        $this->email_body = $email_body;

        return $this;
    }

    public function getApplicationDate(): ?\DateTimeInterface
    {
        return $this->application_date;
    }

    public function setApplicationDate(?\DateTimeInterface $application_date): static
    {
        $this->application_date = $application_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isEmailSent(): ?bool
    {
        return $this->email_sent;
    }

    public function setEmailSent(bool $email_sent): static
    {
        $this->email_sent = $email_sent;

        return $this;
    }
}

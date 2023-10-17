<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
class Companies implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\OneToMany(targetEntity:Advertisements::class, mappedBy:"company", cascade:["persist", "remove"])]
    private $advertisements;

    public function __toString()
    {
        return $this->getName();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $industry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact_email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIndustry(): ?string
    {
        return $this->industry;
    }

    public function setIndustry(?string $industry): static
    {
        $this->industry = $industry;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(?string $contact_email): static
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }
    public function getRoles(): array
    {
        $roles = ['ROLE_EMPLOYEUR'];
        return $roles;    
    }
    public function eraseCredentials()
    {
        // Cette méthode est généralement vide, car les mots de passe en clair ne sont pas stockés après l'authentification
    }

    public function getUserIdentifier():string
    {
        return $this->contact_email; // Si l'email est l'identifiant de l'utilisateur
    }
}

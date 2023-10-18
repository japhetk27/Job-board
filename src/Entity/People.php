<?php

namespace App\Entity;

use App\Repository\PeopleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: PeopleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class People implements UserInterface, PasswordAuthenticatedUserInterface
{

    public function __toString()
    {
        return $this->getFirstName() ." ". $this->getName();
    }

    #[ORM\OneToMany(targetEntity:EmailBody::class, mappedBy:"person", cascade:["persist", "remove"])]
    private $emailBodies;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = ucfirst($first_name);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = strtoupper($name);
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function getRoles(): array
    {
        
        if ($this->getId() == 4) {
            $roles = ['ROLE_ADMIN'];
        } else {
            $roles = ['ROLE_DEMANDEUR'];
        }
    
        return $roles;    
    }

    public function eraseCredentials()
    {
        // Cette méthode est généralement vide, car les mots de passe en clair ne sont pas stockés après l'authentification
    }

    public function getUserIdentifier():string
    {
        return $this->email; // Si l'email est l'identifiant de l'utilisateur
    }
}

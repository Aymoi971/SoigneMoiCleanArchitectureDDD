<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'businessRole')]
    private Collection $users;

    /**
     * @var Collection<int, rights>
     */
    #[ORM\ManyToMany(targetEntity: Rights::class, inversedBy: 'roles')]
    private Collection $rights;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->rights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, rights>
     */
    public function getRights(): Collection
    {
        return $this->rights;
    }

    public function addRight(Rights $right): static
    {
        if (!$this->rights->contains($right)) {
            $this->rights->add($right);
        }

        return $this;
    }

    public function removeRight(Rights $right): static
    {
        $this->rights->removeElement($right);

        return $this;
    }
}

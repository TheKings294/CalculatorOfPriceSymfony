<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'menuses')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, MenuRecipes>
     */
    #[ORM\OneToMany(targetEntity: MenuRecipes::class, mappedBy: 'menu')]
    private Collection $menuRecipes;

    /**
     * @var Collection<int, PrestationMenus>
     */
    #[ORM\OneToMany(targetEntity: PrestationMenus::class, mappedBy: 'menu')]
    private Collection $prestationMenues;

    public function __construct()
    {
        $this->menuRecipes = new ArrayCollection();
        $this->prestationMenues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user = $user_id;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, MenuRecipes>
     */
    public function getMenuRecipes(): Collection
    {
        return $this->menuRecipes;
    }

    public function addMenuRecipe(MenuRecipes $menuRecipe): static
    {
        if (!$this->menuRecipes->contains($menuRecipe)) {
            $this->menuRecipes->add($menuRecipe);
            $menuRecipe->setMenuId($this);
        }

        return $this;
    }

    public function removeMenuRecipe(MenuRecipes $menuRecipe): static
    {
        if ($this->menuRecipes->removeElement($menuRecipe)) {
            // set the owning side to null (unless already changed)
            if ($menuRecipe->getMenuId() === $this) {
                $menuRecipe->setMenuId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrestationMenus>
     */
    public function getPrestationMenuses(): Collection
    {
        return $this->prestationMenues;
    }

    public function addPrestationMenus(PrestationMenus $prestationMenus): static
    {
        if (!$this->prestationMenues->contains($prestationMenus)) {
            $this->prestationMenues->add($prestationMenus);
            $prestationMenus->setMenuId($this);
        }

        return $this;
    }

    public function removePrestationMenus(PrestationMenus $prestationMenus): static
    {
        if ($this->prestationMenues->removeElement($prestationMenus)) {
            // set the owning side to null (unless already changed)
            if ($prestationMenus->getMenuId() === $this) {
                $prestationMenus->setMenuId(null);
            }
        }

        return $this;
    }
}

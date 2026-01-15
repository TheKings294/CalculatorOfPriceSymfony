<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'app_user')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 320)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private ?array $roles = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToOne(targetEntity: ChefSettings::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?ChefSettings $chefSettings = null;

    /**
     * @var Collection<int, Ingredients>
     */
    #[ORM\OneToMany(targetEntity: Ingredients::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $ingredients;

    /**
     * @var Collection<int, Recipes>
     */
    #[ORM\OneToMany(targetEntity: Recipes::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $recipes;

    /**
     * @var Collection<int, Prestations>
     */
    #[ORM\OneToMany(targetEntity: Prestations::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $prestations;

    /**
     * @var Collection<int, Menus>
     */
    #[ORM\OneToMany(targetEntity: Menus::class, mappedBy: 'user')]
    private Collection $menuses;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->recipes = new ArrayCollection();
        $this->prestations = new ArrayCollection();
        $this->menuses = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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

    public function getChefSettings(): ?ChefSettings
    {
        return $this->chefSettings;
    }

    public function setChefSettings(ChefSettings $chefSettings): static
    {
        // set the owning side of the relation if necessary
        if ($chefSettings->getUserId() !== $this) {
            $chefSettings->setUserId($this);
        }

        $this->chefSettings = $chefSettings;

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setUserId($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getUserId() === $this) {
                $ingredient->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recipes>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipes $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setUserId($this);
        }

        return $this;
    }

    public function removeRecipe(Recipes $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUserId() === $this) {
                $recipe->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prestations>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestations $prestation): static
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations->add($prestation);
            $prestation->setUserId($this);
        }

        return $this;
    }

    public function removePrestation(Prestations $prestation): static
    {
        if ($this->prestations->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getUserId() === $this) {
                $prestation->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Menus>
     */
    public function getMenuses(): Collection
    {
        return $this->menuses;
    }

    public function addMenus(Menus $menus): static
    {
        if (!$this->menuses->contains($menus)) {
            $this->menuses->add($menus);
            $menus->setUserId($this);
        }

        return $this;
    }

    public function removeMenus(Menus $menus): static
    {
        if ($this->menuses->removeElement($menus)) {
            // set the owning side to null (unless already changed)
            if ($menus->getUserId() === $this) {
                $menus->setUserId(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getUserIdentifier() :string
    {
        return $this->getEmail();
    }

    public function eraseCredentials(): void
    {
        // clear sensitive temporary data
    }
}

<?php

namespace App\Entity;

use App\Repository\RecipesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipesRepository::class)]
class Recipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, RecipeIngredients>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngredients::class, mappedBy: 'recipe')]
    private Collection $recipeIngredients;

    /**
     * @var Collection<int, PrestationRecipes>
     */
    #[ORM\OneToMany(targetEntity: PrestationRecipes::class, mappedBy: 'recipe')]
    private Collection $prestationRecipes;

    /**
     * @var Collection<int, MenuRecipes>
     */
    #[ORM\OneToMany(targetEntity: MenuRecipes::class, mappedBy: 'recipe')]
    private Collection $menuRecipes;

    public function __construct()
    {
        $this->recipeIngredients = new ArrayCollection();
        $this->prestationRecipes = new ArrayCollection();
        $this->menuRecipes = new ArrayCollection();
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
     * @return Collection<int, RecipeIngredients>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredients $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->addRecipeId($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredients $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            $recipeIngredient->removeRecipeId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PrestationRecipes>
     */
    public function getPrestationRecipes(): Collection
    {
        return $this->prestationRecipes;
    }

    public function addPrestationRecipe(PrestationRecipes $prestationRecipe): static
    {
        if (!$this->prestationRecipes->contains($prestationRecipe)) {
            $this->prestationRecipes->add($prestationRecipe);
            $prestationRecipe->setRecipeId($this);
        }

        return $this;
    }

    public function removePrestationRecipe(PrestationRecipes $prestationRecipe): static
    {
        if ($this->prestationRecipes->removeElement($prestationRecipe)) {
            // set the owning side to null (unless already changed)
            if ($prestationRecipe->getRecipeId() === $this) {
                $prestationRecipe->setRecipeId(null);
            }
        }

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
            $menuRecipe->setRecipeId($this);
        }

        return $this;
    }

    public function removeMenuRecipe(MenuRecipes $menuRecipe): static
    {
        if ($this->menuRecipes->removeElement($menuRecipe)) {
            // set the owning side to null (unless already changed)
            if ($menuRecipe->getRecipeId() === $this) {
                $menuRecipe->setRecipeId(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RecipeIngredientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeIngredientsRepository::class)]
class RecipeIngredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Recipes>
     */
    #[ORM\ManyToOne(targetEntity: Recipes::class, inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $recipe;

    /**
     * @var Collection<int, Ingredients>
     */
    #[ORM\ManyToOne(targetEntity: Ingredients::class, inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $ingredient;

    #[ORM\Column]
    private ?int $quantity = null;

    public function __construct()
    {
        $this->recipe = new ArrayCollection();
        $this->ingredient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Recipes>
     */
    public function getRecipeId(): Collection
    {
        return $this->recipe;
    }

    public function addRecipeId(Recipes $recipeId): static
    {
        if (!$this->recipe->contains($recipeId)) {
            $this->recipe->add($recipeId);
        }

        return $this;
    }

    public function removeRecipeId(Recipes $recipeId): static
    {
        $this->recipe->removeElement($recipeId);

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredientId(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredientId(Ingredients $ingredientId): static
    {
        if (!$this->ingredient->contains($ingredientId)) {
            $this->ingredient->add($ingredientId);
            $ingredientId->setRecipeIngredients($this);
        }

        return $this;
    }

    public function removeIngredientId(Ingredients $ingredientId): static
    {
        if ($this->ingredient->removeElement($ingredientId)) {
            // set the owning side to null (unless already changed)
            if ($ingredientId->getRecipeIngredients() === $this) {
                $ingredientId->setRecipeIngredients(null);
            }
        }

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}

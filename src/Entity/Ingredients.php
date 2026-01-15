<?php

namespace App\Entity;

use App\Repository\IngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientsRepository::class)]
class Ingredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ingredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'unit_enum', options: ['comment' => 'ENUM: g, kg, ml, l, piece'])]
    private ?string $unit = null;

    #[ORM\Column]
    private ?int $cost_per_unit = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(targetEntity: RecipeIngredients::class, mappedBy: 'ingredient', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false)]
    private ?RecipeIngredients $recipeIngredients = null;

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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getCostPerUnit(): ?int
    {
        return $this->cost_per_unit;
    }

    public function setCostPerUnit(int $cost_per_unit): static
    {
        $this->cost_per_unit = $cost_per_unit;

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

    public function getRecipeIngredients(): ?RecipeIngredients
    {
        return $this->recipeIngredients;
    }

    public function setRecipeIngredients(?RecipeIngredients $recipeIngredients): static
    {
        $this->recipeIngredients = $recipeIngredients;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PrestationRecipesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRecipesRepository::class)]
class PrestationRecipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Prestations::class, inversedBy: 'prestationRecipes')]
    private ?Prestations $prestation = null;

    #[ORM\ManyToOne(targetEntity: Recipes::class, inversedBy: 'prestationRecipes')]
    private ?Recipes $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrestationId(): ?Prestations
    {
        return $this->prestation;
    }

    public function setPrestationId(?Prestations $prestation_id): static
    {
        $this->prestation = $prestation_id;

        return $this;
    }

    public function getRecipeId(): ?Recipes
    {
        return $this->recipe;
    }

    public function setRecipeId(?Recipes $recipe_id): static
    {
        $this->recipe = $recipe_id;

        return $this;
    }
}

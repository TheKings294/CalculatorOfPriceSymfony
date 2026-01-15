<?php

namespace App\Entity;

use App\Repository\MenuRecipesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRecipesRepository::class)]
class MenuRecipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'menuRecipes')]
    private ?Menus $menu = null;

    #[ORM\ManyToOne(inversedBy: 'menuRecipes')]
    private ?Recipes $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenuId(): ?Menus
    {
        return $this->menu;
    }

    public function setMenuId(?Menus $menu_id): static
    {
        $this->menu = $menu_id;

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

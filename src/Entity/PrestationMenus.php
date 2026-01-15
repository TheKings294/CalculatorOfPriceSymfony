<?php

namespace App\Entity;

use App\Repository\PrestationMenusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationMenusRepository::class)]
class PrestationMenus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Prestations::class, inversedBy: 'prestationMenues')]
    private ?Prestations $prestation = null;

    #[ORM\ManyToOne(targetEntity: Menus::class, inversedBy: 'prestationMenues')]
    private ?Menus $menu = null;

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

    public function getMenuId(): ?Menus
    {
        return $this->menu;
    }

    public function setMenuId(?Menus $menu_id): static
    {
        $this->menu = $menu_id;

        return $this;
    }
}

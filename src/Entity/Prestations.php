<?php

namespace App\Entity;

use App\Repository\PrestationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationsRepository::class)]
class Prestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'prestations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?int $people_count = null;

    #[ORM\Column]
    private ?int $base_cost = null;

    #[ORM\Column]
    private ?int $travel_km = null;

    #[ORM\Column]
    private ?float $final_price = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $notes = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, PrestationRecipes>
     */
    #[ORM\OneToMany(targetEntity: PrestationRecipes::class, mappedBy: 'prestation')]
    private Collection $prestationRecipes;

    /**
     * @var Collection<int, PrestationMenus>
     */
    #[ORM\OneToMany(targetEntity: PrestationMenus::class, mappedBy: 'prestation', orphanRemoval: true)]
    private Collection $prestationMenues;

    public function __construct()
    {
        $this->prestationRecipes = new ArrayCollection();
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

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPeopleCount(): ?int
    {
        return $this->people_count;
    }

    public function setPeopleCount(int $people_count): static
    {
        $this->people_count = $people_count;

        return $this;
    }

    public function getBaseCost(): ?int
    {
        return $this->base_cost;
    }

    public function setBaseCost(int $base_cost): static
    {
        $this->base_cost = $base_cost;

        return $this;
    }

    public function getTravelKm(): ?int
    {
        return $this->travel_km;
    }

    public function setTravelKm(int $travel_km): static
    {
        $this->travel_km = $travel_km;

        return $this;
    }

    public function getFinalPrice(): ?float
    {
        return $this->final_price;
    }

    public function setFinalPrice(float $final_price): static
    {
        $this->final_price = $final_price;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): static
    {
        $this->notes = $notes;

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
            $prestationRecipe->setPrestationId($this);
        }

        return $this;
    }

    public function removePrestationRecipe(PrestationRecipes $prestationRecipe): static
    {
        if ($this->prestationRecipes->removeElement($prestationRecipe)) {
            // set the owning side to null (unless already changed)
            if ($prestationRecipe->getPrestationId() === $this) {
                $prestationRecipe->setPrestationId(null);
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
            $prestationMenus->setPrestationId($this);
        }

        return $this;
    }

    public function removePrestationMenus(PrestationMenus $prestationMenus): static
    {
        if ($this->prestationMenues->removeElement($prestationMenus)) {
            // set the owning side to null (unless already changed)
            if ($prestationMenus->getPrestationId() === $this) {
                $prestationMenus->setPrestationId(null);
            }
        }

        return $this;
    }
}

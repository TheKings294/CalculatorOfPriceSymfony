<?php

namespace App\Entity;

use App\Repository\ChefSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChefSettingsRepository::class)]
class ChefSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $applies_tva = null;

    #[ORM\Column(type: 'taxe_enum')]
    private ?string $tva_rate = null;

    #[ORM\Column]
    private ?int $margin_percent = null;

    #[ORM\Column]
    private ?int $hourly_rate = null;

    #[ORM\Column]
    private ?int $travel_cost_per_km = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToOne(inversedBy: 'chefSettings', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAppliesTva(): ?bool
    {
        return $this->applies_tva;
    }

    public function setAppliesTva(bool $applies_tva): static
    {
        $this->applies_tva = $applies_tva;

        return $this;
    }

    public function getTvaRate(): ?string
    {
        return $this->tva_rate;
    }

    public function setTvaRate(string $tva_rate): static
    {
        $this->tva_rate = $tva_rate;

        return $this;
    }

    public function getMarginPercent(): ?int
    {
        return $this->margin_percent;
    }

    public function setMarginPercent(int $margin_percent): static
    {
        $this->margin_percent = $margin_percent;

        return $this;
    }

    public function getHourlyRate(): ?int
    {
        return $this->hourly_rate;
    }

    public function setHourlyRate(int $hourly_rate): static
    {
        $this->hourly_rate = $hourly_rate;

        return $this;
    }

    public function getTravelCostPerKm(): ?int
    {
        return $this->travel_cost_per_km;
    }

    public function setTravelCostPerKm(int $travel_cost_per_km): static
    {
        $this->travel_cost_per_km = $travel_cost_per_km;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(User $user_id): static
    {
        $this->user = $user_id;

        return $this;
    }
}

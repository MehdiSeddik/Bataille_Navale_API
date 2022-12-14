<?php

namespace App\Entity;

use App\Repository\FleetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FleetRepository::class)]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getGame'])]
    private ?int $id = null;
    #[Groups(['getGame'])]
    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'Fleet')]
    private ?Game $game = null;
    #[Groups(['getGame'])]
    #[ORM\OneToMany(mappedBy: 'fleet', targetEntity: Boat::class)]
    private Collection $boats;

    #[ORM\Column]
    #[Groups(['getGame'])]
    private ?bool $comfirmed = false;

    #[ORM\OneToMany(mappedBy: 'Fleet', targetEntity: Shot::class)]
    private Collection $shots;

    public function __construct()
    {
        $this->boats = new ArrayCollection();
        $this->shots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection<int, Boat>
     */
    public function getBoats(): Collection
    {
        return $this->boats;
    }

    public function addBoat(Boat $boat): self
    {
        if (!$this->boats->contains($boat)) {
            $this->boats->add($boat);
            $boat->setFleet($this);
        }

        return $this;
    }

    public function removeBoat(Boat $boat): self
    {
        if ($this->boats->removeElement($boat)) {
            // set the owning side to null (unless already changed)
            if ($boat->getFleet() === $this) {
                $boat->setFleet(null);
            }
        }

        return $this;
    }

    public function isComfirmed(): ?bool
    {
        return $this->comfirmed;
    }

    public function setComfirmed(bool $comfirmed): self
    {
        $this->comfirmed = $comfirmed;

        return $this;
    }

    /**
     * @return Collection<int, Shot>
     */
    public function getShots(): Collection
    {
        return $this->shots;
    }

    public function addShot(Shot $shot): self
    {
        if (!$this->shots->contains($shot)) {
            $this->shots->add($shot);
            $shot->setFleet($this);
        }

        return $this;
    }

    public function removeShot(Shot $shot): self
    {
        if ($this->shots->removeElement($shot)) {
            // set the owning side to null (unless already changed)
            if ($shot->getFleet() === $this) {
                $shot->setFleet(null);
            }
        }

        return $this;
    }
}

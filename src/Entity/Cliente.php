<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direcction = null;

    #[ORM\ManyToMany(targetEntity: Hotel::class, mappedBy: 'cliente_id')]
    private Collection $hotel_id;

    public function __construct()
    {
        $this->hotel_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDirecction(): ?string
    {
        return $this->direcction;
    }

    public function setDirecction(?string $direcction): self
    {
        $this->direcction = $direcction;

        return $this;
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getHotelId(): Collection
    {
        return $this->hotel_id;
    }

    public function addHotelId(Hotel $hotelId): self
    {
        if (!$this->hotel_id->contains($hotelId)) {
            $this->hotel_id->add($hotelId);
            $hotelId->addClienteId($this);
        }

        return $this;
    }

    public function removeHotelId(Hotel $hotelId): self
    {
        if ($this->hotel_id->removeElement($hotelId)) {
            $hotelId->removeClienteId($this);
        }

        return $this;
    }
}

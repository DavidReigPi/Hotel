<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(nullable: true)]
    private ?int $n_rooms = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\OneToOne(inversedBy: 'hotel_id', cascade: ['persist', 'remove'])]
    private ?Director $director_id = null;

    #[ORM\ManyToMany(targetEntity: Cliente::class, inversedBy: 'hotel_id', cascade: ['persist', 'remove'])]
    private Collection $cliente_id;

    #[ORM\OneToMany(mappedBy: 'hotel_id', targetEntity: Room::class)]
    private Collection $rooms_id;

    public function __construct()
    {
        $this->cliente_id = new ArrayCollection();
        $this->rooms_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getNRooms(): ?int
    {
        return $this->n_rooms;
    }

    public function setNRooms(?int $n_rooms): self
    {
        $this->n_rooms = $n_rooms;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDirectorId(): ?Director
    {
        return $this->director_id;
    }

    public function setDirectorId(?Director $director_id): self
    {
        $this->director_id = $director_id;

        return $this;
    }

    /**
     * @return Collection<int, Cliente>
     */
    public function getClienteId(): Collection
    {
        return $this->cliente_id;
    }

    public function addClienteId(Cliente $clienteId): self
    {
        if (!$this->cliente_id->contains($clienteId)) {
            $this->cliente_id->add($clienteId);
        }

        return $this;
    }

    public function removeClienteId(Cliente $clienteId): self
    {
        $this->cliente_id->removeElement($clienteId);

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRoomsId(): Collection
    {
        return $this->rooms_id;
    }

    public function addRoomsId(Room $roomsId): self
    {
        if (!$this->rooms_id->contains($roomsId)) {
            $this->rooms_id->add($roomsId);
            $roomsId->setHotelId($this);
        }

        return $this;
    }

    public function removeRoomsId(Room $roomsId): self
    {
        if ($this->rooms_id->removeElement($roomsId)) {
            // set the owning side to null (unless already changed)
            if ($roomsId->getHotelId() === $this) {
                $roomsId->setHotelId(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $n_room = null;

    #[ORM\Column(nullable: true)]
    private ?int $floor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $orientation = null;

    #[ORM\ManyToOne(inversedBy: 'rooms_id')]
    private ?Hotel $hotel_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNRoom(): ?int
    {
        return $this->n_room;
    }

    public function setNRoom(?int $n_room): self
    {
        $this->n_room = $n_room;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function setOrientation(?string $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getHotelId(): ?Hotel
    {
        return $this->hotel_id;
    }

    public function setHotelId(?Hotel $hotel_id): self
    {
        $this->hotel_id = $hotel_id;

        return $this;
    }
}

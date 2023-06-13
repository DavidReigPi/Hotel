<?php

namespace App\Entity;

use App\Repository\DirectorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DirectorRepository::class)]
class Director
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dni = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\OneToOne(mappedBy: 'director_id', cascade: ['persist', 'remove'])]
    private ?Hotel $hotel_id = null;

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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getHotelId(): ?Hotel
    {
        return $this->hotel_id;
    }

    public function setHotelId(?Hotel $hotel_id): self
    {
        // unset the owning side of the relation if necessary
        if ($hotel_id === null && $this->hotel_id !== null) {
            $this->hotel_id->setDirectorId(null);
        }

        // set the owning side of the relation if necessary
        if ($hotel_id !== null && $hotel_id->getDirectorId() !== $this) {
            $hotel_id->setDirectorId($this);
        }

        $this->hotel_id = $hotel_id;

        return $this;
    }
}

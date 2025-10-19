<?php

namespace App\Entity;

use App\Repository\ClientesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientesRepository::class)]
class Clientes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $documento = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $telefono = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $correo = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $direccion = null;

    /**
     * @var Collection<int, Vehiculos>
     */
    #[ORM\OneToMany(targetEntity: Vehiculos::class, mappedBy: 'cliente')]
    private Collection $vehiculos;

    public function __construct()
    {
        $this->vehiculos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): static
    {
        $this->documento = $documento;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): static
    {
        $this->correo = $correo;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return Collection<int, Vehiculos>
     */
    public function getVehiculos(): Collection
    {
        return $this->vehiculos;
    }

    public function addVehiculo(Vehiculos $vehiculo): static
    {
        if (!$this->vehiculos->contains($vehiculo)) {
            $this->vehiculos->add($vehiculo);
            $vehiculo->setCliente($this);
        }

        return $this;
    }

    public function removeVehiculo(Vehiculos $vehiculo): static
    {
        if ($this->vehiculos->removeElement($vehiculo)) {
            // set the owning side to null (unless already changed)
            if ($vehiculo->getCliente() === $this) {
                $vehiculo->setCliente(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TiposVehiculosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TiposVehiculosRepository::class)]
class TiposVehiculos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Vehiculos>
     */
    #[ORM\OneToMany(targetEntity: Vehiculos::class, mappedBy: 'tipo')]
    private Collection $vehiculos;

    /**
     * @var Collection<int, Tarifas>
     */
    #[ORM\OneToMany(targetEntity: Tarifas::class, mappedBy: 'tipo')]
    private Collection $tarifas;

    public function __construct()
    {
        $this->vehiculos = new ArrayCollection();
        $this->tarifas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

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
            $vehiculo->setTipo($this);
        }

        return $this;
    }

    public function removeVehiculo(Vehiculos $vehiculo): static
    {
        if ($this->vehiculos->removeElement($vehiculo)) {
            // set the owning side to null (unless already changed)
            if ($vehiculo->getTipo() === $this) {
                $vehiculo->setTipo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tarifas>
     */
    public function getTarifas(): Collection
    {
        return $this->tarifas;
    }

    public function addTarifa(Tarifas $tarifa): static
    {
        if (!$this->tarifas->contains($tarifa)) {
            $this->tarifas->add($tarifa);
            $tarifa->setTipo($this);
        }

        return $this;
    }

    public function removeTarifa(Tarifas $tarifa): static
    {
        if ($this->tarifas->removeElement($tarifa)) {
            // set the owning side to null (unless already changed)
            if ($tarifa->getTipo() === $this) {
                $tarifa->setTipo(null);
            }
        }

        return $this;
    }
}

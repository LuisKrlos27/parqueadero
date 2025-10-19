<?php

namespace App\Entity;

use App\Enum\TiposVehiculosEnum;
use App\Repository\VehiculosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculosRepository::class)]
class Vehiculos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $placa = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $marca = null;

    #[ORM\Column('string', enumType: TiposVehiculosEnum::class)]
    private TiposVehiculosEnum $tipo_vehiculo;

    #[ORM\ManyToOne(inversedBy: 'vehiculos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clientes $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'vehiculos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TiposVehiculos $tipo = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaca(): ?string
    {
        return $this->placa;
    }

    public function setPlaca(string $placa): static
    {
        $this->placa = $placa;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(?string $marca): static
    {
        $this->marca = $marca;

        return $this;
    }

    public function getTipoVehiculo(): TiposVehiculosEnum
    {
        return $this->tipo_vehiculo;
    }
    public function setTipoVehiculo(TiposVehiculosEnum $tipo_vehiculo): static
    {
        $this->tipo_vehiculo = $tipo_vehiculo;

        return $this;
    }

    public function getCliente(): ?Clientes
    {
        return $this->cliente;
    }

    public function setCliente(?Clientes $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getTipo(): ?TiposVehiculos
    {
        return $this->tipo;
    }

    public function setTipo(?TiposVehiculos $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }
}

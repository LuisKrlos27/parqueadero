<?php

namespace App\Entity;

use App\Repository\TarifasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifasRepository::class)]
class Tarifas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $valor_hora = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $valor_dia = null;

    #[ORM\Column]
    private ?bool $estado = null;

    #[ORM\ManyToOne(inversedBy: 'tarifas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TiposVehiculos $tipo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValorHora(): ?string
    {
        return $this->valor_hora;
    }

    public function setValorHora(string $valor_hora): static
    {
        $this->valor_hora = $valor_hora;

        return $this;
    }

    public function getValorDia(): ?string
    {
        return $this->valor_dia;
    }

    public function setValorDia(string $valor_dia): static
    {
        $this->valor_dia = $valor_dia;

        return $this;
    }

    public function isEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): static
    {
        $this->estado = $estado;

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

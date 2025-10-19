<?php

namespace App\Entity;

use App\Enum\MetodoPagoEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PagosRepository;

#[ORM\Entity(repositoryClass: PagosRepository::class)]
class Pagos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $monto = null;

    #[ORM\Column]
    private ?\DateTime $fecha_pago = null;

    #[ORM\Column(type:'string', enumType: MetodoPagoEnum::class)]
    private MetodoPagoEnum $metodo_pago;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Registros $registro = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getFechaPago(): ?\DateTime
    {
        return $this->fecha_pago;
    }

    public function setFechaPago(\DateTime $fecha_pago): static
    {
        $this->fecha_pago = $fecha_pago;

        return $this;
    }

    public function getMetodoPago(): MetodoPagoEnum
    {
        return $this->metodo_pago;
    }
    public function setMetodoPago(MetodoPagoEnum $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getRegistro(): ?Registros
    {
        return $this->registro;
    }

    public function setRegistro(Registros $registro): static
    {
        $this->registro = $registro;

        return $this;
    }
    
}

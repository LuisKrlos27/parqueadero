<?php

namespace App\Entity;

use App\Enum\EstadoRegistroEnum;
use App\Repository\RegistrosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrosRepository::class)]
class Registros
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $hora_entrada = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $hora_salida = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $tiempo_total = null;

    #[ORM\Column('string', enumType: EstadoRegistroEnum::class)]
    private EstadoRegistroEnum $estado;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoraEntrada(): ?\DateTime
    {
        return $this->hora_entrada;
    }

    public function setHoraEntrada(\DateTime $hora_entrada): static
    {
        $this->hora_entrada = $hora_entrada;

        return $this;
    }

    public function getHoraSalida(): ?\DateTime
    {
        return $this->hora_salida;
    }

    public function setHoraSalida(?\DateTime $hora_salida): static
    {
        $this->hora_salida = $hora_salida;

        return $this;
    }

    public function getTiempoTotal(): ?string
    {
        return $this->tiempo_total;
    }

    public function setTiempoTotal(?string $tiempo_total): static
    {
        $this->tiempo_total = $tiempo_total;

        return $this;
    }
    public function getEstado(): EstadoRegistroEnum
    {
        return $this->estado;
    }
    public function setEstado(EstadoRegistroEnum $estado): static
    {
        $this->estado = $estado;

        return $this;
    }
}

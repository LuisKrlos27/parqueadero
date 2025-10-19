<?php

namespace App\Enum;

enum MetodoPagoEnum: string
{
    case EFECTIVO = 'Efectivo';
    case TARJETA = 'Tarjeta';
    case TRANSFERENCIA_BANCARIA = 'Transferencia Bancaria';
}

<?php
namespace src\DriverContext\Domain\ValueObjects;

enum DriverStatus: string {
    case ACTIVE = 'available';
    case INACTIVE = 'busy';
    case OFFLINE = 'offline'; // تعني أن السائق غير متاح اليوم (غير متصل بالتطبيق)
}

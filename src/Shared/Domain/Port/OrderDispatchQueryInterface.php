<?php
namespace src\Shared\Domain\Port;

use src\Shared\Domain\DTOs\AvailableOrderDTO;

interface OrderDispatchQueryInterface
{
    public function getOrderDispatchDataById(string $orderId): ?AvailableOrderDTO;
}

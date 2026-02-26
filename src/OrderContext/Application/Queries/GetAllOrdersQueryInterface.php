<?php
namespace src\OrderContext\Application\Queries;

use src\OrderContext\Application\DTOs\OrderFilters;

interface GetAllOrdersQueryInterface{
    public function execute(OrderFilters $filters , int $perPage = 15) : array ;
}

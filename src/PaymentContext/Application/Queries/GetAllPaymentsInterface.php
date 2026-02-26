<?php
namespace src\PaymentContext\Application\Queries ;

use src\PaymentContext\Application\DTOs\PaymentFilter;

interface GetAllPaymentsInterface{
    public function execute(PaymentFilter $filterGetAllPayments , int $per_page = 15) : array ;
}

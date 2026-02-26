<?php
namespace src\Shared\Domain\Port;
interface TransactionManagerInterface{
    /**
     * @param callable $operation
     * @return mixed
     * @throws \Exception
     */
    public function execute(callable $callback);
}

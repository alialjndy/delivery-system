<?php
namespace src\DriverContext\Domain\ValueObjects;
final readonly class NationalNumber{
    private string $number;

    public function __construct(string $number) {
        if (!ctype_digit($number)) {
            throw new \InvalidArgumentException("الرقم الوطني يجب أن يحتوي على أرقام فقط.");
        }

        $length = strlen($number);
        if ($length > 15 || $length < 10) {
            throw new \InvalidArgumentException("طول الرقم الوطني غير منطقي.");
        }

        $this->number = $number;
    }

    public function getNumber(): string {
        return $this->number;
    }

    public function equals(NationalNumber $other): bool {
        return $this->number === $other->getNumber();
    }
}

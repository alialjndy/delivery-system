<?php
namespace src\DriverContext\Domain\ValueObjects;

final readonly class PhoneNumber {
    private string $number;

    public function __construct(string $number) {
        if (!ctype_digit($number)) {
            throw new \InvalidArgumentException("رقم الهاتف يجب أن يحتوي على أرقام فقط.");
        }

        $length = strlen($number);
        if ($length < 10 || $length > 15) {
            throw new \InvalidArgumentException("طول رقم الهاتف غير منطقي.");
        }

        $this->number = $number;
    }

    public function getNumber(): string {
        return $this->number;
    }

    public function equals(PhoneNumber $other): bool {
        return $this->number === $other->getNumber();
    }
}

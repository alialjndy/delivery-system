<?php

namespace src\UserContext\Domain\ValueObjects;

use InvalidArgumentException;

readonly class Password
{
    private string $hashedValue;

    public function __construct(string $value, bool $isAlreadyHashed = false, bool $isProviderPassword = false)
    {
        if($isProviderPassword && empty($value)){
            $this->hashedValue = $value;
            return;
        }
        if (!$isAlreadyHashed) {
            $this->validate($value);
            $this->hashedValue = password_hash($value, PASSWORD_BCRYPT);
        } else {
            $this->hashedValue = $value;
        }
    }

    private function validate(string $value): void
    {
        if (strlen($value) < 8) {
            throw new InvalidArgumentException("كلمة السر يجب أن لا تقل عن 8 أحرف.");
        }

        if (!preg_match('/[A-Z]/', $value) || !preg_match('/[0-9]/', $value)) {
            throw new InvalidArgumentException("كلمة السر يجب أن تحتوي على حرف كبير ورقم واحد على الأقل.");
        }
    }

    public function getHashedValue(): string
    {
        return $this->hashedValue;
    }

    // دالة للتحقق من كلمة السر عند تسجيل الدخول
    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }
}

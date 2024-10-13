<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

final class UUID extends ValueObject
{
    public static function fromValue(string $value): self
    {
        return new self($value);
    }

    public function __construct(public readonly string $value) {
    }

    public function equals(ValueObject $valueObject): bool
    {
        if ($valueObject instanceof UUID && $valueObject->value === $this->value) {
            return true;
        }

        return false;
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function generate(): string
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
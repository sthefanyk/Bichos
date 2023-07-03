<?php

namespace Core\Domain\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUiid;

class Uuid
{
    public function __construct(
        protected string $value
    )
    {
        $this->ensureIsValid($value);
    }

    public static function random() : self
    {
        return new self(RamseyUiid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValid(string $id)
    {
        if (!RamseyUiid::isValid($id))
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
    }
}

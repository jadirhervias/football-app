<?php

namespace Src\Shared\Domain;

use Illuminate\Support\Carbon;
use DateTimeImmutable;

class EnhancedDateTime
{
    public function __construct(private DateTimeImmutable $value)
    {
    }

    static public function now(): EnhancedDateTime
    {
        return new self(Carbon::now()->toDateTimeImmutable());
    }

    /**
     * Format like 'Y-m-d H:i:s'
     * @return string
     */
    public function format(): string
    {
        return Carbon::parse($this->value)->format(Carbon::DEFAULT_TO_STRING_FORMAT);
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }
}

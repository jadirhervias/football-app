<?php

namespace Src\Player\Domain;

use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Domain\EnhancedDateTime;

class Player extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $externalId,
        private readonly ?string $name,
        private readonly ?string $position,
        private readonly ?string $dateOfBirth,
        private readonly ?string $nationality,
        private readonly ?int $shirtNumber,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
    )
    {
    }

    public static function create(array $attributes): Player
    {
        $now = EnhancedDateTime::now()->format();
        return new self(
            $attributes['id'],
            $attributes['external_id'],
            $attributes['name'],
            $attributes['position'],
            $attributes['date_of_birth'],
            $attributes['nationality'],
            $attributes['shirt_number'],
            $attributes['created_at'] ?? $now,
            $attributes['updated_at'] ?? $now,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'external_id' => $this->externalId,
            'name' => $this->name,
            'position' => $this->position,
            'date_of_birth' => $this->dateOfBirth,
            'nationality' => $this->nationality,
            'shirt_number' => $this->shirtNumber,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}

<?php

namespace Src\Player\Application\Create;

class CreatePlayerRequest
{
    public function __construct(
        private readonly string $externalId,
        private readonly string $name,
        private readonly string $position,
        private readonly array $dateOfBirth,
        private readonly array $nationality,
        private readonly array $shirtNumber,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'name' => $this->name,
            'position' => $this->position,
            'date_of_birth' => $this->dateOfBirth,
            'nationality' => $this->nationality,
            'shirt_number' => $this->shirtNumber,
        ];
    }
}

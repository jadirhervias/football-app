<?php

namespace Src\Team\Domain;

use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Domain\EnhancedDateTime;

class Team extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $externalId,
        private readonly ?string $name,
        private readonly ?string $shortName,
        private readonly ?string $tla,
        private readonly ?string $crest,
        private readonly ?string $address,
        private readonly ?string $website,
        private readonly ?int $founded,
        private readonly ?string $venue,
        private readonly ?string $coachName,
        private readonly ?string $coachNationality,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
    )
    {
    }

    public static function create(array $attributes): Team
    {
        $now = EnhancedDateTime::now()->format();
        return new self(
            $attributes['id'],
            $attributes['external_id'],
            $attributes['name'],
            $attributes['short_name'],
            $attributes['tla'],
            $attributes['crest'],
            $attributes['address'],
            $attributes['website'],
            $attributes['founded'],
            $attributes['venue'],
            $attributes['coach_name'],
            $attributes['coach_nationality'],
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
            'short_name' => $this->shortName,
            'tla' => $this->tla,
            'crest' => $this->crest,
            'address' => $this->address,
            'website' => $this->website,
            'founded' => $this->founded,
            'venue' => $this->venue,
            'coach_name' => $this->coachName,
            'coach_nationality' => $this->coachNationality,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}

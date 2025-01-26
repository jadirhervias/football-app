<?php

namespace Src\Competition\Domain;

use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Domain\EnhancedDateTime;

class Competition extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private readonly string $externalId,
        private readonly ?string $name,
        private readonly ?string $code,
        private readonly ?string $type,
        private readonly ?string $emblem,
        private readonly ?int $numberOfAvailableSeasons,
        private readonly ?string $areaCode,
        private readonly ?string $areaFlag,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
    )
    {
    }

    public static function create(array $attributes): Competition
    {
        $now = EnhancedDateTime::now()->format();
        return new self(
            $attributes['id'],
            $attributes['external_id'],
            $attributes['name'],
            $attributes['code'],
            $attributes['type'],
            $attributes['emblem'],
            $attributes['number_of_available_seasons'],
            $attributes['area_code'],
            $attributes['area_flag'],
            $attributes['created_at'] ?? $now,
            $attributes['updated_at'] ?? $now,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'external_id' => $this->externalId,
            'type' => $this->type,
            'emblem' => $this->emblem,
            'number_of_available_seasons' => $this->numberOfAvailableSeasons,
            'area_code' => $this->areaCode,
            'area_flag' => $this->areaFlag,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}

<?php

namespace Src\Team\Application\Create;

class CreatTeamRequest
{
    public function __construct(
        private readonly string $externalId,
        private readonly string $name,
        private readonly string $shortName,
        private readonly array $tla,
        private readonly array $crest,
        private readonly string $address,
        private readonly string $website,
        private readonly int $founded,
        private readonly string $venue,
        private readonly string $coachName,
        private readonly string $coachNationality,
    )
    {
    }

    public function toArray(): array
    {
        return [
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
        ];
    }
}

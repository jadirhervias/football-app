<?php

namespace Src\Team\Domain;

interface TeamsRepository
{
    public function save(Team $team): void;

    public function findByExternalId(string $externalId): ?Team;

    /** @return array<Team> */
    public function getAll(int $limit, int $offset): array;

    /**
     * @param Team[] $teams
     * @return void
     */
    public function insertMany(array $teams): void;
}

<?php

namespace Src\Competition\Domain;

interface CompetitionsRepository
{
//    public function save(Competition $competition): void;

    public function findByExternalId(string $externalId): ?Competition;

    /** @return array<Competition> */
    public function getAll(int $limit, int $offset): array;
}

<?php

namespace Src\Competition\Domain;

interface CompetitionsRepository
{
    public function findByExternalId(string $externalId): ?Competition;

    public function findByCode(string $code): ?Competition;

    /** @return array<Competition> */
    public function getAll(int $limit, int $offset): array;

    /**
     * @param Competition[] $competitions
     * @return void
     */
    public function insertMany(array $competitions): void;
}

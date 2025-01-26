<?php

namespace Src\Player\Domain;

interface PlayersRepository
{
    public function save(Player $player): void;

    public function findByExternalId(string $externalId): ?Player;

    /** @return array<Player> */
    public function getAll(int $limit, int $offset): array;

    /**
     * @param Player[] $players
     * @return void
     */
    public function insertMany(array $players): void;
}

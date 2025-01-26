<?php

namespace Src\Player\Infrastructure\Persistence\Eloquent;

use App\Models\Player as PlayerEloquentModel;
use Src\Player\Domain\Player;
use Src\Player\Domain\PlayersRepository;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentPlayersRepository extends EloquentRepository implements PlayersRepository
{
    function serializer($attributes): Player
    {
        return Player::create($attributes);
    }

    function modelClass(): string
    {
        return PlayerEloquentModel::class;
    }

    public function save(Player $player): void
    {
        $model = $this->model()->fill($player->toPrimitives());

        $this->model()::query()->updateOrCreate(
            [$model->getKeyName() => $model->getKey()],
            $model->toArray()
        );
    }

    public function findByExternalId(string $externalId): ?Player
    {
        /** @var PlayerEloquentModel|null $player */
        $player = $this->builder()->firstWhere('external_id', $externalId);

        return $player ? $this->serializer($player) : null;
    }

    /** @return array<Player> */
    public function getAll(int $limit, int $offset): array
    {
        $results = $this->builder()->limit($limit)->offset($offset)->get()->toArray();

        return array_map(fn($item) => $this->serializer($item), $results);
    }

    /**
     * @param Player[] $players
     * @return void
     */
    public function insertMany(array $players): void
    {
        $primitives = array_map(fn(Player $player) => $player->toPrimitives(), $players);
        $this->builder()->upsert($primitives, ['external_id']);
    }
}

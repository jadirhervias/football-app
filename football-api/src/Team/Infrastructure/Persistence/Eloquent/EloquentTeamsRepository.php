<?php

namespace Src\Team\Infrastructure\Persistence\Eloquent;

use App\Models\Team as TeamEloquentModel;
use Src\Team\Domain\Team;
use Src\Team\Domain\TeamsRepository;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentTeamsRepository extends EloquentRepository implements TeamsRepository
{
    function serializer($attributes): Team
    {
        return Team::create($attributes);
    }

    function modelClass(): string
    {
        return TeamEloquentModel::class;
    }

    public function save(Team $team): void
    {
        $model = $this->model()->fill($team->toPrimitives());

        $this->model()::query()->updateOrCreate(
            [$model->getKeyName() => $model->getKey()],
            $model->toArray()
        );
    }

    public function findByExternalId(string $externalId): ?Team
    {
        /** @var TeamEloquentModel|null $team */
        $team = $this->builder()->firstWhere('external_id', $externalId);

        return $team ? $this->serializer($team) : null;
    }

    /** @return array<Team> */
    public function getAll(int $limit, int $offset): array
    {
        $results = $this->builder()->limit($limit)->offset($offset)->get()->toArray();

        return array_map(fn($item) => $this->serializer($item), $results);
    }

    /**
     * @param Team[] $teams
     * @return void
     */
    public function insertMany(array $teams): void
    {
        $primitives = array_map(fn(Team $team) => $team->toPrimitives(), $teams);
        $this->builder()->upsert($primitives, ['external_id']);
    }
}

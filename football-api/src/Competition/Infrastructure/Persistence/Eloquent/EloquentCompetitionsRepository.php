<?php

namespace Src\Competition\Infrastructure\Persistence\Eloquent;

use App\Models\Competition as CompetitionEloquentModel;
use Src\Competition\Domain\Competition;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCompetitionsRepository extends EloquentRepository implements CompetitionsRepository
{
    function serializer($attributes): Competition
    {
        return Competition::create($attributes);
    }

    function modelClass(): string
    {
        return CompetitionEloquentModel::class;
    }

    public function save(Competition $competition): void
    {
        $model = $this->model()->fill($competition->toPrimitives());

        $this->model()::query()->updateOrCreate(
            [$model->getKeyName() => $model->getKey()],
            $model->toArray()
        );
    }

    public function findByCode(string $code): ?Competition
    {
        /** @var CompetitionEloquentModel|null $competition */
        $competition = $this->builder()->firstWhere('code', $code);

        return $competition ? $this->serializer($competition) : null;
    }

    public function findByExternalId(string $externalId): ?Competition
    {
        /** @var CompetitionEloquentModel|null $competition */
        $competition = $this->builder()->firstWhere('external_id', $externalId);

        return $competition ? $this->serializer($competition) : null;
    }

    /** @return array<Competition> */
    public function getAll(int $limit, int $offset): array
    {
        $results = $this->builder()->limit($limit)->offset($offset)->get()->toArray();

        return array_map(fn($item) => $this->serializer($item), $results);
    }

    /**
     * @param Competition[] $competitions
     * @return void
     */
    public function insertMany(array $competitions): void
    {
        $primitives = array_map(fn(Competition $competition) => $competition->toPrimitives(), $competitions);
        $this->builder()->upsert($primitives, ['external_id']);
    }
}

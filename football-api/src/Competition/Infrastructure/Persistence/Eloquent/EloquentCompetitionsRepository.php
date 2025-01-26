<?php

namespace Src\Competition\Infrastructure\Persistence\Eloquent;

use App\Models\Competition as CompetitionEloquentModel;
use Src\Competition\Domain\Competition;
use Src\Competition\Domain\CompetitionsRepository;
use Src\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCompetitionsRepository
//    extends EloquentRepository implements CompetitionsRepository
{
//    function serializer($attributes): Competition
//    {
//        return Competition::create($attributes);
//    }
//
//    function modelClass(): string
//    {
//        return CompetitionEloquentModel::class;
//    }
//
//    public function save(Competition $competition): void
//    {
//        $model = $this->model()->fill($competition->toPrimitives());
//
//        $this->model()::query()->updateOrCreate(
//            [$model->getKeyName() => $model->getKey()],
//            $model->toArray()
//        );
//    }
//
//    public function findByExternalId(string $externalId): ?Competition
//    {
//        /** @var CompetitionEloquentModel|null $competition */
//        $competition = $this->builder()->firstWhere('external_id', $externalId);
//
//        return $competition ? $this->serializer($competition) : null;
//    }
//
//    public function getAll(int $limit, int $offset): array
//    {
//        return $this->builder()->limit($limit)->offset($offset)->get()->toArray();
//    }
}

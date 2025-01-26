<?php

namespace Src\Shared\Infrastructure\Persistence\Eloquent;

use Src\Shared\Domain\AggregateRoot;
use Src\Shared\Domain\Assert;
use Src\Shared\Domain\Utils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class EloquentRepository
{
    abstract function modelClass(): string;

    abstract function serializer($attributes): AggregateRoot;

    public function model(): Model
    {
        Assert::childInstanceOf($this->modelClass(), Model::class);

        return new ($this->modelClass());
    }

    public function builder(): Builder
    {
        return $this->model()::query();
    }

    protected function persist(AggregateRoot $aggregate): void
    {
        $model = $this->model()->fill($aggregate->toPrimitives());

        $this->model()::query()->updateOrCreate(
            [$model->getKeyName() => $model->getKey()],
            $model->toArray()
        );
    }

    /**
     * @return AggregateRoot[]
     */
    protected function all(): array
    {
        return $this->model()::all()
            ->map(fn(Model $model) => $this->serializer($model->toArray()))
            ->toArray();
    }

    protected function find(string $id): ?AggregateRoot
    {
        $item = $this->model()::query()
            ->when(
                $this->useSoftDeletes(),
                fn($query) => $query->withTrashed()
            )
            ->find($id);

        return $item ? $this->serializer($item->toArray()) : null;
    }

    protected function remove(string $id): void
    {
        $this->model()::query()
            ->where('id', $id)
            ->when(
                $this->useSoftDeletes(),
                fn($query) => $query->withTrashed()
            )
            ->forceDelete();
    }

    private function useSoftDeletes(): bool
    {
        return Utils::hasTrait($this->model(), SoftDeletes::class);
    }
}

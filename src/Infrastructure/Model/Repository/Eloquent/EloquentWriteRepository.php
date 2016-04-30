<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent;

use Illuminate\Database\Eloquent\Model;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\WriteRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Filter as DomainFilter;

class EloquentWriteRepository extends BaseEloquentRepository implements WriteRepository
{
    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     *
     * @param Filter|null $filter
     *
     * @return int
     */
    public function count(Filter $filter = null)
    {
        $model = self::$instance;
        $query = $model->query();

        if ($filter) {
            EloquentFilter::filter($query, $filter);
        }

        return (int) $query->getQuery()->count();
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param $id
     *
     * @return bool
     */
    public function exists(Identity $id)
    {
        $model = self::$instance;

        $filter = new DomainFilter();
        $filter->must()->equal($model->getKeyName(), $id->id());

        return $this->count($filter) > 0;
    }

    /**
     * Adds a new entity to the storage.
     *
     * @param Identity|Model $value
     *
     * @return mixed
     */
    public function add(Identity $value)
    {
        $this->guard($value);
        $value->save();

        return $value;
    }

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @return mixed
     */
    public function addAll(array $values)
    {
        foreach ($values as $value) {
            $this->guard($value);
            $value->save();
        }

        return $values;
    }

    /**
     * Removes the entity with the given id.
     *
     * @param $id
     */
    public function remove(Identity $id)
    {
        $model = self::$instance;

        $model->query()->find($id->id())->delete();
    }

    /**
     * Removes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be deleted.
     *
     * @param Filter $filter
     *
     * @return bool
     */
    public function removeAll(Filter $filter = null)
    {
        $model = self::$instance;
        $query = $model->query();

        if ($filter) {
            EloquentFilter::filter($query, $filter);
        }

        $query->delete();
    }

    /**
     * Repository data is added or removed as a whole block.
     * Must work or fail and rollback any persisted/erased data.
     *
     * @param callable $transaction
     *
     * @throws \Exception
     */
    public function transactional(callable $transaction)
    {
        $model = $model = self::$instance;

        try {
            $model->getConnection()->beginTransaction();
            $transaction();
            $model->getConnection()->commit();
        } catch (\Exception $e) {
            $model->getConnection()->rollback();
            throw $e;
        }
    }
}

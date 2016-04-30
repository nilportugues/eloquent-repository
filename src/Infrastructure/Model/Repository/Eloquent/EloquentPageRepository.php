<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Page;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\PageRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Page as ResultPage;

class EloquentPageRepository extends BaseEloquentRepository implements PageRepository
{
    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     */
    public function findAll(Pageable $pageable = null)
    {
        $model = self::$instance;
        $query = $model->query();

        if ($pageable) {
            $fields = $pageable->fields();
            $columns = (!$fields->isNull()) ? $fields->get() : ['*'];

            if (count($distinctFields = $pageable->distinctFields()->get()) > 0) {
                $query->getQuery()->distinct();
                $columns = $distinctFields;
            }

            $filter = $pageable->filters();
            if (!$filter->isNull()) {
                EloquentFilter::filter($query, $filter);
            }

            $sort = $pageable->sortings();
            if (!$sort->isNull()) {
                EloquentSorter::sort($query, $sort);
            }

            return new ResultPage(
                $query->paginate($pageable->pageSize(), $columns, 'page', $pageable->pageNumber())->items(),
                $query->paginate()->total(),
                $pageable->pageNumber(),
                ceil($query->paginate()->total() / $pageable->pageSize())
            );
        }

        return new ResultPage(
            $query->paginate($query->paginate()->total(), ['*'], 'page', 1)->items(),
            $query->paginate()->total(),
            1,
            1
        );
    }
}

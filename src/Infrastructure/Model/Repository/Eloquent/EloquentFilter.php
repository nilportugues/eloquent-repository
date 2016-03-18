<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 7/02/16
 * Time: 16:06.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter as FilterInterface;

/**
 * Class SqlFilter.
 */
class EloquentFilter
{
    const MUST_NOT = 'must_not';
    const MUST = 'must';
    const SHOULD = 'should';

    public static function filter(Builder $query, FilterInterface $filter)
    {
        foreach ($filter->filters() as $condition => $filters) {
            $filters = self::removeEmptyFilters($filters);
            if (count($filters) > 0) {
                self::processConditions($query, $condition, $filters);
            }
        }

        return $query;
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    private static function removeEmptyFilters(array $filters)
    {
        $filters = array_filter($filters, function ($v) {
            return count($v) > 0;
        });

        return $filters;
    }

    /**
     * @param Builder $where
     * @param string  $condition
     * @param array   $filters
     */
    private static function processConditions(Builder $where, $condition, array &$filters)
    {
        switch ($condition) {
            case self::MUST:
                self::apply($where, $filters, 'AND');
                break;

            case self::MUST_NOT:
                self::apply($where, $filters, 'AND NOT');
                break;

            case self::SHOULD:
                self::apply($where, $filters, 'OR');
                break;
        }
    }

    /**
     * @param Builder $where
     * @param array   $filters
     * @param string  $boolean
     */
    protected static function apply(Builder $where, array $filters, $boolean)
    {
        foreach ($filters as $filterName => $valuePair) {
            foreach ($valuePair as $key => $value) {
                if (is_array($value) && count($value) > 0) {
                    $value = array_values($value);
                    if (count($value[0]) > 1) {
                        switch ($filterName) {
                            case BaseFilter::RANGES:
                                $where->whereBetween($key, [$value[0][0], $value[0][1]], $boolean);
                                break;
                            case BaseFilter::NOT_RANGES:
                                $where->whereNotBetween($key, [$value[0][0], $value[0][1]], $boolean);
                                break;
                        }
                    } else {
                        switch ($filterName) {
                            case BaseFilter::GROUP:
                                $where->whereIn($key, $value, $boolean);
                                break;
                            case BaseFilter::NOT_GROUP:
                                $where->whereNotIn($key, $value, $boolean);
                                break;
                        }
                    }
                }

                $value = (array) $value;
                $value = array_shift($value);
                switch ($filterName) {
                    case BaseFilter::GREATER_THAN_OR_EQUAL:
                        $where->where($key, '>=', $value, $boolean);
                        break;
                    case BaseFilter::GREATER_THAN:
                        $where->where($key, '>', $value, $boolean);
                        break;
                    case BaseFilter::LESS_THAN_OR_EQUAL:
                        $where->where($key, '<=', $value, $boolean);
                        break;
                    case BaseFilter::LESS_THAN:
                        $where->where($key, '<', $value, $boolean);
                        break;
                    case BaseFilter::CONTAINS:
                        $where->where($key, 'LIKE', '%'.$value.'%', $boolean);
                        break;
                    case BaseFilter::NOT_CONTAINS:
                        $where->where($key, 'NOT LIKE', '%'.$value.'%', $boolean);
                        break;
                    case BaseFilter::STARTS_WITH:
                        $where->where($key, 'LIKE', $value.'%', $boolean);
                        break;
                    case BaseFilter::ENDS_WITH:
                        $where->where($key, 'LIKE', '%'.$value, $boolean);
                        break;
                    case BaseFilter::EQUALS:
                        $where->where($key, '=', $value, $boolean);
                        break;
                    case BaseFilter::NOT_EQUAL:
                        $where->where($key, '!=', $value, $boolean);
                        break;
                }
            }
        }
    }
}

<?php

namespace NilPortugues\Tests\Foundation;

use NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent\EloquentRepository;

class ClientOrdersRepository extends EloquentRepository
{
    /**
     * Must return the Eloquent Model Fully Qualified Class Name as a string.
     *
     * eg: return App\Model\User::class
     *
     * @return string
     */
    protected function modelClassName()
    {
        return ClientOrders::class;
    }
}

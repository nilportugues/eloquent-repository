<?php

namespace NilPortugues\Tests\Foundation;

use Illuminate\Database\Eloquent\Model;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent\IdentityTrait;

class Clients extends Model implements Identity
{
    use IdentityTrait;

    /**
     * @var string
     */
    protected $table = 'clients';

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    /*public function orderDates()
    {
        return $this->hasMany(ClientOrders::class);
    }*/
}

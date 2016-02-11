<?php

namespace NilPortugues\Tests\Foundation\Helpers;

use Illuminate\Database\Eloquent\Model;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent\IdentityTrait;

class ClientOrders extends Model implements Identity
{
    use IdentityTrait;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'client_orders';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(Clients::class);
    }
}

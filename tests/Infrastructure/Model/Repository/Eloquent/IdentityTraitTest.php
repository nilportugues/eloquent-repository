<?php

namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\Eloquent;

use NilPortugues\Foundation\Infrastructure\Model\Repository\Eloquent\IdentityTrait;

class IdentityTraitTest extends \PHPUnit_Framework_TestCase
{
    use IdentityTrait;

    /**
     * @var int
     */
    public $id = 1;

    /**
     *
     */
    public function testItCanGetId()
    {

        $this->assertEquals(1, $this->id());
    }

    /**
     *
     */
    public function testItCanGetIdAsString()
    {
        $this->assertEquals('1', (string) $this);
    }
}

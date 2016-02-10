<?php

namespace NilPortugues\Tests\Foundation;

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientsRepository
     */
    protected $repository;

    /**
     *
     */
    public function setUp()
    {
        $this->repository = new ClientsRepository();
        Database::createAndPopulate();
    }

    /**
     *
     */
    public function tearDown()
    {
        Capsule::schema('default')->drop('clients');
        Capsule::schema('default')->drop('client_orders');
    }

    public function testItCanFind()
    {
        $id = new ClientId(1);
        $client = $this->repository->find($id);

        print_r($client);
    }
}

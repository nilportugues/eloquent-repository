<?php

use NilPortugues\Example\Domain\UserId;
use NilPortugues\Example\Persistence\Eloquent\UserRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Order;
use NilPortugues\Foundation\Domain\Model\Repository\Sort;

include_once '../vendor/autoload.php';

//------------------------------------------------------------
// Create database if does not exist + establish connection
//------------------------------------------------------------

//------------------------------------------------------------
// getUserAction
//------------------------------------------------------------
$repository = new UserRepository();
$userId = new UserId(1);
print_r($repository->find($userId));

//------------------------------------------------------------
// getUsersRegisteredLastMonth
//------------------------------------------------------------
$filter = new Filter();
$filter->must()->greaterThanOrEqual('created_at', '2016-01-01');
$filter->must()->lessThan('created_at', '2016-02-01');

$sort = new Sort();
$sort->setOrderFor('created_at', new Order('ASC'));
print_r($repository->findBy($filter, $sort));

<?php

use App\NumberQueue\NumberQueueServiceProvider;
use App\Shared\SharedServiceProvider;
use App\User\UserServiceProvider;

return [
    SharedServiceProvider::class,
    UserServiceProvider::class,
    NumberQueueServiceProvider::class,
];

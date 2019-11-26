<?php

use Framework\Router;
use App\Controllers\SubscribersController;
use App\Controllers\FieldsController;

Router::resource('subscriber', SubscribersController::class);
Router::resource('field', FieldsController::class);

<?php

use Framework\Router;
use App\Controllers\SubscribersController;
use App\Controllers\FieldTypesController;

Router::resource('subscriber', SubscribersController::class);
Router::resource('field-type', FieldTypesController::class);

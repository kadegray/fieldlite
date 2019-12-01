<?php

use Framework\Router;
use App\Controllers\SubscribersController;
use App\Controllers\FieldTypesController;

Router::resource('subscriber', SubscribersController::class);
Router::get('field-types', FieldTypesController::class, 'index');

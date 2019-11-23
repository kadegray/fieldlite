<?php

namespace App;

use Framework\Router;
use Framework\Controllers\FieldsController;
use Framework\Controllers\SubscribersController;

Router::resource('subscriber', SubscribersController::class);
Router::resource('field', FieldsController::class);

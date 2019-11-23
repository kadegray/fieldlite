<?php

require __DIR__ . '/../vendor/autoload.php';

// framework
require_once __DIR__ . '/../Framework/Model.php';
require_once __DIR__ . '/../Framework/Controller.php';
require_once __DIR__ . '/../Framework/Router.php';
require_once __DIR__ . '/../Framework/Request.php';
require_once __DIR__ . '/../Framework/Response.php';

// controllers
require_once __DIR__ . '/../app/controllers/FieldsController.php';
require_once __DIR__ . '/../app/controllers/SubscribersController.php';

// models
require_once __DIR__ . '/../app/models/Field.php';
require_once __DIR__ . '/../app/models/Subscriber.php';

require_once __DIR__ . '/../app/routes.php';

Framework\Router::route();

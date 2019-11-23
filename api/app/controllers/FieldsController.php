<?php

namespace Framework\Controllers;

use Field;
use Framework\Controller;

class FieldsController extends Controller {

    public function index($id)
    {
        Field::find($id);
    }

    public function create($request)
    {

    }

    public function update($request)
    {

    }

    public function delete($id)
    {

    }

}

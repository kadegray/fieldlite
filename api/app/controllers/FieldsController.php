<?php

namespace App\Controllers;

use App\Models\Field;
use App\Requests\FieldRequest as Request;
use Framework\Controller;
use Framework\Model;
use Framework\Response;

class FieldsController extends Controller {

    public function index(Request $request)
    {
        $fields = Field::all();

        new Response($fields);
    }

    public function show(Request $request, Model $field)
    {
        new Response($field);
    }

    public function create(Request $request)
    {
        $requestData = $request->data();
        $field = new Field($requestData);
        $field->save();

        new Response($field);
    }

    public function update(Request $request, Model $field)
    {
        $requestData = $request->data();
        $field->fill($requestData);
        $field->save();

        new Response($field);
    }

    public function delete(Request $request, Model $field)
    {
        new Response($field->delete(), 200);
    }

}

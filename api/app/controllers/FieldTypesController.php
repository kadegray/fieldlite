<?php

namespace App\Controllers;

use App\Models\FieldType;
use App\Requests\FieldTypeRequest as Request;
use Framework\Controller;
use Framework\Response;

class FieldTypesController extends Controller
{
    public function index(Request $request)
    {
        $fields = FieldType::all();

        new Response($fields);
    }
}

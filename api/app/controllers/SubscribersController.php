<?php

namespace Framework\Controllers;

use Framework\Controller;
use Subscriber;

class SubscribersController extends Controller {

    public function index($id)
    {
        Subscriber::find($id);
    }

    public function create($request)
    {
        $subscriber = new Subscriber();
        $subscriber->fill($request);
        $subscriber->save();
    }

    public function update($request)
    {

    }

    public function delete($id)
    {

    }

}

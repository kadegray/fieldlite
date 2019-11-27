<?php

namespace App\Controllers;

use App\Models\Subscriber;
use App\Requests\SubscriberRequest as Request;
use Framework\Controller;
use Framework\Model;
use Framework\Response;

class SubscribersController extends Controller {

    public function index(Request $request)
    {
        $subscribers = Subscriber::all();

        new Response($subscribers);
    }

    public function show(Request $request, Model $subscriber)
    {
        if (!$subscriber) {
            return;
        }

        new Response($subscriber);
    }

    public function create(Request $request)
    {
        $requestData = $request->data();
        $subscriber = new Subscriber($requestData);
        $subscriber->save();

        new Response($subscriber);
    }

    public function update(Request $request, Model $subscriber)
    {
        if (!$subscriber) {
            return;
        }

        $requestData = $request->data();
        $subscriber->fill($requestData);
        $subscriber->save();

        new Response($subscriber);
    }

    public function delete(Request $request, Model $subscriber)
    {
        new Response($subscriber->delete(), 200);
    }

}

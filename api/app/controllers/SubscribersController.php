<?php

namespace App\Controllers;

use App\Models\FieldSubscriber;
use App\Models\Subscriber;
use App\Requests\SubscriberRequest as Request;
use Framework\Controller;
use Framework\Model;
use Framework\Response;

class SubscribersController extends Controller
{
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
        $fields = data_get($requestData, 'fields', []);
        $subscriber = new Subscriber($requestData);
        $id = $subscriber->save();

        $this->updateFields($id, $fields);

        $subscriber = Subscriber::find($id);

        new Response($subscriber);
    }

    public function update(Request $request, Model $subscriber)
    {
        if (!$subscriber) {
            return;
        }

        $requestData = $request->data();
        $fields = data_get($requestData, 'fields', []);
        $subscriber->fill($requestData);
        $subscriber->save();

        $this->updateFields($subscriber->id, $fields);

        new Response($subscriber);
    }

    protected function updateFields($subscriberId, $fields)
    {
        if (!$fields || !count($fields)) {
            return;
        }

        foreach($fields as $_field) {

            $fieldId = data_get($_field, 'id');
            $fieldData = data_get($_field, 'data');

            if (is_null($fieldId)) {
                $field = new FieldSubscriber($_field);
                $field->fill([
                    'subscriber_id' => $subscriberId
                ]);
                $field->save();

                continue;
            }

            $field = FieldSubscriber::find($fieldId);
            $field->fill([
                'data' => $fieldData,
                'subscriber_id' => $subscriberId
            ]);
            $field->save();
        }
    }

    public function delete(Request $request, Model $subscriber)
    {
        new Response($subscriber->delete(), 200);
    }
}

<?php

namespace Framework;

interface ControllerInterface
{
    public function index(Request $request);
    public function show(Request $request, Model $model);
    public function create(Request $request);
    public function update(Request $request, Model $model);
    public function delete(Request $request, Model $model);
}

abstract class Controller implements ControllerInterface {
    abstract public function index(Request $request);
    abstract public function show(Request $request, Model $model);
    abstract public function create(Request $request);
    abstract public function update(Request $request, Model $model);
    abstract public function delete(Request $request, Model $model);
}
